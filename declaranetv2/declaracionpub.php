<?php
    require_once('lib/secure.php');
    require_once('lib/ext.php');
    require_once('lib/DBConn.php');
    require_once('lib/templates.php');

    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    
    if(!$action){
        $sql = "select * from acuerdo_dec_pub where ID_Serv = " . $_SESSION['UI'] . " order by Fecha_Doc DESC";
        $context->dec = $db->getArray($sql);
             
        RenderTemplate('templates/declaracionpub.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "upload"){
        $id = showVar($_POST['id']);
        if(!empty($_FILES)){
            $file = $_FILES['document']['name'];
            $path = $_FILES['document']['tmp_name'];
            $ext = strtolower(end(explode(".", $file)));
            if($ext == "pdf"){
                $target = "documents/acuerdos/Acuerdo_" . Date('Y') . "_" . time() . "_" . $_SESSION['UI'] . ".pdf";
                if(move_uploaded_file($path, $target)){
                    if(is_numeric($id))
                        $sql = "update acuerdo_dec_pub set Fecha_Doc = NOW(), Documento = '" . $target . "', Estatus = 0 Where ID_AcuerdoPub=". $id;
                    else
                        $sql = "insert into acuerdo_dec_pub values(NULL, " . $_SESSION['UI'] . ", NOW(), NULL, '" . $target . "',0)";
                    
                    $db->execute($sql);
                }
            }
        }
        Header('location: declaracionpub.php');
    }

