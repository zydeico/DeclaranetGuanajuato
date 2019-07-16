<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');
    require_once('../lib/ext.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $year = $_GET['year'];
    $sql = "select ID_Verificacion, v.ID_Serv, RFC, CONCAT_WS(' ', sp.Paterno, sp.Materno, sp.Nombre) as Nombre, 
            Dependencia, IFNULL(CONCAT_WS(' ', u.Nombre, u.Paterno), 'Sin asignación') as Responsable, 
            Fecha_Inclusion, General, Fecha_Cierre, 
            GROUP_CONCAT(DISTINCT(CONCAT_WS('|', Tipo_Depend, Nombre_Depend))) as Depend, 
            GROUP_CONCAT(DISTINCT(CONCAT_WS('|', in1.Tipo_In, in1.Ciudad_In))) as Propios,  
            GROUP_CONCAT(DISTINCT(CONCAT_WS('|', in2.Tipo_In,in2.Ciudad_In))) as Otros  
            from verificacion v 
            join servpub sp on sp.ID_Serv = v.ID_Serv 
            join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
            left join ddependientes dep on dep.ID_Serv = sp.ID_Serv and dep.Estatus = 1 
            left join dinmuebles in1 on in1.ID_Serv = sp.ID_Serv and in1.Titular_In is null and in1.Estatus = 1 
            left join dinmuebles in2 on in2.ID_Serv = sp.ID_Serv and in2.Titular_In is not null and in2.Estatus = 1 
            left join users u on u.ID_User = v.ID_Resp 
            where General >= 0 and YEAR(Fecha_Inclusion) = " . ($year?$year:Date('Y')) . "
            group by sp.ID_Serv 
            order by Fecha_Inclusion DESC";
    $db->execute("SET SESSION group_concat_max_len = 1000000;");
    $data = $db->getArray($sql);
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
   
    $cont = 1;
    foreach($data as $d){
        $depend = explode(",", $d['Depend']);
        $own = explode(",", $d['Propios']);
        $other = explode(",", $d['Otros']);
        print  "<row id = '" . $d['ID_Verificacion'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        if(in_array(51, $_SESSION['PM'])){
            print  "<cell type = 'img'>img/delete.png^Eliminar^javascript:Del(" . $d["ID_Verificacion"] . ")^_self</cell>";
            print  "<cell type = 'img'>img/edit.png^Cambiar asignación^javascript:Change(" . $d["ID_Verificacion"] . ")^_self</cell>";
        }
        print  "<cell>" . $d['Fecha_Inclusion'] . "</cell>";
        print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Nombre']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Dependencia']) . "</cell>";
        print  "<cell>"; 
        if($depend[0]){
            foreach($depend as $dep)
                print reset(explode("|", $dep)) . ": " . showVar(end(explode("|", $dep))) . ", ";
        }
        print "</cell>";
        print  "<cell>"; 
        if($own[0]){
            foreach($own as $o)
                print reset(explode("|", $o)) . ": " . showVar(end(explode("|", $o))) . ", ";
        }
        print "</cell>";
        print  "<cell>"; 
        if($other[0]){
            foreach($other as $o)
                print reset(explode("|", $o)) . ": " . showVar(end(explode("|", $o))) . ", ";
        }
        print "</cell>";
        print  "<cell>" . htmlspecialchars($d['Responsable']) . "</cell>";
        print "<cell type = 'img'>img/view.gif^Detalles^javascript:View(" . $d["ID_Serv"] . ")^_self</cell>";
        switch($d['General']){
            case "0": 
               print "<cell type = 'img'>img/traffic-gray.png^Sin asignación^javascript:Verify(" . $d['ID_Verificacion'] . "," . $d["ID_Serv"] . ")^_self</cell>";
            break;
            case "1": 
               print "<cell type = 'img'>img/traffic-green.png^Correcto^javascript:Verify(" . $d['ID_Verificacion'] . "," . $d["ID_Serv"] . ")^_self</cell>";
            break;
            case "2":    
               print "<cell type = 'img'>img/traffic-orange.png^Observaciones^javascript:Verify(" . $d['ID_Verificacion'] . "," . $d["ID_Serv"] . ")^_self</cell>";
            break;
        }
        if($d['Fecha_Cierre'])
            print "<cell type = 'img'>img/ok.png^" . $d['Fecha_Cierre'] . "^javascript:Closed(" . $d['ID_Verificacion'] . ")^_self</cell>";
        else
            print "<cell></cell>";
        print  "</row>";
    }
    print  "</rows>";
?>
