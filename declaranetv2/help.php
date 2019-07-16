<?php    
    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn(); 
    $context->title = "Preguntas frecuentes";
	if(!$action){
		$context->allow = getAccess();
		$context->menu = setMenu();
		$sql = "SELECT * FROM faqs";
		$context->data = $db->getArray($sql);
		
                RenderTemplate('templates/help.tpl.php', $context, 'templates/base.php');
		
	
	}
	
	
?>