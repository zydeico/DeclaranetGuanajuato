<?php

    require_once('../lib/DBConn.php');
    require_once('../lib/secure.php');
    

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $sql = "SELECT * FROM dependencias WHERE Activo=1 order by Dependencia";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    $temp = "";
    foreach($data as $d){
        if($temp != $d['ID_Dependencia']){
            $temp = $d['ID_Dependencia'];
            print "<row id = '" . $d["ID_Dependencia"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell type = 'img'>img/edit.png^Editar^javascript:EditDependencia(" . $d["ID_Dependencia"] . ")^_self</cell>";
            print "<cell type = 'img'>img/delete.png^Eliminar^javascript:DelDependencia(" . $d["ID_Dependencia"] . ")^_self</cell>";
            print "<cell>" . htmlspecialchars($d["Dependencia"]) . "</cell>";		
            print "</row>";
        }
    }
    print "</rows>";    
?>
