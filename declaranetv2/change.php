<?php

    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn(); 
    $context->title = "Cambiar contraseña";
    if(!$action){	
        $context->allow = getAccess();
        $context->menu = setMenu();
        RenderTemplate('templates/change.tpl.php', $context, 'templates/base.php');

    }else if($action=='save'){
		$param='';
		$error='';
        if(!empty($_POST)){
			$anterior=encrypt($_POST['anterior']);
			if($_SESSION['PRO']=='#SP')
				$sql="SELECT * FROM servpub WHERE ID_Serv=".$_SESSION['UI']." AND Password='$anterior' LIMIT 1";
			else
				$sql="SELECT * FROM users WHERE ID_User=".$_SESSION['UI']." AND Password='$anterior' LIMIT 1";		
		   $data = $db->getObject($sql);
		   if($data){				
		   		$nueva=$_POST['nueva'];	
				$nueva2=$_POST['nueva2'];
				$error=validatePwd($id, $nueva, $nueva2, $type);//type= SP si es serv publico y USER si es del otro tipo	
				if($error==''){
					$nueva=encrypt($nueva);
					if($_SESSION['PRO']=='#SP'){
						$db->execute("UPDATE servpub SET Password='$nueva' WHERE ID_Serv=".$_SESSION['UI']." LIMIT 1");
					}else
						$db->execute("UPDATE users SET Password='$nueva' WHERE ID_User=".$_SESSION['UI']." LIMIT 1 ");												
				}else
				 	echo $error;
			}else{
				echo "El password anterior es incorrecto";
			}

		}
	}

?>