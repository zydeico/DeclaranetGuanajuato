<?php

    require_once('../lib/secure.php');
    require_once('../lib/DBConn.php');
    require_once('../lib/ext.php');
    
    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    
    $db = new DBConn();
    $dec = $_GET['dec'];
    $dep = $_GET['dep'];
    
    $sql = "select ID_Serv from servpub where Estatus = 4 " . ($dep?"and ID_Dependencia = " . $_GET['dep']:"");
    $data = $db->getArray($sql);
    foreach($data as $d){
        $sql = "select Termino from movimientos where Tipo_Mov = 4 and ID_Serv = " . $d['ID_Serv'] . " order by ID_Mov DESC LIMIT 1";
        $end = $db->getOne($sql);
        if($end){
            $actual = strtotime(Date('Y-m-d'));
            $end = strtotime($end);
            if($actual > $end){
                $sql = "update servpub set Estatus = 1 where ID_Serv = " . $d['ID_Serv'];
                $db->execute($sql);
            }
        }
    }
    
    $sql = "select Valor from parametros where ID_Parametro = 3";
    $days = $db->getOne($sql);
    $sql = "select * from dias_inhabiles order by Fecha";
    $omit = $db->getArray($sql);
    foreach($omit as $o)
        $inhab[] = $o['Fecha'];
    $sql = "select * from fracciones order by ID_Fraccion";
    $fracciones = $db->getArray($sql);
    foreach ($fracciones as $f)
       $fracc[$f['ID_Fraccion']] = $f['Fraccion'];
    
    $sql = "select ID_Serv from procedimientos where Tipo_Proc = 2 and YEAR(Fecha_Proc) = YEAR(NOW()) and Activo = 1 and Omision = '" . $dec . "'";
    $procedure = $db->getArray($sql);
    $proc = array();
    foreach($procedure as $p)
        $proc[] = $p['ID_Serv'];
    
    $data = $db->queryStored("getOmited", array($dec, $dep), 'ARRAY');
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
//    var_export($data);
//    exit;
    $cont = 1;
    foreach($data as $d){
        $continue = false;
        $compare = null;
        $str = "";
        $date = Date('Y-m-d');
        $pro = $d['Fecha_Aut'];
        
        if($dec == "INTERESES"){
            $continue = true;
        }elseif($dec == "ANUAL"){
            if(strtotime($date) > strtotime($pro))
                $continue = true;
        }else{
            if($pro){
                if(strtotime($date) > strtotime($pro))
                    $continue = true;    
            }else{
                $compare = Calculate($d['Fecha'], $days, $inhab);
                if($date >= $compare)
                    $continue = true;
            }
        }
                
        if($continue){
            $sql= "select CONCAT_WS(', ', 
                    CONCAT_WS(', ', Calle, Numero, Colonia), 
                    (select CONCAT_WS(', ', Ciudad, Estado) from ciudades c 
                    join estados e on e.ID_Estado = c.ID_Estado where c.ID_Ciudad = i.ID_Ciudad), 
                    CP ) as Dir 
                    from infoserv i 
                    where ID_Serv = " . $d['ID_Serv'] . " 
                    order by ID_Info DESC LIMIT 1 ";
            $dir = $db->getOne($sql);
            print  "<row id = '" . $d['ID_Serv'] . "'>";
            print  "<cell>" . $cont++ . "</cell>";
            print  "<cell " . (in_array($d['ID_Serv'], $proc)?"type = 'ro'":"") . "></cell>";
            print  "<cell>" . htmlspecialchars($d['RFC']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Nombre']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Dependencia']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Puesto']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Area']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Correo']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Fecha']) . "</cell>";
            print  "<cell>" . htmlspecialchars($d['Fecha_Aut']) . "</cell>";
            if($compare)
                print  "<cell>" . htmlspecialchars($compare) . "</cell>";
            else
                print  "<cell></cell>";
            foreach (explode("|", $d['ART64']) as $e)
                if($e) $str .= $fracc[$e] . ", ";
            print  "<cell>" . $str . "</cell>";
            print  "<cell>" . htmlspecialchars($dir) . "</cell>";
            print  "</row>";
        }
    }
    print  "</rows>";
    
?>
