<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $dep = $_GET['dep'];
    $st = $_GET['st'];
    
    $sql = "select * from fracciones order by ID_Fraccion";
    $fracciones = $db->getArray($sql);
    foreach ($fracciones as $f)
       $fracc[$f['ID_Fraccion']] = $f['Fraccion'];
    
    $sql = "select sp.ID_Serv, RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, ART64, Dependencia, Puesto, "
            . "GROUP_CONCAT(Funcion) as Funciones "
            . "from servpub sp "
            . "join dependencias d on d.ID_Dependencia = sp.ID_Dependencia "
            . "join puestos p on p.ID_Puesto = sp.ID_Puesto "
            . "join funciones f on f.ID_Serv = sp.ID_Serv "
            . "where Estatus = " . $st;
    if(is_numeric($dep))
        $sql .= " and sp.ID_Dependencia = " . $dep;
    $sql .= " group by sp.ID_Serv "
            . "order by Dependencia, RFC";
    $data = $db->getArray($sql);
    
    $cont = 1;
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    foreach($data as $d){
        print  "<row id = '" . $d['ID_Serv'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Dependencia']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Nombre']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Puesto']) . "</cell>";
        $str = "";
        foreach (explode("|", $d['ART64']) as $e)
                if($e) $str .= $fracc[$e] . ", ";
        print  "<cell>" . $str . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Funciones']) . "</cell>";
        print  "</row>";
        
    }
    
    print  "</rows>";
?>
