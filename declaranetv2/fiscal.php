<?php
    require_once('lib/secure.php');
    require_once('lib/ext.php');
    require_once('lib/DBConn.php');
    require_once('lib/templates.php');

    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    
    if(!$action){
        $sql = "select * from fiscal_dec where ID_Serv = " . $_SESSION['UI'] . " order by Fecha_DecFis DESC";
        $context->dec = $db->getArray($sql);
        
        $sql = "select ID_DecFis from fiscal_dec where YEAR(Fecha_DecFis) = YEAR(NOW()) and ID_Serv = " . $_SESSION['UI'];
        $context->fiscal = $db->getOne($sql);
        
        RenderTemplate('templates/fiscal.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "upload"){
        if(!empty($_FILES)){
            $file = $_FILES['document']['name'];
            $path = $_FILES['document']['tmp_name'];
            $ext = strtolower(end(explode(".", $file)));
            if($ext == "pdf"){
                $target = "fiscal/DeclaracionFiscal_" . Date('Y') . "_" . $_SESSION['UI'] . ".pdf";
                if(move_uploaded_file($path, $target)){
                    $sql = "insert into fiscal_dec values(NULL, " . $_SESSION['UI'] . ", NOW(), '" . $target . "')";
                    $db->execute($sql);
                }
            }
        }
        Header('location: fiscal.php');
    }elseif($action == "view"){
        $id = $_GET['id'];
        $sql = "select * from fiscal_dec where ID_Serv = " . $id . " order by Fecha_DecFis DESC";
        $context->dec = $db->getArray($sql);
        
        $sql = "select ID_DecFis from fiscal_dec where YEAR(Fecha_DecFis) = YEAR(NOW()) and ID_Serv = " . $_SESSION['UI'];
        $context->fiscal = $db->getOne($sql);
        
        RenderTemplate('templates/fiscaladmin.tpl.php', $context);
    }

