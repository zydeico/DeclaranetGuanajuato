<?php
    require_once('dump.php');
    require_once('lib/DBConn.php');
    require_once('lib/ext.php');
    
    $db = new DBConn();
//// Revision de balances //////////////////////////////////////////////////////
    $sql = "select ID_Dec from declaraciones where Balanza is null";
    $data = $db->getArray($sql);
    foreach($data as $d){
        $balance = $db->queryStored("Balance", array($d['ID_Dec']), 'ARRAY');
        $b1 = str_replace(",", "", ($balance[0]['sueldo'] + $balance[0]['honorarios'] + $balance[0]['otros'] + $balance[0]['inmuebles'] + $balance[0]['muebles'] + $balance[0]['vehiculos'] + $balance[0]['inversiones'] + $balance[0]['adeudos'] - $balance[0]['depositos'] - $balance[0]['pagos']));
        $b2 = str_replace(",", "", ($balance[0]['conyuge'] + $balance[0]['inmuebles_con'] + $balance[0]['muebles_con'] + $balance[0]['vehiculos_con'] + $balance[0]['inversiones_con'] + $balance[0]['adeudos_con'] - $balance[0]['depositos_con'] - $balance[0]['pagos_con']));
        $b3 = str_replace(",", "", ($balance[0]['depend'] + $balance[0]['inmuebles_dep'] + $balance[0]['muebles_dep'] + $balance[0]['vehiculos_dep'] + $balance[0]['inversiones_dep'] + $balance[0]['adeudos_dep'] - $balance[0]['depositos_dep'] - $balance[0]['pagos_dep']));
        
        $sql = "update declaraciones set Balanza = " . $b1 . ", 
                Balanza_Conyuge = " . $b2 . ", 
                Balanza_Depend = " . $b3 . "
                where ID_Dec = " . $d['ID_Dec'];
        $db->execute($sql);
    }
    
//// Creacion de procedimientos ////////////////////////////////////////////////
    $declare = array("FINAL", "ANUAL");
    $sql = "select Valor from parametros where ID_Parametro = 5";
    $limit = strtotime($db->getOne($sql));
    foreach($declare as $dec){
        $counter[$dec] = 0;
        if($dec == "ANUAL"){
            if(!$limit || strtotime(Date('Y-m-d')) < $limit)
                break;
        }
        $url = getDomain() . "/data/loadOmited.php?dec=" . $dec;
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_HEADER, 0);  
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        $output = curl_exec($ch);  
        $xml = simplexml_load_string($output);
        
        foreach($xml->children() as $child){
            if(!$db->exist("ID_Proc", "procedimientos", "Tipo_Proc = 2 and Activo = 1 and YEAR(Fecha_Proc) = YEAR(NOW()) and ID_Serv = " . $child->attributes() . " and Omision = '" . $dec ."'")){
                $sql = "insert into procedimientos values("
                     . $db->getID("ID_Proc", "procedimientos") . ", "
                     . $child->attributes() . ", "
                     . "NOW(), "
                     . "2, "
                     . "null, "
                     . "'".$dec."', "
                     . "null, " // PRA
                     . "null, " // Fecha PRA
                     . "1, " // Bloq
                     . "null, "
                     . "1)";
                $db->execute($sql);
                $counter[$dec]++;
            }
        }
    }
    $sql = "insert into agenda(Fecha_Agenda, FINAL, ANUAL) values(NOW()," . $counter["FINAL"] . ", " . $counter['ANUAL'] . ")";
    $db->execute($sql);
?>
