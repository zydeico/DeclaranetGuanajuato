<?php

require_once('lib/DBConn.php');
require_once('lib/WSConn.php');
require_once('lib/ext.php');

$action = $_GET['action'];
$db = new DBConn();

if(!$action){

   
}elseif($action == "balance"){
    $dec = $_GET['dec'];
    $balance = $db->queryStored("Balance", array($dec), 'ARRAY');
    $b1 = str_replace(",", "", ($balance[0]['sueldo'] + $balance[0]['honorarios'] + $balance[0]['otros'] + $balance[0]['inmuebles'] + $balance[0]['muebles'] + $balance[0]['vehiculos'] + $balance[0]['inversiones'] + $balance[0]['adeudos'] - $balance[0]['depositos'] - $balance[0]['pagos']));
    $b2 = str_replace(",", "", ($balance[0]['conyuge'] + $balance[0]['inmuebles_con'] + $balance[0]['muebles_con'] + $balance[0]['vehiculos_con'] + $balance[0]['inversiones_con'] + $balance[0]['adeudos_con'] - $balance[0]['depositos_con'] - $balance[0]['pagos_con']));
    $b3 = str_replace(",", "", ($balance[0]['depend'] + $balance[0]['inmuebles_dep'] + $balance[0]['muebles_dep'] + $balance[0]['vehiculos_dep'] + $balance[0]['inversiones_dep'] + $balance[0]['adeudos_dep'] - $balance[0]['depositos_dep'] - $balance[0]['pagos_dep']));
    //                $db->queryStored("updateDec", array($dec, $b1, $b2, $b3));
    $sql = "update declaraciones set Balanza = " . $b1 . ", 
            Balanza_Conyuge = " . $b2 . ", 
            Balanza_Depend = " . $b3 . "
            where ID_Dec = " . $dec;

    $db->execute($sql);
    echo "OK";
    
}elseif($action == "hide"){
    echo hideVar($_GET['str']);
    
}elseif($action == "show"){
    echo showVar($_GET['str']);
    
}elseif($action == "pwd"){
    echo Encrypt($_GET['str']);
}
    

?>
