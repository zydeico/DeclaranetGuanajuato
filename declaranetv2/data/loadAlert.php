<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $d1 = $_GET['d1'];
    $d2 = $_GET['d2'];
    $sql = "select COUNT(ID_Consulta), c.ID_Serv, RFC, CONCAT_WS(' ', sp.Paterno, sp.Materno, sp.Nombre) as Servidor, Dependencia, 
            CONCAT_WS(' ', u.Nombre, u.Paterno) as Usuario, DATE(Fecha) as Fecha_Con
            from consultas c 
            join servpub sp on sp.ID_Serv = c.ID_Serv
            join dependencias dep on dep.ID_Dependencia = sp.ID_Dependencia
            join users u on u.ID_User = c.ID_User 
            where DATE(c.Fecha) between '" . $d1 . "' and '" . $d2 . "'
            group by RFC, Usuario, Fecha_Con, Servidor, Dependencia, ID_Serv 
            order by Fecha_Con, Servidor";
    
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
   
    $cont = 1;
    foreach($data as $d){
        
        print  "<row id = '" . $d['ID_Serv'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Servidor']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Dependencia']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Usuario']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Fecha_Con']) . "</cell>";
        print  "<cell type = 'img'>img/view.gif^Detalles^javascript:View(" . $d["ID_Serv"] . ", \"" . $d['Fecha_Con'] . "\")^_self</cell>";
        print  "</row>";
    }
    print  "</rows>";
?>
