<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
   
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Declaración Patrimonial";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        RenderTemplate('templates/declare.tpl.php', $context, 'templates/base.php');
    
        
    }elseif($action == "view"){
        $context->action = $_GET['cat'];
        switch($_GET['cat']){
            case "inmuebles":
                $context->title = "Mis inmuebles actuales";
                $context->info ="Propiedades que no pueden ser trasladadas del lugar en que se hallan, tales como: 
                                 CASAS, DEPARTAMENTOS, TERRENOS, LOCALES, etc.";
                $context->height = "max";
                $context->data = $db->queryStored("FindInmuebles", array($_SESSION['UI']), 'ARRAY');
                $opt[0][] = array("img" => "img/cancel.png", "action" => 0, "title" => "Eliminar elemento");
                $opt[1][] = array("img" => "img/sell.png", "action" => 2, "title" => "Vender", "dim" => 280);
                $opt[1][] = array("img" => "img/gift.png", "action" => 4, "title" => "Donar/Regalar", "dim" => 250);
                $opt[1][] = array("img" => "img/minus.png", "action" => 5, "title" => "Perdido", "dim" => 280);
                $opt[2][] = array("img" => "img/return.png", "action" => 9, "title" => "Cancelar venta", "dim" => 280);
            break;
            case "muebles":
                $context->title ="Mis muebles actuales";
                $context->info = "Objetos que se pueden trasladarse de un lugar a otro y pueden ser clasificados en LÍNEA BLANCA, 
                                  ELECTRÓNICA, MUEBLES DE CASA, CÓMPUTO, OFICINA, etc.";
                $context->height = 430;
                $context->data = $db->queryStored("FindMuebles", array($_SESSION['UI']), 'ARRAY');
                $opt[0][] = array("img" => "img/cancel.png", "action" => 0, "title" => "Eliminar elemento");
                $opt[1][] = array("img" => "img/sell.png", "action" => 2, "title" => "Vender", "dim" => 280);
                $opt[1][] = array("img" => "img/gift.png", "action" => 4, "title" => "Donar/Regalar", "dim" => 250);
                $opt[1][] = array("img" => "img/minus.png", "action" => 5, "title" => "Perdido", "dim" => 280);
                $opt[2][] = array("img" => "img/return.png", "action" => 9, "title" => "Cancelar venta", "dim" => 280);
            break;
            case "vehiculos":
                $context->title ="Mis vehículos actuales";
                $context->info ="Cualquier medio de transporte o maquinaria tales como: AUTOMÓVIL, MOTOCICLETA, MAQUINARIA AGRÍCOLA, etc.";
                $context->height = 480;
                $context->data = $db->queryStored("FindVehiculos", array($_SESSION['UI']), 'ARRAY');
                $opt[0][] = array("img" => "img/cancel.png", "action" => 0, "title" => "Eliminar elemento");
                $opt[1][] = array("img" => "img/sell.png", "action" => 2, "title" => "Vender", "dim" => 280);
                $opt[1][] = array("img" => "img/gift.png", "action" => 4, "title" => "Donar/Regalar", "dim" => 250);
                $opt[1][] = array("img" => "img/minus.png", "action" => 5, "title" => "Perdido", "dim" => 280);
                $opt[2][] = array("img" => "img/return.png", "action" => 9, "title" => "Cancelar venta", "dim" => 280);
            break;
            case "inversiones":
                $context->title ="Mis inversiones actuales";
                $context->info ="Cualquier tipo de AHORRO de capital que puede ser en efectivo o bienes con el objetivo de 
                                 generar ganancias a futuro como: CAJA DE AHORRO, CUENTA BANCARIA, PRÉSTAMOS, NEGOCIOS, etc.";
                $context->height = 350;
                $context->data = $db->queryStored("FindInversiones", array($_SESSION['UI']), 'ARRAY');
                $opt[0][] = array("img" => "img/cancel.png", "action" => 0, "title" => "Eliminar elemento");
                $opt[1][] = array("img" => "img/minus.png", "action" => 8, "title" => "Finiquitar inversión", "dim" => 220);
            break;
            case "adeudos":
                $context->title = "Mis adeudos actuales";
                $context->info ="Cualquier tipo de deuda que se este pagando actualmente, así como los adquiridos para 
                                 obtener nuevos bienes, ejemplos: HIPOTECARIO, AUTOFINANCIAMIENTO, PRÉSTAMOS PERSONALES Y BANCARIOS, TARJETAS DE CRÉDITO, etc.";
                $context->height = 450;
                $context->data = $db->queryStored("FindAdeudos", array($_SESSION['UI']), 'ARRAY');
                $opt[0][] = array("img" => "img/cancel.png", "action" => 0, "title" => "Eliminar elemento");
                $opt[1][] = array("img" => "img/minus.png", "action" => 7, "title" => "Liquidar adeudo", "dim" => 220);
            break;
            case "dependientes":
                $context->title ="Mis dependientes actuales";
                $context->info = "Esposo o esposa, además de aquellas personas que tienen una dependencia económica directa";
                $context->height = 400;
                $context->data = $db->queryStored("FindDependientes", array($_SESSION['UI']), 'ARRAY');
                $opt[0][] = array("img" => "img/cancel.png", "action" => 0, "title" => "Eliminar elemento");
                $opt[1][] = array("img" => "img/info.png", "action" => 12, "title" => "Actualizar información", "dim" => 280);
                $opt[1][] = array("img" => "img/separate.png", "action" => 6, "title" => "Separación", "dim" => 220);
            break; 
        }
        $context->opt = $opt;
        RenderTemplate('templates/declare.view.php', $context);
        
        
    }elseif($action == "details"){
        $id = showVar($_GET['id']);
        $target = $_GET['target'];
        $sql = "select ID_Depend, Nombre_Depend from ddependientes where Estatus >= 0 and ID_Serv = " . $_SESSION['UI'];
        $context->depend = $db->getArray($sql);
        $sql = "select ID_Adeudo as ID, Tipo_Ad, Institucion_Ad, Cuenta_Ad from dadeudos where Estatus >= 0 and ID_Serv = " . $_SESSION['UI'];
        $context->credit = $db->getArray($sql);
        if(is_numeric($id)){
            switch($target){
                case "dependientes":
                    $sql = "select * from ddependientes d 
                            join dtransacciones t on t.ID_Elem = d.ID_Depend and Tipo_Elem = 'dependientes'
                            join depend_hist h on h.ID_Depend = d.ID_Depend 
                            where Tipo_Trans = 1 and d.ID_Depend = " . $id . "
                            order by ID_Hist DESC LIMIT 1";
                break;
                case "inversiones":
                    $sql = "select * from dinversiones d 
                            join dtransacciones t on t.ID_Elem = d.ID_Inversion and Tipo_Elem = 'inversiones'
                            where Tipo_Trans = 1 and ID_Inversion = " . $id . "
                            order by ID_Trans DESC LIMIT 1";
                break;
                case "adeudos":
                    $sql = "select * from dadeudos d 
                            join dtransacciones t on t.ID_Elem = d.ID_Adeudo and Tipo_Elem = 'adeudos'
                            where Tipo_Trans = 1 and ID_Adeudo = " . $id . "
                            order by ID_Trans DESC LIMIT 1";
                break;
                case "inmuebles":
                    $sql = "select * from dinmuebles d 
                            join dtransacciones t on t.ID_Elem = d.ID_Inmueble and Tipo_Elem = 'inmuebles'
                            where Tipo_Trans in (1, 3, 15, 16, 17, 18, 19) and ID_Inmueble = " . $id . "
                            order by ID_Trans DESC LIMIT 1";
                break;
                case "muebles":
                    $sql = "select * from dmuebles d 
                            join dtransacciones t on t.ID_Elem = d.ID_Mueble and Tipo_Elem = 'muebles'
                            where Tipo_Trans in (1, 3, 15, 16, 17, 18, 19) and ID_Mueble = " . $id . "
                            order by ID_Trans DESC LIMIT 1";
                break;
                case "vehiculos":
                    $sql = "select * from dvehiculos d 
                            join dtransacciones t on t.ID_Elem = d.ID_Vehiculo and Tipo_Elem = 'vehiculos'
                            where Tipo_Trans in (1, 3, 15, 16, 17, 18, 19) and ID_Vehiculo = " . $id . "
                            order by ID_Trans DESC LIMIT 1";
                break;
            }
            $context->data = $db->getObject($sql);
            $context->canmodify = ($_SESSION['MODIFY'] && $_SESSION['MODIFY'] == $context->data->ID_Dec);
            
        }
        RenderTemplate('templates/declare.' . $target . ".php", $context);
        
    }elseif($action == "save"){
        $update = $id = showVar($_POST['id']);
        $ts = showVar($_POST['trans']);
        $target = $_GET['target'];
        $param = array();
        $trans = array();
        $obs = $_POST['obs'];
        
        switch($target){
            case "dependientes":
                $error = ValidateRFC($_POST['RFC']);
                if(!$error){
                    $mov = 1;
                    $year = substr($_POST['RFC'], 4, 2);
                    $month = substr($_POST['RFC'], 6, 2);
                    $day = substr($_POST['RFC'], 8, 2);
                    $year = ($year<=Date('y')?"20":"19") . $year;
                    if(checkdate($month, $day, $year)){
                        if(!is_numeric($id))
                            $id = $db->getID("ID_Depend", "ddependientes");
                        $param[] = $id;
                        $param[] = $_SESSION['UI'];
                        $param[] = $_POST['relation'];
                        $param[] = hideVar(Upper($_POST['name']));
                        $param[] = hideVar(Upper($_POST['RFC']));
                        $param[] = hideVar(Upper($_POST['CURP']));
                        $param[] = hideVar(Upper($_POST['direc']));
                        $param[] = $year . "-" . $month . "-" . $day;
                        $param[] = hideVar($_POST['ocupacion']);
                        $param[] = hideVar($_POST['place']);
                        $param[] = hideVar($_POST['address']);
                        $db->queryStored("setDependiente", $param);
                    }else{
                        echo "Fecha de nacimiento en RFC incorrecta, favor de revisar: " . $year . "-" . $month . "-" . $day;;
                        exit;
                    }
                    
                }else{
                    echo $error;
                    exit;
                }
            break;
            case "inmuebles":
                $mov = ($_SESSION['DEC']=="INICIAL"?3:$_POST['mov']);
                $form = $_POST['form'];
                $credit = $_POST['credit'];
                $date = $_POST['date'];
                $imp = str_replace(",", "", $_POST['value']);
                if(is_numeric($imp)){
                    if(!is_numeric($id))
                        $id = $db->getID("ID_Inmueble", "dinmuebles");
                    $param[] = $id;
                    $param[] = $_SESSION['UI'];
                    $param[] = $_POST['type'];
                    $param[] = hideVar(Upper($_POST['tm2']));
                    $param[] = hideVar(Upper($_POST['cm2']));
                    $param[] = hideVar(Upper($_POST['street']));
                    $param[] = hideVar(Upper($_POST['num']));
                    $param[] = hideVar(Upper($_POST['col']));
                    $param[] = hideVar(Upper($_POST['city']));
                    $param[] = hideVar($_POST['CP']);
                    $param[] = $_POST['titular'];
                    $db->queryStored("setInmueble", $param);
                }else{
                    echo "Valor de inmueble incorrecto, favor de revisar";
                    exit;
                }
            break;
            case "muebles":
                $mov = ($_SESSION['DEC']=="INICIAL"?3:$_POST['mov']);
                $form = $_POST['form'];
                $credit = $_POST['credit'];
                $date = $_POST['date'];
                $imp = str_replace(",", "", $_POST['value']);
                if(is_numeric($imp)){
                    if(!is_numeric($id))
                        $id = $db->getID("ID_Mueble", "dmuebles");
                    $param[] = $id;
                    $param[] = $_SESSION['UI'];
                    $param[] = $_POST['type'];
                    $param[] = hideVar(Upper($_POST['desc']));
                    $param[] = $_POST['titular'];
                    $db->queryStored("setMueble", $param);
                }else{
                    echo "Valor de mueble incorrecto, favor de revisar";
                    exit;
                }
            break;
            case "vehiculos":
                $mov = ($_SESSION['DEC']=="INICIAL"?3:$_POST['mov']);
                $form = $_POST['form'];
                $credit = $_POST['credit'];
                $date = $_POST['date'];
                $imp = str_replace(",", "", $_POST['value']);
                if(is_numeric($imp)){
                    if(!is_numeric($id))
                        $id = $db->getID("ID_Vehiculo", "dvehiculos");
                    $param[] = $id;
                    $param[] = $_SESSION['UI'];
                    $param[] = $_POST['type'];
                    $param[] = hideVar(Upper($_POST['mark']));
                    $param[] = hideVar(Upper($_POST['serie']));
                    $param[] = hideVar(Upper($_POST['model']));
                    $param[] = hideVar($_POST['year']);
                    $param[] = $_POST['titular'];
                    $db->queryStored("setVehiculo", $param);
                }else{
                    echo "Valor de vehículo incorrecto, favor de revisar";
                    exit;
                }
            break;
            case "inversiones":
                $mov = 1;
                $date = $_POST['date'];
                $imp = str_replace(",", "", $_POST['balance']);
                if(is_numeric($imp)){
                    if(!is_numeric($id)){
                        $id = $db->getID("ID_Inversion", "dinversiones");
                        $balance = $imp;
                    }
                    $param[] = $id;
                    $param[] = $_SESSION['UI'];
                    $param[] = $_POST['type'];
                    $param[] = hideVar(Upper($_POST['inst']));
                    $param[] = hideVar(Upper($_POST['account']));
                    $param[] = $_POST['titular'];
                    $db->queryStored("setInversion", $param);
                }else{
                    echo "Valor de saldo incorrecto, favor de revisar";
                    exit;
                }
            break;
            case "adeudos":
                $mov = 1;
                $date = $_POST['date'];
                $imp = str_replace(",", "", $_POST['balance']);
                if(is_numeric($imp)){
                    if(!is_numeric($id)){
                        $id = $db->getID("ID_Adeudo", "dadeudos");
                        $balance = $imp;
                    }
                    $param[] = $id;
                    $param[] = $_SESSION['UI'];
                    $param[] = $_POST['type'];
                    $param[] = hideVar(Upper($_POST['inst']));
                    $param[] = hideVar(Upper($_POST['account']));
                    $param[] = hideVar($_POST['term']);
                    $param[] = hideVar($_POST['pay']);
                    $param[] = $_POST['titular'];
                    $db->queryStored("setAdeudo", $param);
                }else{
                    echo "Valor de saldo incorrecto, favor de revisar";
                    exit;
                }
            break;
        }
        if(is_numeric($update)){
            $sql = "update dtransacciones set 
                    Fecha_Mov = " . ($date?"'".$date."'":"null") . ", 
                    Forma_Trans = " . ($form?"'".$form."'":"null") . ", 
                    ID_Credito = " . ($credit?$credit:"null") . ", 
                    Importe = " . ($imp?$imp:"null") . ", 
                    Saldo = " . ($imp?$imp:"null") . ", 
                    Observaciones = '" . $obs . "'
                    where ID_Trans = " . $ts;
            $db->execute($sql);
        }else{
            $trans[] = ""; // Declaracion
            $trans[] = $id;
            $trans[] = $target;
            $trans[] = $date;
            $trans[] = $mov;
            $trans[] = $form;
            $trans[] = $credit;
            $trans[] = $imp;
            $trans[] = $balance;
            $trans[] = ""; // Plazo
            $trans[] = $obs;
            $db->queryStored("NewTransaction", $trans);
        }
        if(array_search($target, $_SESSION['CHANGE']) !== false)
            unset($_SESSION['CHANGE'][array_search($target, $_SESSION['CHANGE'])]);
        
    }elseif($action == "manage"){
        if(empty($_POST)){
            $context->id = $_GET['id'];
            $context->target = $_GET['target'];
            $context->opt = $_GET['opt'];
            if($context->opt == 12){
                $sql = "select * from depend_hist where ID_Depend = " . showVar($context->id) . " order by ID_Hist DESC LIMIT 1";
                $context->data = $db->getObject($sql);
            }
            RenderTemplate('templates/declare.manage.php', $context);
        }else{
            $trans = array();
            $id = showVar($_POST['id']);
            $target = $_POST['target'];
            $opt = $_POST['opt'];
            $direc = $_POST['direc'];
            $ocupacion = $_POST['ocupacion'];
            $job_place = $_POST['job_place'];
            $job_address = $_POST['job_address'];
            
            switch ($opt){
                case "2":
                    if($_POST['form'] == "CREDITO")
                        $st = "2";
                    else
                        $st = "-1";
                break;
                case "9":
                case "12":
                    $st = "1";
                break;
                default:
                    $st = "-1";
                break;
            }
            switch($target){
                case "dependientes":
                    $sql = "update ddependientes set Estatus = " . $st . " where ID_Depend = " . $id;
                break;
                case "adeudos":
                    $sql = "update dadeudos set Estatus = " . $st . " where ID_Adeudo = " . $id;
                break;
                case "inversiones":
                    $sql = "update dinversiones set Estatus = " . $st . " where ID_Inversion = " . $id;
                break;
                case "inmuebles":
                    $sql = "update dinmuebles set Estatus = " . $st . " where ID_Inmueble = " . $id;
                break;
                case "muebles":
                    $sql = "update dmuebles set Estatus = " . $st . " where ID_Mueble = " . $id;
                break;
                case "vehiculos":
                    $sql = "update dvehiculos set Estatus = " . $st . " where ID_Vehiculo = " . $id;
                break;
            }
            $db->execute($sql);
            
            if($opt == 12){
                $sql = "delete from dtransacciones where Tipo_Elem = 'dependientes' and Tipo_Trans = 12 and ID_Dec is null and ID_Elem = " . $id;
                $db->execute($sql);
                $sql = "insert into depend_hist values(NULL, NOW(), " . $id . ", '" . hideVar($direc) . "', '" . hideVar($ocupacion) . "', " . ($ocupacion=="TRABAJA"?"'".hideVar($job_place)."'":"NULL") . ", " . ($ocupacion=="TRABAJA"?"'".hideVar($job_address)."'":"NULL") . ")";
                $db->execute($sql);
            } 
            
            $trans[] = ""; // Declaracion 
            $trans[] = $id;
            $trans[] = $target;
            $trans[] = $_POST['date'];
            $trans[] = $opt;
            $trans[] = $_POST['form'];
            $trans[] = ""; // Credit
            $trans[] = str_replace(",", "", $_POST['value']);
            $trans[] = ($st == "-1"?"0":str_replace(",", "", $_POST['value']));
            $trans[] = $_POST['term'] . " " . $_POST['period'];
            $trans[] = ($opt=="4"?"Beneficiario: ".$_POST['benefit'].", Parentesco: ".$_POST['relation']:$_POST['motive']);
            $db->queryStored("NewTransaction", $trans);
            
            if(array_search($target, $_SESSION['CHANGE']) !== false)
                unset($_SESSION['CHANGE'][array_search($target, $_SESSION['CHANGE'])]);
        }
        
    }elseif($action == "del"){
        $id = showVar($_GET['id']);
        $target = $_GET['target'];
        switch($target){
            case "dependientes":
                $sql = "delete from ddependientes where ID_Depend = " . $id;
            break;
            case "inversiones":
                $sql = "delete from dinversiones where ID_Inversion = " . $id;
            break;
            case "adeudos":
                $sql = "delete from dadeudos where ID_Adeudo = " . $id;
            break;
            case "inmuebles":
                $sql = "delete from dinmuebles where ID_Inmueble = " . $id;
            break;
            case "muebles":
                $sql = "delete from dmuebles where ID_Mueble = " . $id;
            break;
            case "vehiculos":
                $sql = "delete from dvehiculos where ID_Vehiculo = " . $id;
            break;
        }
        $db->execute($sql);
        $sql = "delete from dtransacciones where Tipo_Elem = '" . $target . "' and ID_Elem = " . $id;
        $db->execute($sql);
        
        if(array_search($target, $_SESSION['CHANGE']) !== false)
            unset($_SESSION['CHANGE'][array_search($target, $_SESSION['CHANGE'])]);
        
    }elseif($action == "final"){
        $sql = "select Dependencia, Area, Puesto, Nivel, Per_Mensual, Fecha_Inicio, Tel_Trabajo, 
                Calle_Trabajo, Num_Trabajo, Col_Trabajo, CP_Trabajo, Ciudad_Trabajo
                from servpub sp 
                join dependencias d on d.ID_Dependencia = sp.ID_Dependencia
                join puestos p on p.ID_Puesto = sp.ID_Puesto 
                where ID_Serv = " . $_SESSION['UI'];
        $context->lab = $db->getObject($sql);
        $sql = "select Calle, Numero, Colonia, CP, IFNULL(c.ID_Ciudad, 0) as ID_Ciudad, e.ID_Estado, Telefono, Civil, CURP 
                from infoserv i 
                join declaraciones d on d.ID_Info = i.ID_Info
                left join ciudades c on c.ID_Ciudad = i.ID_Ciudad 
                left join estados e on e.ID_Estado = c.ID_Estado 
                where i.ID_Serv = " . $_SESSION['UI'] . " order by i.ID_Info DESC LIMIT 1";
        $context->per = $db->getObject($sql);
        $sql = "select * from estados order by Estado";
        $context->estate = $db->getArray($sql);
        $sql = "select * from ciudades where ID_Estado = " . ($context->per->ID_Estado?$context->per->ID_Estado:"0");
        $context->city = $db->getArray($sql);
        $sql = "select ID_Inmueble as ID, CONCAT_WS('|', 'inmuebles', Calle_In, Numero_In, Colonia_In, Ciudad_In) as Info
                from dinmuebles where Estatus = 2 and ID_Serv = " . $_SESSION['UI'];
        $temp_in = $db->getArray($sql);
        $sql = "select ID_Mueble as ID, CONCAT_WS('|', 'muebles', Descripcion_Mue) as Info
                from dmuebles where Estatus = 2 and ID_Serv = " . $_SESSION['UI'];
        $temp_mue = $db->getArray($sql);
        $sql = "select ID_Vehiculo as ID, CONCAT_WS('|', 'vehiculos', Marca_Veh, Modelo_Veh, Anio_Veh) as Info
                from dvehiculos where Estatus = 2 and ID_Serv = " . $_SESSION['UI'];
        $temp_veh = $db->getArray($sql);
        $context->sell = array_merge($temp_in, $temp_mue, $temp_veh);
        $sql = "select DISTINCT(ID_Adeudo) as ID, CONCAT_WS('|', Institucion_Ad, Cuenta_Ad) as Info
                from dadeudos a where Estatus >= 0 and ID_Serv = " . $_SESSION['UI'];
        $context->debt = $db->getArray($sql);
        $sql = "select DISTINCT(ID_Inversion) as ID, CONCAT_WS('|', Tipo_Inv, Institucion_Inv, Cuenta_Inv) as Info 
                from dinversiones i where Estatus >= 0  and ID_Serv = " . $_SESSION['UI'];
        $context->inver = $db->getArray($sql);
        $sql = "select ID_Depend as ID, Nombre_Depend
                from ddependientes where Estatus >= 0 and ID_Serv = " . $_SESSION['UI'];
        $context->depend = $db->getArray($sql);
        $sql = "select ID_Inmueble as ID, CONCAT_WS('|', Calle_In, Numero_in, Colonia_In, Ciudad_In) as Info
                from dinmuebles where Estatus >= 0 and ID_Serv = " . $_SESSION['UI'];
        $context->in = $db->getArray($sql);
        
        $context->struct[] = "laboral";
        $context->struct[] = "personal";
        if($_SESSION['DEC'] != "INICIAL"){
            if($context->sell)
                $context->struct[] = "sell";
            if($context->debt)
                $context->struct[] = "debt";
            if($context->inver)
                $context->struct[] = "inversment";
            if($context->depend)
                $context->struct[] = "depend";
            $context->struct[] = "pension";
            $context->struct[] = "income";
        }
        RenderTemplate('templates/declare.final.php', $context);
    
        
    }elseif($action == "send"){
            switch($_SESSION['DEC']){
                case "INICIAL":
                    $sql = "select Tipo_Dec from declaraciones where ID_Serv = " . $_SESSION['UI'] . " order by ID_Dec DESC LIMIT 1";
                    $search = $db->getOne($sql);
                    $continue = ($search != "INICIAL");
                break;
                case "ANUAL":
                    $sql = "select YEAR(Fecha_Dec) from declaraciones where ID_Serv = " . $_SESSION['UI'] . " and Tipo_Dec = 'ANUAL' order by ID_Dec DESC LIMIT 1";
                    $search = $db->getOne($sql);
                    if($search)
                        $continue = ($search < Date('Y'));
                    else
                        $continue = true;
                break;
                case "FINAL":
                    $sql = "select Tipo_Dec from declaraciones where ID_Serv = " . $_SESSION['UI'] . " order by ID_Dec DESC LIMIT 1";
                    $search = $db->getOne($sql);
                    $continue = ($search != "FINAL");
                break;
            }
            if($continue || $_SESSION['MODIFY']){
                
                if($_SESSION['DEC'] != "INICIAL" && (!$_POST['inc-type'] || !in_array(1, $_POST['inc-type']))){
                    die("Debe registrar al menos un ingreso correspondiente al SUELDO");
                }
                
                // Datos laborales del Servidor Publico ///////////////////////////////
                $percepcion = str_replace(",", "", $_POST['percep']);
                $lab[] = $_SESSION['UI'];
                $lab[] = Upper($_POST['area']);
                $lab[] = $percepcion;
                $lab[] = $_POST['level'];
                $lab[] = $_POST['phonework'];
                $lab[] = $_POST['streetwork'];
                $lab[] = $_POST['numwork'];
                $lab[] = $_POST['colwork'];
                $lab[] = $_POST['cpwork'];
                $lab[] = $_POST['citywork'];
                $db->queryStored("updateLab", $lab);
                
                // Datos personales del servidor ///////////////////////////////////////
                if($_SESSION['MODIFY']){
                    $sql = "update infoserv set 
                            Calle = '" . $_POST['street'] . "', 
                            Numero = '" . $_POST['num'] . "', 
                            Colonia = '" . $_POST['col'] . "', 
                            ID_Ciudad = '" . $_POST['city'] . "', 
                            CP = '" . $_POST['CP'] . "', 
                            Telefono = '" . $_POST['phone'] . "', 
                            Civil = '" . $_POST['civil'] . "', 
                            CURP = '" . $_POST['curp'] . "'
                            where ID_Info = (select ID_Info from declaraciones where ID_Dec = " . $_SESSION['MODIFY'] . ")";
                    $db->execute($sql);
                }else{
                    $info = $db->getID("ID_Info", "infoserv");
                    $param[] = $info;
                    $param[] = $_SESSION['UI'];
                    $param[] = $_POST['street'];
                    $param[] = $_POST['num'];
                    $param[] = $_POST['col'];
                    $param[] = $_POST['city'];
                    $param[] = $_POST['CP'];
                    $param[] = $_POST['phone'];
                    $param[] = $_POST['civil'];
                    $param[] = Upper($_POST['curp']);
                    $db->queryStored("NewInfo", $param);
                }

                // Creacion de la declaracion /////////////////////////////////////////
                if($_SESSION['MODIFY'])
                    $dec = $_SESSION['MODIFY'];
                else{
                    $newdec = $db->queryStored("NewDec", array($_SESSION['UI'], $info, $_SESSION['DEC']), 'ARRAY');
                    $dec = $newdec[0]['ID_Dec'];
                }

                // Desglose de ventas realizadas //////////////////////////////////////
                for($i=0; $i<count($_POST['id-sell']); $i++){
                    $id = $_POST['id-sell'][$i];
                    $sell = str_replace(",", "", $_POST['sell'][$i]);
                    $type = $_POST['type-sell'][$i];
                    
                    if($_SESSION['MODIFY'] && $db->queryStored("SearchTrans", array($dec, $id, $type, 2), 'ARRAY')){
                        $sql = "update dtransacciones set Importe = " . $sell . " 
                                where Tipo_Trans = 2 and Tipo_Elem = '" . $type . "' 
                                and ID_Elem = " . $id . " and ID_Dec = " . $dec;
                        $db->execute($sql);
                    }else{
                        $trans = array();
                        $trans[] = $dec;
                        $trans[] = $id;
                        $trans[] = $type;
                        $trans[] = Date('Y-m-d');
                        $trans[] = 2;
                        $trans[] = "";
                        $trans[] = "";
                        $trans[] = $sell;
                        $trans[] = "";
                        $trans[] = "";
                        $trans[] = "";
                        $db->queryStored("NewTransaction", $trans);
                    }
                }

                if($_POST['finish-sell-inmuebles']){
                    $sql = "update dinmuebles set Estatus = -1 where ID_Inmueble in " . concat($_POST['finish-sell-inmuebles']);
                    $db->execute($sql);
                }
                if($_POST['finish-sell-muebles']){
                    $sql = "update dmuebles set Estatus = -1 where ID_Mueble in " . concat($_POST['finish-sell-muebles']);
                    $db->execute($sql);
                }
                if($_POST['finish-sell-vehiculos']){
                    $sql = "update dvehiculos set Estatus = -1 where ID_Vehiculo in " . concat($_POST['finish-sell-vehiculos']);
                    $db->execute($sql);
                }


                // Desglose de deudas //////////////////////////////////////////////////
                for($i=0; $i<count($_POST['id-debt']); $i++){
                    $id = $_POST['id-debt'][$i];
                    $imp = str_replace(",", "", $_POST['imp-debt'][$i]);
                    $debt = str_replace(",", "", $_POST['debt'][$i]);
                    
                    if($_SESSION['MODIFY'] && $db->queryStored("SearchTrans", array($dec, $id, "adeudos", 7), 'ARRAY')){
                        $sql = "update dtransacciones set Importe = " . $imp . ", Saldo = " . $debt . "
                                where Tipo_Trans = 7 and Tipo_Elem = 'adeudos' and ID_Elem = " . $id . "
                                and ID_Dec = " . $dec;
                        $db->execute($sql);
                    }else{
                        $trans = array();
                        $trans[] = $dec;
                        $trans[] = $id;
                        $trans[] = "adeudos";
                        $trans[] = Date('y-m-d');
                        $trans[] = 7;
                        $trans[] = "";
                        $trans[] = "";
                        $trans[] = $imp;
                        $trans[] = $debt;
                        $trans[] = "";
                        $trans[] = "";
                        $db->queryStored("NewTransaction", $trans);
                    }
                }
                if($_POST['finish-debt']){
                    $sql = "update dadeudos set Estatus = -1 where ID_Adeudo in " . concat($_POST['finish-debt']);
                    $db->execute($sql);
                }

                // Desglose de inversiones /////////////////////////////////////////////
                for($i=0; $i<count($_POST['id-inver']); $i++){
                    $id = $_POST['id-inver'][$i];
                    $dep = str_replace(",", "", $_POST['dep-inver'][$i]);
                    $ret = str_replace(",", "", $_POST['ret-inver'][$i]);
                    $inver = str_replace(",", "", $_POST['inver'][$i]);
                    
                    if($_SESSION['MODIFY'] && $db->queryStored("SearchTrans", array($dec, $id, "inversiones", 8), 'ARRAY')){
                        $sql = "update dtransacciones set Importe = " . $ret . ", Saldo = " . $inver . "
                                where Tipo_Trans = 8 and Tipo_Elem = 'inversiones' and ID_Elem = " . $id . "
                                and ID_Dec = " . $dec;
                        $db->execute($sql);
                    }else{
                        $trans = array();
                        $trans[] = $dec;
                        $trans[] = $id;
                        $trans[] = "inversiones";
                        $trans[] = Date('Y-m-d');
                        $trans[] = 8;
                        $trans[] = "";
                        $trans[] = "";
                        $trans[] = $ret;
                        $trans[] = $inver;
                        $trans[] = "";
                        $trans[] = "";
                        $db->queryStored("NewTransaction", $trans);
                    }
                    if($_SESSION['MODIFY'] && $db->queryStored("SearchTrans", array($dec, $id, "inversiones", 10), 'ARRAY')){
                        $sql = "update dtransacciones set Importe = " . $dep . ", Saldo = " . $inver . "
                                where Tipo_Trans = 10 and Tipo_Elem = 'inversiones' and ID_Elem = " . $id . "
                                and ID_Dec = " . $dec;
                        $db->execute($sql);
                    }else{
                        $trans = array();
                        $trans[] = $dec;
                        $trans[] = $id;
                        $trans[] = "inversiones";
                        $trans[] = Date('Y-m-d');
                        $trans[] = 10;
                        $trans[] = "";
                        $trans[] = "";
                        $trans[] = $dep;
                        $trans[] = $inver;
                        $trans[] = "";
                        $trans[] = "";
                        $db->queryStored("NewTransaction", $trans);
                    }
                }

                // Aportacion de los dependientes ////////////////////////////////////
                for($i=0; $i<count($_POST['id-depend']); $i++){
                    $id = $_POST['id-depend'][$i];
                    $aport = str_replace(",", "", $_POST['depend'][$i]);
                    
                    if($_SESSION['MODIFY'] && $db->queryStored("SearchTrans", array($dec, $id, "dependientes", 11), 'ARRAY')){
                        $sql = "update dtransacciones set Importe = " . $aport . "
                                where Tipo_Trans = 11 and Tipo_Elem = 'dependientes' and ID_Elem = " . $id . "
                                and ID_Dec = " . $dec;
                        $db->execute($sql);
                    }else{
                        $trans = array();
                        $trans[] = $dec;
                        $trans[] = $id;
                        $trans[] = "dependientes";
                        $trans[] = Date('Y-m-d');
                        $trans[] = 11;
                        $trans[] = "";
                        $trans[] = "";
                        $trans[] = $aport;
                        $trans[] = "";
                        $trans[] = "";
                        $trans[] = "";
                        $db->queryStored("NewTransaction", $trans);
                    }
                }
                
                // Pensiones ///////////////////////////////////////
                if($_SESSION['MODIFY']){
                    $sql = "delete from dtransacciones where Tipo_Elem = 'pensiones' and ID_Dec = " . $dec;
                    $db->execute($sql);
                }
                if($_POST['pension-cant']){
                    $pension = str_replace(",", "", $_POST['pension-cant']);
                    $pension_obs = $_POST['pension-text'];
                    
                    $trans = array();
                    $trans[] = $dec;
                    $trans[] = "";
                    $trans[] = "pensiones";
                    $trans[] = Date('Y-m-d');
                    $trans[] = 1;
                    $trans[] = "";
                    $trans[] = "";
                    $trans[] = $pension;
                    $trans[] = "";
                    $trans[] = "";
                    $trans[] = $pension_obs;
                    $db->queryStored("NewTransaction", $trans);
                }

                // Lista de ingresos declarados ///////////////////////////////////////
                if($_SESSION['MODIFY']){
                    $sql = "delete from dingresos where ID_Ingreso in (select ID_Elem from dtransacciones where Tipo_Elem = 'ingresos' and ID_Dec = " . $dec . ")";
                    $db->execute($sql);
                    $sql = "delete from dtransacciones where Tipo_Elem = 'ingresos' and ID_Dec = " . $dec;
                    $db->execute($sql);
                }
                
                for($i=0; $i<count($_POST['inc-type']); $i++){
                    $type = $_POST['inc-type'][$i];
                    $razon = $_POST['inc-razon'][$i];
                    $service = $_POST['inc-service'][$i];
                    $contra = $_POST['inc-contra'][$i];
                    $inmueble = $_POST['inc-inmueble'][$i];
                    $concept = $_POST['inc-concept'][$i];
                    $imp = str_replace(",", "", $_POST['inc-import'][$i]);

                    $param = array();
                    $id = $db->getID("ID_Ingreso", "dingresos");
                    $param[] = $id;
                    $param[] = $_SESSION['UI'];
                    $param[] = $type;
                    $param[] = hideVar($service?$service:($concept?$concept:""));
                    $param[] = hideVar($imp);
                    $param[] = $inmueble;
                    $param[] = hideVar($contra);
                    $db->queryStored("setIngreso", $param);

                    $trans = array();
                    $trans[] = $dec;
                    $trans[] = $id;
                    $trans[] = "ingresos";
                    $trans[] = Date('Y-m-d');
                    $trans[] = 1;
                    $trans[] = "";
                    $trans[] = "";
                    $trans[] = $imp;
                    $trans[] = "";
                    $trans[] = "";
                    $trans[] = "";
                    $db->queryStored("NewTransaction", $trans);
                }
                
                // Aplicacion final de declaracion //////////////////////////////
                $db->queryStored("applyDec", array($_SESSION['UI'], $dec));
                $balance = $db->queryStored("Balance", array($dec), 'ARRAY');
                $b1 = str_replace(",", "", ($balance[0]['sueldo'] + $balance[0]['honorarios'] + $balance[0]['otros'] + $balance[0]['inmuebles'] + $balance[0]['muebles'] + $balance[0]['vehiculos'] + $balance[0]['inversiones'] + $balance[0]['adeudos'] - $balance[0]['pensiones'] - $balance[0]['depositos'] - $balance[0]['pagos']));
                $b2 = str_replace(",", "", ($balance[0]['conyuge'] + $balance[0]['inmuebles_con'] + $balance[0]['muebles_con'] + $balance[0]['vehiculos_con'] + $balance[0]['inversiones_con'] + $balance[0]['adeudos_con'] - $balance[0]['depositos_con'] - $balance[0]['pagos_con']));
                $b3 = str_replace(",", "", ($balance[0]['depend'] + $balance[0]['inmuebles_dep'] + $balance[0]['muebles_dep'] + $balance[0]['vehiculos_dep'] + $balance[0]['inversiones_dep'] + $balance[0]['adeudos_dep'] - $balance[0]['depositos_dep'] - $balance[0]['pagos_dep']));
//                $db->queryStored("updateDec", array($dec, $b1, $b2, $b3));
                $sql = "update declaraciones set 
                        Balanza = " . $b1 . ", 
                        Balanza_Conyuge = " . $b2 . ", 
                        Balanza_Depend = " . $b3 . "
                        where ID_Dec = " . $dec;
                $db->execute($sql);
                $_SESSION['DEC'] = null;
                $_SESSION['DT'] = (Date('Y') + 1) . "-01-01";
                $_SESSION['FISCAL'] = (count($_POST['inc-type']) > 1 || $percepcion * 12 >= 400000);
                echo $dec;
                sleep(1);
            }else
                echo "Se ha detectado que ya se envió esta declaración previamente. Favor de verificar";
        
    }elseif($action == "warning"){
        RenderTemplate('templates/declare.warning.php', $context);
        
    }elseif($action == "count"){
        echo json_encode($db->queryStored("CountElem", array($_SESSION['UI']), 'ARRAY'));
    
    }elseif($action == "add"){
        $context->id = $_GET['id'];
        RenderTemplate('templates/declare.coment.php', $context);
    
    }elseif($action == "coment"){
        $id = showVar($_POST['id']);
        $coment = $_POST['coment'];
        $sql = "update dtransacciones set Aclaracion = '" . $coment . "' where ID_Trans = " . $id;
        $db->execute($sql);
    }elseif($action == "cities"){
        $id = $_GET['id'];
        $sql = "select * from ciudades where ID_Estado = " . $id . " order by Ciudad";
        $data = $db->getArray($sql);
        foreach($data as $d)
            echo "<option value = '" . $d['ID_Ciudad'] . "'>" . $d['Ciudad'] . "</option>";
        
    }elseif($action == "valid"){
        if($_SESSION['UI'] && $_SESSION['DEC']){
            $error = validateCURP($_POST['curp']);
            if($error){
                echo $error;
                exit;
            }
            if($_POST['civil'] == "Casado"){
                iF(!$db->exist("ID_Depend", "ddependientes", "Tipo_Depend = 'CONYUGE' and Estatus >= 0 and ID_Serv = " . $_SESSION['UI'])){
                    echo "Debe ingresar loa datos de su CÓNYUGE en la sección de CÓNYUGE y DEPENDIENTES";
                    exit;
                }
            }
            for($i=0; $i<count($_POST['id-sell']); $i++){
                 $val = str_replace(",", "", $_POST['sell'][$i]);
                 if(!is_numeric($val)){
                     echo "Sólo debe ingresar números en las cantidades de ventas realizadas";
                     exit;
                 }
            }
            for($i=0; $i<count($_POST['id-debt']); $i++){
                $val1 = str_replace(",", "", $_POST['imp-debt'][$i]);
                $val2 = str_replace(",", "", $_POST['debt'][$i]);
                if(!is_numeric($val1) || !is_numeric($val2)){
                    echo "Sólo debe ingresar números en las cantidades pagadas y saldos de sus deudas";
                    exit;
                }
            }
            for($i=0; $i<count($_POST['id-inver']); $i++){
                $val1 = str_replace(",", "", $_POST['dep-inver'][$i]);
                $val2 = str_replace(",", "", $_POST['ret-inver'][$i]);
                $val3 = str_replace(",", "", $_POST['inver'][$i]);
                if(!is_numeric($val1) || !is_numeric($val2) || !is_numeric($val3)){
                    echo "Sólo debe ingresar números en las cantidades de sus inversiones";
                    exit;
                }
            }
            for($i=0; $i<count($_POST['id-depend']); $i++){
                $val = str_replace(",", "", $_POST['depend'][$i]);
                if(!is_numeric($val)){
                     echo "Sólo debe ingresar números en los ingresos de sus dependientes";
                     exit;
                 }
            }
            for($i=0; $i<count($_POST['inc-type']); $i++){
                $val = str_replace(",", "", $_POST['inc-import'][$i]);
                if(!is_numeric($val)){
                     echo "Sólo debe ingresar números en sus ingresos declarados";
                     exit;
                }
            }
        }else
            echo "Tiempo de sesión expirado. Favor de salir e ingresar nuevamente";
        
    }elseif($action == "aviso"){
        RenderTemplate('templates/declare.aviso.php');
    
    }elseif($action == "check"){
        if(count($_SESSION['CHANGE']) > 0){
            $str = "Aún no ha registrado cambios en: ";
            foreach($_SESSION['CHANGE'] as $c)
                $str .= $c . ", ";
            $str = substr($str, 0, -2) . " ¿Desea continuar? ";
            echo $str;
        }
    }
?>
