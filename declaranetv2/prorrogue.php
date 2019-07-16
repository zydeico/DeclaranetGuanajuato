<?
    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');

    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = ($_SESSION['PRO']=="#SP"?"Solicitud de prórroga":"Gestión de prórrogas");

    if(!$action){
        $context->menu = setMenu();
        if($_SESSION['PRO'] == "#SP"){
            $sql = "select * from prorrogas where Terminado = 0 and ID_Serv = " . $_SESSION['UI'] . " order by ID_Prorroga DESC LIMIT 1";
            $context->data = $db->getObject($sql);
        }else{
            $context->allow = getAccess();
            $context->params[] = array("Header" => "#", "Width" => "40", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
            $context->params[] = array("Header" => "Fecha", "Width" => "130", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
            $context->params[] = array("Header" => "RFC", "Width" => "100", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
            $context->params[] = array("Header" => "Nombre", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
            $context->params[] = array("Header" => "Dependencia", "Width" => "*", "Attach" => "txt", "Align" => "left", "Sort" => "str", "Type" => "ro");
            $context->params[] = array("Header" => "Estatus", "Width" => "100", "Attach" => "cmb", "Align" => "left", "Sort" => "str", "Type" => "ro");
            $context->params[] = array("Header" => "Revisar", "Width" => "60", "Attach" => "", "Align" => "center", "Sort" => "", "Type" => "ro");
            
        }
        RenderTemplate('templates/prorrogue.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "save"){
        $motive = $_POST['motive'];
        $date = $_POST['date'];
        $tempFile = $_FILES['document']['tmp_name'];
        $file_name = $_FILES['document']['name'];
        $ext = explode(".", $file_name);
        $allow = array("xls", "xlsx", "doc", "docx", "pdf", "zip", "rar", "txt", "rtf");
        if(in_array($ext[count($ext)-1], $allow)){
            $id = $db->getID("ID_Prorroga", "prorrogas");
            $targetFile = "uploaded/prorrogas/" . $id . "_" . quitarAcentos($file_name, true);
            if (move_uploaded_file($tempFile,$targetFile)){
                $sql = "insert into prorrogas values("
                     . $id . ", "
                     . $_SESSION['UI'] . ", "
                     . "NOW(), "
                     . "'" . $date . "', "
                     . "'" . $motive . "', "
                     . "'" . $targetFile . "', "
                     . "null, null, 0, 0)";
                $db->execute($sql);
            }else
                echo "Ocurrió un error subiendo su archivo, por favor intente de nuevo";
        }else
            echo "El tipo de archivo adjuntado es inválido, favor de revisar";
    
        
    }elseif($action == "view"){
        $id = $_GET['id'];
        $sql = "select p.*, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Dependencia 
                from prorrogas p 
                join servpub sp on sp.ID_Serv = p.ID_Serv 
                join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
                where ID_Prorroga = " . $id;
        $context->data = $db->getObject($sql);
        RenderTemplate('templates/prorrogue.view.php', $context);
    
    }elseif($action == "resp"){
        $id = $_POST['id'];
        $resp = showVar($_GET['resp']);
        $date = $_POST['date'];
        $text = $_POST['text'];
        
        $sql = "update prorrogas set 
                Fecha_Aut = " . ($date?"'" .$date  . "'":"null") . ", 
                Respuesta = '" . $text . "', 
                Estatus = " . $resp . "
                where ID_Prorroga = " .$id;
        $db->execute($sql);
        
    }elseif($action == "again"){
        $id = $_GET['id'];
        $sql = "update prorrogas set Terminado = 1 where ID_Prorroga = " . $id;
        $db->execute($sql);
    }
?>