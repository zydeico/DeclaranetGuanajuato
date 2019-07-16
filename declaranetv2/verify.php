<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
   
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Proceso de verificación";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where Activo = 1 order by Dependencia";
        $context->dep = $db->getArray($sql);
        $sql = "select * from puestos where Activo = 1 order by Puesto";
        $context->pos = $db->getArray($sql);
        $sql = "select IFNULL(MIN(YEAR(Fecha_Dec)), YEAR(NOW())) from declaraciones";
        $context->min = $db->getOne($sql);
        $context->params1[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params1[] = array("Header" => "Selección", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ch");
        $context->params1[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params1[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params1[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params1[] = array("Header" => "Cargo", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params1[] = array("Header" => "Estatus", "Width" => "80", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params1[] = array("Header" => "Ver", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        
        $context->params2[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params2[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params2[] = array("Header" => "Nombre", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params2[] = array("Header" => "Declaración", "Width" => "90", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params2[] = array("Header" => "Responsable", "Width" => "120", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params2[] = array("Header" => "Estatus", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params2[] = array("Header" => "Información", "Width" => "300", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params2[] = array("Header" => "Verificación", "Width" => "300", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params2[] = array("Header" => "Observaciones", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params2[] = array("Header" => "Fecha verif.", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        
        RenderTemplate('templates/verify.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "view"){
        $id = $_GET['id'];
        $context->id = $id;
        
        $dec = $db->queryStored("FindDeclaraciones", array($id), 'ARRAY');
       
        foreach($dec as $d){
            $balance[$d['Tipo_Dec'] . " (" . $d['Fecha_Dec'] . ")"] = $db->queryStored("Balance", array($d['ID_Dec']), 'ARRAY');
            $info[] = $d['ID_Info'];
        }
        $context->balance = ($balance?$balance:array());
        
        $sql = "select CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Dependencia, Puesto, Correo, Correo2 
                from servpub sp 
                join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
                join puestos p on p.ID_Puesto = sp.ID_Puesto 
                where ID_Serv = " . $id;
        $context->general = $db->getObject($sql);
        
        $context->mov = array();
        $search = $id;
        do{
            $movement = $db->queryStored("getMovimientos", array($search, $mov), 'ARRAY');
            $context->mov = array_merge($context->mov, $movement);
            $search = $movement[0]['Procedencia'];
        }while($search);
        
        if($info){
            $sql = "select i.*, c.Ciudad, e.Estado from infoserv i 
                    left join ciudades c on c.ID_Ciudad = i.ID_Ciudad
                    left join estados e on e.ID_Estado = c.ID_Estado
                    where ID_Info in " . concat($info) . " order by ID_Info DESC";
            $datainfo = $db->getArray($sql); 
            for($i=0; $i<count($dec); $i++)
                $context->info[$dec[$i]['Tipo_Dec'] . " (" . $dec[$i]['Fecha_Dec'] . ")"] = $datainfo[$i];
        }else
            $context->info = array();
        
        $context->stuff['INMUEBLES'] = $db->queryStored("FindInmuebles", array($id), 'ARRAY');
        $context->stuff['MUEBLES'] = $db->queryStored("FindMuebles", array($id), 'ARRAY');
        $context->stuff['VEHÍCULOS'] = $db->queryStored("FindVehiculos", array($id), 'ARRAY');
        $context->stuff['INVERSIONES'] = $db->queryStored("FindInversiones", array($id), 'ARRAY');
        $context->stuff['ADEUDOS'] = $db->queryStored("FindAdeudos", array($id), 'ARRAY');
        $context->stuff['CONYUGE/DEPENDIENTES'] = $db->queryStored("FindDependientes", array($id), 'ARRAY');
        
        $db->queryStored("RegisterConsult", array($id, $_SESSION['UI'], "Consulta General"));
        RenderTemplate('templates/verify.view.php', $context);
        
    }elseif($action == "json"){
        $id = $_GET['id'];
        $dec = $db->queryStored("FindDeclaraciones", array($id), 'ARRAY');
        $json = array();
        for($i=count($dec) - 1; $i>=0; $i--){
            if($dec[$i]['Tipo_Dec'] != "INICIAL"){
                $balance = $db->queryStored("Balance", array($dec[$i]['ID_Dec']), 'ARRAY');
                $date = explode("-", $dec[$i]['Fecha_Dec']);
                $income = $balance[0]['sueldo'] + $balance[0]['honorarios'] + $balance[0]['otros'] + $balance[0]['en_inmuebles'] + $balance[0]['en_muebles'] + $balance[0]['en_vehiculos'] + $balance[0]['inversiones'] + $balance[0]['adeudos'];
                $income_else = $balance[0]['conyuge'] + $balance[0]['depend'] + $balance[0]['en_inmuebles_con'] + $balance[0]['en_inmuebles_dep'] + $balance[0]['en_muebles_con'] + $balance[0]['en_muebles_dep'] + $balance[0]['en_vehiculos_con'] + $balance[0]['en_vehiculos_dep'] + $balance[0]['inversiones_con'] + $balance[0]['inversiones_dep'] + $balance[0]['adeudos_con'] + $balance[0]['adeudos_dep'];
                $debit = $balance[0]['ad_inmuebles'] + $balance[0]['ad_muebles'] + $balance[0]['ad_vehiculos'] + $balance[0]['pagos'] + $balance[0]['depositos'];
                $debit_else = $balance[0]['ad_inmuebles_con'] + $balance[0]['ad_inmuebles_dep'] + $balance[0]['ad_muebles_con'] + $balance[0]['ad_muebles_dep'] + $balance[0]['ad_vehiculos_con'] + $balance[0]['ad_vehiculos_dep'] + $balance[0]['pagos_con'] + $balance[0]['pagos_dep'] + $balance[0]['depositos_con'] + $balance[0]['depositos_dep'];
                $json[] = array("dec" => $dec[$i]['Tipo_Dec'] . "-" . $date[0], "income" => $income, "debit" => $debit, "income_else" => $income_else, "debit_else" => $debit_else);
            }
        }
        echo json_encode($json);
        
    }elseif($action == "send"){
        $ids = $_POST['ids'];
        $not = array();
        $since = array();
        
        foreach($ids as $i){
            $sql = "select CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Until 
                    from verificacion v 
                    join servpub sp on sp.ID_Serv = v.ID_Serv 
                    where v.ID_Serv = " . $i . " and General >= 0 order by ID_Verificacion DESC LIMIT 1";
            $data = $db->getObject($sql);
            if($data){
                $sql = "select ID_Dec from declaraciones where ID_Serv = " . $i . " and ID_Dec > " . $data->Until . " order by ID_Dec LIMIT 1";
                $last = $db->getOne($sql);
                if($last)
                    $since[$i] = $last;
                else
                    $not[$i] = $data->Nombre;
            }else{
                $sql = "select min(ID_Dec) from declaraciones where ID_Serv = " . $i;
                $since[$i] = $db->getOne($sql);
            }
        }
        if($not){
            $error = "Sin declaraciones recientes: ";
            foreach($not as $k => $v)
                $error .= "<br>" . $v;
            echo $error;
        }else{
            foreach($since as $i => $s){
                $sql = "insert into verificacion values("
                         . $db->getID("ID_Verificacion", "verificacion") . ", "
                         . "NOW(), "
                         . $i . ", "
                         . $_SESSION['UI'] . ", "
                         . "null, " // Responsable
                         . "0, " // Estatus sin asignacion 
                         . "null, " // Cierre 
                         . $s . ", "
                         . "(select max(ID_Dec) from declaraciones where ID_Serv = " . $i . "))";
                $db->execute($sql);
            }
        }
        
    }elseif($action == "list"){
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        if(in_array(51, $_SESSION['PM'])){
            $context->params[] = array("Header" => "Eliminar", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Cambiar", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        }
        $context->params[] = array("Header" => "Fecha<br>inclusión", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ed");
        $context->params[] = array("Header" => "Nombre", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Cónyuge/Depend.", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Inmuebles<br>propios", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Inmuebles<br>depend.", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Responsable", "Width" => "120", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Resúm", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Verificación", "Width" => "70", "Attach" => "", "Align" => "center", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Cerrada", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "str", "Type" => "ro");
        
        $sql = "select IFNULL(MIN(YEAR(Fecha_Inclusion)), YEAR(NOW())) from verificacion";
        $context->min = $db->getOne($sql);
        
        RenderTemplate('templates/verify.list.php', $context);
    }elseif($action == "del"){
        $id = $_GET['id'];
        $sql = "update verificacion set ID_User = " . $_SESSION['UI'] . ", General = -1 where ID_Verificacion = " .$id;
        $db->execute($sql);
    
    }elseif($action == "change"){
        if(empty($_POST)){
            $id = $_GET['id'];
            $context->id = $id;
            $sql = "select ID_Resp from verificacion where ID_Verificacion = " . $id;
            $context->resp = $db->getOne($sql);
            $sql = "select DISTINCT(u.ID_User), CONCAT_WS(' ', Nombre, Paterno, Materno) as Nombre 
                    from users u 
                    join user_profile pro on pro.ID_User = u.ID_User 
                    join perfiles p on p.ID_Perfil = pro.ID_Perfil
                    where Acceso like '%52|%'";
            $context->users = $db->getArray($sql);
            RenderTemplate('templates/verify.change.php', $context);
        }else{
            $id = $_POST['id'];
            $user = $_POST['user'];
            $sql = "update verificacion set ID_Resp = " . $user . ", General = 1 where ID_Verificacion = " . $id;
            $db->execute($sql);
        }
    }elseif($action == "verify"){
        $id = $_GET['id'];
        $ver = $_GET['ver'];
        $look = $_GET['look'];
        if($ver){
            $sql = "select Since, Until from verificacion where ID_Verificacion = " . $ver;
            $data = $db->getObject($sql);
        }
        $dec = $db->queryStored("FindDeclaraciones", array($id), 'ARRAY');
        unset($_SESSION['DEC']);
        for($i=count($dec)-1; $i>=0; $i--){
            if(($dec[$i]['ID_Dec'] >= $data->Since && $dec[$i]['ID_Dec'] <= $data->Until) || $look)
                $_SESSION['DEC'][] = array("ID" => $dec[$i]['ID_Dec'], "TYPE" => $dec[$i]['Tipo_Dec'], "DATE" => $dec[$i]['Fecha_Dec']);
        }
        echo $_SESSION['DEC'][0]['ID'];
        
    }elseif($action == "show"){
        $id = $_GET['id'];
        $ver = $_GET['ver'];
        $context->id = $id;
        $context->ver = $ver;
        if($ver){
            $sql = "select ID_Serv, ID_Resp, Fecha_Cierre from verificacion where ID_Verificacion = " . $context->ver;
            $verif = $db->getObject($sql);
            $context->resp = $verif->ID_Resp;
            $context->close = $verif->Fecha_Cierre;
        }else{
            $sql = "select ID_Serv from declaraciones where ID_Dec = " . $id;
            $serv = $db->getOne($sql);
        }
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
        $data = $db->queryStored("getElementsByDec", array($id, "dependientes"), 'ARRAY');
        $depend["ME"] = $data;
        $data = $db->queryStored("getElementsByDec", array($id, "pensiones"), 'ARRAY');
        $pension["ME"] = $data;
        $data = $db->queryStored("getElementsByDec", array($id, "ingresos"), 'ARRAY');
        $income["ME"] = $data;
        $data = $db->queryStored("getElementsByDec", array($id, "extras"), 'ARRAY');
        $income['CONYUGE'] = $data[0]['Ing_Conyuge'];
        $income['DEPEND'] = $data[0]['Ing_Depend'];
        
        $context->data['INMUEBLES'] = $inmuebles;
        $context->data['MUEBLES'] = $muebles;
        $context->data['VEHÍCULOS'] = $vehiculos;
        $context->data['INVERSIONES'] = $inversiones;
        $context->data['ADEUDOS'] = $adeudos;
        $context->data['CONYUGE/DEPENDIENTES'] = $depend;
        $context->data['PENSIONES'] = $pension;
        $context->data['INGRESOS'] = $income;
//        var_export($income);
        for($i=0; $i<count($_SESSION['DEC']); $i++){
            if($id == $_SESSION['DEC'][$i]['ID']){
                $context->dec = $_SESSION['DEC'][$i]['TYPE'];
                $context->date = $_SESSION['DEC'][$i]['DATE'];
                $context->prev = $_SESSION['DEC'][$i-1]['ID'];
                $context->next = $_SESSION['DEC'][$i+1]['ID'];
                break;
            }
        }
        $db->queryStored("RegisterConsult", array($verif?$verif->ID_Serv:$serv, $_SESSION['UI'], ($ver?"Verificación":"Declaración")));
        RenderTemplate('templates/verify.core.php', $context);
        
    }elseif($action == "save"){
        $seg = $_POST['seg'];
        $trans = $_POST['trans'];
        $id = $_POST['id'];
        $verif = $_POST['verif'];
        $obs = $_POST['obs'];
        $resp = $_POST['resp'];
        $st = $_POST['st'];
        
        if($seg){
            $sql = "update seguimiento set 
                    ID_User = " . $resp . ", 
                    Estatus = " . $st . ", 
                    Verificacion = '" . $verif . "', 
                    Observaciones = '" . $obs . "', 
                    Fecha_Seg = NOW()
                    where ID_Seg = " . $seg;
        }else{
            $sql = "insert into seguimiento values("
                 . $db->getID("ID_Seg", "seguimiento") . ", "
                 . $id . ", "
                 . $trans . ", "
                 . $resp . ", "
                 . $st . ", "
                 . "'" . $verif . "', " 
                 . "'" . $obs . "', " 
                 . "NOW() )";
        }
        $db->execute($sql);
        
        $sqlCount = "select COUNT(ID_Seg) from seguimiento s 
                     join verificacion v on v.ID_Verificacion = s.ID_Verificacion 
                     where Estatus = 2 and v.ID_Verificacion = ". $id;
        
        $sql = "update verificacion set General = " . ($db->getOne($sqlCount)>0?"2":"1") . " where ID_Verificacion = " . $id;
        $db->execute($sql);
        sleep(1);
    }elseif($action == "close"){
        $id = $_GET['id'];
        $sql = "update verificacion set Fecha_Cierre = NOW() where ID_Verificacion = " . $id;
        $db->execute($sql);
        Header('location: verify.php');
        
    }elseif($action == "proced"){
        $id = $_GET['id'];
        $context->ver = $id;
        $sql = "select v.ID_Serv, Fecha_Inclusion, Fecha_Cierre, General, CONCAT_WS(' ', Nombre, Paterno, Materno) as Resp 
                from verificacion v 
                join users u on u.ID_User = v.ID_Resp
                where ID_Verificacion = " . $id;
        $context->data = $db->getObject($sql);
        RenderTemplate('templates/verify.closed.php', $context);
        
    }elseif ($action == "worksheet") {
        $context->allow = getAccess();
        $context->menu = setMenu();
        
        $id = $_GET['id'];
        $ver = $_GET['ver'];
        $sql = "select CONCAT_WS(' ', Nombre, Paterno, Materno) as Servidor, Cargo_Funcional, Dependencia "
                . "from servpub sp "
                . "join dependencias d on d.ID_Dependencia = sp.ID_Dependencia "
                . "where ID_Serv = " . $id;
        $context->info = $db->getObject($sql);
        
        $context->obs = array();
        if($ver){
            $sql = "select ID_Serv, ID_Resp, Fecha_Cierre from verificacion where ID_Verificacion = " . $ver;
            $verif = $db->getObject($sql);
            $context->resp = $verif->ID_Resp;
            $context->close = $verif->Fecha_Cierre;
            $sql = "select Fecha_Obs, Tipo_Obs, CONCAT_WS(' ', Nombre, Paterno, Materno) as Usuario, Observacion "
                    . "from verificacion_obs o "
                    . "join verificacion v on v.ID_Verificacion = o.ID_Verif "
                    . "join users u on u.ID_User = v.ID_Resp "
                    . "where ID_Serv = " . $id;
            $context->obs = $db->getArray($sql);
        }
        $json = array();
        $inmuebles = array();
        $muebles = array();
        $vehiculos = array();
        $inversiones = array();
        $adeudos = array();
        $declared = array_reverse($db->getArray("CALL FindDeclaraciones(" . $id . ")"));
        foreach ($declared as $dec) {
            
            if($dec['Tipo_Dec'] != "INICIAL"){
                $balance = $db->queryStored("Balance", array($dec['ID_Dec']), 'ARRAY');
                $date = explode("-", $dec['Fecha_Dec']);
                $income = $balance[0]['sueldo'] + $balance[0]['honorarios'] + $balance[0]['otros'] + $balance[0]['en_inmuebles'] + $balance[0]['en_muebles'] + $balance[0]['en_vehiculos'] + $balance[0]['inversiones'] + $balance[0]['adeudos'];
                $income_else = $balance[0]['conyuge'] + $balance[0]['depend'] + $balance[0]['en_inmuebles_con'] + $balance[0]['en_inmuebles_dep'] + $balance[0]['en_muebles_con'] + $balance[0]['en_muebles_dep'] + $balance[0]['en_vehiculos_con'] + $balance[0]['en_vehiculos_dep'] + $balance[0]['inversiones_con'] + $balance[0]['inversiones_dep'] + $balance[0]['adeudos_con'] + $balance[0]['adeudos_dep'] + $balance[0]['pensiones'];
                $debit = $balance[0]['ad_inmuebles'] + $balance[0]['ad_muebles'] + $balance[0]['ad_vehiculos'] + $balance[0]['pagos'] + $balance[0]['depositos'];
                $debit_else = $balance[0]['ad_inmuebles_con'] + $balance[0]['ad_inmuebles_dep'] + $balance[0]['ad_muebles_con'] + $balance[0]['ad_muebles_dep'] + $balance[0]['ad_vehiculos_con'] + $balance[0]['ad_vehiculos_dep'] + $balance[0]['pagos_con'] + $balance[0]['pagos_dep'] + $balance[0]['depositos_con'] + $balance[0]['depositos_dep'];
                $json[] = array("dec" => $dec['Tipo_Dec'] . "-" . $date[0], "income" => $income, "debit" => $debit, "income_else" => $income_else, "debit_else" => $debit_else);
            }
            
            if($search = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "inmuebles"), 'ARRAY'))
                $inmuebles[] = $search;

            if($search = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "muebles"), 'ARRAY'))
                $muebles[] = $search;
            
            if($search = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "vehiculos"), 'ARRAY'))
                $vehiculos[] = $search;

            if($search = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "inversiones"), 'ARRAY'))
                $inversiones[] = $search;

            if($search = $db->queryStored("getElementsByDec", array($dec['ID_Dec'], "adeudos"), 'ARRAY'))
                $adeudos[] = $search;
            
        }
        
        $context->data['INMUEBLES'] = $inmuebles;
        $context->data['MUEBLES'] = $muebles;
        $context->data['VEHÍCULOS'] = $vehiculos;
        $context->data['INVERSIONES'] = $inversiones;
        $context->data['ADEUDOS'] = $adeudos;
        $context->json = json_encode($json);
        
        $context->title = "Verificación patrimonial";
        $context->id = $id;
        $context->ver = $ver;
        
        RenderTemplate('templates/verify.worksheet.php', $context, 'templates/base.php');
        
    }elseif($action == "obs"){
        $ver = $_POST['ver'];
        $obs = $_POST['obs'];
        
        $sql = "insert into verificacion_obs values(NULL, 'GENERAL', " . $ver . ", NOW(), '" . $obs . "')";
        $db->execute($sql);
        sleep(1);
        
    }elseif($action == "adds"){
        $id = $_POST['id'];
        $obs = $_POST['obs'];
        $target = $_POST['target'];
        
        $sql = "insert into verificacion_obs values(NULL, '" . $target . "', " . $id . ", NOW(), '" . $obs . "')";
        $db->execute($sql);
        sleep(1);
    }
        
?>