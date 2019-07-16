<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Acuerdos declaración pública";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where Activo = 1 order by Dependencia";
        $context->dep = $db->getArray($sql);
        
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Cargo", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Estatus", "Width" => "150", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Ver", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        RenderTemplate('templates/adopublica.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "acuerdo"){
        $id = $_GET['id'];
        $context->id = $id;
        
        
        $sql = "select dp.ID_AcuerdoPub, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Dependencia, Puesto, Motivo, Fecha_Doc, dp.Estatus, dp.Documento 
                from servpub sp 
                join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
                join puestos p on p.ID_Puesto = sp.ID_Puesto 
                join acuerdo_dec_pub dp on dp.ID_Serv = sp.ID_Serv
                where sp.ID_Serv = " . $id;
        
        $context->general = $db->getObject($sql);
        
        RenderTemplate('templates/adopublica.view.php', $context);
        
    }elseif($action == "resp"){
        $id = $_POST['id'];
        $resp = showVar($_GET['resp']);
        $text = $_POST['txtMotivo'];
        
        $sql = "update acuerdo_dec_pub set Motivo = '" . $text . "', Estatus = " . $resp . " where ID_AcuerdoPub = " .$id;
        $db->execute($sql);
        
    }
?>
