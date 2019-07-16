<?php
    
    if ($_SESSION['HTTP_HOST'] != "localhost" && $_SERVER["HTTPS"] != "on" && substr_count($_SERVER['HTTP_HOST'], "strc.guanajuato")){
        Header('location: https://declaranet.strc.guanajuato.gob.mx/index.php');
    }
?>
