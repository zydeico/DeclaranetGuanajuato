<?php


    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');   
    require_once ('lib/document.php');
 
    $context = new Context();
    $db = new DBConn(); 

    $action = showVar($_GET['action']);
    $context->title = "Mi historial de declaraciones";
   
    if(!$action && !$_POST){
        $context->allow = getAccess();
        $context->menu = setMenu();      
        $context->data = $db->queryStored("FindDeclaraciones", array($_SESSION['UI']), 'ARRAY');	
        
        RenderTemplate('templates/history.tpl.php', $context, 'templates/base.php');
    }
    else if($action=='generate'){
        $doc = $_GET['type'];
        $id = showVar($_GET['id']);
       
        switch($doc){
            case "Acuse":
                $sql = "select ID_Dec, Tipo_Dec, YEAR(Fecha_Dec) as Anio, DATE(Fecha_Dec) as Fecha, Fecha_Dec from declaraciones where ID_Dec = " . $id;
                $dec = $db->getObject($sql);
                $date = explode("-", $dec->Fecha);
                $data['fecha'] = DayOfWeek($date[0], $date[1], $date[2]) . ", " . DateFormat($dec->Fecha_Dec, 1);
                $data['hora'] = DateFormat($dec->Fecha_Dec, 2) . " hrs.";
                $data['servidor'] = $_SESSION['NM'];
                $data['tipo'] = $dec->Tipo_Dec;
                $data['periodo'] = $dec->Anio;
                $data['control'] = substr($dec->Tipo_Dec, 0, 1) . $dec->Anio . "-" . format($dec->ID_Dec, 10, "0");
                echo hideVar(GenerateDocument($id, $doc, $data, $param));
            break;
            case "Declaracion":
                $data = $db->queryStored("getElementsByDec", array($id, "inmuebles"), 'ARRAY');
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
                $data = $db->queryStored("getElementsByDec", array($id, "muebles"), 'ARRAY');
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
                $data = $db->queryStored("getElementsByDec", array($id, "vehiculos"), 'ARRAY');
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
                $data = $db->queryStored("getElementsByDec", array($id, "inversiones"), 'ARRAY');
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
                $data = $db->queryStored("getElementsByDec", array($id, "adeudos"), 'ARRAY');
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
                $data = $db->queryStored("getElementsByDec", array($id, "dependientes"), 'ARRAY');
                $elem['CÓNYUGE/DEPENDIENTES'] = array("ME" => $data);
                $data = $db->queryStored("getElementsByDec", array($id, "pensiones"), 'ARRAY');
                $elem['PENSIONES']['ME'] = $data;
                $data = $db->queryStored("getElementsByDec", array($id, "ingresos"), 'ARRAY');
                $elem['INGRESOS']['ME'] = $data;
                $data = $db->queryStored("getElementsByDec", array($id, "extras"), 'ARRAY');
                if($data[0]['Ing_Conyuge'])
                    $elem['INGRESOS']['CONYUGE'][] = array("Tipo_Elem" => "ingresos", "Tipo_Trans" => "1", "Importe" => $data[0]['Ing_Conyuge']);
                if($data[0]['Ing_Depend'])
                    $elem['INGRESOS']['DEPEND'][] = array("Tipo_Elem" => "ingresos", "Tipo_Trans" => "1", "Importe" => $data[0]['Ing_Depend']);
                
                $sql = "select CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Fecha_Dec, Tipo_Dec, Dependencia, Puesto
                        from declaraciones d 
                        join servpub sp on sp.ID_Serv = d.ID_Serv
                        join dependencias dep on dep.ID_Dependencia = sp.ID_Dependencia
                        join puestos p on p.ID_Puesto = sp.ID_Puesto
                        where ID_Dec = " . $id;
                $data = $db->getObject($sql);
                $param['name'] = $data->Nombre;
                $param['dec'] = $data->Tipo_Dec;
                $param['dep'] = $data->Dependencia;
                $param['pos'] = $data->Puesto;
                $param['date'] = DateFormat($data->Fecha_Dec, 1) . ", " . DateFormat($data->Fecha_Dec, 2) . " hrs.";
                echo hideVar(GenerateDocument($id, $doc, $elem, $param));
            break;
        }
        
    }elseif($action == "public"){
        $st = $_GET['st'];
        $db = new DBConn();
        $sql = "update publicaciones set Fecha_Oculta = NOW() where Fecha_Oculta is null and ID_Serv = " . $_SESSION['UI'];
        $db->execute($sql);
        if($st == "on"){
            $sql = "insert into publicaciones values(NULL, " . $_SESSION['UI'] . ", NOW(), NULL)";
            $db->execute($sql);
        }
    }

	
?>