<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
   
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Movimientos del padrón";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where " . ($_SESSION['TP']=="GLOBAL"?"Activo = 1":"ID_Dependencia = " . $_SESSION['DEP']) . " order by Dependencia";
        $context->dep = $db->getArray($sql);
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "RFC", "Width" => "75", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ed");
        $context->params[] = array("Header" => "Nombre", "Width" => "200", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ed");
        $context->params[] = array("Header" => "Area", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Cargo Funcional", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Nivel", "Width" => "50", "Attach" => "txt", "Align" => "center", "Sort" => "str", "Type" => "ro");
        if(in_array(56, $context->allow))
            $context->params[] = array("Header" => "Borrar", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        if(in_array(15, $context->allow))
            $context->params[] = array("Header" => "Baja", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        if(in_array(14, $context->allow))
            $context->params[] = array("Header" => "Lic.", "Width" => "45", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        if(in_array(36, $context->allow))
            $context->params[] = array("Header" => "Promo.", "Width" => "45", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        if(in_array(37, $context->allow))
            $context->params[] = array("Header" => "Info.", "Width" => "45", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        if(in_array(29, $context->allow))
            $context->params[] = array("Header" => "Clave", "Width" => "45", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        
        RenderTemplate('templates/mov.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "load"){
        $context->id = $_GET['id'];
        switch($_GET['opt']){
            case "Down":
                RenderTemplate('templates/mov.down.php', $context);
            break;
            case "License":
                RenderTemplate('templates/mov.lic.php', $context);
            break;
            case "Promo":
                $sql = "select CONCAT_WS(' ', Nombre, Paterno, Materno) as Nombre, Cargo_Funcional, ID_Puesto, Nivel, Area, ART64 
                        from servpub where ID_Serv = " . $context->id;
                $context->data = $db->getObject($sql);
                $sql = "select * from funciones where ID_Serv = " . $context->id;
                $context->functions = $db->getArray($sql);
                $sql = "select * from fracciones where Activo = 1 order by ID_Fraccion";
                $context->fracc = $db->getArray($sql);
                $sql = "select * from puestos where Activo = 1 order by Puesto";
                $context->pos = $db->getArray($sql);
                RenderTemplate('templates/mov.promo.php', $context);
            break;
            case "Key":
                RenderTemplate('templates/mov.key.php', $context);
            break;
            case "Deactivate":
                RenderTemplate('templates/mov.deactivate.php', $context);
            break;
            case "Correct":
                $sql = "select * from servpub where ID_Serv = " . $context->id;
                $context->data = $db->getObject($sql);
                $sql = "select * from dependencias where " . ($_SESSION['TP']=="GLOBAL"?"Activo = 1":"ID_Dependencia = " . $_SESSION['DEP']) . " order by Dependencia";
                $context->dep = $db->getArray($sql);
                $sql = "select * from puestos where Activo = 1 order by Puesto";
                $context->pos = $db->getArray($sql);
                RenderTemplate('templates/register.manual.php', $context);
            break;
        }
        
    }elseif($action == "key"){
        $id = $_POST['id'];
        $pwd1 = $_POST['pwd'];
        $pwd2 = $_POST['confirm'];
        $error = validatePwd($id, $pwd1, $pwd2, "SP");
        if(!$error){
            $sql = "update servpub set Password = '" . Encrypt($pwd1) . "', Clave_Nueva = 1 where ID_Serv = " . $id;
            $db->execute($sql);
        }else
            echo $error;
    }elseif($action == "correct"){
        $id = $_POST['id'];
        $rfc = Upper($_POST['RFC']);
        $name = Upper($_POST['name']);
        $patern = Upper($_POST['paterno']);
        $matern = Upper($_POST['materno']);
        $dep = $_POST['dep'];
        $pos = $_POST['pos'];
        $func = $_POST['funcional'];
        $contra = $_POST['contra'];
        $art = $_POST['art'];
        $level = $_POST['level'];
        $area = $_POST['area'];
        $street_job = $_POST['street_job'];
        $num_job = $_POST['num_job'];
        $col_job = $_POST['col_job'];
        $CP_job = $_POST['CP_job'];
        $city_job = $_POST['city_job'];
        $phone = $_POST['phone'];
        $percep = $_POST['percep'];
        $date = $_POST['date'];
        $desc = $_POST['desc'];
        
        $temp = $db->getID("ID_Temp", "temporal");
        $sql = "insert into temporal values("
             . $temp . ", "
             . "'" . $name . "', "
             . "'" . $patern . "', "
             . "'" . $matern . "', "
             . "'" . $rfc . "', "
             . $dep . ", "
             . $pos . ", "
             . "'" . $func . "', "
             . "'" . $contra . "', "
             . "'" . $art . "', "
             . "'" . $level . "', "
             . "'" . $area . "', "
             . "'" . $street_job . "', "
             . "'" . $num_job . "', "
             . "'" . $col_job . "', "
             . "'" . $CP_job . "', "
             . "'" . $city_job . "', "
             . "'" . $phone . "', "
             . "'" . $percep . "', "
             . "'" . $date . "') ";
        $db->execute($sql);
        
        $sql = "insert into correcciones values("
             . $db->getID("ID_Correccion", "correcciones") . ", "
             . $temp . ", "
             . $id . ", "
             . "'" . $desc . "', "
             . "NOW(), "
             . $_SESSION['UI'] . ", "
             . "null, null, null, 0 )"; 
        $db->execute($sql);
     
        
    }elseif ($action == "view") {
        $target = showVar($_GET['target']);
        switch($target){
            case "license":
                $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
                $context->params[] = array("Header" => "RFC", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "Area", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "Inicio", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "Fin", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                if(in_array(14, $_SESSION['PM']))
                    $context->params[] = array("Header" => "Ver", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
                RenderTemplate('templates/mov.license.php', $context);
            break;
            case "correct":
                $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
                $context->params[] = array("Header" => "Fecha", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "Usuario", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "Estatus", "Width" => "80", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
                $context->params[] = array("Header" => "Ver", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
                RenderTemplate('templates/mov.correct.php', $context);
            break;
        }
    }elseif($action == "details"){
        $tp = showVar($_GET['tp']);
        $id = $_GET['id'];
        switch($tp){
            case "correct":
                 $sql = "select sp.RFC as SP_RFC, sp.Nombre as SP_Nombre, sp.Paterno as SP_Paterno, sp.Materno as SP_Materno, 
                         d1.Dependencia as SP_Dep, p1.Puesto as SP_Pos, sp.Cargo_Funcional as SP_Funcional, 
                         sp.Contratacion as SP_Contra, sp.AG172 as SP_ART, sp.Nivel as SP_Level, sp.Area as SP_Area, 
                         sp.Calle_Trabajo as SP_Street, sp.Num_Trabajo as SP_Num, sp.Col_Trabajo as SP_Col, sp.CP_Trabajo as SP_CP, 
                         sp.Ciudad_Trabajo as SP_City, sp.Tel_Trabajo as SP_Tel, sp.Per_Mensual as SP_Percep, sp.Fecha_Inicio as SP_Inicio,
                         tmp.RFC as TEMP_RFC, tmp.Nombre as TEMP_Nombre, tmp.Paterno as TEMP_Paterno, tmp.Materno as TEMP_Materno, 
                         d2.Dependencia as TEMP_Dep, p2.Puesto as TEMP_Pos, tmp.Cargo_Funcional as TEMP_Funcional,
                         tmp.Contratacion as TEMP_Contra, tmp.AG172 as TEMP_ART, tmp.Nivel as TEMP_Level, tmp.Area as TEMP_Area, 
                         tmp.Calle_Trabajo as TEMP_Street, tmp.Num_Trabajo as TEMP_Num, tmp.Col_Trabajo as TEMP_Col, tmp.CP_Trabajo as TEMP_CP, 
                         tmp.Ciudad_Trabajo as TEMP_City, tmp.Tel_Trabajo as TEMP_Tel, tmp.Per_Mensual as TEMP_Percep, tmp.Fecha_Inicio as TEMP_Inicio,
                         c.ID_Correccion, c.Correccion, c.Estatus, c.ID_Serv, c.ID_Temp, DATE(c.Fecha_Valida) as Valida, c.Observaciones
                         from correcciones c 
                         join servpub sp on sp.ID_Serv = c.ID_Serv 
                         join temporal tmp on tmp.ID_Temp = c.ID_Temp 
                         join dependencias d1 on d1.ID_Dependencia = sp.ID_Dependencia 
                         join dependencias d2 on d2.ID_Dependencia = tmp.ID_Dependencia 
                         join puestos p1 on p1.ID_Puesto = sp.ID_Puesto
                         join puestos p2 on p2.ID_Puesto = tmp.ID_Puesto
                         where ID_Correccion = " . $id;
                 $context->data = $db->getObject($sql);
                 RenderTemplate('templates/mov.validate.php', $context);
            break;
            case "license":
                $context->id = $id;
                $sql = "select * from movimientos where Tipo_Mov = 4 and (Termino is null OR Termino >= NOW()) and ID_Serv = " . $id;
                $context->data = $db->getObject($sql);
                RenderTemplate('templates/mov.lic.php', $context);
            break;
        }
    }elseif($action == "validate"){
        $st = $_GET['st'];
        $id = $_POST['id'];
        $serv = $_POST['serv'];
        $temp = $_POST['temp'];
        $obs = $_POST['obs'];
        
        $sql = "update correcciones set 
                Estatus = " . $st . ",
                ID_Valida = " . $_SESSION['UI'] . ",
                Fecha_Valida = NOW(), 
                Observaciones = '" . $obs  . "' 
                where ID_Correccion = " . $id;
        $db->execute($sql);
        if($st == 1){
            $sql = "select * from temporal where ID_Temp = " . $temp;
            $temp = $db->getObject($sql);
            $sql = "update servpub set ";
            foreach($temp as $k => $v){
                if($k != "ID_Temp")
                    $sql .= $k . " = '" . $v. "',";
            }
            $sql = substr($sql, 0, -1) . " where ID_Serv = " . $serv;
            $db->execute($sql);
        }
    }elseif($action == "down"){
        $id = $_POST['id'];
        $date = $_POST['date'];
        $type = $_POST['type'];
        
        if(!empty($_FILES)){
            $tempFile = $_FILES['act']['tmp_name'];
            $file_name = $_FILES['act']['name'];
            $targetFile = "uploaded/movimientos/BAJA_" . $id . "_" . quitarAcentos($file_name, true);
            if (!move_uploaded_file($tempFile,$targetFile)){
                echo "Ocurrió un error al cargar su archivo";
                exit;
            }
        }
        $sql = "update servpub set Fecha_Termino = '" . $date . "', Estatus = 2 where ID_Serv = " . $id;
        $db->execute($sql);
        $db->queryStored("registerMov", array($id, 2, $type, $targetFile, null, null, $date, null, $_SESSION['UI']));
        
    }elseif($action == "deactivate"){
        $id = $_POST['id'];
        $obs = $_POST['obs'];
        $sql = "update servpub set Estatus = 0 where ID_Serv = " . $id;
        $db->execute($sql);
        $db->queryStored("registerMov", array($id, 5, null, null, null, null, null, $obs, $_SESSION['UI']));
        
    }elseif($action == "license"){
        $id = $_POST['id'];
        $mov = $_POST['mov'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $type = $_POST['type'];
        $obs = $_POST['obs'];
        $actual = strtotime(Date('Y-m-d'));
        $date1 = strtotime($start);
        $date2 = strtotime($end);
        
        if(!$mov){
            $sql = "select ID_Mov from servpub sp 
                    join movimientos m on m.ID_Serv = sp.ID_Serv 
                    where Estatus = 4 and (Termino <= NOW() or Termino is null) and sp.ID_Serv = " . $id;
            $exist = $db->getOne($sql);
            if(!$exist){
                if($end && $date1 >= $date2){
                    echo "La fecha de término debe ser mayor a la inicial";
                    exit;
                }
                $db->queryStored("registerMov", array($id, 4, $type, null, null, $start, $end, $obs, $_SESSION['UI']));
            }else
                echo "El servidor público cuenta con una licencia vigente";
        }else{
            $sql = "update movimientos set Tipo_Reg = '" . $type . "', Termino = " . ($end?"'".$end."'":"null") . " where ID_Mov = " . $mov;
            $db->execute($sql);
        }
        $sql = "update servpub set Estatus = " . ($end?($actual>$date2?"1":"4"):"4") . " where ID_Serv = " . $id;
        $db->execute($sql);
        
    }elseif($action == "promo"){
        $id = $_POST['id'];
        $pos = $_POST['pos'];
        $func = $_POST['funcional'];
        $area = $_POST['area'];
        $level = $_POST['level'];
        $date = $_POST['date'];
        $fn = $_POST['fn'];
        $fracc = $_POST['fracc'];
        
        $sql = "select * from servpub where ID_Serv = " . $id;
        $data = $db->getObject($sql);
        $new = $db->getID("ID_Serv", "servpub");
        $param[] = $new;
        $param[] = $data->Nombre;
        $param[] = $data->Paterno;
        $param[] = $data->Materno;
        $param[] = $data->RFC;
        $param[] = $data->ID_Dependencia;
        $param[] = $pos;
        $param[] = $func;
        $param[] = $data->Contratacion;
        $str = "";
        foreach($fracc as $f)
            $str .= $f . "|";
        $param[] = $str;
        $param[] = $data->AG172;
        $param[] = $area;
        $param[] = $level;
        $param[] = $data->Tel_Trabajo;
        $param[] = $data->Per_Mensual;
        $param[] = $data->Calle_Trabajo;
        $param[] = $data->Num_Trabajo;
        $param[] = $data->Col_Trabajo;
        $param[] = $data->CP_Trabajo;
        $param[] = $data->Ciudad_Trabajo;
        $param[] = $data->Fecha_Inicio;
        $param[] = $data->Correo;
        $param[] = $data->Password;
        
        $db->queryStored("NewServ", $param);
        foreach($fn as $f)
            if($f) $db->queryStored ("setFunction", array($new, $f));
        
        $sql = "update servpub set Fecha_Termino = '" . $date . "', Estatus = 3 where ID_Serv = " . $id;
        $db->execute($sql);
        $db->queryStored("Transfer", array($id, $new));
        $db->queryStored("registerMov", array($new, 3, null, null, $id, $date, null, null, $_SESSION['UI']));
        
    }
?>
