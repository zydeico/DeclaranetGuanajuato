<?php

    require_once('../lib/secure.php');
    require_once('../lib/ext.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $rfc = $_GET['rfc'];
    $dep = $_GET['dep'];
    $est = $_GET['st'];
    $bnd=0;
    
    $sql = "select DISTINCT(sp.ID_Serv), CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, RFC, Dependencia, Puesto, case dp.Estatus when 0 then 'Por validar' when 1 then 'Validada' when 2 then 'Rechazada' end as Estatus 
            from servpub sp 
            join declaraciones d on d.ID_Serv = sp.ID_Serv
            join dependencias dep on dep.ID_Dependencia = sp.ID_Dependencia
            join puestos p on p.ID_Puesto = sp.ID_Puesto
            inner join acuerdo_dec_pub dp on dp.ID_Serv = sp.ID_Serv 
            Where 0=0 "; 
    
    if($est==0){
    $sql .= " and dp.Estatus = 0"; $bnd=1;} else
    { $sql .= " and dp.Estatus = " . $est; $bnd=1;} 
    
    if($rfc){
    $sql .= " and RFC like '%" . $rfc . "%'"; $bnd=1;}
    if($dep){
    $sql .= " and sp.ID_Dependencia = " . $dep; $bnd=1;}
    
    if($bnd==0)
        $w=" and dp.Estatus = 0 ";
    else
        $w="";
        
    $sql .= $w. " group by sp.ID_Serv, CONCAT_WS(' ', Paterno, Materno, Nombre), RFC, Dependencia, Puesto 
             order by Nombre";


    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
   
    $cont = 1;
    foreach($data as $d){
        
        print  "<row id = '" . $d['ID_Serv'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Nombre']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Dependencia']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Puesto']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Estatus']) . "</cell>";
        print  "<cell type = 'img'>img/view.gif^Acuerdos^javascript:ver(" . $d["ID_Serv"] . ")^_self</cell>";
        print  "</row>";
    }
    print  "</rows>";
?>
