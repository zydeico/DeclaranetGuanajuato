<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Reporte de cumplimiento";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where Activo = 1 " . ($_SESSION['TP']=="GLOBAL"?" order by Dependencia":" and ID_Dependencia = " . $_SESSION['DEP']);
        $context->dep = $db->getArray($sql);
        $sql = "select IFNULL(MIN(YEAR(Fecha_Dec)), YEAR(NOW())) from declaraciones";
        $context->min = $db->getOne($sql);
        
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Obligados", "Width" => "80", "Attach" => "txt", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "Cumplidos", "Width" => "80", "Attach" => "txt", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "% Individual", "Width" => "80", "Attach" => "txt", "Align" => "center", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Faltantes", "Width" => "80", "Attach" => "txt", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "% Total", "Width" => "80", "Attach" => "txt", "Align" => "center", "Sort" => "str", "Type" => "ro");
        
        RenderTemplate('templates/repcump.tpl.php', $context, 'templates/base.php');
    }
?>
