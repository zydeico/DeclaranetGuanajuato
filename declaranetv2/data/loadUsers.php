<?php

    require_once('../lib/DBConn.php');
    require_once('../lib/secure.php');
    

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $sql = "select u.ID_User, CONCAT_WS(' ',Paterno, Materno, Nombre) as Nombre, User, Fecha_Alta, Dependencia,
            CASE Tipo when 'GLOBAL' then 'GLOBAL' when 'REST' then 'RESTRINGIDO' END as Tipo, ID_Pro
            from users u
            join dependencias d on d.ID_Dependencia = u.ID_Dependencia 
            left join user_profile pro on pro.ID_User = u.ID_User
            where Fecha_Baja is null 
            order by Nombre";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    $temp = "";
    foreach($data as $d){
        if($temp != $d['ID_User']){
            $temp = $d['ID_User'];
            print "<row id = '" . $d["ID_User"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell type = 'img'>img/edit.png^Editar^javascript:Edit(" . $d["ID_User"] . ")^_self</cell>";
            print "<cell type = 'img'>img/delete.png^Eliminar^javascript:Del(" . $d["ID_User"] . ")^_self</cell>";
            print "<cell>" . htmlspecialchars($d["Nombre"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["User"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Dependencia"]) . "</cell>";		
            print "<cell>" . $d["Tipo"] . "</cell>";		
            print "<cell>" . $d["Fecha_Alta"] . "</cell>";		
            print "<cell type = 'img'>img/" . ($d['ID_Pro']?"view.gif":"add2.png") . "^Ver^javascript:View(" . $d["ID_User"] . ")^_self</cell>";
            print "</row>";
        }
    }
    print "</rows>";    
?>
