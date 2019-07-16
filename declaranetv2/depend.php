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

    $context->title = "Catálogo de dependencias";
    if(!$action && !$_POST){
        $context->allow = getAccess();
        $context->menu = setMenu();         
		$context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
		$context->params[] = array("Header" => "Editar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Eliminar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");

        RenderTemplate('templates/depend.tpl.php', $context, 'templates/base.php');
	}elseif($action == "addDependencia"){
        $id = $_GET['id'];
        if($id){
            $sql = "select * from dependencias where ID_Dependencia = " . $id;
            $context->data = $db->getObject($sql);
        }
        RenderTemplate('templates/depend.form.php', $context);
    }elseif($action == "saveDependencia" && $_POST['dependencia']!=''){
        $ID_Dependencia = $_POST['id'];
        $dependencia = $_POST['dependencia'];
        if($ID_Dependencia!='' && $ID_Dependencia!=0){//update
            $sql = "UPDATE dependencias SET 
                    Dependencia = '" . $dependencia . "' 
                    WHERE ID_Dependencia= " .$ID_Dependencia. " 
					LIMIT 1";
         } else{//insert
		    $ID_Dependencia = $db->getID("ID_Dependencia", "dependencias");
            $sql = "INSERT INTO dependencias(ID_Dependencia, Dependencia,Activo)VALUES($ID_Dependencia,'" . $dependencia . "',1)";			 
		 }
         $db->execute($sql);		
	}elseif($action == "delDependencia"){
       $id = $_GET['id'];
       $sql = "UPDATE dependencias SET Activo=0 WHERE ID_Dependencia= " . $id." LIMIT 1";
       $db->execute($sql);
            
    }
	
?>