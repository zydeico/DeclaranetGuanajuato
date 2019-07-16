<?php
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $code = showVar($_GET['code']);
    $context = new Context();
    
    if(!$code)
        Header('location: index.php');
    else{
        switch($code){
            case "1":
                $context->title = "Acceso no permitido";
                $context->error = "No cuenta con permisos para acceder la página deseada";
                $context->img = "img/lock.png";
            break;
            case "2":
                $context->title = "Enlace no disponible";
                $context->error = "El enlace solicitado es incorrecto o ha expirado, por favor intente generarlo de nuevo";
                $context->img = "img/broken.png";
            break;
            case "3":
                $context->title = "Declaración enviada previamente";
                $context->error = "Ya existe un registro de su declaración. Favor de verificar";
                $context->img = "img/lock.png";
            break;
        }
        RenderTemplate('templates/error.tpl.php', $context, 'templates/base.php');
    }
    
?>
