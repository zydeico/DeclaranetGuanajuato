<?php

    require_once('../lib/DBConn.php');
    require_once('../lib/secure.php');
    

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $sql = "SELECT * FROM reactivos WHERE Activo=1 order by ID_Reactivo";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    $temp = "";
    foreach($data as $d){
        if($temp != $d['ID_Reactivo']){
            $temp = $d['ID_Reactivo'];
            print "<row id = '" . $d["ID_Reactivo"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell type = 'img'>img/edit.png^Editar^javascript:EditEncuesta(" . $d["ID_Reactivo"] . ")^_self</cell>";
            print "<cell type = 'img'>img/delete.png^Eliminar^javascript:DelEncuesta(" . $d["ID_Reactivo"] . ")^_self</cell>";
            print "<cell>" . htmlspecialchars($d["Reactivo"]) . "</cell>";		
            print "<cell>" . ($d["Opciones"]?"Opciones":"Abierta") . "</cell>";		
            print "</row>";
        }
    }
    print "</rows>";    
?>
