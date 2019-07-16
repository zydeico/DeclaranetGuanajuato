<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Consulta de declaraciones";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where Activo = 1 order by Dependencia";
        $context->dep = $db->getArray($sql);
        
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ed");
        $context->params[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Cargo", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Patrimonial", "Width" => "70", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "Intereses", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
//        $context->params[] = array("Header" => "Fiscal", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        RenderTemplate('templates/consult.tpl.php', $context, 'templates/base.php');
    }
?>
