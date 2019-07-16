<?php 
    require_once ('lib/https.php');
    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    require_once ('lib/recaptchalib.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    
    if(!$action){
        if($_SESSION['CU'])
            $context->allow = getAccess();
        $context->menu = setMenu();
        if(isset($_SESSION['UI'])){
            if($_SESSION['PRO'] == "#SP"){
                $sql = "select Correo, Clave_Nueva from servpub where ID_Serv = " . $_SESSION['UI'];
                $data = $db->getObject($sql);
                if($data->Clave_Nueva || !$data->Correo){
                   if($data->Clave_Nueva)
                       $_SESSION['PWD'] = true;
                   if(!$data->Correo)
                       $_SESSION['MAIL'] = true;
                }else
                    Header('location: home.php');
            }else{
                $sql = "select Fecha_Clave from users where ID_User = " . $_SESSION['UI'];
                $last = $db->getOne($sql);
                if(DateDiff(Date('Y-m-d'), $last, 'DIAS', true) > 60)
                   $context->change = true;
                if(in_array(60, $context->allow)){
                    $sql = "select COUNT(RFC) as Conteo, RFC 
                            from servpub  
                            where Estatus in (1, 2) and ID_Serv not in 
                            (select ID_Serv from serv_ex)
                            GROUP by RFC
                            having COUNT(RFC) > 1";
                    $rfc = $db->getArray($sql);
                    
                    $inhab = array();
                    $sql = "select * from dias_inhabiles where YEAR(Fecha) >= (YEAR(NOW()) - 1)";
                    foreach ($db->getArray($sql) as $o)
                        $inhab[] = $o['Fecha'];
                    
                    $days = $db->getOne("select Valor from parametros where ID_Parametro = 3");
                
                    $cont = 0;
                    foreach($rfc as $r){
                        $sql = "select ID_Serv, RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Dependencia, Puesto, Fecha_Inicio, Fecha_Termino, Estatus 
                                from servpub sp 
                                join dependencias d on d.ID_Dependencia = sp.ID_Dependencia
                                join puestos p on p.ID_Puesto = sp.ID_Puesto
                                where RFC = '" . $r['RFC'] . "' order by ID_Serv DESC LIMIT 2";
                        $data = $db->getArray($sql);
                        if($data[0]['Estatus'] == "1"){
                            $mov[$cont]['new'] = $data[0];
                            $mov[$cont]['old'] = $data[1];
                            $start = $data[0]['Fecha_Inicio'];
                            $end = $data[1]['Fecha_Termino'];
                            $calc = Calculate($end, $days, $inhab);
                            if(strtotime($calc) >= strtotime($start)){
                                $mov[$cont]['opt'] = "promo";
                            }else{
                                $mov[$cont]['opt'] = "back";
                            }
                            $cont++;
                        }
                    }
                    $context->mov = $mov?$mov:array();
                    
                    $sql = "select COUNT(ID_Prorroga) from prorrogas where Estatus = 0 and Terminado = 0";
                    $context->pro = $db->getOne($sql);
                    
                    $sql = "select COUNT(ID_Correccion) from correcciones where Estatus = 0";
                    $context->correct = $db->getOne($sql);
                    
                    $sql = "select * from dependencias where Activo = 1 order by Dependencia";
                    $context->dep = $db->getArray($sql);
                    
                    $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
                    $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->params[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->params[] = array("Header" => "Usuario", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->params[] = array("Header" => "Fecha", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->params[] = array("Header" => "Ver", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "str", "Type" => "ro");
                    
                    $context->control[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
                    $context->control[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->control[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->control[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->control[] = array("Header" => "Declaración", "Width" => "80", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->control[] = array("Header" => "Usuario", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->control[] = array("Header" => "Fecha Permiso", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->control[] = array("Header" => "Fecha Límite", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    
                    $context->public[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
                    $context->public[] = array("Header" => "Selección", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ch");
                    $context->public[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->public[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->public[] = array("Header" => "Puesto", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->public[] = array("Header" => "Estado<br>Actual", "Width" => "100", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
                    $context->public[] = array("Header" => "Detalles", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "str", "Type" => "ro");
                    
                }
            }
        }
        RenderTemplate('templates/index.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "change"){
        
        RenderTemplate('templates/index.change.php', $context);
        
    }elseif($action == "data"){
        $pwd = trim($_POST['pwd']);
        $confirm = trim($_POST['confirm']);
        $mail = trim($_POST['mail']);
        $alter = trim($_POST['alter']);
        $error = false;
        
        if($pwd && $confirm)
            $error = validatePwd($_SESSION['UI'], $pwd, $confirm, ($_SESSION['PRO']=="#SP"?"SP":"USER"));
        if(!$error){
            if($mail)
                $error = ValidateMail($mail);
            if($alter)
                $error = ValidateMail($alter);
            if(!$error){
                If($_SESSION['PRO'] == "#SP"){
                    $sql = "update servpub set Nivel = Nivel ";
                    if($pwd)
                        $sql .= ", Password = '" . Encrypt($pwd) . "', Clave_Nueva = 0 ";
                    if($mail)
                        $sql .= ", Correo = '" . $mail . "' ";
                    if($alter)
                        $sql .= ", Correo2 = '" . $alter . "' ";
//                    if($pwd && $mail)
//                        $sql .= "Password = '" . Encrypt($pwd) . "', Clave_Nueva = 0, Correo = '" . $mail . "' ";
//                    elseif($pwd && !$mail)
//                        $sql .= "Password = '" . Encrypt($pwd) . "', Clave_Nueva = 0 ";
//                    elseif(!$pwd && $mail)
//                        $sql .= "Correo = '" . $mail . "' ";
                    $sql .= "where ID_Serv = " . $_SESSION['UI'];
                    
                }else{
                    $sql = "select Password from users where ID_User = " . $_SESSION['UI'];
                    $old = $db->getOne($sql);
                    $sql = "update users set 
                            Password = '" . Encrypt($pwd) . "', 
                            Old = '" . $old . "', 
                            Fecha_Clave = NOW()
                            where ID_User = " . $_SESSION['UI'];
                }
                
                $db->execute($sql);
                $_SESSION['PWD'] = false;
                $_SESSION['MAIL'] = false;
            }else
                echo $error;
        }else
            echo $error;
        
    }elseif($action == "recover"){
        RenderTemplate('templates/index.recover.php', $context);
        
    }elseif($action == "send"){
        $search = $_POST['data'];
        if(strpos($search, "@") === false) // #SP
            $type = "#SP";
        else // User
            $type = "USER";
        $data = $db->getObject("CALL FindAndRecover('" . $type . "', '" . $search . "')");
        if($data){
            $subject = "Acceso temporal";
            $text = "<p>A continuación se presenta un enlace para conceder su acceso al sistema Declaranet Guanajuato.</p>
                     <p><center><a href = '" . getDomain() . "login.php?recover=" . hideVar($search) . "-" . hideVar(Date('Ymd')) . "' target = '_blank'>PULSE AQUÍ PARA CONTINUAR</a><center></p>";
            if($data->Mail){
                $mail[] = $data->Mail;
                if($data->Mail_Alter)
                    $mail[] = $data->Mail_Alter;
                if(SendMail($mail, $subject, $data->Nombre, $text))
                    echo implode("|", $mail);
                else
                    echo "Error al enviar correo, por favor intente de nuevo. ";
            }else
                echo "No cuenta con una dirección de correo registrada. Consulte su área de personal para generar su clave";
        }else
            echo "El usuario no ha sido encontrado con estos datos";
        
    }elseif($action == "consult"){
        $rfc = $_GET['rfc'];
        if(ctype_alpha(substr($rfc, 0, 4))){
            $sql = "select ID_Serv, RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Dependencia, 
                    (select Fecha_Dec from declaraciones where Tipo_Dec = 'INICIAL' and ID_Serv = sp.ID_Serv order by ID_Dec DESC LIMIT 1) as Inicial, 
                    (select Fecha_Dec from declaraciones where Tipo_Dec = 'ANUAL' and ID_Serv = sp.ID_Serv and YEAR(Fecha_Dec) = YEAR(NOW()) LIMIT 1) as Anual, 
                    (select Fecha_Dec from declaraciones where Tipo_Dec = 'FINAL' and ID_Serv = sp.ID_Serv order by ID_Dec DESC LIMIT 1) as Final, 
                    CASE Estatus 
                    when 1 then 'ACTIVO'
                    when 2 then 'BAJA'
                    when 4 then 'LICENCIA'
                    END as Estatus
                    from servpub sp 
                    join dependencias d on d.ID_Dependencia = sp.ID_Dependencia
                    where RFC like '" . $rfc . "%' and Estatus in (1, 2, 4) 
                    order by ID_Serv DESC";
            $context->results = $db->getArray($sql);
        }   
        RenderTemplate('templates/index.results.php', $context);
        
    }elseif($action == "fix"){
        $opt = $_POST['opt'];
        $newid = $_POST['newid'];
        $newst = $_POST['newst'];
        $oldid = $_POST['oldid'];
        $oldst = $_POST['oldst'];
        
        if($opt == "promo"){
            $sql = "select Tipo_Dec from declaraciones where ID_Serv = " . $oldid  . " order by ID_Dec DESC LIMIT 1";
            $last_dec = $db->getOne($sql);
            if($last_dec != "FINAL"){
                $sql = "select Fecha_Inicio from servpub where ID_Serv = " . $newid;
                $newstart = $db->getOne($sql);
                $db->queryStored("registerMov", array($newid, 3, null, null, $oldid, $newstart , null, null, $_SESSION['UI']));
                $sql = "update movimientos set Procedencia = " . $oldid . " where Tipo_Mov = 1 and ID_Serv = " . $newid;
                $db->execute($sql);
                $sql = "select Fecha_Inicio from servpub where ID_Serv = " . $oldid;
                $oldstart = $db->getOne($sql);
                $sql = "update servpub set Fecha_Inicio = '" . $oldstart . "' where ID_Serv = " . $newid;
                $db->execute($sql);
                $db->queryStored("Transfer", array($oldid, $newid));
            }
        }
        $sql = "insert into serv_ex(ID_Serv, Fecha, ID_User, Opcion) values(" . $oldid . ", NOW(), " . $_SESSION['UI'] . ", '" . $opt . "')";
        $db->execute($sql);
        
    }elseif($action == "details"){
        $id = $_GET['id'];
        $date = $_GET['date'];
        $sql = "select Fecha, Tipo from consultas where ID_Serv = " . $id . " and DATE(Fecha) = '". $date . "' order by Fecha";
        $context->data = $db->getArray($sql);
        $context->window = "Detalle de consultas";
        $context->head = array("Fecha/Hora", "Fuente");
        $context->fields = array("Fecha", "Tipo");
        RenderTemplate('templates/index.alert.php', $context);
    
        
    }elseif($action == "load"){
        $context->target = $_GET['target'];
        RenderTemplate('templates/index.loader.php', $context);
    
    }elseif($action == "control"){
        $rfc = $_GET['rfc'];
        $sql = "select ID_Dec, Tipo_Dec, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, RFC, Dependencia, 
                CASE Estatus 
                when 1 then 'ACTIVO'
                when 2 then 'BAJA'
                when 4 then 'LICENCIA'
                END as St 
                from servpub sp 
                join declaraciones d on d.ID_Serv = sp.ID_Serv 
                join dependencias dep on dep.ID_Dependencia = sp.ID_Dependencia 
                where RFC = '" . $rfc . "' and Estatus in (1, 2, 4)
                order by ID_Dec DESC, sp.ID_Serv DESC LIMIT 1";
        $context->data = $db->getObject($sql);
        RenderTemplate('templates/index.control.php', $context);
        
    }elseif($action == "modify"){
        $id = $_GET['id'];
        $date = $_POST['date'];
        if(strtotime($date) > strtotime(Date('Y-m-d'))){
            if(!$db->exist("ID_Modif", "modificaciones", "ID_Dec = " . $id . " and Fecha_Limite >= DATE(NOW())")){
                $sql = "insert into modificaciones values("
                     . $db->getID("ID_Modif", "modificaciones") . ", "
                     . "NOW(), "
                     . $id . ", "
                     . $_SESSION['UI'] . ", "
                     . "'" . $date . "')";
                $db->execute($sql);
            }else
                echo "Ya existe un permiso de modificación vigente";
        }else
            echo "Debe ingresar una fecha límite mayor a la actual";
        
    }elseif($action == "invitation"){
        echo "Aún no disponible";
        exit;
        $ids = $_POST['ids'];
        $sql = "select ID_Serv, CONCAT_WS(' ', Nombre, Paterno, Materno) as Servidor, Correo from servpub where Correo is not null and Correo <> '' and ID_Serv in (" . implode(",", $ids) . ")";
        $data = $db->getArray($sql);
        $cont = 0;
        foreach ($data as $d){
            $text = "Lo invitamos a publicar su declaracion dando click en el siguiente enlace:"
                . "<p><b><a target = '_blank' href = '" . getDomain() . "index.php?action=" . hideVar('public') . "&id=" . hideVar($d['ID_Serv']) . "'>"
                . "PUBLICAR MI DECLARACIÓN</a></b></p>";
            if(!SendMail($d['Correo'], "Publicación de declaración patrimonial", $d['Servidor'], $text)){
                echo "Error enviando correos, intente nuevamente. (" . $cont . " enviados de " . count($data) . ")";
                exit;
            }
            $cont++;
        }
        
    }elseif($action == "public"){
        $id = showVar($_GET['id']);
        if(is_numeric($id)){
            $db = new DBConn();
            $sql = "update publicaciones set Fecha_Oculta = NOW() where Fecha_Oculta is null and ID_Serv = " . $id;
            $db->execute($sql);
            $sql = "insert into publicaciones values(NULL, " . $id . ", NOW(), NULL)";
            $db->execute($sql);
            $context->title = "Publicación de declaración patrominial";
            $context->error = "A partir de este momento queda <b>PUBLICADA</b> su historial de declaraciones vigentes dentro de nuestro sistema, "
                    . "y podrá ser consultada por la ciudadanía medienta la siguiente liga:"
                    . "<p><b><a href = 'http://strc.guanajuato.gob.mx'>Consulta de Declaración Patrimonial</a></b></p>"
                    . "<p>Muchas gracias por tu participación</p>";
            $context->img = "img/accept.png";
            $context->crono = 30;
            RenderTemplate('templates/error.tpl.php', $context, 'templates/base.php');
        }else
            Header('location: error.php?code=' . hideVar("2"));
        
    }elseif($action == "history"){
        $id = $_GET['id'];
        $db = new DBConn();
        $sql = "select * from publicaciones where ID_Serv = " . $id . " order by Fecha_Publica";
        $context->data = $db->getArray($sql);
        $context->window = "Historial de publicaciones";
        $context->head = array("Publicado", "Ocultado");
        $context->fields = array("Fecha_Publica", "Fecha_Oculta");
        RenderTemplate('templates/index.alert.php', $context);
        
    }elseif($action == "aviso"){
        echo "<center><img src = 'img/Declaracion.png' width = '100%' height = '90%'></center>";
    }
    
    function RollBack($id){
        $sql = "select ID_Serv, Tipo_Dec from declaraciones where ID_Dec = " . $id;
        $info = $db->getObject($sql);
        $sql = "select ID_Trans,  ID_Elem, Tipo_Elem, Tipo_Trans from dtransacciones where ID_Dec = " . $id;
        $data = $db->getArray($sql);
        foreach ($data as $d){
            switch($d['Tipo_Trans']){
                case 1:
                    if($d['Tipo_Elem'] == "ingresos"){
                        $sql = "delete from dingresos where ID_Ingreso = " . $d['ID_Elem'];
                        $db->execute($sql);
                        Trans("delete", $d['ID_Trans']);
                    }else{
                        Trans("update", $d['ID_Trans']);
                    }
                break;
                case 2:
                case 4:
                case 5:
                case 6:
                case 7:
                case 8:
                    Reactivar($d);
                break;
                case 3:
                    Trans("update", $d['ID_Trans']);
                break;
                case 9:
                    switch($d['Tipo_Elem']){
                        case "inmuebles":
                            $sql = "update dinmuebles set Estatus = 2 where ID_Inmueble = " . $d['ID_Elem'];
                        break;
                        case "muebles":
                            $sql = "update dmuebles set Estatus = 2 where ID_Mueble = " . $d['ID_Elem'];
                        break;
                        case "vehiculos":
                            $sql = "update dvehiculos set Estatus = 2 where ID_Vehiculo = " . $d['ID_Elem'];
                        break;
                    }
                    $db->execute($sql);
                    Trans("delete", $d['ID_Trans']);
                break;
                case 10:
                case 11:
                    Trans("delete", $d['ID_Trans']);
                break;
            }
        }
        $sql = "delete from declaraciones where ID_Dec = " . $id;
        $db->execute($sql);
        if($_SESSION['UI'] != "1" && $_SESSION['UI'] != "5"){
            $sql = "insert into log (ID_Serv, Tipo_Dec, Fecha, ID_User) values (" . $info->ID_Serv . ", '" . $info->Tipo_Dec . "', NOW(), " . $_SESSION['UI'] . ")";
            $db->execute($sql);
        }
    }
    
    function Reactivar($d){
        global $db;
        switch($d['Tipo_Elem']){
            case "inmuebles":
                $sql = "update dinmuebles set Estatus = 0 where ID_Inmueble = " . $d['ID_Elem'];
                $db->execute($sql);
                Trans("delete", $d['ID_Trans']);
            break;
            case "muebles":
                $sql = "update dmuebles set Estatus = 0 where ID_Mueble = " . $d['ID_Elem'];
                $db->execute($sql);
                Trans("delete", $d['ID_Trans']);
            break;
            case "vehiculos":
                $sql = "update dvehiculos set Estatus = 0 where ID_Vehiculo = " . $d['ID_Elem'];
                $db->execute($sql);
                Trans("delete", $d['ID_Trans']);
            break;
            case "dependientes":
                $sql = "update ddependientes set Estatus = 0 where ID_Depend = " . $d['ID_Elem'];
                $db->execute($sql);
                Trans("delete", $d['ID_Trans']);
            break;
            case "adeudos":
                $sql = "update dadeudos set Estatus = 0 where ID_Adeudo = " . $d['ID_Elem'];
                $db->execute($sql);
                Trans("delete", $d['ID_Trans']);
            break;
            case "inversiones":
                $sql = "update dinversiones set Estatus = 0 where ID_Inversion = " . $d['ID_Elem'];
                $db->execute($sql);
                Trans("delete", $d['ID_Trans']);
            break;
            
        }
    }
  
    function Trans($action, $id){
        global $db;
        if($action == "update")
            $sql = "update dtransacciones set ID_Dec = null where ID_Trans = " . $id;
        elseif($action == "delete")
            $sql = "delete from dtransacciones where ID_Trans = " . $id;
        $db->execute($sql);
    }
    
?>