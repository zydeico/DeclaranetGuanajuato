<?php

    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn(); 

	
    $_POST['asunto']=strtoupper($_POST['asunto']);	
    $context->allow = getAccess();
    if(!$action){      
        
        $context->menu = setMenu();

        if($_SESSION['PRO']=='#SP'){
                $context->title = "Centro de Notificaciones";		
                $context->notificaciones = $db->queryStored("FindMensajes", array($_SESSION['UI'],'2', $_SESSION['DEP']), 'ARRAY');					
                RenderTemplate('templates/mensajesServidores.tpl.php', $context, 'templates/base.php');
        }else{
            $context->title = "Centro de Mensajes";
            $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Editar", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Eliminar", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Creado", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Asunto", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
//                    $context->params[] = array("Header" => "Mensaje", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Tipo", "Width" => "100", "Attach" => "cmb", "Align" => "left", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Destinatario", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Fecha Creacion", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Fecha Expiracion", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");

            $context->mensajes = $db->queryStored("FindMensajes", array($_SESSION['UI'],'1',$_SESSION['DEP']), 'ARRAY');	
            $context->notificaciones = $db->queryStored("FindMensajes", array($_SESSION['UI'],'2',$_SESSION['DEP']), 'ARRAY');									
            RenderTemplate('templates/mensajesUsuarios.tpl.php', $context, 'templates/base.php');
        }
				   		
    }else if($action=='show'){

		RenderTemplate('templates/mensajes.tpl.php', $context);
	
	}else if($action=='leido'){
		$id=$_GET['i'];
		$id= (int) $id;
		 $sql="UPDATE mensajes SET Leido=1 WHERE ID_Mensaje=".$id;
		if($db->execute($sql))
			echo 1;
		//RenderTemplate('templates/mensajes.tpl.php', $context);
	
	}else if($action=='addMsg'){
        $tipo = $_GET['tipo'];
        $id = $_GET['i'];		
		$context->tipo=$tipo;
	    $context->usuarios = $db->getArray("SELECT * FROM users WHERE Fecha_Baja IS NULL AND ID_User!= ".$_SESSION['UI']);	
	    $context->dependencias = $db->getArray("SELECT * FROM dependencias WHERE Activo=1 ORDER BY DEPENDENCIA ASC");					
        $context->perfiles = $db->getArray("SELECT * FROM perfiles");
		if($id)
        $context->data = $db->getArray("SELECT * FROM mensajes WHERE ID_Mensaje =$id AND ID_Emisor = ".$_SESSION['UI']);	
		if($context->data[0]['Alcance']=='UNICO'){
			$context->RFC=$db->getOne("SELECT RFC FROM servpub WHERE ID_Serv= '{$context->data[0]['ID_Receptor']}'");
		}
       	RenderTemplate('templates/mensajeForm.tpl.php', $context);			



		//RenderTemplate('templates/mensajes.tpl.php', $context);
	
	}else if($action=='saveMsg'){
	
		if(in_array(55, $context->allow) && ($_POST['receptor']!=$_SESSION['UI']) && ($_POST['t']==1)){
			//mensajes
                        $sql = "select DISTINCT(u.ID_User) 
                                from users u 
                                join user_profile pro on pro.ID_User = u.ID_User ";
			if($_POST['tipo']==2){//por perfil
                            $perfil = $_POST['perfil'];
                            $sql .= "where ID_Perfil = " . $perfil;
			}else{
                            $receptor = $_POST['receptor'];
                            $sql .= "where u.ID_User = " . $receptor;
			}
                        $data = $db->getArray($sql);
                        foreach($data as $d){
                            $id = $db->getID("ID_Mensaje", "mensajes");
                            $db->execute("INSERT INTO  mensajes (ID_Mensaje,Tipo,ID_Emisor,Alcance,ID_Receptor,Fecha_Creacion,Asunto, Mensaje, Leido)VALUES
                            ($id, 1, ".$_SESSION['UI'].", 'UNICO', {$d['ID_User']}, SYSDATE(),'{$_POST['asunto']}','{$_POST['mensaje']}',0) ");	
                        }
			echo 1;	
			
			
		}else if(in_array(59, $context->allow) && ($_POST['t']==2)){
			$id = $db->getID("ID_Mensaje", "mensajes");
			if($_POST['tipo']=='DEPENDENCIA')
				$receptor=$_POST['dependencia'];
			else if($_POST['tipo']=='UNICO')
				$receptor= $_POST['s'];
			else
				$receptor="NULL";				
			if($_POST['i']=='')
				$db->execute("INSERT INTO  mensajes (ID_Mensaje,Tipo,ID_Emisor,Alcance,ID_Receptor,Fecha_Creacion, Fecha_Expiracion, Asunto, Mensaje, Leido)VALUES
				($id, 2, ".$_SESSION['UI'].",'{$_POST['tipo']}', $receptor, SYSDATE(),'{$_POST['fechade']}','{$_POST['asunto']}','{$_POST['mensaje']}',0) ");		
			else{
				if($_POST['e']==$_SESSION['UI'])	
				$db->execute("UPDATE  mensajes SET Alcance='{$_POST['tipo']}',ID_Receptor=$receptor, Fecha_Expiracion='{$_POST['fechade']}', Asunto='{$_POST['asunto']}', Mensaje='{$_POST['mensaje']}'
								WHERE ID_Mensaje={$_POST['i']} 
								AND ID_Emisor={$_SESSION['UI']} 
								LIMIT 1
				");		
				else
					echo "No tiene permisos para editar este registro";
			}
			echo 1;			
			
		}else
			echo "No tiene permisos para enviar mensajes";
			

		//RenderTemplate('templates/mensajes.tpl.php', $context);
	
	}elseif($action == "del"){
       $id = $_GET['id'];
	   $id=(int) $id;
       $sql = "DELETE FROM mensajes WHERE ID_Mensaje =" . $id." LIMIT 1";
       $db->execute($sql);
            
    }elseif($action == "checaRFC"){
        $rfc = $_GET['rfc'];
	$sql = "SELECT ID_Serv FROM servpub WHERE RFC='" . $rfc."' and Estatus = 1 order by ID_Serv DESC LIMIT 1";
        echo $db->getOne($sql);
    }
?>