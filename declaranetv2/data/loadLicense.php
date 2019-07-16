<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    
    $sql = "select sp.ID_Serv, RFC, CONCAT_WS(' ',Paterno, Materno, Nombre) as Nombre, Area, 
            Inicio, Termino, Motivo
            from servpub sp 
            join movimientos m on m.ID_Serv = sp.ID_Serv 
            where ID_Dependencia = " . $_GET['dep'] . "
            and Estatus = 4 and Tipo_Mov = 4 
            and (Termino is null or Termino >= NOW())
            order by Nombre";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    foreach($data as $d){
            print "<row id = '" . $d["ID_Serv"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell>" . htmlspecialchars($d["RFC"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Nombre"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Area"]) . "</cell>";	
            print "<cell>" . htmlspecialchars($d["Inicio"]) . "</cell>";	
            print "<cell>" . htmlspecialchars($d["Termino"]) . "</cell>";	
            if(in_array(14, $_SESSION['PM']))
                print "<cell type = 'img'>img/view.gif^Detalles^javascript:ViewLic(" . $d["ID_Serv"] . ", 500, 300)^_self</cell>";
            print "</row>";
    }
    print "</rows>";    
?>
