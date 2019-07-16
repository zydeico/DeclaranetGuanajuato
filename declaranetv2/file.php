<?php
    include("lib/class.downloadfile.php");
    require_once('lib/secure.php');	
    require_once ('lib/ext.php');	
    include_once("lib/class.downloadfile.php");
	//echo hideVar('temporal/1_Acuse.pdf');
	//die();
	//774a946c659646a078402a4c90847709
    $nombre = showVar($_GET['id']);
    $nombreDescarga=explode("/",$nombre);
    $nombreDescarga=$nombreDescarga[count($nombreDescarga)-1];
    //$idBit=substr($id,0,-4);

    $domain = GetHostByName($REMOTE_ADDR); 

    $extension=substr($nombre,-4);

   #Al llegar aqui es necesario revisar q el usuario q esta descargando el archivo en verdad tenga permisos para eso.
	
   if (strtoupper($extension)=='.PDF') 
       $file_type = "application/pdf";  
   else if(strtoupper($extension)=='.ZIP') 
       $file_type = "application/x-zip-compressed"; 
   else
       $file_type = "application";
	    		
    $downloadfile = new DOWNLOADFILE("$nombre");
    $downloadfile->file_name=$nombreDescarga;
    $downloadfile->df_contenttype= $file_type;
    //$downloadfile = new DOWNLOADFILE("",$file_type,'attachment', "$id");	
    if (!$downloadfile->df_download()) echo "Error";
?>
