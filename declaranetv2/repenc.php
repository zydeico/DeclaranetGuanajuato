<?php

    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Reporte de encuestas";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select * from dependencias where Activo = 1 " . ($_SESSION['TP']=="GLOBAL"?" order by Dependencia":" and ID_Dependencia = " . $_SESSION['DEP']);
        $context->dep = $db->getArray($sql);
        $sql = "select IFNULL(MIN(YEAR(Fecha_Dec)), YEAR(NOW())) from declaraciones";
        $context->min = $db->getOne($sql);
        RenderTemplate('templates/repenc.tpl.php', $context, 'templates/base.php');
    
        
    }elseif($action == "load"){
        $dec = $_GET['dec'];
        $dep = $_GET['dep'];
        $year = $_GET['year'];
        
        $sql = "select * from reactivos where Activo = 1";
        $reactivos = $db->getArray($sql);
        
        foreach($reactivos as $r){
            if($r['Opciones'])
                $data[$r['ID_Reactivo']] = array();
            else
                $open[$r['ID_Reactivo']] = "";
        }
        
        $sql = "select DISTINCT(ID_Encuesta), Respuesta from encuestas e 
                join declaraciones d on d.ID_Dec = e.ID_Declaracion 
                join servpub sp on sp.ID_Serv = d.ID_Serv 
                where YEAR(Fecha_Dec) = " . $year; 
        if($dec)
            $sql .= " and Tipo_Dec = '" . $dec . "'";
        if($dep)
            $sql .= " and ID_Dependencia = " . $dep;
        
        $resp = $db->getArray($sql);
                
        foreach($resp as $r){
            $exp = explode("|", $r['Respuesta']);
            foreach($exp as $e){
                $x = explode("-", $e);
                if(array_key_exists($x[0], $data)){
                    if($data[$x[0]][$x[1]])
                        $data[$x[0]][$x[1]] += 1;
                    else
                        $data[$x[0]][$x[1]] = 1;
                }elseif(array_key_exists($x[0], $open)){
                     $open[$x[0]] = $open[$x[0]] . "|" . $x[1];
                }
            }
        }
        
        foreach($reactivos as $r){
            if($r['Opciones']){
                $json = array();
                foreach($data[$r['ID_Reactivo']] as $k => $v)
                    $json[] = array("Resp" => $k, "Value" => $v);
                $context->data[] = array("ID" => $r['ID_Reactivo'], "NAME" => $r['Reactivo'], "JSON" => json_encode($json));
            }else{
                $context->data[] = array("ID" => $r['ID_Reactivo'], "NAME" => $r['Reactivo'], "DATA" => ($open[$r['ID_Reactivo']]));
            }
        }
        RenderTemplate('templates/repenc.load.php', $context);
    }
        
?>
