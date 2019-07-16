<?php

    require_once('../lib/secure.php');
    require_once('../lib/ext.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    
    $sql = "select ID_Modif, RFC, CONCAT_WS(' ', sp.Paterno, sp.Materno, sp.Nombre) as Nombre, Dependencia, 
            CONCAT_WS(' ', u.Nombre, u.Paterno) as Usuario, Fecha_Modif, Fecha_Limite, Tipo_Dec 
            from modificaciones m
            join declaraciones d on d.ID_Dec = m.ID_Dec
            join servpub sp on sp.ID_Serv = d.ID_Serv 
            join dependencias dep on dep.ID_Dependencia = sp.ID_Dependencia 
            join users u on u.ID_User = m.ID_User
            order by ID_Modif DESC";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
   
    $cont = 1;
    foreach($data as $d){
        
        print  "<row id = '" . $d['ID_Modif'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Nombre']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Dependencia']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Tipo_Dec']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Usuario']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Fecha_Modif']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Fecha_Limite']) . "</cell>";
        print  "</row>";
    }
    print  "</rows>";
?>
