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
    $rfc = $_GET['rfc'];
    
   $sql = "select RFC, CONCAT_WS(' ', s.Nombre, s.Paterno, s.Materno) as Nombre, YEAR(Fecha_Dec) as Anio, Tipo_Dec, 
            CONCAT_WS(' ', u.Nombre, u.Paterno, u.Materno) as Responsable, Tipo_Elem, 
            CASE General 
            when 0 then 'Sin asignar'
            when 1 then 'Correcto' 
            when 2 then 'Observaciones'
            END as Estatus, 
            CASE Tipo_Elem 
            when 'inmuebles' then 
            CONCAT_WS('|', i.Tipo_In, Calle_In, Numero_In, Ciudad_In)
            when 'vehiculos' then 
            CONCAT_WS('|', v.Tipo_Veh, Marca_Veh, Modelo_Veh, Anio_Veh)
            when 'dependientes' then 
            CONCAT_WS('|', Tipo_Depend, Nombre_Depend)
            when 'adeudos' then 
            CONCAT_WS('|', Tipo_Ad, Institucion_Ad, Cuenta_Ad)
            when 'inversiones' then 
            CONCAT_WS('|', Tipo_Inv, Institucion_Inv, Cuenta_Inv)
            when 'muebles' then 
            CONCAT_WS('|', Tipo_Mue, Descripcion_Mue)
            when 'ingresos' then 
            CONCAT_WS('|', ti.Tipo, Concepto_Ing, Importe_Ing)
            END as Elemento, 
            seg.Verificacion, seg.Observaciones, seg.Fecha_Seg 
            from verificacion ver 
            join seguimiento seg on seg.ID_Verificacion = ver.ID_Verificacion 
            join servpub s on s.ID_Serv = ver.ID_Serv 
            join users u on u.ID_User = ver.ID_Resp 
            join dtransacciones t on t.ID_Trans = seg.ID_Trans 
            join declaraciones d on d.ID_Dec = t.ID_Dec 
            left join dinmuebles i on i.ID_Inmueble = t.ID_Elem 
            left join dvehiculos v on v.ID_Vehiculo = t.ID_Elem
            left join ddependientes dep on dep.ID_Depend = t.ID_Elem
            left join dadeudos ad on ad.ID_Adeudo = t.ID_Elem
            left join dinversiones inv on inv.ID_Inversion = t.ID_Elem
            left join dmuebles mue on mue.ID_Mueble = t.ID_Elem
            left join dingresos ing on ing.ID_Ingreso = t.ID_Elem
            left join tipo_ingresos ti on ti.ID_Tipo = ing.Tipo_Ing 
            where YEAR(Fecha_Inclusion) = " . $year . ($rfc?" and RFC like '" . $rfc . "%' and s.Estatus in (1, 4)":"") . " 
            order by RFC, Fecha_Dec ";
    $db->execute("SET SESSION group_concat_max_len = 1000000;");
    $data = $db->getArray($sql);
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
   
    $cont = 1;
    foreach($data as $d){
        $exp = explode("|", $d['Elemento']);
        $elem = $exp[0];
        for($i=1; $i<count($exp); $i++){
            $elem .= ", " . showVar($exp[$i]);
        }
        print  "<row id = '" . $cont . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell>" . $d['RFC'] . "</cell>";
        print  "<cell>" . $d['Nombre'] . "</cell>";
        print  "<cell>" . $d['Tipo_Dec'] . " " . $d['Anio'] . "</cell>";
        print  "<cell>" . $d['Responsable'] . "</cell>";
        print  "<cell>" . $d['Estatus'] . "</cell>";
        print  "<cell>" . Upper($d['Tipo_Elem']) . ": " . $elem . "</cell>";
        print  "<cell>" . $d['Verificacion'] . "</cell>";
        print  "<cell>" . $d['Observaciones'] . "</cell>";
        print  "<cell>" . $d['Fecha_Seg'] . "</cell>";
        print  "</row>";
    }
    print  "</rows>";
?>
