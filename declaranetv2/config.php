<?php

    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
	$context = new Context();
    $db = new DBConn(); 
	
    $action = showVar($_GET['action']);
	if($_POST &&  $_POST['action']!='')
    	$action = showVar($_POST['action']);

    $context->title = "Opciones del sistema";
  
    if(!$action && !$_POST){
        $context->allow = getAccess();
        $context->menu = setMenu();         
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Editar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Eliminar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Pregunta", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Respuesta", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");

		
        $sql = "SELECT * FROM faqs  ";
        $context->data = $db->getArray($sql);
        $context->parametros = $db->getArray("SELECT * FROM parametros order by Orden");	

        $context->reactivs[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->reactivs[] = array("Header" => "Editar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->reactivs[] = array("Header" => "Eliminar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->reactivs[] = array("Header" => "Pregunta", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
        $context->reactivs[] = array("Header" => "Tipo", "Width" => "100", "Attach" => "cmb", "Align" => "left", "Sort" => "", "Type" => "ro");
		RenderTemplate('templates/config.tpl.php', $context, 'templates/base.php');
	}elseif($action == "addFaq"){
        $id = $_GET['id'];
        if($id){
            $sql = "select * from faqs where ID_Faq = " . $id;
            $context->data = $db->getObject($sql);
        }
        RenderTemplate('templates/faq.form.php', $context);
    }elseif($action == "validFaq"){
        $Descripcion = $_POST['pregunta'];
        $Respuesta = $_POST['respuesta'];
       	if($Descripcion=='' || $Respuesta=='')
			echo "Todos los campos son obligatorios";
    }elseif($action == "saveFaq"){
        $ID_Faq = $_POST['id'];
        $Descripcion = $_POST['pregunta'];
        $Respuesta = $_POST['respuesta'];
        if($id!='' && $id!=0){//update
            $sql = "UPDATE faqs SET 
                    Descripcion = '" . $Descripcion . "', 
                    Respuesta = '" . $Respuesta . "', 
                    WHERE ID_Faq= " .$ID_Faq. " LIMIT 1";
         } else{//insert
		    $ID_Faq = $db->getID("ID_Faq", "faqs");
            $sql = "INSERT INTO faqs(ID_Faq, Descripcion,Respuesta)VALUES($ID_Faq,'" . $Descripcion . "','" . $Respuesta . "')";			 
		 }
         $db->execute($sql);		
	}elseif($action == "del"){
       $id = $_GET['id'];
       $sql = "DELETE FROM faqs WHERE ID_Faq= " . $id." LIMIT 1";
       $db->execute($sql);
            
    }elseif($action == "saveParams"){
		foreach($_POST as $key => $val){
			$ID_Parametro=substr($key,3);
			$Valor=$val;
			if($val!='undefined'){
				$sql="UPDATE parametros SET Valor='$Valor' WHERE ID_Parametro=$ID_Parametro";
				$db->execute($sql);	
			}
		}
		
		foreach($_FILES as $key => $val){
			if($val['tmp_name']!=''){
				
				$ID_Parametro=substr($key, 3);
				$tmp_name=$val['tmp_name'];
				$name=quitarAcentos($val['name'],true);
                                $ext = strtolower(end(explode(".", $name)));
                                $sqlPar = "SELECT Tipo FROM parametros WHERE ID_Parametro = " . $ID_Parametro;
				$resul = $db->getObject($sqlPar);
				$extensiones=$resul->Tipo;
				$tipos=explode(",",$extensiones);
				$error=1;
				foreach($tipos as $tipo){
				
					if($tipo!=$ext && $error==1){
						$error=1;
					}else
						$error=2;
				}
				if($error==2){
					$context->profile = $data->Perfil;
					//if(strtolower(substr($name,-3))=='pdf' || strtolower(substr($name,-3))=='jpg' || strtolower(substr($name,-4))=='jpeg' || strtolower(substr($name,-2))=='png'){
					
					if($name!=''){
						$sqlExt = "select * from parametros where ID_Parametro = " . $ID_Parametro;
                                                $obExt = $db->getObject($sqlExt);							
                                                $path = explode("/", $obExt->Valor);
                                                $target = "";
                                                for($i=0; $i<count($path)-1; $i++)
                                                    $target .= $path[$i] . "/";
                                                $file = explode(".", $path[count($path)-1]);
                                                $target = $target . $file[0] . "." . $ext;
						if(move_uploaded_file($tmp_name, $target)){
							$sql="UPDATE parametros SET Valor='" . $target . "' WHERE ID_Parametro=$ID_Parametro";
							$db->execute($sql);				
						}else
							echo "Ocurrio un error y el archivo no se subio correctamente.";
					}
				}else
					echo "La extension no es la correcta, solo se aceptan:".$extensiones;
			}
		}		
		$sender = getParam(6);
                if($sender && !SendMail($sender, "Test Sending", "Tester", "Testing..."))
                    echo "Error al enviar correo de prueba";
                
                
    }elseif($action == "addPregunta"){
        $id = $_GET['id'];
        if($id){
            $sql = "select * from reactivos where ID_Reactivo = " . $id;
            $context->reactivosEdit = $db->getObject($sql);
        }
        RenderTemplate('templates/preguntas.form.php', $context);
    }elseif($action == "delPregunta"){
       $id = $_GET['id'];
       $sql = "UPDATE reactivos SET Activo= 0 WHERE ID_Reactivo=" . $id;
       $db->execute($sql);
            
	}else if($action=='saveReactivos'){
		$param='';
		

            if(!empty($_POST)){
			if($_SESSION['UI']){
				$error='';
				$opciones='';
				$ID_Reactivo=$_POST['id'];
				$Reactivo=$_POST['pregunta'];
				foreach($_POST['opt'] as $opt){
                                    if($opt)
					$opciones.=$opt."|";
                                    else
                                        break;
				}
//                                if($opciones)
                                    $opciones=substr($opciones,0,-1);
                                
//                                if($opciones!='' && $Reactivo!=''){
                                        if($ID_Reactivo>0){
                                                //update
                                                $sql="UPDATE reactivos SET Reactivo='$Reactivo', Opciones=" . ($opciones?"'".$opciones."'":"null") . " WHERE ID_Reactivo=$ID_Reactivo";
                                                $db->execute($sql);						
                                        }else{
                                                $ID_Reactivo = $db->getID("ID_Reactivo", "reactivos");
                                                //edit
                                                $sql="INSERT INTO reactivos(ID_Reactivo, Reactivo, Opciones, Activo)VALUES($ID_Reactivo,'$Reactivo'," . ($opciones?"'".$opciones."'":"null") . ",1)";
                                                $db->execute($sql);									
                                        }
//                                }else{
//                                        $error="Faltan campos requeridos";	
//                                }
                                
//				if($error!='')
//					echo $error;
			}

		}
	}
?>