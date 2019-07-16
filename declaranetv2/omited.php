<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
   
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Casos omisos";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where " . ($_SESSION['TP']=="GLOBAL"?"Activo = 1":"ID_Dependencia = " . $_SESSION['DEP']) . " order by Dependencia";
        $context->dep = $db->getArray($sql);
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "Selección", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "str", "Type" => "ch");
        $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ed");
        $context->params[] = array("Header" => "Nombre", "Width" => "250", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Cargo", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Área", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Correo", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Inicio/Termino", "Width" => "90", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Prórroga", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Vencido", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Artículo 64", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Dirección", "Width" => "300", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        
        RenderTemplate('templates/omited.tpl.php', $context, 'templates/base.php');
        
    }
?>
