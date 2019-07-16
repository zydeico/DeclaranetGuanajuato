<?php

    require_once('../lib/secure.php');
    require_once('../lib/ext.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $rfc = $_GET['rfc'];
    $dep = $_GET['dep'];
    $est = $_GET['st'];
    $sql = "select DISTINCT(sp.ID_Serv), CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, RFC, Dependencia, Puesto, COUNT(ID_Dec)
            from servpub sp 
            join declaraciones d on d.ID_Serv = sp.ID_Serv
            join dependencias dep on dep.ID_Dependencia = sp.ID_Dependencia
            join puestos p on p.ID_Puesto = sp.ID_Puesto
            where sp.Estatus = " . $est;
    if($rfc)
        $sql .= " and RFC like '%" . $rfc . "%'";
    if($dep)
        $sql .= " and sp.ID_Dependencia = " . $dep;
    $sql .= " group by sp.ID_Serv, CONCAT_WS(' ', Paterno, Materno, Nombre), RFC, Dependencia, Puesto 
             order by Nombre";
    
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
        print  "<cell type = 'img'>img/view.gif^Declaraciones^javascript:Look(" . $d["ID_Serv"] . ")^_self</cell>";
        print  "<cell type = 'img'>img/view.gif^Declaraciones^javascript:interes(" . $d["ID_Serv"] . ")^_self</cell>";
//        print  "<cell type = 'img'>img/view.gif^Declaraciones^javascript:fiscal(" . $d["ID_Serv"] . ")^_self</cell>";
        print  "</row>";
    }
    print  "</rows>";
?>
