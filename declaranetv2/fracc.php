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

    $context->title = "Catálogo de fracciones";
    if(!$action && !$_POST){
        $context->allow = getAccess();
        $context->menu = setMenu();         
		$context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
		$context->params[] = array("Header" => "Editar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Eliminar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Fraccion", "Width" => "50", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Descripción", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");

		RenderTemplate('templates/fracc.tpl.php', $context, 'templates/base.php');
	}elseif($action == "addFraccion"){
        $id = $_GET['id'];
        if($id){
            $sql = "select * from fracciones where ID_Fraccion = " . $id;
            $context->data = $db->getObject($sql);
        }
        RenderTemplate('templates/fracc.form.php', $context);
    }elseif($action == "saveFraccion" && $_POST['Fraccion']!=''){
        $ID_Fraccion = $_POST['id'];
        $Fraccion = $_POST['Fraccion'];
        $Descripcion = $_POST['Descripcion'];		
        if($ID_Fraccion!='' && $ID_Fraccion!=0 && $Descripcion!=''){//update
            $sql = "UPDATE fracciones SET 
                    Fraccion = '" . $Fraccion . "',
                    Descripcion = '" . $Descripcion . "'  
                    WHERE ID_Fraccion= " .$ID_Fraccion. " 
					LIMIT 1";
         } else{//insert
		    $ID_Fraccion = $db->getID("ID_Fraccion", "fracciones");
            $sql = "INSERT INTO fracciones(ID_Fraccion, Fraccion,Descripcion,Activo)VALUES($ID_Fraccion,'" . $Fraccion . "','" . $Descripcion . "',1)";			 
		 }
         $db->execute($sql);		
	}elseif($action == "delFraccion"){
       $id = $_GET['id'];
       $sql = "UPDATE fracciones SET Activo=0 WHERE ID_Fraccion= " . $id." LIMIT 1";
       $db->execute($sql);
            
    }
	
?>