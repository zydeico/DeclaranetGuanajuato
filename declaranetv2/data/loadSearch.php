<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

//    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
//        header("Content-type: application/xhtml+xml"); 
//    else
//        header("Content-type: text/xml");
//    
    
    $db = new DBConn();
    
    $balance = $_POST['balance'];
    $rfc = strtoupper($_POST['rfc']);
    $name = strtoupper($_POST['name']);
    $dep = $_POST['dep'];
    $pos = $_POST['pos'];
    $begin1 = $_POST['begin1'];
    $begin2 = $_POST['begin2'];
    $end1 = $_POST['end2'];
    $end2 = $_POST['end2'];
    $estatus = $_POST['estatus'];
    
    $concat ="(";
    foreach($estatus as $e)
        $concat .= $e . ",";
    $concat = substr($concat, 0, -1) . ")";
    
    $sql = "select sp.ID_Serv, RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, 
            Dependencia, Puesto, 
            CASE sp.Estatus
            when 1 then 'Activo'
            when 2 then 'Baja'
            when 3 then 'Promocionado'
            when 4 then 'Licencia'
            END as Est 
            from servpub sp 
            join dependencias d on d.ID_Dependencia = sp.ID_Dependencia
            join puestos p on p.ID_Puesto = sp.ID_Puesto 
            join declaraciones dc on dc.ID_Serv = sp.ID_Serv 
            where sp.Estatus in " . $concat;
    if($balance)
        $sql .= " and (dc.Balanza < 0 OR dc.Balanza_Conyuge < 0 OR dc.Balanza_Depend < 0)";
    if($rfc)
        $sql .= " and sp.RFC like '%" . $rfc . "%'";
    if($name){
        $terms = explode(" ", trim($name));
        $sql .= " and (";
        foreach($terms as $t)
            $sql .= "sp.Paterno like '%" . $t . "%' or ";
        foreach($terms as $t)
            $sql .= "sp.Materno like '%" . $t . "%' or ";
        foreach($terms as $t)
            $sql .= "sp.Nombre like '%" . $t . "%' or ";
        $sql = substr($sql, 0, -4) . ")";
    }
    if($dep)
        $sql .= " and sp.ID_Dependencia = " . $dep; 
    if($pos)
        $sql .= " and sp.ID_Puesto = " . $pos;
    if($begin1 && $begin2)
        $sql .= " and (Fecha_Inicio between '" . $begin1 . "' and '". $begin2 . "')";
    if($end1 && $end2)
        $sql .= " and (Fecha_Termino between '" . $end1 . "' and '" . $end2 . "')";
    $sql .= " order by Nombre, ID_Serv";
    $data = $db->getArray($sql);
    
    $sql = "select DISTINCT(ID_Serv) from verificacion where General >= 0 and (Fecha_Cierre is null or Fecha_Cierre = '')";
    $search = $db->getArray($sql);
    $verif = array();
    foreach($search as $s)
        $verif[] = $s['ID_Serv'];

    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $temp = "";
    $cont = 1;
    foreach($data as $d){
        if($temp != $d['ID_Serv']){
            $temp = $d['ID_Serv'];
            print  "<row id = '" . $d['ID_Serv'] . "'>";
            print  "<cell>" . $cont++ . "</cell>";
            if(in_array($d['ID_Serv'], $verif))
                print  "<cell type = 'ro'></cell>";
            else
                print  "<cell>OK</cell>";
            print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Nombre']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Dependencia']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Puesto']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Est']) . "</cell>";
            print  "<cell type = 'img'>img/view.gif^Detalles^javascript:View(" . $d["ID_Serv"] . ")^_self</cell>";
            print  "</row>";
        }
    }
    print  "</rows>";
?>
