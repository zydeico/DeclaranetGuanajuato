<?php

    require_once ('lib/secure.php');
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    require_once ('lib/ExcelReader/reader.php');
    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn(); 
    $context->title = "Alta de servidores públicos";
    
    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu(); 
        $sql = "select * from dependencias where " . ($_SESSION['TP']=="GLOBAL"?"Activo = 1":"ID_Dependencia = " . $_SESSION['DEP']) . " order by Dependencia";
        $context->dep = $db->getArray($sql);
        $sql = "select * from fracciones where Activo = 1 order by ID_Fraccion";
        $context->fracc = $db->getArray($sql);
        $sql = "select * from puestos where Activo = 1 order by Puesto";
        $context->pos = $db->getArray($sql);
        $context->functions = array();
        $context->selection = array();
        
        if(!empty($_POST)){
            $dep = $_POST['auto-dep'];
            $pos = $_POST['auto-pos'];
            $fracc = $_POST['auto-fracc'];
            $fn = $_POST['auto-fn'];
            
            $context->autodep = $dep;
            $context->autopos = $pos;
            $context->selection = $fracc;
            $context->functions = $fn;
            
            $tempFile = $_FILES['template']['tmp_name'];
            $file_name = $_FILES['template']['name'];
            $ext = explode(".", $file_name);
            if($ext[count($ext)-1] == 'xls'){
            	$targetFile = "uploaded/plantillas/" . Date('Ymd') . "_" . quitarAcentos($_SESSION['NM'], true) . "_plantilla.xls";
                if (move_uploaded_file($tempFile,$targetFile)){
                    $data = new Spreadsheet_Excel_Reader();
                    $data->setOutputEncoding('CP1251');
                    $data->read($targetFile);
                    $celdas = $data->sheets[0]['cells'];
                    
                    $str = "";
                    foreach($fracc as $f)
                        $str .= $f . "|";
                    if(!$pos){
                        $sql = "select Puesto from puestos where Activo = 1 order by Puesto";
                        $puestos = $db->getArray($sql);
                        foreach($puestos as $p)
                            $comp[] = $p;
                    }
                    $i = 3;
                    $error = array();
                    $AG_val = array("SI", "NO", "Si", "No", "si", "no");
                    $contra_val = array("HONORARIOS", "BASE", "Honorarios", "Base", "honorarios", "base");
                    $all = array();
                    while($celdas[$i][1]!=''){
//                        var_export($celdas[$i]);
                        $rfc = trim($celdas[$i][1]);
                        $name =  trim($celdas[$i][2]);
                        $patern =  trim($celdas[$i][3]);
                        $matern =  trim($celdas[$i][4]);
                        $func =  trim($celdas[$i][5]);
                        $day =  trim($celdas[$i][6]);
                        $month =  trim($celdas[$i][7]);
                        $year =  trim($celdas[$i][8]);
                        $contra =  trim($celdas[$i][9]);
                        $art =  trim($celdas[$i][10]);
                        $area =  trim($celdas[$i][11]);
                        $level =  trim($celdas[$i][12]);
                        $percep =  trim($celdas[$i][13]);
                        $phone =  trim($celdas[$i][14]);
                        $calle =  trim($celdas[$i][15]);
                        $num =  trim($celdas[$i][16]);
                        $col =  trim($celdas[$i][17]);
                        $CP =  trim($celdas[$i][18]);
                        $city =  trim($celdas[$i][19]);
                        
                        if(!$rfc || !$name || !$patern || !$matern)
                            $error[$i] = "Faltan datos personales del servidor como RFC, nombre o apellidos";
                        elseif(in_array($rfc, $all))
                            $error[$i] = "Este RFC se encuentra repetido en la plantilla. Favor de revisar";
                        elseif(ValidateRFC($rfc) || strlen($rfc) != 10)
                            $error[$i] = "Error en el RFC, verifique su contenido (10 caracteres forzoso)";
                        elseif(!$nomin && !$pos)
                            $error[$i] = "Debe incluir un cargo nominal si no fue seleccionado en los campos opcionales";
                        elseif(!$pos && !in_array($nomin, $comp))
                            $error[$i] = "El cargo nominal seleccionado no se reconoce del catálogo permitido";
                        elseif(!$func || !$contra || !$art || !$area || !$level || !$phone)
                            $error[$i] = "Faltan datos como Cargo Funcional, Contratación, AG 172, Area, Nivel o Teléfono";
                        elseif(!is_numeric($day) || !is_numeric($month) || !is_numeric($year) || strlen($day) != 2 || strlen($month) != 2 || strlen($year) != 4)
                            $error[$i] = "La fecha de posesión es incorrecta o esta incompleta (" . $day . "/" . $month . "/" . $year . ")";
                        elseif(strtotime($year . "-" . $month . "-" . $day) > strtotime(Date('Y-m-d')))
                            $error[$i] = "La fecha de posesión debe ser menor o igual a la actual";
                        elseif(strtotime($year . "-" . $month . "-" . $day) < strtotime("2015-01-01"))
                            $eror[$i] = "Por el momento solo se permiten ALTAS de nuevo ingreso";
                        elseif(!in_array($contra, $contra_val))
                            $error[$i] = "El valor de CONTRATACIÓN es inválido. (Permitidos: HONORARIOS, BASE)";
                        elseif(!in_array($art, $AG_val))
                            $error[$i] = "El valor de AG 172 es inválido. (Permitidos: SI, NO)";
                        elseif(!is_numeric($level))
                            $error[$i] = "El valor de Nivel Tabular debe ser numérico";
                        elseif(!$phone || !$calle || !$num || !$col || !$CP || !$city)
                            $error[$i] = "Falta información sobre el lugar de trabajo";
                        elseif($db->queryStored("findServ", array($rfc, $dep), 'ARRAY'))
                            $error[$i] = "Ya existe una persona con este RFC en la misma dependencia. Favor de revisar";
                        $all[] = $rfc;
                        $i++;
                    }
                   
                    if(!$error){
                        $i = 3;
                        while($celdas[$i][1]!=''){
                            $param = array();
                            $id = $db->getID("ID_Serv", "servpub");
                            $param[] = $id;
                            $param[] = utf8_encode(Upper($celdas[$i][2])); // Nombre
                            $param[] = utf8_encode(Upper($celdas[$i][3])); // Paterno
                            $param[] = utf8_encode(Upper($celdas[$i][4])); // Materno
                            $param[] = Upper($celdas[$i][1]); // RFC
                            $param[] = $dep; // Dependencia
                            $param[] = $pos; // Nominal
                            $param[] = utf8_encode($celdas[$i][5]); // funcional
                            $param[] = utf8_encode($celdas[$i][9]); // Contratacion
                            $param[] = $str; // Fracciones
                            $param[] = utf8_encode(Upper($celdas[$i][10])); // AG 172
                            $param[] = utf8_encode(Upper($celdas[$i][11])); // Area
                            $param[] = utf8_encode($celdas[$i][12]); // Nivel
                            $param[] = utf8_encode($celdas[$i][14]); // Telefono
                            $param[] = str_replace(",", "", $celdas[$i][13]); // Percepcion
                            $param[] = utf8_encode($celdas[$i][15]); // Calle trabajo
                            $param[] = utf8_encode($celdas[$i][16]); // Num trabajo
                            $param[] = utf8_encode($celdas[$i][17]); // Colonia trabajo
                            $param[] = utf8_encode($celdas[$i][18]); // CP trabajo
                            $param[] = utf8_encode($celdas[$i][19]); // Ciudad trabajo
                            $date = $celdas[$i][8] . "-" . $celdas[$i][7] . "-" . $celdas[$i][6]; // Fecha
                            $param[] = $date;
                            $param[] = utf8_encode($celdas[$i][20]); // Correo
                            $param[] = Encrypt(Upper($celdas[$i][1])); // Pwd
                            $info = array();
                            $info[] = $db->getID("ID_Info", "infoserv");
                            $info[] = $id;
                            $info[] = utf8_encode($celdas[$i][21]); // Calle
                            $info[] = utf8_encode($celdas[$i][22]); // Numero
                            $info[] = utf8_encode($celdas[$i][23]); // Colonia
                            $info[] = ""; // Ciudad
                            $info[] = utf8_encode($celdas[$i][24]); // CP
                            $info[] = utf8_encode($celdas[$i][25]); // Tel
                            $info[] = utf8_encode($celdas[$i][26]); // Civil
                            $info[] = utf8_encode($celdas[$i][27]); // CURP
                            
                            $db->queryStored("NewServ", $param);
                            $db->queryStored("NewInfo", $info);
                            $db->queryStored("registerMov", array($id, 1, null, null, null, $date, null, null, $_SESSION['UI']));
                            foreach($fn as $f)
                                $db->queryStored("setFunction", array($id, $f));
                            $i++;
                        }
                        $context->msg = "Se han importado exitosamente " . ($i - 3) . " registros desde su archivo";
                    }else{
                        $context->msg = "Se han encontrado " . count($error) . " error(es). Favor de corregirlos para continuar";
                        $context->error = $error;
                    }
                }else
                    $context->msg = "Ha ocurrido un error al cargar su archivo, por favor intente de nuevo";
                
            }else
                $context->msg = "La extensión del archivo seleccionado es inválida, (Permitida: .xls). Si persiste el problema descargue nuevamente la plantilla y carguela con los datos correspondientes";
            
        }
        
        RenderTemplate('templates/register.tpl.php', $context, 'templates/base.php');
    }elseif($action == "add"){
        $sql = "select * from estados order by Estado";
        $context->estate = $db->getArray($sql);
        RenderTemplate('templates/register.add.php', $context);
        
    }elseif($action == "save"){
        $dep = $_POST['dep'];
        $pos = $_POST['pos'];
        $func = $_POST['funcional'];
        $contra = $_POST['contra'];
        $art = $_POST['art'];
        $level = $_POST['level'];
        $area = $_POST['area'];
        $tel_work = $_POST['tel_work'];
        $calle_work = $_POST['calle_work'];
        $num_work = $_POST['num_work'];
        $col_work = $_POST['col_work'];
        $CP_work = $_POST['CP_work'];
        $city_work = $_POST['city_work'];
        $fn = $_POST['fn'];
        $fracc = $_POST['fracc'];
        $str = "";
        foreach($_POST['fracc'] as $f)
            $str .= $f . "|";
        
        for($i=0; $i<count($_POST['rfc']); $i++){
            $param = array();
            $id = $db->getID("ID_Serv", "servpub");
            $param[] = $id;
            $param[] = Upper($_POST['name'][$i]);
            $param[] = Upper($_POST['patern'][$i]);
            $param[] = Upper($_POST['matern'][$i]);
            $param[] = Upper($_POST['rfc'][$i]);
            $param[] = $dep;
            $param[] = $pos;
            $param[] = $func;
            $param[] = $contra;
            $param[] = $str;
            $param[] = $art;
            $param[] = Upper($area);
            $param[] = $level;
            $param[] = $tel_work;
            $param[] = str_replace(",", "", $_POST['percep'][$i]);
            $param[] = $calle_work;
            $param[] = $num_work;
            $param[] = $col_work;
            $param[] = $CP_work;
            $param[] = $city_work;
            $param[] = $_POST['date'][$i];
            $param[] = $_POST['mail'][$i];
            $param[] = Encrypt(Upper($_POST['rfc'][$i]));
            
            $info = array();
            $info[] = $db->getID("ID_Info", "infoserv");
            $info[] = $id;
            $info[] = $_POST['street'][$i];
            $info[] = $_POST['num'][$i];
            $info[] = $_POST['col'][$i];
            $info[] = $_POST['city'][$i];
            $info[] = $_POST['CP'][$i];
            $info[] = $_POST['tel'][$i];
            $info[] = $_POST['civil'][$i];
            $info[] = $_POST['curp'][$i];
            
            $db->queryStored("NewServ", $param);
            $db->queryStored("NewInfo", $info);
            $db->queryStored("registerMov", array($id, 1, null, null, null, $_POST['date'][$i], null, null, $_SESSION['UI']));
            foreach($fn as $f)
                $db->queryStored("setFunction", array($id, $f));
        }
        
        
    }elseif($action == "check"){
        $date = strtotime($_POST['date']);
        $limit = strtotime("2015-01-01");
        if($date >= $limit){
            $error1 = ValidateRFC($_POST['RFC']);
            if(!$error1){
                if($_POST['pwd'])
                    $error2 = validatePwd("", $_POST['pwd'], $_POST['pwd'], "SP");
                if(!$error2){
                    if($_POST['mail'])
                        $error3 = ValidateMail($_POST['mail']);
                    if(!$error3){
                        if($_POST['curp'])
                            $error4 = validateCURP($_POST['curp']);
                        if(!$error4){
                            if($db->queryStored("findServ", array($_POST['RFC'], $_GET['dep']), 'ARRAY'))
                                echo "Ya existe una persona con este RFC en la misma dependencia. Favor de revisar";
                        }else
                            echo $error4;
                    }else
                        echo $error3;
                }else
                    echo $error2;
            }else
                echo $error1;
        }else
            echo "Por el momento solo se permiten ALTAS de nuevo ingreso";
    }
?>
