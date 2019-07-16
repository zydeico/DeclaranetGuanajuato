<?php
    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');

	 session_start();
		$permiso_para_agregar = 57;
		$add = "0";
		$access = getAccess();
		//print_r($_SESSION);
		foreach($access as $key=>$val){ 
		   if($val == $permiso_para_agregar){
			   $add = "1";
			}
		} 
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn(); 
    $context->title = "Oficios";
	//echo $action;
    if(!$action){
		$_SESSION['attrib_ac'] = $access;
		//ac'] = $access;
        $context->allow = $access;
        $context->menu = setMenu();
		$sql = "select * from oficios";
            $context->data = $db->getObject($sql);
			$context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
			
			if($add == "1"){
				 $context->params[] = array("Header" => "Editar", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
				  $context->params[] = array("Header" => "Borrar", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
				}
       
	   
	    
       
		$context->params[] = array("Header" => "Expediente", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
		$context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
		$context->params[] = array("Header" => "Fecha", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
		$context->params[] = array("Header" => "Instrucción", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
		$context->params[] = array("Header" => "Responsable", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
		$context->params[] = array("Header" => "Estatus", "Width" => "*", "Attach" => "cmb", "Align" => "left", "Sort" => "cmb", "Type" => "ro");
	
		if($add == "0"){
				 $context->params[] = array("Header" => "Cambiar Estatus", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
				}
		
        RenderTemplate('templates/ofic.tpl.php', $context, 'templates/base.php');
    }
	elseif($action=='get_usuarios'){
	//	echo "asd";
	$dp = $_GET['dp'];
		$sql = 'select ID_User, concat(Nombre, " ", Paterno) as Nombre from users where ID_Dependencia = '.$dp.';';
		
			
		$data = $db->getArray($sql);
		
		foreach($data as $d){
			
			echo ' <option value="'.$d['ID_User'].'">'.$d['Nombre'].'</option>';
		}
		
	}
	elseif($action == "editar_user"){
		$id	 = $_GET['id'];
		$sql = "select REPLACE(REPLACE(REPLACE(oficios.Estatus, '1', 'Pendiente') , '2', 'En Tramite') , '3', 'Atendido') as Estatus, Estatus as Estatusb from oficios where id_Oficio = ".$id;
			 $d_est = $db->getArray($sql);
			 $context->arr = $d_est;
			 $context->v_id = $id;
			RenderTemplate('templates/oficios.add.php', $context);
		}	
	elseif($action == "nuevo" || $action == "editar"){
		//echo $action;
		$context->editar = 0; 
		
		if($action == "editar"){
			$context->editar = 1; 
			$id	 = $_GET['id'];
			$context->id = $id; 
			$sql = 'select * from oficios where ID_Oficio = '.$id;
			$data_rowg = $db->getArray($sql);
			$context->data_rowg = $data_rowg;
			
			$sql = "select Dependencia from dependencias where ID_Dependencia = ".$data_rowg[0]['ID_Dependencia'];;
	  $data_dependencia_name = $db->getArray($sql);
	  
	  $context->data_dependencia_name = $data_dependencia_name;
	  
	  $sql = 'select concat(users.Nombre, " ", users.Paterno) as Nombre, ID_User from users where ID_User = '.$data_rowg[0]['ID_Responsable'];
		 $d_namee = $db->getArray($sql);
		  $context->d_namee = $d_namee;
		 
		 $sql = "select REPLACE(REPLACE(REPLACE(oficios.Estatus, '1', 'Pendiente') , '2', 'En Tramite') , '3', 'Atendido') as Estatus, Estatus as Estatusb from oficios where id_Oficio = ".$id;
			 $d_est = $db->getArray($sql);
			 $context->d_est = $d_est;
		}
			$sql = "select ID_Dependencia, Dependencia from dependencias where Activo = 1";
            $data_dependencia = $db->getArray($sql);
			$context->data_dependencia = $data_dependencia;
			
			$sql = "select user_profile.ID_User, concat(users.Nombre, ".'" "'.", users.Paterno) as Nombre from user_profile, users where user_profile.ID_Perfil in (select perfiles.ID_Perfil from perfiles where Acceso like '%|50|%' or Acceso like '%|57|%') and user_profile.ID_User = users.ID_User group by user_profile.ID_User";
		$data_users = $db->getArray($sql);
		$context->data_users = $data_users;
		RenderTemplate('templates/oficios.add_new.php', $context);	
	}
	elseif($action == "save"){
		$editar = $_POST['editar'];
        $dependencia = $_POST['dependencia'];
        $instrucciones = $_POST['instrucciones'];
        $responsable = $_POST['responsable'];
        $estatus = $_POST['estatus'];
		$expediente = $_POST['expediente'];
       // echo $estatus;
	   if($editar>=1){
			$sql = "UPDATE oficios SET ID_Responsable = '".$responsable."', Expediente = '".$expediente."', ID_Dependencia = '".$dependencia."', Instruccion = '".$instrucciones."', Estatus = '".$estatus."' WHERE ID_Oficio = ".$editar;
		}else{
				$sql = "INSERT INTO oficios (ID_User, ID_Responsable, Expediente, ID_Dependencia, Fecha_Turno, Instruccion, Estatus) VALUES ('".$_SESSION['UI']."', '".$responsable."', '".$expediente."', '".$dependencia."', now(), '".$instrucciones."', '".$estatus."');";
		} 
        //echo $sql;
        $db->execute($sql);
		//header("Location: Ofic.php");
    }elseif($action == "save_user"){
		$id = $_POST['id'];
        $estatus = $_POST['estatus'];
		$sql = "UPDATE oficios SET Estatus = '".$estatus."' WHERE ID_Oficio = ".$id;
		 $db->execute($sql);
		//header("Location: Ofic.php");
		}
		elseif($action == 'Borrar'){
			$sql = "delete from oficios where ID_Oficio = ".$_GET['id'];
			echo $sql;
        $db->execute($sql);
			}
			//echo $action;
?>
