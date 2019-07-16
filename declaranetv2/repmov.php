<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Reporte de movimientos";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where Activo = 1 " . ($_SESSION['TP']=="GLOBAL"?" order by Dependencia":" and ID_Dependencia = " . $_SESSION['DEP']);
        $context->dep = $db->getArray($sql);
        
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "Movimiento", "Width" => "80", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Tipo", "Width" => "80", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Fecha Mov", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Inicio", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Término", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Nombre", "Width" => "300", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Área", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Cargo", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Usuario", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        
        RenderTemplate('templates/repmov.tpl.php', $context, 'templates/base.php');
    }
?>
