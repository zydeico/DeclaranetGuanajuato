<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    
    $sql = "select ID_Prorroga, Fecha_Solicitud, RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Dependencia, 
            CASE p.Estatus 
            when 0 then 'Pendiente'
            when 1 then 'Aprobada'
            when 2 then 'Rechazada'
            END as Phase 
            from prorrogas p 
            join servpub sp on sp.ID_Serv = p.ID_Serv 
            join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
            where Terminado = 0
            order by Fecha_Solicitud DESC ";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    foreach($data as $d){
            print "<row id = '" . $d["ID_Prorroga"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell>" . $d["Fecha_Solicitud"] . "</cell>";		
            print "<cell>" . htmlspecialchars($d["RFC"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Nombre"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Dependencia"]) . "</cell>";	
            print "<cell>" . htmlspecialchars($d["Phase"]) . "</cell>";	
            print "<cell type = 'img'>img/view.gif^Detalles^javascript:View(" . $d["ID_Prorroga"] . ")^_self</cell>";
            print "</row>";
    }
    print "</rows>";    
?>
