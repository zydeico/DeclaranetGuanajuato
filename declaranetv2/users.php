<?php
    
    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn(); 
    $context->title = "Usuarios de sistema";
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Editar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Desactivar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Usuario", "Width" => "180", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Tipo", "Width" => "100", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
        $context->params[] = array("Header" => "Fecha Alta", "Width" => "70", "Attach" => "txt", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Perfil", "Width" => "50", "Attach" => "", "Align" => "center", "Sort" => "str", "Type" => "ro");
        RenderTemplate('templates/users.tpl.php', $context, 'templates/base.php');
    }elseif($action == "user"){
        $id = $_GET['id'];
        if($id){
            $sql = "select * from users where ID_User = " . $id;
            $context->data = $db->getObject($sql);
        }
        $sql = "select * from dependencias where Activo = 1 order by Dependencia";
        $context->dep = $db->getArray($sql);
        RenderTemplate('templates/users.form.php', $context);
    }elseif($action == "save"){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $pater = $_POST['paterno'];
        $mater = $_POST['materno'];
        $mail = $_POST['mail'];
        $pwd = $_POST['pwd'];
        $type = $_POST['type'];
        $dep = $_POST['dep'];
        
        if($id){
            $sql = "select Password from users where ID_User = " .$id;
            $old = $db->getOne($sql);
            $sql = "update users set 
                    Nombre = '" . $name . "', 
                    Paterno = '" . $pater . "', 
                    Materno = '" . $mater . "', 
                    User = '" . $mail . "', ";
            if($pwd){
                $sql .= "Password = '" . Encrypt($pwd) . "', 
                         Old = '" . $old . "', 
                         Fecha_Clave = null, ";
            }
            $sql .= "Tipo = '" . $type . "', 
                     ID_Dependencia = " . ($dep?$dep:"null") . "
                     where ID_User = " . $id;
        }else{
            if($db->exist("ID_User", "users", "User = '" . $mail . "' and Fecha_Baja is null")){
                echo "Ya existe un usuario con este correo, favor de verificar";
                exit;
            }
            $id = $db->getID("ID_User", "users");
            $sql = "insert into users values("
                 . $id . ", "
                 . "'" . $name . "', "
                 . "'" . $pater . "', "
                 . "'" . $mater . "', "
                 . "'" . $mail . "', "
                 . "'" . Encrypt($pwd) . "', "
                 . "null, null, " // Clave anterior y fecha
                 . "NOW(), "
                 . "'" . $type . "', "
                 . ($dep?$dep:"null") . ", "
                 . "null )";
        }
        $db->execute($sql);
        echo $id;
        
    }elseif($action == "del"){
       $id = $_GET['id'];
       $sql = "update users set Fecha_Baja = NOW() where ID_User = " . $id;
       $db->execute($sql);
            
    }elseif($action == "valid"){
        $id = $_POST['id'];
        $pwd1 = $_POST['pwd'];
        $pwd2 = $_POST['confirm'];
        echo validatePwd($id, $pwd1, $pwd2, "USER");
    }elseif($action == "view"){
        $id = $_GET['id'];
        $context->id = $id;
        $sql = "select ID_Pro, p.ID_Perfil, Perfil 
                from perfiles p 
                join user_profile u on u.ID_Perfil = p.ID_Perfil 
                where ID_User = " . $id;
        $context->data = $db->getArray($sql);
        $sql = "select * from perfiles where ID_Perfil not in 
                (select ID_Perfil from user_profile where ID_User = " . $id . ")";
        $context->profiles = $db->getArray($sql);
        RenderTemplate('templates/users.profile.php', $context);
    }elseif($action == "add"){
        $id = $_GET['id'];
        $pro = $_GET['pro'];
        $sql = "insert into user_profile values("
             . $db->getID("ID_Pro", "user_profile") . ", "
             . $pro . ", "
             . $id . ")";
        $db->execute($sql);
    }elseif($action == "quit"){
        $id = $_GET['id'];
        $sql = "delete from user_profile where ID_Pro = " . $id;
        $db->execute($sql);
    }
?>
