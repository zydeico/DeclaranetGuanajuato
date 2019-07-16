<?php
    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    
    if(!$action){
        RenderTemplate('templates/home.tpl.php', $context, 'templates/base.php');
    }

