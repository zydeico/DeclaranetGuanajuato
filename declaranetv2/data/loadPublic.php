<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $dep = $_GET['dep'];
    
    $sql = "select sp.ID_Serv, CONCAT_WS(' ', Paterno, Materno, Nombre) as Servidor, RFC, Puesto, ID_Public "
            . "from servpub sp "
            . "join puestos p on p.ID_Puesto = sp.ID_Puesto "
            . "left join publicaciones pub on pub.ID_Serv = sp.ID_Serv and Fecha_Oculta is null "
            . "where Estatus = 1 and ID_Dependencia = " . $dep ." "
            . "order by RFC";
    
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
   
    $cont = 1;
    foreach($data as $d){
        print  "<row id = '" . $d['ID_Serv'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell type = '" . ($d['ID_Public']?"ro":"ch") . "'></cell>";
        print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Servidor']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Puesto']) . "</cell>";
        print  "<cell>" . ($d['ID_Public']?"PUBLICADO":"NO PUBLICADO") . "</cell>";
        print  "<cell type = 'img'>img/view.gif^Detalles^javascript:PublicHistory(" . $d["ID_Serv"] . ")^_self</cell>";
        print  "</row>";
    }
    print  "</rows>";
?>
