<?php

    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn(); 
    $context->title = "Información personal";
    if(!$action){

        $context->data = $db->queryStored("FindInfo", array($_SESSION['UI']), 'ARRAY');	
        $context->email = $db->queryStored("FindEmail", array($_SESSION['UI']), 'ARRAY');	
        $sqlEstados = "select * from estados";
        $context->estados = $db->getArray($sqlEstados);
		
        $context->ID_Estado=$db->getOne("select ID_Estado from ciudades WHERE ID_Ciudad=".($context->data[0]['ID_Ciudad']?$context->data[0]['ID_Ciudad']:"0"));

        $sqlCiudades = "select * from ciudades where ID_Estado=".($context->ID_Estado?$context->ID_Estado:"0");
        $context->ciudades = $db->getArray($sqlCiudades);		

        $context->allow = getAccess();
        $context->menu = setMenu();
        RenderTemplate('templates/info.tpl.php', $context, 'templates/base.php');

    }else if($action=='save'){
		$param=array();

        if(!empty($_POST)){
			$error='';
			//$id = $db->getID("ID_Info", "infoserv");
			$param[] = $_POST['i'];	
                        $param[] = $_SESSION['UI'];
			$param[] = $_POST['Calle'];
			$param[] = $_POST['Colonia'];
			$param[] = $_POST['Numero'];
			$param[] = $_POST['Ciudad'];
			$param[] = $_POST['CP'];												
			$param[] = $_POST['Telefono'];
			$param[] = $_POST['Civil'];
			$param[] = $_POST['CURP'];
			$x=0;
			foreach($param as $par){
				if($par=='')
					$error.="Todos los campos son obligatorios $x.";				
			}
			
			if(ValidateMail($_POST['email'])!=''){
				$error.="<br />El email tiene un formato incorrecto.";
			}
			if($_POST['email']==''){
				$error.="<br />El email principal es obligatorio.";
			}
			
			$paramEmail[]=$_POST['email'];	
			$paramEmail[]=$_POST['alter'];	
			$paramEmail[] = $_SESSION['UI'];
			if($error==''){			
				$db->queryStored("EditInfo", $param);			
				$db->queryStored("EditEmail", $paramEmail);							
                                
			}else
				echo $error;
		/*	if(!$db->queryStored("FindInfo", array($_SESSION['UI'],$_POST['i']), 'ARRAY')){//reviza si existe
				$db->queryStored("NewInfo", $param);								
				$param[] = $id;
			}else{
				$param[] = $_POST['i'];				
				$db->queryStored("EditInfo", $param);					
			}
		*/
		}
	}else if($action=='cities'){
				$id=$_GET['ciud'];
				$sqlCiudades = "select * from ciudades where ID_Estado=".$id;
				$ciudades = $db->getArray($sqlCiudades);
				foreach($ciudades as $ciudad){
                		echo "<option value='".$ciudad['ID_Ciudad']."'>".$ciudad['Ciudad']."</option>";
                 }
	}
	
	
?>
