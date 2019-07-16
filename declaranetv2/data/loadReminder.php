<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');
    require_once('../lib/ext.php');
    

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    
    $sql = "select ID_Serv, RFC, Dependencia, CONCAT_WS(' ',Paterno, Materno, Nombre) as Nombre, Area, Fecha_Inicio, Fecha_Termino
            from servpub sp
            join dependencias d on d.ID_Dependencia = sp.ID_Dependencia
            where sp.ID_Dependencia " . ($_GET['dep']?" = " . $_GET['dep']:" > 0") . "
            and Estatus = " . ($_GET["st"]=="Inicial"?"1":"2") . " 
            and ID_Serv not in 
            (select ID_Serv from declaraciones where YEAR(Fecha_Dec) >= YEAR(" . ($_GET["st"]=="Inicial"?"Fecha_Inicio":"Fecha_Termino") . ") 
            and Tipo_Dec = '" . ($_GET["st"]=="Inicial"?"INICIAL":"FINAL") . "') 
            order by " . ($_GET["st"]=="Inicial"?"Fecha_Inicio":"Fecha_Termino");
    $data = $db->getArray($sql);
    $sql = "select * from dias_inhabiles where YEAR(Fecha) >= (YEAR(NOW()) - 1)";
    $omit = $db->getArray($sql);
    foreach ($omit as $o)
        $inhab[] = $o['Fecha'];
    $sql = "select Valor from parametros where ID_Parametro = 3";
    $days = $db->getOne($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    foreach($data as $d){
        $date =  ($_GET["st"]=="Inicial"?$d['Fecha_Inicio']:$d['Fecha_Termino']);
        $now = Date('Y-m-d');
        $calc = Calculate($date, $days, $inhab);
        $diff = DateDiff($now, $calc, "DIAS", true);
//        if($now <= $calc){
            print "<row id = '" . $d["ID_Serv"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell></cell>";		
            print "<cell>" . htmlspecialchars($d["RFC"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Nombre"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Dependencia"]) . "</cell>";	
            print "<cell>" . ($_GET['st']=="Inicial"?$d['Fecha_Inicio']:$d['Fecha_Termino']) . "</cell>";	
            print "<cell>" . (strtotime($now) > strtotime($calc) ? "0":$diff) . "</cell>";
            print "<cell type = 'img'>img/file.png^Generar^javascript:Remind(" . $d["ID_Serv"] . ", \"" . $_GET['st'] . "\")^_self</cell>";
            print "<cell type = 'img'>img/like.png^Generar^javascript:Agree(" . $d["ID_Serv"] . ")^_self</cell>";
            print "</row>";
//        }
    }
    print "</rows>";    
    sleep(1);
?>
