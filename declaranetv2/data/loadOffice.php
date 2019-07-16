<?php
$addd = "0";
if(isset($_GET['add'])){
	$addd = "1";
	}
    require_once('../lib/DBConn.php');
    require_once('../lib/secure.php');
    

    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml"))
        header("Content-type: application/xhtml+xml"); 
    else
        header("Content-type: text/xml");
    
    $db = new DBConn();
	
	if($addd == "1"){
		$sql = "select oficios.ID_Oficio, dependencias.Dependencia, DATE_FORMAT(Fecha_Turno, '%Y-%m-%d') as Fecha_Turno, oficios.Instruccion, users.ID_User, oficios.Expediente, concat(users.Nombre, ' ', users.Paterno) as Nombre, REPLACE(REPLACE(REPLACE(oficios.Estatus, '1', 'Pendiente') , '2', 'En Tramite') , '3', 'Atendido') as Estatus from oficios, dependencias, users where oficios.ID_Dependencia = dependencias.ID_Dependencia and users.ID_User = ID_Responsable";
		}else{
			$sql = "select oficios.ID_Oficio, dependencias.Dependencia, DATE_FORMAT(Fecha_Turno, '%Y-%m-%d') as Fecha_Turno, oficios.Instruccion, users.ID_User, oficios.Expediente, concat(users.Nombre, ' ', users.Paterno) as Nombre, REPLACE(REPLACE(REPLACE(oficios.Estatus, '1', 'Pendiente') , '2', 'En Tramite') , '3', 'Atendido') as Estatus from oficios, dependencias, users where oficios.ID_Dependencia = dependencias.ID_Dependencia and users.ID_User = ID_Responsable and users.ID_User = ".$_SESSION['UI'];
			}
			
			//echo $sql;
    
	//print_r($_SESSION);
    $data = $db->getArray($sql);
    
    print  "<?xml version='1.0' encoding='UTF-8'?>\n";
    print  "<rows pos='0'>";
    $cont = 1;
    foreach($data as $d){
		
		
            print "<row id = '" . $d["ID_Oficio"] . "'>";
			print "<cell>" . $cont++ . "</cell>";	
			if($addd == 1){
					print "<cell type = 'img'>img/edit.png^Editar^javascript:Edit(" . $d["ID_Oficio"] . ")^_self</cell>";
					print "<cell type = 'img'>img/delete.png^Borrar^javascript:Borrar(" . $d["ID_Oficio"] . ")^_self</cell>";
				} 
			
            	
            print "<cell>" . htmlspecialchars($d["Expediente"]) . "</cell>";	
            print "<cell>" . htmlspecialchars($d["Dependencia"]) . "</cell>";		
            print "<cell>" . $d["Fecha_Turno"] . "</cell>";		
            print "<cell>" . htmlspecialchars($d["Instruccion"]) . "</cell>";		
			print "<cell>" . $d["Nombre"] . "</cell>";	
			print "<cell>" . $d["Estatus"] . "</cell>";	
			if($addd == 0){
					print "<cell type = 'img'>img/edit.png^Editar^javascript:Edit_user(" . $d["ID_Oficio"] . ")^_self</cell>";
				} 
			
            print "</row>";
    }
    print "</rows>";    
?>
