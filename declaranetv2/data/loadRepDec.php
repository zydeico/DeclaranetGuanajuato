<?php

    require_once('../lib/secure.php');
    require_once('../lib/ext.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $dec = $_GET['dec'];
    $dep = $_GET['dep'];
    $year = $_GET['year'];
    
    if($dec == "INTERESES"){
        $source = "intereses_dec";
        $date = "Fecha_DecInt";
    }else{
        
    }
    
    $sql = "select DISTINCT(d.ID_Serv), " . ($dec=="INTERESES"?"Fecha_DecInt":"Fecha_Dec") . " as Fecha,
            RFC, CONCAT_WS(' ', Paterno, Materno, Nombre)as Nombre, Dependencia, Puesto
            from " . ($dec=="INTERESES"?"intereses_dec":"declaraciones") .  " d 
            join servpub sp on sp.ID_Serv = d.ID_Serv
            join dependencias dep on dep.ID_Dependencia = sp.ID_Dependencia
            join puestos p on p.ID_Puesto = sp.ID_Puesto
            where YEAR(" . ($dec=="INTERESES"?"Fecha_DecInt":"Fecha_Dec") . ") = " . $year
            . ($dec!="INTERESES"?" and Tipo_Dec = '" . $dec ."'":"") 
            . ($dep?" and sp.ID_Dependencia = ". $dep:"") 
            . " order by ". ($dec=="INTERESES"?"Fecha_DecInt":"Fecha_Dec") . ", RFC";
    
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
   
    $cont = 1;
    foreach($data as $d){
        print  "<row id = '" . $d['ID_Serv'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Nombre']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Dependencia']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Puesto']) . "</cell>";
        print  "<cell>" . $d['Fecha'] . "</cell>";
//        print  "<cell>" . substr($d['Tipo_Dec'], 0, 1) . $d['Anio'] . "-" . format($d['ID_Dec'], 10, "0") . "</cell>";
//        print  "<cell type = 'img'>img/view.gif^Declaraciones^javascript:Look(" . $d["ID_Serv"] . ")^_self</cell>";
        print  "</row>";
    }
    print  "</rows>";
?>
