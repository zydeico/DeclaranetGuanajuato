<?php
    require_once('../lib/ext.php');
    require_once('../lib/DBConn.php');
    
    session_start();

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $sql = "select * from perfiles order by perfil";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    foreach($data as $d){
            print "<row id = '" . $d["ID_Perfil"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell type = 'img'>img/view.gif^Ver^javascript:View(" . $d["ID_Perfil"] . ")^_self</cell>";
            print "<cell type = 'img'>img/edit.png^Editar^javascript:Edit(" . $d["ID_Perfil"] . ")^_self</cell>";
            print "<cell type = 'img'>img/delete.png^Eliminar^javascript:Del(" . $d["ID_Perfil"] . ")^_self</cell>";
            print "<cell>" . htmlspecialchars($d["Perfil"]) . "</cell>";		
            print "</row>";
    }
    print "</rows>";    
?>
