<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Reporte de declaraciones";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where Activo = 1 " . ($_SESSION['TP']=="GLOBAL"?" order by Dependencia":" and ID_Dependencia = " . $_SESSION['DEP']);
        $context->dep = $db->getArray($sql);
        $sql = "select IFNULL(MIN(YEAR(Fecha_Dec)), YEAR(NOW())) from declaraciones";
        $context->min = $db->getOne($sql);
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "int", "Type" => "ro");
        $context->params[] = array("Header" => "RFC", "Width" => "80", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ed");
        $context->params[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Cargo", "Width" => "150", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Fecha", "Width" => "120", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
//        $context->params[] = array("Header" => "Folio", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
        RenderTemplate('templates/repdec.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "gauge"){
        $dec = $_GET['dec'];
        $dep = $_GET['dep'];
        $year = $_GET['year'];
        
        switch($dec){
            case "INICIAL":
                $sqlTotal = "select COUNT(DISTINCT(ID_Serv)) from servpub sp 
                             where Estatus = 1 and YEAR(Fecha_Inicio) = " . $year . ($dep?" and ID_Dependencia = " . $dep:"");
                
                $sqlAv = "select COUNT(DISTINCT(ID_Dec)) from declaraciones d 
                          join servpub sp on sp.ID_Serv = d.ID_Serv and Estatus = 1 and YEAR(Fecha_Inicio) = " . $year ." 
                          where Tipo_Dec = 'INICIAL'" . ($dep?" and sp.ID_Dependencia = " . $dep:"");
            break;
            case "ANUAL":
                $sqlTotal = "select COUNT(DISTINCT(sp.ID_Serv)) from servpub sp 
                             where Estatus = 1 and YEAR(Fecha_Inicio) < " . $year  . ($dep?" and sp.ID_Dependencia = " . $dep:"");
                
                $sqlAv = "select COUNT(DISTINCT(ID_Dec)) from declaraciones d 
                          join servpub sp on sp.ID_Serv = d.ID_Serv and Estatus = 1 and YEAR(Fecha_Inicio) < " . $year . " 
                          where Tipo_Dec = 'ANUAL' and YEAR(Fecha_Dec) = " . $year  . ($dep?" and sp.ID_Dependencia = " . $dep:"");
            break;
            case "FINAL":
                $sqlTotal = "select COUNT(DISTINCT(sp.ID_Serv)) from servpub sp
                             join movimientos m on m.ID_Serv = sp.ID_Serv and Tipo_Mov = 2 and Tipo_Reg <> 'DEFUNCION'
                             where Estatus = 2 and YEAR(Fecha_Termino) = " . $year . ($dep?" and ID_Dependencia = " . $dep:" ") . "
                             and sp.ID_Serv not in 
                             (select Procedencia from movimientos where Tipo_Mov = 1 and Procedencia is not null and YEAR(Fecha_Mov) >= " . $year . ")";
                
                $sqlAv = "select COUNT(DISTINCT(ID_Dec)) from declaraciones d 
                          join servpub sp on sp.ID_Serv = d.ID_Serv and sp.Estatus = 2 and YEAR(Fecha_Termino) = " . $year . " 
                          where Tipo_Dec = 'FINAL'" . ($dep?" and sp.ID_Dependencia = " . $dep:"");
            break;
            case "INTERESES":
                $sqlTotal = "select COUNT(DISTINCT(sp.ID_Serv)) from servpub sp 
                             where Estatus = 1 and YEAR(Fecha_Inicio) < " . $year  . ($dep?" and sp.ID_Dependencia = " . $dep:"");
                $sqlAv = "select COUNT(DISTINCT(sp.ID_Serv)) from intereses_dec d 
                          join servpub sp on sp.ID_Serv = d.ID_Serv and Estatus = 1 and YEAR(Fecha_Inicio) < " . $year . " 
                          where YEAR(Fecha_DecInt) = " . $year  . ($dep?" and sp.ID_Dependencia = " . $dep:"");
                break;
        }
        $total = $db->getOne($sqlTotal);
        $advance = $db->getOne($sqlAv);
        echo ($total?round(($advance * 100) / $total):0); 
        sleep(1);
        
    }elseif($action == "general"){
        $dec = $_GET['dec'];
        $dep = $_GET['dep'];
        $year = $_GET['year'];
        
        if($dec == "INTERESES"){
            $sql = "select COUNT(sp.ID_Serv) as Conteo, DATE(Fecha_DecInt) as Fecha 
                    from intereses_dec d 
                    join servpub sp on sp.ID_Serv = d.ID_Serv 
                    where YEAR(Fecha_DecInt) = " . $year;
            if($dep)
                $sql .= " and ID_Dependencia = " . $dep;
            $sql .= " GROUP by Fecha order by Fecha";
        }else{
            $sql = "select COUNT(ID_Dec) as Conteo, DATE(Fecha_Dec) as Fecha 
                    from declaraciones d 
                    join servpub sp on sp.ID_Serv = d.ID_Serv 
                    where YEAR(Fecha_Dec) = " . $year . " and Tipo_Dec = '" . $dec . "'";
            if($dep)
                $sql .= " and ID_Dependencia = " . $dep;
            $sql .= " GROUP by Fecha order by Fecha";
        }
        
        $data = $db->getArray($sql);
        $json = array();
        foreach($data as $d)
            $json[] = array("date" => $d['Fecha'], "value" => $d['Conteo']);
        sleep(1);
        echo json_encode($json);
    }
?>
