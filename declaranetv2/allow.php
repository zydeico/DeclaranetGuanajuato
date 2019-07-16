<?
    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
   
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Perfiles y permisos";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Ver", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Editar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Eliminar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
        $context->params[] = array("Header" => "Perfil", "Width" => "*", "Attach" => "", "Align" => "left", "Sort" => "str", "Type" => "ro");
        RenderTemplate('templates/allow.tpl.php', $context, 'templates/base.php');
    }elseif($action == "load"){
        $id = $_GET['id'];
        $sql = "select Permiso, ID_Permiso, Modulo, Grupo
                from permisos p 
                join modulos m on m.ID_Modulo = p.ID_Modulo
                join grupos g on g.ID_Grupo = m.ID_Grupo 
                order by g.ID_Grupo, p.ID_Modulo, ID_Permiso";
        
        $context->permission = $db->getArray($sql);
        $sql = "select Perfil, Acceso from perfiles where ID_Perfil = " . $id;
        $data = $db->getObject($sql);
        $context->profile = $data->Perfil;
        $context->access = explode("|", $data->Acceso);
        $context->id = $id;
        RenderTemplate('templates/allow.permission.php', $context);
    }elseif($action == 'save'){
        $id = $_POST['id'];
        $permission = $_POST['permission'];
        $concat = "";
        foreach($permission as $p)
            $concat .= $p . "|";
        $sql = "update perfiles set Acceso = '" . $concat . "' where ID_Perfil = " . $id;
        $db->execute($sql);
        sleep(1);   
    }elseif($action == "del"){
        $id = $_GET['id'];
        if($db->exist("ID_Pro", "user_profile", "ID_Perfil = " . $id)){
            echo "No es posible eliminar, existe uno o más usuarios con este perfil";
        }else{
            $sql = "delete from perfiles where ID_Perfil = " . $id;
            $db->execute($sql);
        }
        
    }elseif($action == "profile"){
        $id = $_GET['id'];
        if($id){
            $context->id = $id;
            $sql = "select Perfil from perfiles where ID_PerfiL = " . $id;
            $context->name = $db->getOne($sql);
        }
        RenderTemplate('templates/allow.profile.php', $context);
        
    }elseif($action == "saveProfile"){
        $id = $_POST['id'];
        $name = $_POST['profile'];
        if($id){
            $sql = "update perfiles set Perfil = '" . $name . "' where ID_Perfil = " . $id;
        }else{
            $sql = "insert into perfiles values("
                 . $db->getID("ID_Perfil", "perfiles") . ", "
                 . "'" . $name . "', "
                 . "null)";
        }
        $db->execute($sql);
    }
    
?>
