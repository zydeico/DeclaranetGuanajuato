<?php

    require_once('../lib/DBConn.php');
    require_once('../lib/secure.php');
    

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $sql = "SELECT * FROM puestos WHERE Activo=1 order by ID_Puesto";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    $temp = "";
    foreach($data as $d){
        if($temp != $d['ID_Puesto']){
            $temp = $d['ID_Puesto'];
            print "<row id = '" . $d["ID_Faq"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell type = 'img'>img/edit.png^Editar^javascript:EditPuesto(" . $d["ID_Puesto"] . ")^_self</cell>";
            print "<cell type = 'img'>img/delete.png^Eliminar^javascript:DelPuesto(" . $d["ID_Puesto"] . ")^_self</cell>";
            print "<cell>" . htmlspecialchars($d["Puesto"]) . "</cell>";		
            print "</row>";
        }
    }
    print "</rows>";    
?>
