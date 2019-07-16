<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $down = $_GET['down'];
    
    $sql = "select ID_Serv from servpub where Estatus = 4 and ID_Dependencia = " . $_GET['dep'];
    $data = $db->getArray($sql);
    foreach($data as $d){
        $sql = "select Termino from movimientos where Tipo_Mov = 4 and ID_Serv = " . $d['ID_Serv'] . " order by ID_Mov DESC LIMIT 1";
        $end = $db->getOne($sql);
        if($end){
            $actual = strtotime(Date('Y-m-d'));
            $end = strtotime($end);
            if($actual > $end){
                $sql = "update servpub set Estatus = 1 where ID_Serv = " . $d['ID_Serv'];
                $db->execute($sql);
            }
        }
    }
    
    $sql = "select ID_Serv, RFC, CONCAT_WS(' ',Paterno, Materno, Nombre) as Nombre, Area, Cargo_Funcional, Nivel
            from servpub where ID_Dependencia = " . $_GET['dep'] . "
            and Estatus = " . ($down?"2":"1") . "
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
            print "<cell>" . htmlspecialchars($d["Cargo_Funcional"]) . "</cell>";	
            print "<cell>" . htmlspecialchars($d["Nivel"]) . "</cell>";	
            if($down){
                print  "<cell></cell>";
                print  "<cell></cell>";
                print  "<cell></cell>";
                print  "<cell></cell>";
                print  "<cell></cell>";
            }else{
                if(in_array(56, $_SESSION['PM']))
                    print "<cell type = 'img'>img/delete.png^Desactivar^javascript:Load(\"Deactivate\", " . $d["ID_Serv"] . ", 500, 220)^_self</cell>";
                if(in_array(15, $_SESSION['PM']))
                    print "<cell type = 'img'>img/down.png^Baja^javascript:Load(\"Down\", " . $d["ID_Serv"] . ", 500, 270)^_self</cell>";
                if(in_array(14, $_SESSION['PM']))
                    print "<cell type = 'img'>img/minicalendar.png^Licencia^javascript:Load(\"License\", " . $d["ID_Serv"] . ", 500, 300)^_self</cell>";
                if(in_array(36, $_SESSION['PM']))
                    print "<cell type = 'img'>img/star.png^Promoción^javascript:Load(\"Promo\", " . $d["ID_Serv"] . ", 700, 500)^_self</cell>";
                if(in_array(37, $_SESSION['PM']))
                    print "<cell type = 'img'>img/minicheck.png^Corrección^javascript:Load(\"Correct\", " . $d["ID_Serv"] . ", 700, \"*\")^_self</cell>";
            }
            if(in_array(29, $_SESSION['PM']))
                    print "<cell type = 'img'>img/minikey.png^Clave^javascript:Load(\"Key\", " . $d["ID_Serv"] . ", 600, 150)^_self</cell>";
            print "</row>";
    }
    print "</rows>";    
    sleep(1);
?>
