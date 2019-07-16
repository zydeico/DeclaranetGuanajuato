<?php
    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    require_once ('lib/recaptchalib.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    
    if(!$action){
        $xf = $_GET['xf'];
        if($xf && $_SESSION['UI']){
            $sql = "select ID_Serv, RFC, CONCAT_WS(' ', Nombre, Paterno, Materno) as Nombre, d.ID_Dependencia,  Dependencia, Fecha_Inicio, Fecha_Termino, Estatus, YEAR(Fecha_Inicio) as Inicio, Correo 
                    from servpub sp
                    join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
                    where MD5(RFC) = '" . $xf . "' and sp.Estatus in (1, 2, 4) 
                    order by ID_Serv DESC LIMIT 1";
            $data = $db->getObject($sql);
            $context->error = AllowAccess($data);
        }else{
            $user = $_POST['user'];
            $pwd = $_POST['pwd'];
            $recover = $_GET['recover'];

            if(!$user && !$pwd && !$recover)
                 Header('location: index.php');
            if($_POST["recaptcha_challenge_field"]){
                $captcha_respuesta = recaptcha_check_answer (CAPTCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                if (!$captcha_respuesta->is_valid){
                    $context->error = "Clave CAPTCHA incorrecta. Intente de nuevo";
                    RenderTemplate('templates/index.tpl.php', $context, 'templates/base.php');
                    exit;
                }
            }

            if($user && strpos($user, "@") === false){ // Entrando como Servidor Público...
               if(true){
                    $error = ValidateRFC($user);
                    if(!$error){
                        $sql = "select ID_Serv, RFC, Password, CONCAT_WS(' ', Nombre, Paterno, Materno) as Nombre, sp.ID_Dependencia,  
                                Fecha_Inicio, Fecha_Termino, Estatus, YEAR(Fecha_Inicio) as Inicio, Correo, 
                                (select Dependencia from dependencias where ID_Dependencia = sp.ID_Dependencia) as Dependencia, 
                                (select COUNT(ID_Dec) from declaraciones where ID_Serv = sp.ID_Serv) as Declared,
                                (select COUNT(ID_Dec) from declaraciones where Tipo_Dec = 'FINAL' and ID_Serv = sp.ID_Serv) as Final
                                from servpub sp
                                where RFC = '" . Upper($user) . "' and sp.Estatus in (1, 2, 4) 
                                and ID_Serv not in (select ID_Serv from serv_ex where Opcion = 'ignore')
                                order by ID_Serv DESC LIMIT 2";
                        $search = $db->getArray($sql);
                        if($search){
                            $nuevo = $search[0];
                            $anterior = $search[1];
                            if(count($search) == 1){
                                $data = (object)$nuevo;
                            }elseif($anterior['Estatus'] == 2 && !$anterior['Declared']){
                                $data = (object)$nuevo;
                            }elseif($anterior['Estatus'] == 2 && !$anterior['Final']){
                                $data = (object)$anterior;
                            }elseif($anterior['Estatus'] != 2 && !$anterior['Declared']){
                                $data = (object)$nuevo;
                            }elseif($anterior['Estatus'] != 2 && $anterior['Declared']){
                                $data = (object)$anterior;
                            }else{
                                $data = (object)$nuevo;
                            }
                            
                            if($data->Password == Encrypt($pwd)){
                                if($db->exist("ID_Proc", "procedimientos", "Bloqueado = 1 and Activo = 1 and ID_Serv = " . $data->ID_Serv))
                                    $context->error = "Su acceso ha sido bloqueado temporalmente,<br>favor de acudir a la Dirección de Declaración Patrimonial
                                                       ubicada en las oficinas de esta dependencia,<br>con domicilio en Conjunto Administrativo Pozuelos S/N
                                                       Gto. Capital";
                                else
                                    $context->error = AllowAccess($data);
                            }else{
                                TryMore();
                                $context->error = "Datos de acceso incorrectos, favor de verificar.<br>[" . $data->ID_Serv . "]";
                            }   
                        }else{
                            TryMore();
                            $context->error = "Datos de acceso incorrectos, favor de verificar";
                        }
                    }else
                        $context->error = $error;
              }else
                    $context->error = "Sistema en mantenimiento. Espere un momento porfavor";


            }elseif($recover){ // Recuperación de contraseña
                $exp = explode("-", $recover);
                $search = showVar($exp[0]);
                $date = showVar($exp[1]);
                if(strpos($search, "@") === false){
                    $sql = "select ID_Serv, RFC, CONCAT_WS(' ', Nombre, Paterno, Materno) as Nombre, d.ID_Dependencia,  Dependencia, Fecha_Inicio, Fecha_Termino, Estatus, YEAR(Fecha_Inicio) as Inicio, Correo 
                           from servpub sp
                           join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
                           where RFC = '" . $search . "' and '" . Date('Ymd') . "' = '" . $date . "' and sp.Estatus in (1, 2, 4) 
                           order by ID_Serv DESC LIMIT 1";
                    $data = $db->getObject($sql);
                    if($data){
                        $sql = "update servpub set Clave_Nueva = 1 where ID_Serv = " . $data->ID_Serv;
                        $db->execute($sql);
                        $context->error = AllowAccess($data);
                    }else
                        Header('location: error.php?code=' . hideVar ('2'));

                }else{
                    $sql = "select u.ID_User, p.ID_Perfil, Perfil, CONCAT_WS(' ', Nombre, Paterno, Materno) as Nombre, 
                            Tipo, ID_Dependencia
                            from users u 
                            join user_profile pro on pro.ID_User = u.ID_User 
                            join perfiles p on p.ID_Perfil = pro.ID_Perfil
                            where User = '" . showVar($exp[0]) . "' and '" . Date('Ymd') . "' = '" . showVar($exp[1]) . "'
                            and Fecha_Baja is null";
                    $data = $db->getArray($sql);
                    if($data){
                        $sql = "update users set Fecha_Clave = null where ID_User = " . $data[0]['ID_User'];
                        $db->execute($sql);
                        setSessionUser($data);
                    }else
                        Header('location: error.php?code=' . hideVar ('2'));
                }   

            }else{ // Entrando como usuario de sistema...
                $error = ValidateMail($user);
                if(!$error){
                    $sql = "select u.ID_User, p.ID_Perfil, Perfil, CONCAT_WS(' ', Nombre, Paterno, Materno) as Nombre, 
                            Tipo, ID_Dependencia
                            from users u 
                            join user_profile pro on pro.ID_User = u.ID_User 
                            join perfiles p on p.ID_Perfil = pro.ID_Perfil
                            where User = '" . $user . "' and Password = '" . Encrypt($pwd) . "' 
                            and Fecha_Baja is null";
                    $data = $db->getArray($sql);
                    if($data){
                        setSessionUser($data);
                    }else{
                        $context->recover = true;
                        if(isset($_SESSION['TRY']))
                            $_SESSION['TRY']++;
                        else
                            $_SESSION['TRY'] = 1;
                        $context->error = "Datos de acceso incorrectos, favor de verificar";
                    }

                }else
                    $context->error = $error;
            }
        }
        if($context->error)
            RenderTemplate('templates/index.tpl.php', $context, 'templates/base.php');
       
        
    }elseif($action == "logout"){
        session_unset();
        session_destroy();
        Header('location: index.php');
    
        
    }elseif($action == "switch"){
        $pro = $_GET['pro'];
        $_SESSION['CU'] = $pro;
        Header('location:index.php');
    
        
    }elseif($action == "apply"){
        $id = $_GET['id'];
        $sql = "select ID_Serv, Fecha_Inicio, Fecha_Termino from servpub where ID_Serv = " . $_SESSION['UI'];
        $data = $db->getObject($sql);
        Analyze($data, "survey.php?id=" . $id);
    }
    
    function AllowAccess($data){
        global $db;
        switch($data->Estatus){
            case 1:
                Analyze($data, "index.php");   
            break;
            case 2:
                $sql = "select Tipo_Reg from movimientos where Tipo_Mov = 2 and ID_Serv = " . $data->ID_Serv . " order by ID_Mov DESC LIMIT 1";
                $type = $db->getOne($sql);
                if($type == "NORMAL")
                    Analyze($data, "index.php");   
                else
                    return "El Servidor Público ha sido dado de baja <br> Para mayor información contacte a su área de personal";
            break;
            case 4:
                $sql = "select Termino from movimientos where Tipo_Mov = 4 and ID_Serv = " . $data->ID_Serv . " order by ID_Mov DESC LIMIT 1";
                $end = $db->getOne($sql);
                if($end){
                    $actual = strtotime(Date('Y-m-d'));
                    $end = strtotime($end);
                    if($actual > $end){
                        $sql = "update servpub set Estatus = 1 where ID_Serv = " . $data->ID_Serv;
                        $db->execute($sql);
                        Analyze($data, "index.php");
                    }else
                        return "El Servidor Público cuenta con una licencia vigente <br> Para mayor información contacte a su área de Personal";
                }else
                    return "El Servidor Público cuenta con una licencia vigente <br> Para mayor información contacte a su área de Personal";
            break;
        }
    }
    
    function Analyze($data, $url){
        global $db;
        $sql = "select d.ID_Dec, d.Tipo_Dec, YEAR(Fecha_Dec) as Anio, Fecha_Limite, COUNT(ID_Trans) as Conteo, 
                (select IFNULL(Per_Mensual, 0) from servpub where ID_Serv = d.ID_Serv) as Mensual
                from declaraciones d 
                left join modificaciones m on m.ID_Dec = d.ID_Dec and Fecha_Limite  >= DATE(NOW())
                left join dtransacciones t on t.ID_Dec = d.ID_Dec and Tipo_Elem = 'ingresos'
                where d.ID_Serv = " . $data->ID_Serv . " 
                group by d.ID_Dec
                order by d.ID_Dec DESC, ID_Modif DESC LIMIT 1";
        $last = $db->getObject($sql);
        if(!$last){
            $dec = "INICIAL";
            $dt = $data->Fecha_Inicio;
            setSessionSP($data, $dec, null, $dt);
//            echo "1"; exit;
        }elseif($last->Tipo_Dec == "FINAL" && $data->Estatus == 1){
            if($last->Fecha_Limite && strtotime($last->Fecha_Limite) >= strtotime(Date('Y-m-d'))){
                $dec = $last->Tipo_Dec;
                $modif = $last->ID_Dec;
            }else
                $dec = "INICIAL";
            $dt = $data->Fecha_Inicio;
            setSessionSP($data, $dec, null, $dt, $last->Anio, $last->Mensual, $last->Conteo, $modif);
//            echo "2"; exit;
        }elseif($last->Tipo_Dec != "FINAL" && $data->Estatus == 2){
            if($last->Fecha_Limite && strtotime($last->Fecha_Limite) >= strtotime(Date('Y-m-d'))){
                $dec = $last->Tipo_Dec;
                $modif = $last->ID_Dec;
            }else
                $dec = "FINAL";
            $begin = ($last->Tipo_Dec=="INICIAL"?$data->Fecha_Inicio:$last->Anio."-01-01");
            $dt = $data->Fecha_Termino;
            setSessionSP($data, $dec, $begin, $dt, $last->Anio, $last->Mensual, $last->Conteo, $modif);
//            echo "3"; exit;
        }elseif($last->Tipo_Dec == "INICIAL" && $data->Inicio < Date('Y')){
            if($last->Fecha_Limite && strtotime($last->Fecha_Limite) >= strtotime(Date('Y-m-d'))){
                $dec = $last->Tipo_Dec;
                $modif = $last->ID_Dec;
            }else
                $dec = "ANUAL";
            $begin = $data->Fecha_Inicio;
            $dt = Date('Y') . "-01-01";
            setSessionSP($data, $dec, $begin, $dt, $last->Anio, $last->Mensual, $last->Conteo, $modif);
//            echo "4"; exit;
        }elseif($last->Tipo_Dec == "ANUAL" && $last->Anio < Date('Y')){
            if($last->Fecha_Limite && strtotime($last->Fecha_Limite) >= strtotime(Date('Y-m-d'))){
                $dec = $last->Tipo_Dec;
                $modif = $last->ID_Dec;
            }else
                $dec = "ANUAL";
            $begin = (Date('Y') - 1) . "-01-01";
            $dt = Date('Y') . "-01-01";
            setSessionSP($data, $dec, $begin, $dt, $last->Anio, $last->Mensual, $last->Conteo, $modif);
//            echo "5"; exit;
        }else{
            $dt = ($last->Anio + 1) . "-01-01";
            if($last->Fecha_Limite && strtotime($last->Fecha_Limite) >= strtotime(Date('Y-m-d'))){
                $dec = $last->Tipo_Dec;
                $modif = $last->ID_Dec;
            }
            setSessionSP($data, $dec, null, $dt, $last->Anio, $last->Mensual, $last->Conteo, $modif);
//            echo "6"; exit;
        }
        Header('location: '. $url);
    }
    
    function setSessionUser($data){
        $_SESSION['TRY'] = 1;
        $_SESSION['UI'] = $data[0]['ID_User']; // User ID 
        $_SESSION['CU'] = $data[0]['ID_Perfil']; // Current Profile
        $_SESSION['NM'] = $data[0]['Nombre']; // User Name
        $_SESSION['TP'] = $data[0]['Tipo']; // Type User
        $_SESSION['DEP'] = $data[0]['ID_Dependencia']; // Dependencia
        $_SESSION['HOME'] = "index.php";
        foreach($data as $d)
            $_SESSION['PRO'][] = array("ID" => $d['ID_Perfil'], "PRO" => $d['Perfil']); // Available Profiles
        Header('location: index.php');
    }
    
    function setSessionSP($data, $dec, $begin, $dt, $year = null, $salary = 0, $income = 0, $modif = null){
        $_SESSION['TRY'] = 1;
        $_SESSION['PRO'] = '#SP';
        $_SESSION['UI'] = $data->ID_Serv;
        $_SESSION['RFC'] = $data->RFC;
        $_SESSION['DEP'] = $data->ID_Dependencia;
        $_SESSION['WORK'] = $data->Dependencia;
        $_SESSION['NM'] = $data->Nombre;
        $_SESSION['HOME'] = "home.php";
        $_SESSION['DEC'] = $dec;
        $_SESSION['LAST'] = $begin;
        $_SESSION['DT'] = $dt;
        $_SESSION['CHANGE'] = array("dependientes", "adeudos", "inversiones", "inmuebles", "muebles", "vehiculos");
        $_SESSION['IMPORT'] = array("inversiones", "adeudos");
        $_SESSION['MODIFY'] = $modif;
        $_SESSION['INTEREST'] = (Date('Y') == $year);
        $_SESSION['FISCAL'] = ($income > 1 || ($salary * 12 >= 400000));
        $_SESSION['ACDO'] = $data->Declared;
    }
    
    function TryMore(){
       if(isset($_SESSION['TRY']))
            $_SESSION['TRY']++;
       else
            $_SESSION['TRY'] = 1;
    }
?>
