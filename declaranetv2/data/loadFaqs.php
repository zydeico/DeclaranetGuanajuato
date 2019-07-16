<?php

    require_once('../lib/DBConn.php');
    require_once('../lib/secure.php');
    

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $sql = "SELECT * FROM faqs order by ID_Faq";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    $temp = "";
    foreach($data as $d){
        if($temp != $d['ID_Faq']){
            $temp = $d['ID_Faq'];
            print "<row id = '" . $d["ID_Faq"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell type = 'img'>img/edit.png^Editar^javascript:Edit(" . $d["ID_Faq"] . ")^_self</cell>";
            print "<cell type = 'img'>img/delete.png^Eliminar^javascript:Del(" . $d["ID_Faq"] . ")^_self</cell>";
            print "<cell>" . htmlspecialchars($d["Descripcion"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Respuesta"]) . "</cell>";		
            print "</row>";
        }
    }
    print "</rows>";    
?>
