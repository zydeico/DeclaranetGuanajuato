<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $d1 = $_GET['d1'];
    $d2 = $_GET['d2'];
    $dep = $_GET['dep'];
    $mov = $_GET['mov'];
    
    $sql = "select DISTINCT(ID_Mov), Movimiento, Tipo_Reg, Fecha_Mov, RFC, 
            CASE Tipo_Mov 
            when 1 then sp.Fecha_Inicio
            when 2 then sp.Fecha_Inicio
            when 4 then m.Inicio
            END as Inicio, 
            CASE Tipo_Mov 
            when 2 then sp.Fecha_Termino
            when 4 then m.Termino
            END as Termino, 
            CONCAT_WS(' ', sp.Paterno, sp.Materno, sp.Nombre) as Nombre, Dependencia, Puesto, Area,
            CONCAT_WS(' ', u.Nombre, u.Paterno) as User 
            from movimientos m 
            join tipo_mov t on t.ID_Tipo = m.Tipo_Mov
            join servpub sp on sp.ID_Serv = m.ID_Serv 
            join dependencias d on d.ID_Dependencia = sp.ID_Dependencia
            join puestos p on p.ID_Puesto = sp.ID_Puesto 
            join users u on u.ID_User = m.ID_User 
            where Fecha_Mov BETWEEN '" . $d1 . "' and '" . $d2 . "'";
    if($dep)
        $sql .= " and sp.ID_Dependencia = " . $dep; 
    if($mov)
        $sql .= " and Tipo_Mov = " . $mov;
    $sql .= " order by Fecha_Mov";
    
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
   
    $cont = 1;
    foreach($data as $d){
        print  "<row id = '" . $d['ID_Mov'] . "'>";
        print  "<cell>" . $cont++ . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Movimiento']) . "</cell>";
        print  "<cell>" . htmlspecialchars($d['Tipo_Reg']) . "</cell>";
        print  "<cell>" . $d['Fecha_Mov'] . "</cell>";
        print  "<cell>" . $d['Inicio'] . "</cell>";
        print  "<cell>" . $d['Termino'] . "</cell>";
        print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
        print  "<cell>" . htmlspecialchars(($d['Nombre'])) . "</cell>";
        print  "<cell>" . htmlspecialchars(($d['Dependencia'])) . "</cell>";
        print  "<cell>" . htmlspecialchars(($d['Area'])) . "</cell>";
        print  "<cell>" . htmlspecialchars(($d['Puesto'])) . "</cell>";
        print  "<cell>" . htmlspecialchars(($d['User'])) . "</cell>";
        print  "</row>";
    }
    print  "</rows>";
?>
