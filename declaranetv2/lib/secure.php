<?php
    
    session_start();
    ini_set('session.gc_maxlifetime', '7200');
    
    if(!isset($_SESSION['UI']) && strpos($_SERVER['SCRIPT_NAME'], 'index.php') === false && strpos($_SERVER['SCRIPT_NAME'], 'login.php') === false){
        Header('location:index.php');
    }

    foreach($_GET as $k => $v){
        if(is_array($v)){
                $array = array();
                foreach($v as $val)
                        $array[] = mysql_escape_string(trim($val));
                $_GET[$k] = $array;
        }else{
                $_GET[$k] = mysql_escape_string(trim($v));
        }
    }

    foreach($_POST as $k => $v){
        if(is_array($v)){
                $array = array();
                foreach($v as $val)
                        $array[] = mysql_escape_string(trim($val));
                $_POST[$k] = $array;
        }else{
                $_POST[$k] = mysql_escape_string(trim($v));
        }
    }
?>
