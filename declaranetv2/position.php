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

    $context->title = "Catálogo de puestos";
    if(!$action && !$_POST){
        $context->allow = getAccess();
        $context->menu = setMenu();         
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Editar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Eliminar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Pruesto", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");

        $context->puestos = $db->getArray("SELECT * FROM puestos");	

		RenderTemplate('templates/position.tpl.php', $context, 'templates/base.php');
	}elseif($action == "addPuesto"){
        $id = $_GET['id'];
        if($id){
            $sql = "select * from puestos where ID_Puesto = " . $id;
            $context->data = $db->getObject($sql);
        }
        RenderTemplate('templates/position.form.php', $context);
    }elseif($action == "savePuesto" && $_POST['puesto']!=''){
        $ID_Puesto = $_POST['id'];
        $puesto = $_POST['puesto'];
        if($ID_Puesto!='' && $ID_Puesto!=0){//update
            $sql = "UPDATE puestos SET 
                    Puesto = '" . $puesto . "' 
                    WHERE ID_Puesto= " .$ID_Puesto. " LIMIT 1";
         } else{//insert
		    $ID_Puesto = $db->getID("ID_Puesto", "puestos");
            $sql = "INSERT INTO puestos(ID_Puesto, Puesto,Activo)VALUES($ID_Puesto,'" . $puesto . "',1)";			 
		 }
         $db->execute($sql);		
	}elseif($action == "delPuesto"){
       $id = $_GET['id'];
       $sql = "UPDATE puestos SET Activo=0 WHERE ID_Puesto= " . $id." LIMIT 1";
       $db->execute($sql);
            
    }
	
?>