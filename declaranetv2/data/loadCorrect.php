<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
    $pending = $_GET['pending'];
    $sql = "select c.ID_Correccion, sp.ID_Serv, sp.RFC, CONCAT_WS(' ',sp.Paterno, sp.Materno, sp.Nombre) as Nombre, 
            Dependencia, CONCAT_WS(' ', u.Nombre, u.Paterno, u.Materno) as User, DATE(c.Fecha_Correccion) as Fecha, 
            CASE c.Estatus 
            when 0 then 'Pendiente'
            when 1 then 'Validada'
            when 2 then 'Rechazada'
            END as Estatus
            from servpub sp 
            join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
            join correcciones c on c.ID_Serv = sp.ID_Serv
            join users u on u.ID_User = c.ID_User where true ";
            if(!in_array(38, $_SESSION['PM']))
                $sql .= " and c.ID_User = " . $_SESSION['UI'];
            if($pending)
                $sql .= " and c.Estatus = 0";
    $sql .= " order by c.Fecha_Correccion DESC";
    $data = $db->getArray($sql);
//    echo $sql;
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    foreach($data as $d){
            print "<row id = '" . $d["ID_Correccion"] . "'>";
            print "<cell>" . $cont++ . "</cell>";		
            print "<cell>" . $d["Fecha"] . "</cell>";		
            print "<cell>" . htmlspecialchars($d["RFC"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Nombre"]) . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Dependencia"]) . "</cell>";	
            print "<cell>" . htmlspecialchars($d["User"]) . "</cell>";	
            print "<cell>" . htmlspecialchars($d["Estatus"]) . "</cell>";	
            print "<cell type = 'img'>img/view.gif^Detalles^javascript:Correct(" . $d["ID_Correccion"] . ")^_self</cell>";
            print "</row>";
    }
    print "</rows>";    
?>
