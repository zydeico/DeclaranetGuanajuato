<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');
    require_once('../lib/ext.php');
    
    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $dep = $_GET['dep'];
    $year = $_GET['year'];
    $pra = $_GET['pra'];
    
    $sql = "select ID_Proc, RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Dependencia, PRA, Fecha_PRA, Bloqueado,
            CASE Tipo_Proc
            when 1 then 'INCONSISTENCIA'
            when 2 then CONCAT_WS(' ', 'OMISIÓN', Omision)
            END as Tipo, Fecha_Proc, Tipo_Proc
            from procedimientos p 
            join servpub sp on sp.ID_Serv = p.ID_Serv 
            join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
            where p.Activo = 1 ";
    if($dep)
        $sql .= " and sp.ID_Dependencia = " . $dep;
    if($year)
        $sql .= " and YEAR(Fecha_Proc) = " . $year;
    if($pra)
        $sql .= " and PRA is not null";
    $sql .= " order by Fecha_Proc DESC";
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
   
    $cont = 1;
    foreach($data as $d){
       
        print  "<row id = '" . $d['ID_Proc'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell type = 'img'>img/edit.png^Editar^javascript:Edit(" . $d["ID_Proc"] . ")^_self</cell>";
        print  "<cell type = 'img'>img/delete.png^Eliminar^javascript:Del(" . $d["ID_Proc"] . ")^_self</cell>";
        print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Nombre']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Dependencia']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Tipo']) . "</cell>";
        print  "<cell>" . $d['Fecha_Proc'] . "</cell>";
        print  "<cell>" . $d['PRA'] . "</cell>";
        print  "<cell>" . $d['Fecha_PRA'] . "</cell>";
        print  "<cell>" . ($d['Bloqueado']?"SI":"NO") . "</cell>";
        print  "<cell type = 'img'>img/file.png^Documento^javascript:Generate(" . $d["ID_Proc"] . ", " . $d['Tipo_Proc'] . ")^_self</cell>";
        print  "</row>";
        
    }
    print  "</rows>";
    
?>
