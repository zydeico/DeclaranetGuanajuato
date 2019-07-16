<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $dep = $_GET['dep'];
    $dec = $_GET['dec'];
    $year = $_GET['year'];
    
    $sql = "select * from dependencias where " . ($dep?"ID_Dependencia = " . $dep:"Activo = 1") . " order by Dependencia";
    $list = $db->getArray($sql);
    
    switch($dec){
        case "INICIAL":
            $sqlObl = "select COUNT(ID_Serv) from servpub where Estatus = 1 and YEAR(Fecha_Inicio) = " . $year . " 
                       and ID_Serv not in (select ID_Serv from serv_ex) ";
            $sqlCum = "select COUNT(sp.ID_Serv) from declaraciones d 
                       join servpub sp on sp.ID_Serv = d.ID_Serv and Estatus = 1 and YEAR(Fecha_Inicio) = " . $year . "
                       where Tipo_Dec = 'INICIAL' ";
        break;
        case "ANUAL":
            $sqlObl = "select COUNT(ID_Serv) from servpub where Estatus = 1 and YEAR(Fecha_Inicio) < " . $year . " 
                       and ID_Serv not in (select ID_Serv from prorrogas where Estatus = 1 and Terminado = 0 and Fecha_Aut >= DATE(NOW())) 
                       and ID_Serv not in (select ID_Serv from serv_ex) ";
            $sqlCum = "select COUNT(DISTINCT(sp.ID_Serv)) from declaraciones d 
                       join servpub sp on sp.ID_Serv = d.ID_Serv and Estatus = 1 and YEAR(Fecha_Inicio) < " . $year . "
                       where Tipo_Dec = 'ANUAL' and YEAR(Fecha_Dec) = " . $year . "
                       and sp.ID_Serv not in (select ID_Serv from prorrogas where Estatus = 1 and Terminado = 0 and Fecha_Aut >= DATE(NOW())) 
                       and sp.ID_Serv not in (select ID_Serv from serv_ex) ";
        break;
        case "FINAL":
            $sqlObl = "select COUNT(sp.ID_Serv) from servpub sp
                       join movimientos m on m.ID_Serv = sp.ID_Serv and Tipo_Mov = 2 and Tipo_Reg <> 'DEFUNCION'
                       where Estatus = 2 and YEAR(Fecha_Termino) <= " . $year . " and sp.ID_Serv not in 
                       (select Procedencia from movimientos where Tipo_Mov = 1 and Procedencia is not null) 
                       and sp.ID_Serv not in (select ID_Serv from serv_ex) ";
            $sqlCum = "select COUNT(DISTINCT(sp.ID_Serv)) from declaraciones d 
                       join servpub sp on sp.ID_Serv = d.ID_Serv and sp.Estatus = 2 and YEAR(Fecha_Termino) <= " . $year . " 
                       where Tipo_Dec = 'FINAL' and sp.ID_Serv not in 
                       (select Procedencia from movimientos where Tipo_Mov = 1 and Procedencia is not null) 
                       and sp.ID_Serv not in (select ID_Serv from serv_ex) ";
        break;
        case "INTERESES":
            $sqlObl = "select COUNT(ID_Serv) from servpub where Estatus = 1 and YEAR(Fecha_Inicio) < " . $year . " 
                       and ID_Serv not in (select ID_Serv from prorrogas where Estatus = 1 and Terminado = 0 and Fecha_Aut >= DATE(NOW())) 
                       and ID_Serv not in (select ID_Serv from serv_ex) ";
            $sqlCum = "select COUNT(DISTINCT(sp.ID_Serv)) from intereses_dec d 
                       join servpub sp on sp.ID_Serv = d.ID_Serv and Estatus = 1 and YEAR(Fecha_Inicio) < " . $year . "
                       where YEAR(Fecha_DecInt) = " . $year . "
                       and sp.ID_Serv not in (select ID_Serv from prorrogas where Estatus = 1 and Terminado = 0 and Fecha_Aut >= DATE(NOW())) 
                       and sp.ID_Serv not in (select ID_Serv from serv_ex) ";
            break;
    }
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $total = $db->getOne($sqlObl);
    $cont = 1;
    $greatObl = 0;
    $greatCum = 0;
    $greatInd = 0;
    $greatRest = 0;
    $greatGlobal = 0;
    foreach($list as $i){
        $obl = $db->getOne($sqlObl . "and ID_Dependencia = " . $i['ID_Dependencia']);
        $cum = $db->getOne($sqlCum . "and ID_Dependencia = " . $i['ID_Dependencia']);
        $ind = round(($cum * 100) / $obl, 2);
        $rest = ($obl-$cum<0?0:$obl-$cum);
        $global = round(($cum * 100) / $total, 2);
        print  "<row id = '" . $i['ID_Dependencia'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell>" . htmlspecialchars($i['Dependencia']) . "</cell>";
        print  "<cell>" . $obl . "</cell>";
        print  "<cell>" . $cum . "</cell>";
        print  "<cell>" . $ind . "%</cell>";
        print  "<cell>" . $rest . "</cell>";
        print  "<cell>" . $global . "%</cell>";
        print  "</row>";
        $greatObl += $obl;
        $greatCum += $cum;
        $greatInd += $ind;
        $greatRest += $rest;
        $greatGlobal += $global;
    }
    print  "<row id = '0'>";
    print  "<cell></cell>";
    print  "<cell>Totales</cell>";
    print  "<cell>" . $greatObl . "</cell>";
    print  "<cell>" . $greatCum . "</cell>";
    print  "<cell>" . round(($greatCum * 100) / $greatObl, 2) . "%</cell>";
    print  "<cell>" . $greatRest . "</cell>";
    print  "<cell>" . round($greatGlobal) . "%</cell>";
    print  "</row>";
    print  "</rows>";
?>
