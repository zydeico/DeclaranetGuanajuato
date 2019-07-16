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
	$ID_Declaracion=$_GET['id'];
    $context->title = "Encuesta";
  
    if(!$action && !$_POST && $ID_Declaracion!='' && $ID_Declaracion!=0){
        $context->allow = getAccess();
        $context->menu = setMenu();         
		
		$sql = "SELECT * FROM reactivos  WHERE Activo=1  ";
		$context->reactivos = $db->getArray($sql);
		$context->existeEncuesta = $db->queryStored("FindSurvey", array($ID_Declaracion,$_SESSION['UI']), 'ARRAY');			
		//validar que el id de declaracion sea el correspondiente
		$context->declaracionValida = $db->queryStored("FindDeclaracionValida", array($ID_Declaracion,$_SESSION['UI']), 'ARRAY');		
		
		RenderTemplate('templates/survey.tpl.php', $context, 'templates/base.php');

	}elseif($action == "saveSurvey"){
//		$sql = "SELECT GROUP_CONCAT( ID_Reactivo)as Opciones FROM reactivos WHERE Activo=1 ";
//		
//		$reactivos = $db->getArray($sql);
                $reactivos = $_POST['reactivo'];
                $ID_Declaracion=(int) $_POST['i'];
//		$opciones=explode(",",$reactivos[0]['Opciones']);
		
		$error=0;	
		$resp='';
		 if($ID_Declaracion=='' || $ID_Declaracion==0){
                        $error=1;
		 }
		 
		 if($error==0){
                     foreach($reactivos as $r){
		 	if($_POST['opt'.$r]!='')
                            $resp.=$r."-".$_POST['opt'.$r]."|";
			elseif($_POST['resp'.$r]!='')
                            $resp.=$r."-".str_replace("-", "", $_POST['resp'.$r])."|";
                        else
                            $error=1;
                    }
                    $respuesta=substr($resp,0,-1);
                    
                    $paramsCheck=array();
                    $paramsCheck[]=$ID_Declaracion;
                    $paramsCheck[]=$_SESSION['UI'];			 
                    $existeEncuesta = $db->queryStored("FindSurvey", array($ID_Declaracion,$_SESSION['UI']), 'ARRAY');	
                    if($existeEncuesta){
                           echo "Ya has contestado esta encuesta o no es posible hacerlo ahora";

                    }else{
                            $ID_Encuesta = $db->getID("ID_Encuesta", "encuestas");
                            $param[]=$ID_Encuesta;
                            $param[]=$ID_Declaracion;
                            $param[]=$_SESSION['UI'];
                            $param[]=$respuesta;
                            $db->queryStored("NewSurvey", $param);	

                    }
		 }else
		 	echo "Todos los campos son obligatorios";	
	}
	
	
	
?>