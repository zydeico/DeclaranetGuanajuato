<?php

    require_once('../lib/DBConn.php');
    require_once('../lib/secure.php');
    

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $tipo=$_GET['t'];
    if($tipo=='')
            $tipo=2;
    $data = $db->queryStored("FindNotificaciones", array($_SESSION['UI'],$tipo), 'ARRAY');	
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    $temp = "";
    foreach($data as $d){
        if($temp != $d['ID_Mensaje']){
            $temp = $d['ID_Mensaje'];
            print "<row id = '" . $d["ID_Mensaje"] . "'>";
            print "<cell>" . $cont++ . "</cell>";	
            if($d['ID_Emisor']==$_SESSION['UI']){				
                print "<cell type = 'img'>img/edit.png^Editar^javascript:addMsg(2," . $d["ID_Mensaje"] . ")^_self</cell>";
                print "<cell type = 'img'>img/delete.png^Eliminar^javascript:Del(" . $d["ID_Mensaje"] . ")^_self</cell>";
            }else
                print "<cell></cell><cell></cell>";
            print "<cell>" . $d["Creado"] . "</cell>";	
            print "<cell>" . htmlspecialchars($d["Asunto"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Alcance"]) . "</cell>";		    
            print "<cell>" . htmlspecialchars($d["Destino"]) . "</cell>";		    			        
            print "<cell>" . $d["Fecha_Creacion"] . "</cell>";	
            print "<cell>" . $d["Fecha_Expiracion"] . "</cell>";		
            print "<cell type = 'img'>img/" . ($d['ID_Mensaje']?"view.gif":"add2.png") . "^Ver^javascript:View(" . $d["ID_Mensaje"] . ")^_self</cell>";
            print "</row>";
        }
    }
    print "</rows>";    
?>
