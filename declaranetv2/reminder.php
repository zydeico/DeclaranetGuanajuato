<?php

    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    require_once ('lib/document.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn(); 
    $context->title = "Recordatorios y Convenios";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu(); 
        $sql = "select * from dependencias where " . ($_SESSION['TP']=="GLOBAL"?"Activo = 1":"ID_Dependencia = " . $_SESSION['DEP']) . " order by Dependencia";
        $context->dep = $db->getArray($sql);
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Selección", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ch");
        $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ed");
        $context->params[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Alta/Baja", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Días restantes", "Width" => "70", "Attach" => "txt", "Align" => "center", "Sort" => "int", "Type" => "ro");
        if(in_array(9, $context->allow))
            $context->params[] = array("Header" => "Recordatorio", "Width" => "80", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        if(in_array(7, $context->allow))
            $context->params[] = array("Header" => "Convenio", "Width" => "70", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        RenderTemplate('templates/reminder.tpl.php', $context, 'templates/base.php');
    
    }elseif($action == "remind"){
        $type = $_GET['type'];
        $id = $_POST['id'];
        
        $sql = "select CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Dependencia, Puesto, Fecha_Inicio, Fecha_Termino
                from servpub sp 
                join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
                join puestos p on p.ID_Puesto = sp.ID_Puesto 
                where ID_Serv " . (is_array($id)?"in " . concat($id):" = " . $id) . "
                order by Nombre";
        $data = $db->getArray($sql);
        $sql = "select * from dias_inhabiles where YEAR(Fecha) >= (YEAR(NOW()) - 1)";
        $omit = $db->getArray($sql);
        foreach ($omit as $o)
            $inhab[] = $o['Fecha'];
        echo hideVar(GenerateDocument($_SESSION['UI'], "R." . $type, $data, $inhab));
        
    }elseif($action == "data"){
        $id = $_GET['id'];
        $context->id = $id;
        $sql = "select * from infoserv i 
                left join ciudades c on c.ID_Ciudad = i.ID_Ciudad 
                left join estados e on e.ID_Estado = c.ID_Estado
                where ID_Serv = " . $id . " order by ID_Info DESC LIMIT 1";
        $context->data = $db->getObject($sql);
        $sql = "select * from estados order by Estado";
        $context->estate = $db->getArray($sql);
        $sql = "select * from ciudades where ID_Estado = " . ($context->data->ID_Estado?$context->data->ID_Estado:"0") . " order by Ciudad";
        $context->cities = $db->getArray($sql);
        RenderTemplate('templates/reminder.data.php', $context);
        
    }elseif($action == "agree"){
        $id = $_POST['id'];
        $serv = $_POST['serv'];
        $street = $_POST['street'];
        $num = $_POST['num'];
        $col = $_POST['col'];
        $city = $_POST['city'];
        $card = $_POST['card'];
        $key = $_POST['key'];
        
        $sql = "update infoserv set 
                Calle = '" . $street . "', 
                Numero = '" . $num . "', 
                Colonia = '" . $col . "', 
                ID_Ciudad = '" . $city . "', 
                Telefono = '" . $phone . "', 
                Identificacion = '" . $card . "', 
                Clave = '" . $key . "'
                where ID_Info = " . $id;
        $db->execute($sql);
        $sql = "select CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, RFC, Dependencia, Puesto, Fecha_Inicio
                from servpub sp 
                join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
                join puestos p on p.ID_Puesto = sp.ID_Puesto 
                where ID_Serv = " . $serv;
        $obj = $db->getObject($sql);
        $sql = "select * from dias_inhabiles where YEAR(Fecha) >= (YEAR(NOW()) - 1)";
        $omit = $db->getArray($sql);
        foreach ($omit as $o)
            $inhab[] = $o['Fecha'];
        $data['address'] = $street . " " . $num . ", " . $col;
        $data['card'] = $card;
        $data['key'] = $key;
        $data['city'] = $db->getOne("select Ciudad from ciudades where ID_Ciudad = " . $city);
        $data['name'] = $obj->Nombre;
        $data['RFC'] = $obj->RFC;
        $data['pos'] = $obj->Puesto;
        $data['dep'] = $obj->Dependencia;
        $data['date'] = $obj->Fecha_Inicio;
        $data['limit'] = Calculate($obj->Fecha_Inicio, getParam(3), $inhab);
        
        echo hideVar(GenerateDocument($_SESSION['UI'], "Convenio", $data));
    }
        
?>
