<?php

    require_once('../lib/DBConn.php');
    require_once('../lib/secure.php');
    

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $sql = "SELECT * FROM fracciones WHERE Activo=1 order by ID_Fraccion";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    $temp = "";
    foreach($data as $d){
        if($temp != $d['ID_Fraccion']){
            $temp = $d['ID_Fraccion'];
            print "<row id = '" . $d["ID_Fraccion"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell type = 'img'>img/edit.png^Editar^javascript:EditFraccion(" . $d["ID_Fraccion"] . ")^_self</cell>";
            print "<cell type = 'img'>img/delete.png^Eliminar^javascript:DelFraccion(" . $d["ID_Fraccion"] . ")^_self</cell>";
            print "<cell>" . htmlspecialchars($d["Fraccion"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Descripcion"]) . "</cell>";				
            print "</row>";
        }
    }
    print "</rows>";    
?>
