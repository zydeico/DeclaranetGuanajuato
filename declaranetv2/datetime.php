<?php
    require_once('lib/DBConn.php');
    require_once('lib/ext.php');
    
    $db = new DBConn();
    
    echo $db->getTimezone();
    echo "<br>";
    echo $inicio_verano = date("Y-m-d", strtotime("2016-03-31 next Sunday"));
    echo "<br>";
    echo $fin_verano = date("Y-m-d", strtotime("2016-11-01 last Sunday"));
    echo "<br>";
    echo "MYSQL: " . $db->getOne("Select NOW()") . "<br>";
    echo "APACHE: " . Date('Y-m-d H:i:s');
