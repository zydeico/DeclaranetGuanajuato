<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    require_once ('lib/document.php');
   
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Procedimientos";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where Activo = 1 order by Dependencia";
        $context->dep = $db->getArray($sql);
        $sql = "select * from agenda order by ID_Agenda DESC LIMIT 1";
        $context->agend = $db->getObject($sql);
        $sql = "select IFNULL(MIN(YEAR(Fecha_Proc)), YEAR(NOW())) from procedimientos where Activo = 1";
        $context->year = $db->getOne($sql);
        
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "Editar", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "Eliminar", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ed");
        $context->params[] = array("Header" => "Nombre", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Tipo", "Width" => "100", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Fecha Proc", "Width" => "120", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "PRA", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Fecha PRA", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Bloqueado", "Width" => "70", "Attach" => "cmb", "Align" => "center", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Generar", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "str", "Type" => "ro");
        
        RenderTemplate('templates/procedure.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "new"){
        $type = $_GET['type'];
        $ver = $_GET['ver'];
        $dec = $_GET['dec'];
        $proced = array();
        
        if($type == "1"){
           $id = $_GET['id'];
           if ($db->exist("ID_Proc", "procedimientos", "Tipo_Proc = 1 and Activo = 1 and ID_Verif = " . $ver))
                $error[]["ID"] = $id;
           else
               $proced[] = $id;
        }else{
            $id = $_POST['id'];
            foreach($id as $i){
                if($db->exist("ID_Proc", "procedimientos", "Tipo_Proc = 2 and Activo = 1 and YEAR(Fecha_Proc) = YEAR(NOW()) and ID_Serv = " . $i . " and Omision = '" . $dec ."'"))
                    $error[]["ID"] = $i;
                else
                    $proced[] = $i;
            }
        }
        
        foreach($proced as $i){
            $sql = "insert into procedimientos values("
                 . $db->getID("ID_Proc", "procedimientos") . ", "
                 . $i . ", "
                 . "NOW(), "
                 . $type . ", "
                 . ($ver?$ver:"null") . ", "
                 . ($dec?"'".$dec."'":"null") . ", "
                 . "null, " // PRA
                 . "null, " // Fecha PRA
                 . "1, " // Bloq
                 . $_SESSION['UI'] . ", "
                 . "1)";
            $db->execute($sql);
        }
        if($error)
            echo json_encode($error);
        
    }elseif($action == "del"){
        $id = $_GET['id'];
        $sql = "update procedimientos set Activo = 0, ID_User = " . $_SESSION['UI'] . " where ID_Proc = " . $id;
        $db->execute($sql);
        
    }elseif($action == "generate"){
        $id = $_GET['id'];
        $type = $_GET['type'];
        $sql = "select * from parametros order by ID_Parametro";
        $values = $db->getArray($sql);
        foreach($values as $v)
            $param[$v['ID_Parametro']] = $v['Valor'];
        
        if($type == "1"){
            $sql = "select v.ID_Serv, Since, Until, CONCAT_WS(' ', sp.Paterno, sp.Materno, sp.Nombre) as Nombre, Dependencia, Puesto
                    from verificacion v 
                    join servpub sp on sp.ID_Serv = v.ID_Serv 
                    join dependencias d on d.ID_Dependencia = sp.ID_Dependencia
                    join puestos pos on pos.ID_Puesto = sp.ID_Puesto 
                    join procedimientos p on p.ID_Verif = v.ID_Verificacion
                    where ID_Proc = " . $id;
            $verif = $db->getObject($sql);
            $declare = $db->queryStored("FindDeclaraciones", array($verif->ID_Serv), 'ARRAY');
            $param['name'] = $verif->Nombre;
            $param['dep'] = $verif->Dependencia;
            $param['pos'] = $verif->Puesto;
            $elem = array();
                    
            foreach($declare as $dec){
                if($dec['ID_Dec'] >= $verif->Since && $dec['ID_Dec'] <= $verif->Until){
                    $data = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "inmuebles"), 'ARRAY');
                    foreach($data as $d){
                        switch($d['Own']){
                            case "ME":
                                $inmuebles["ME"][] = $d;
                            break;
                            case "CONYUGE":
                                $inmuebles["CONYUGE"][] = $d;
                            break;
                            default: 
                                $inmuebles["DEPEND"][] = $d;
                            break;
                        }
                    }
                    $elem['INMUEBLES'] = $inmuebles;
                    $data = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "muebles"), 'ARRAY');
                    foreach($data as $d){
                        switch($d['Own']){
                            case "ME":
                                $muebles["ME"][] = $d;
                            break;
                            case "CONYUGE":
                                $muebles["CONYUGE"][] = $d;
                            break;
                            default: 
                                $muebles["DEPEND"][] = $d;
                            break;
                        }
                    }
                    $elem['MUEBLES'] = $muebles;
                    $data = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "vehiculos"), 'ARRAY');
                    foreach($data as $d){
                        switch($d['Own']){
                            case "ME":
                                $vehiculos["ME"][] = $d;
                            break;
                            case "CONYUGE":
                                $vehiculos["CONYUGE"][] = $d;
                            break;
                            default: 
                                $vehiculos["DEPEND"][] = $d;
                            break;
                        }
                    }
                    $elem['VEHÍCULOS'] = $vehiculos;
                    $data = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "inversiones"), 'ARRAY');
                    foreach($data as $d){
                        switch($d['Own']){
                            case "ME":
                                $inversiones["ME"][] = $d;
                            break;
                            case "CONYUGE":
                                $inversiones["CONYUGE"][] = $d;
                            break;
                            default: 
                                $inversiones["DEPEND"][] = $d;
                            break;
                        }
                    }
                    $elem['INVERSIONES'] = $inversiones;
                    $data = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "adeudos"), 'ARRAY');
                    foreach($data as $d){
                        switch($d['Own']){
                            case "ME":
                                $adeudos["ME"][] = $d;
                            break;
                            case "CONYUGE":
                                $adeudos["CONYUGE"][] = $d;
                            break;
                            default: 
                                $adeudos["DEPEND"][] = $d;
                            break;
                        }
                    }
                    $elem['ADEUDOS'] = $adeudos;
                    $data = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "dependientes"), 'ARRAY');
                    $elem['CÓNYUGE/DEPENDIENTES'] = array("ME" => $data);
                    $data = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "ingresos"), 'ARRAY');
                    $elem['INGRESOS'] = array("ME" => $data);
                    $eval[$d['ID_Dec']] = array("type" => $dec['Tipo_Dec'], "date" => $dec['Fecha_Dec'], "elem" => $elem);
                }
            }
            echo hideVar(GenerateDocument($id, "Verificacion", $eval, $param));
        }else{
            $sql = "select CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Fecha_Proc, Dependencia, Puesto, Fecha_Inicio, Fecha_Termino, Omision 
                    from procedimientos p 
                    join servpub sp on sp.ID_Serv = p.ID_Serv 
                    join dependencias d on d.ID_Dependencia = sp.ID_Dependencia
                    join puestos pos on pos.ID_Puesto = sp.ID_Puesto 
                    where ID_Proc = " . $id;
            $data = $db->getObject($sql);
            echo hideVar(GenerateDocument($id, "Constancia", $data, $param));
        }
        
    }elseif($action == "edit"){
        $id = $_GET['id'];
        $sql = "select ID_Proc, PRA, Fecha_PRA, Bloqueado from procedimientos where ID_Proc = " . $id;
        $context->data = $db->getObject($sql);
        RenderTemplate('templates/procedure.edit.php', $context);
        
    }elseif($action == "save"){
        $id = $_POST['id'];
        $pra = $_POST['pra'];
        $date = $_POST['date'];
        $bloq = $_POST['bloq'];
        
        $sql = "update procedimientos set 
                PRA = '" . $pra . "', 
                Fecha_PRA = '" . $date . "', 
                Bloqueado = " . ($bloq?"1":"0") . "
                where ID_Proc = " . $id;
        $db->execute($sql);
    }
?>
