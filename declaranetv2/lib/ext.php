<?php
    require_once ('phpAES/AES.class.php');
    require_once ('class.phpmailer.php');
    require_once ('DBConn.php');
    
    date_default_timezone_set('America/Mexico_City');
    
    $db = new DBConn();
    
    DEFINE('KEY', ''); // 32 bits
    DEFINE('IV', 'abcdef0987654321'); // 16 bits
    DEFINE('MODE', 'CBC');
    
    $aes = new AES(KEY, MODE, IV);
    
    function hideVar($str){
        global $aes;
        return bin2hex($aes->encrypt($str));
    }
    
    function showVar($str){
        global $aes;
        $hex = new hex2bin();
        return $aes->decrypt($hex->convert($str));
    }
    
    function getParam($id = null){
        global $db;
        $sql = "select * from parametros";
        $config = $db->getArray($sql);
        foreach($config as $c)
            $param[$c['ID_Parametro']] = $c['Valor'];
        return ($id?$param[$id]:$param);
    }
    
    function Upper($str){
        $search = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú");
        $rep = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
        return strtoupper(str_replace($search, $rep, $str));
    }
    
    function concat($array){
        $cad = "(";
        foreach($array as $a)
                $cad .= "'" . $a . "',";
        return substr($cad, 0, -1) . ")";
    }
    
    function setMenu(){
        if($_SESSION['UI']){
            if($_SESSION['PRO'] == "#SP"){
                $menu = array();
                $item = new Menu("Ayuda", "img/help.png");
                $item->addSub("Preguntas frecuentes", "help.php");
                $item->addSub("Descargar manual", "file.php?id=" . hideVar("media/manual.pdf"));
                $menu[] = $item;
                $item = new Menu("Declaración Patrimonial", "img/money.png");
                $item->addSub("Realizar declaración", "declare.php");
                $item->addSub("Mi historial", "history.php");
                $item->addSub("Solicitar prórroga", "prorrogue.php");
                $menu[] = $item;
                $item = new Menu("Captura", "img/form.png");
                $item->addSub("Información personal", "info.php");
                $menu[] = $item;
                $item = new Menu("Contraseña", "img/key.png");
                $item->addSub("Mi contraseña", "change.php");
                $menu[] = $item;
            }else{
                $ignore = array("Chat", "Alertas");
                global $db;
                $sql = "select Acceso from perfiles p 
                        join user_profile pro on pro.ID_Perfil = p.ID_Perfil
                        join users u on u.ID_User = pro.ID_User
                        where u.ID_User = " . $_SESSION['UI'] . " and pro.ID_Perfil = " . $_SESSION['CU'];
                $access = explode("|", $db->getOne($sql));
                $sql = "select DISTINCT(Modulo), Page, Grupo, Image
                        from modulos m 
                        join grupos g on g.ID_Grupo = m.ID_Grupo 
                        join permisos p on p.ID_Modulo = m.ID_Modulo 
                        where ID_Permiso in " . concat($access) . "
                        order by Grupo, m.ID_Modulo";
//                echo $sql;
                $data = $db->getArray($sql);
                $menu = array();
                $temp = "";
                foreach($data as $d){
                    if(!in_array($d['Grupo'], $ignore)){
                        if($temp != $d["Grupo"]){
                            $temp = $d["Grupo"];
                            if($item)
                                $menu[] = $item;
                            $item = new Menu($d["Grupo"], $d["Image"]);
                        }
                        $item->addSub($d["Modulo"], $d["Page"]);
                    }
                }
                if($item)
                    $menu[] = $item;
                $item = new Menu("Contraseña", "img/key.png");
                $item->addSub("Mi contraseña", "change.php");
                $menu[] = $item;
            }
            return $menu;
        }
    }
    
    function getModule(){
        $pos = strrpos($_SERVER['SCRIPT_NAME'], "/");
        $module = substr($_SERVER['SCRIPT_NAME'], $pos + 1, strlen($_SERVER['SCRIPT_NAME']) - $pos);
        return $module;
    }
    
    function getAccess(){
        $pos = strrpos($_SERVER['SCRIPT_NAME'], "/");
        $module = substr($_SERVER['SCRIPT_NAME'], $pos + 1, strlen($_SERVER['SCRIPT_NAME']) - $pos);
        if($_SESSION['PRO'] == "#SP"){
            $allow = array("info.php", "change.php", "declare.php", "help.php", "history.php", "survey.php", "message.php");
            if(!in_array($module, $allow) && strpos($_SERVER['SCRIPT_NAME'], 'index.php') === false)
                Header('location: error.php?code=' . hideVar ('1'));
        }else{
            $extras = array("change.php", "fake.php");
            $sql = "select ID_Permiso from permisos p 
                    join modulos m on m.ID_Modulo = p.ID_Modulo 
                    where Page = '" . $module . "'";
            global $db;
            $data = $db->getArray($sql);
            $sql = "select Acceso from perfiles where ID_Perfil = " . ($_SESSION['CU']?$_SESSION['CU']:"0");
            $perm = explode("|", $db->getOne($sql));
            $allow = array();
            foreach($data as $d){
                if(in_array($d['ID_Permiso'], $perm))
                    $allow = true;
            }
            if(!$allow && $module != "index.php" && !in_array($module, $extras))
                Header('location: error.php?code=' . hideVar ('1'));
            else{
                $_SESSION['PM'] = $perm;
                return $perm;
            }
        }
    }
    
    function setLayout($num){
        switch ($num){
            case 1: return array(1); break;
            case 3: return array(1, 2); break;
            case 4: return array(2, 2); break;
            case 5: return array(2, 2, 1); break;
            case 6: return array(2, 3, 1); break;
            case 7: return array(2, 3, 2); break;
            case 8: return array(3, 3, 2); break;
            case 9: return array(3, 3, 3); break;
            case 10: return array(3, 4, 3); break;
            default: return array(); break;
        }
    }
    
    function setPadding($num){
        switch ($num){
            case 1: return 60; break;
            case 3: return 40; break;
            case 4: return 50; break;
            case 5: return 25; break;
            case 6: return 25; break;
            case 7: return 20; break;
            case 8: return 15; break;
            case 9: return 15; break;
            case 10: return 15; break;
            default: return 0; break;
        }
    }
    
    function ValidateRFC($rfc){
        if(strlen($rfc) == 10 || strlen($rfc) == 13){
            if(ctype_alpha(substr($rfc, 0, 4))){
                if(!is_numeric(substr($rfc, 4, 6)))
                   return "Error en RFC, últimos 6 caracteres deben ser dígitos";
            }else
                return "Error en RFC, primeros 4 caracteres deben ser letras";
        }else
            return "La longitud del RFC es incorrecta";
        
    }
    
    function ValidateMail($mail){
        $first = explode("@", $mail);
        $second = explode(".", $first[1]);
        $array = array(" ", ".", "-", "/", ",", "");
        if(count($second) > 1){
            if(strlen($first[0]) == 0)
                return "Formato de correo incorrecto. Favor de revisar";
            foreach($second as $s){
                if(!ctype_alpha($s))
                    return "Formato de correo incorrecto. Favor de revisar";
            }
        }else
            return "Formato de correo incorrecto. Favor de revisar";
    }
    
    function validatePwd($id, $pwd1, $pwd2, $type){
        if(trim($pwd1) == trim($pwd2)){
            if(strlen(trim($pwd1)) >= 8){
                $numeric = false;
                $letter = false;
                for($i=0; $i<strlen($pwd1); $i++){
                    if(is_numeric($pwd1[$i]))
                        $numeric = true;
                    else
                        $letter = true;
                }
                if(!$numeric || !$letter)
                    return "Las contraseñas deben contener letras y números";
            }else
                return "La longitud mínima para la contraseña es de 8 caracteres";
        }else{
            return "Las claves no coinciden!";
        }
        if($id){
            global $db;
            switch($type){
                case "USER":
                    $sql = "select Password, Old from users where ID_User = " . $id;
                    $data = $db->getObject($sql);
                    if(Encrypt($pwd1) == $data->Password)
                        return "La contrseña debe ser distinta a la actual";
                    elseif(Encrypt($pwd1) == $data->Old)
                        return "Por seguridad la contraseña debe ser distinta a su antecesora";
                break;
                case "SP":
                    $sql = "select Nombre, Paterno, Materno, RFC, Password from servpub where ID_Serv = " . $id;
                    $data = $db->getObject($sql);
                    $search[] = $data->Nombre;
                    $search[] = strtolower($data->Nombre);
                    $search[] = $data->Paterno;
                    $search[] = strtolower($data->Paterno);
                    $search[] = $data->Materno;
                    $search[] = strtolower($data->Materno);
                    $search[] = $data->RFC;
                    $search[] = strtolower($data->RFC);
                    if(Encrypt($pwd1) == $data->Password)
                        return "La contraseña debe ser distinta a la actual";
                    elseif(strpos($data->Nombre, $pwd1)){
                        foreach($search as $s){
                            if(strpos($pwd1, $s) === true)
                                return "La contraseña no dede contener datos personales como nombre o RFC";
                        }
                    }
                break;
            }
        }
    }
    
    function validateCURP($curp){
        if(strlen(trim($curp)) == 18){
            if(ctype_alpha(substr($curp, 0, 4))){
                if(is_numeric(substr($curp, 4, 6))){
                    if(ctype_alpha(substr($curp, 10, 6))){
                        if(!is_numeric(substr($curp, 16, 2)))
                            return "Los últimos dos caracteres del CURP deben ser números";
                    }else
                        return "Error en CURP, revise el formato correcto: ABCD123456EFGHIJ78";
                }else 
                    return "Error en CURP, revise el formato correcto: ABCD123456EFGHIJ78";
            }else
                return "Primeros 4 caracteres del CURP deben ser letras";
        }else
            return "La longitud del CURP debe ser de 18 caracteres";
    }
    
    function Quotes($str){
        return "'" . $str . "'";
    }
    
    function quitarAcentos($text, $quitspace){
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);
        $patron = ($quitspace?"/[\, ]+/":"/[\,]+/");
        $patron = array (
                // Espacios, puntos y comas por guion
                 $patron => '_',

                // Vocales
                '/&agrave;/' => 'a',
                '/&egrave;/' => 'e',
                '/&igrave;/' => 'i',
                '/&ograve;/' => 'o',
                '/&ugrave;/' => 'u',

                '/&aacute;/' => 'a',
                '/&eacute;/' => 'e',
                '/&iacute;/' => 'i',
                '/&oacute;/' => 'o',
                '/&uacute;/' => 'u',

                '/&acirc;/' => 'a',
                '/&ecirc;/' => 'e',
                '/&icirc;/' => 'i',
                '/&ocirc;/' => 'o',
                '/&ucirc;/' => 'u',

                '/&atilde;/' => 'a',
                '/&etilde;/' => 'e',
                '/&itilde;/' => 'i',
                '/&otilde;/' => 'o',
                '/&utilde;/' => 'u',

                '/&auml;/' => 'a',
                '/&euml;/' => 'e',
                '/&iuml;/' => 'i',
                '/&ouml;/' => 'o',
                '/&uuml;/' => 'u',

                '/&auml;/' => 'a',
                '/&euml;/' => 'e',
                '/&iuml;/' => 'i',
                '/&ouml;/' => 'o',
                '/&uuml;/' => 'u',

                // Otras letras y caracteres especiales
                '/&aring;/' => 'a',
                '/&ntilde;/' => ($quitspace?'N':'Ñ')

                // Agregar aqui mas caracteres si es necesario

        );
        $text = preg_replace(array_keys($patron),array_values($patron),$text);
        return $text;
    }
    
    function setGrid($grid, $params, $paging = false){
        $html = $grid . " = new dhtmlXGridObject('" . $grid . "');"
            . $grid . ".setImagePath('js/dhtmlxGrid/codebase/imgs/');"
            . $grid . ".enableSmartRendering(true);"
            . $grid . ".setSkin('dhx_skyblue');"
            . $grid . ".setHeader('" . Display($params, "Header") . "',null,[" . styleHeaderGrid(count($params)) . "]);"
            . $grid . ".setInitWidths('" . Display($params, "Width") . "');"
            . $grid . ".attachHeader('" . Display($params, "Attach") . "');"
            . $grid . ".setColAlign('" . Display($params, "Align") . "');"
            . $grid . ".setColSorting('" . Display($params, "Sort") . "');"
            . $grid . ".setColTypes('" . Display($params, "Type") . "');";
        if($paging){
            $html .=  $grid . ".enablePaging(true,100,null,'pager',true,'infopage');"
                   . $grid . ".setPagingSkin( 'toolbar', 'dhx_skyblue' );";		 
        }
        $html .= $grid . ".init();"
               . $grid . ".attachEvent('onFilterEnd', function(){ Count(" . $grid . "); });";
        echo $html;	
    }

    function styleHeaderGrid($num){
            $style=str_repeat('"text-align:center;font-size:8pt;font-weight:normal;vertical-align:middle;",',$num); 
            $style=substr($style,0,strlen($style)-1);
            return $style;
    }

    function Display($array, $key){
            $val = "";
            for($i=0; $i<count($array)-1; $i++)
                    $val .= ParseFilter($array[$i][$key]) . ",";
            $val .= ParseFilter($array[count($array)-1][$key]);
            return $val;
    }

    function ParseFilter($val){
            switch($val){
                    case "txt": return "#text_filter"; break;
                    case "cmb": return "#select_filter"; break;
                    case "": return ""; break;
                    default: return $val; break;
            }
    }

    function DateFormat($date, $mode){
            $global = explode(" ", $date);
            $d = explode("-", $global[0]);		
            $t = explode(":", $global[1]);
            $time_format = $t[0] . ":" . $t[1];		
            switch($mode){
                    case 1:
                        switch($d[1]){
                                case "01":
                                        $month = "Enero";
                                break;
                                case "02":
                                        $month = "Febrero";
                                break;
                                case "03":
                                        $month = "Marzo";
                                break;
                                case "04":
                                        $month = "Abril";
                                break;
                                case "05":
                                        $month = "Mayo";
                                break;
                                case "06":
                                        $month = "Junio";
                                break;
                                case "07":
                                        $month = "Julio";
                                break;
                                case "08":
                                        $month = "Agosto";
                                break;
                                case "09":
                                        $month = "Septiembre";
                                break;
                                case "10":
                                        $month = "Octubre";
                                break;
                                case "11":
                                        $month = "Noviembre";
                                break;
                                case "12":
                                        $month = "Diciembre";
                                break;
                        }
                        $date_format = $d[2] . " de " . $month . " de " . $d[0];
                        return $date_format;
                    break;
                    case 2:
                            return $time_format;
                    break;
            }		
    }
    
    function Month($m){
        $month = array("01" => "Enero", 
                       "02" => "Febrero", 
                       "03" => "Marzo", 
                       "04" => "Abril", 
                       "05" => "Mayo", 
                       "06" => "Junio", 
                       "07" => "Julio", 
                       "08" => "Agosto", 
                       "09" => "Septiembre", 
                       "10" => "Octubre", 
                       "11" => "Noviembre", 
                       "12" => "Diciembre" );
        return $month[$m];
    }
    
    function getDomain(){
        $domain = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];		
        $pos = strrpos($domain, "/");		
        return ($_SERVER['HTTPS']=="on"?"https":"http") . "://" . substr($domain, 0, $pos) . "/";
    }

    function ManageDate($date, $year=0, $month=0, $day=0){
        return date("Y-m-d", strtotime($date . " + " . $year . " year + " . $month . " month + " . $day . " days"));
    }

    function Encrypt($str){
         return sha1(md5($str));
    }

    function DayOfWeek($year, $month, $day, $format = 'str'){
         $day = date("w",mktime(0, 0, 0, $month, $day, $year));
         $week = array(1 => "Lunes", 
                       2 => "Martes", 
                       3 => "Miércoles", 
                       4 => "Jueves", 
                       5 => "Viernes", 
                       6 => "Sábado", 
                       7 => "Domingo");
         if($format == 'int')
             return $day;                  
         else
             return $week[$day];
    }
    
    function format($str, $total, $char){
        $add = "";
        for($i=0; $i<$total - strlen($str); $i++)
                $add .= $char;
        return $add . $str;
    }
    
    function DateDiff($fecha_principal, $fecha_secundaria, $obtener = 'SEGUNDOS', $redondear = false){
        $f0 = strtotime($fecha_principal);
        $f1 = strtotime($fecha_secundaria);
        if ($f0 < $f1) { $tmp = $f1; $f1 = $f0; $f0 = $tmp; }
        $resultado = ($f0 - $f1);
        switch ($obtener) {
            default: break;
            case "MINUTOS"   :   $resultado = $resultado / 60;   break;
            case "HORAS"     :   $resultado = $resultado / 60 / 60;   break;
            case "DIAS"      :   $resultado = $resultado / 60 / 60 / 24;   break;
            case "SEMANAS"   :   $resultado = $resultado / 60 / 60 / 24 / 7;   break;
        }
        if($redondear) $resultado = round($resultado);
        return $resultado;
     }
     
     function SendMail($send, $subject, $name, $text, $attach = null){
            global $db;
            $sql = "select * from parametros";
            $config = $db->getArray($sql);
            foreach($config as $c)
                $param[$c['ID_Parametro']] = $c['Valor'];
            $from = $param[6];
            $pass = $param[7];	
            $mail = new PHPMailer();		
            if(is_array($send)){
                foreach($send as $s)
                    $mail -> AddAddress ($s);
            }else
                $mail -> AddAddress ($send);
            $mail -> From = $from;
            $mail -> FromName = $param[8];		
            $mail -> Subject = utf8_decode($subject);
            $mail -> Body = utf8_decode(BodyMail($subject, $name, $text, $param[14], $param[15]));
            $mail -> IsHTML(true);
            if($attach)
                    $mail->AddAttachment($attach, $file);
            $mail->IsSMTP();
            $mail->SMTPDebug  = 1;  //---->Esta linea es para hacer debug y ver los errores que se generan en el envio del mail.
            $mail->Host = $param[9];
            $mail->Port = $param[10];
            $mail->SMTPAuth = $param[11];
            $mail->Username = $from;
            $mail->Password = $pass;

            //Se verifica que se haya enviado el correo con el metodo Send().
            return $mail->Send();	
     }
     
     function BodyMail($subject, $name, $text, $dependence, $gob){
            return "<table style = 'border: 2px outset #084773; border-collapse: collapse; font-size: 9pt; '>
                        <tr>
                            <td style = 'border: 2px outset #084773; padding: 5px; text-align: center; '>
                                <p><b>" . $dependence . "</b></p>
                                <p><b>" . $gob . "</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td width = '700' style = 'border: 2px outset #084773; padding: 5px;'><center>" . $subject . "</center></td>
                        </tr>
                        <tr>
                            <td width = '700' style = 'border: 2px outset #084773; padding: 5px;'>
                                    <p><b>Estimado (a): " . $name . "</b></p>" . $text . "
                                    <br>
                                    <p><b>Le agradecemos por usar nuestro portal electrónico </b></p>
                            </td>
                        </tr>
                 </table>";
    }
    
    function Calculate($start, $days, $inhab){ // Regresa fecha de vencimiento + 1
        $i = 1;
        $next = $start;
        while($i <= $days + 1){
            $next = ManageDate($next, 0, 0, 1);
            if(!in_array($next, $inhab))
                $i++;
        }
        return $next;
    }
    
    function InterpretTrans($e, $dec){
        switch($e['Tipo_Trans']){
            case "1":
                switch($e['Tipo_Elem']){
                    case "inversiones":
                    case "adeudos":
                        $resp = ($dec=="INICIAL"?"SALDO":"ADQUISICIÓN") . "<br>$ " . number_format($e['Saldo'], 2) . "<br>" . $e['Fecha_Mov'] . "<br>";
                    break;
                    case "dependientes":
                        $resp = "REGISTRO NUEVO<br>" . $e['Fecha_Mov'];
                    break;
                    case "ingresos":
                        $resp = "$ " . number_format($e['Importe'], 2);
                    break;
                    case "pensiones":
                        $resp = "Cantidad pagada $ " . number_format($e['Importe'], 2);
                    break;
                    default:
                        $resp = ($dec=="INICIAL"?"DECLARACIÓN INICIAL":"ADQUISICIÓN (COMPRA)") . "<br> $ " . number_format($e['Importe'], 2) . "<br>" . $e['Forma_Trans'] . "<br>" . $e['Fecha_Mov'] . "<br>";
                        if($e['ID_Credito']){
                            $plazo = showVar($e['Plazo_Ad']);
                            $pago =  showVar($e['Pago_Ad']);
                            $resp .= $e['Tipo_Ad'] . "<br>"
                                   . showVar($e['Institucion_Ad']) . " " . showVar($e['Cuenta_Ad']) . "<br>"
                                   . ($plazo?$plazo . " meses":"") . ($pago?" PAGO $ " . $pago:"");
                        }
                    break;
                }
            break;
            case "2":
                if($e['Forma_Trans'])
                    $resp = "ENAJENACIÓN (VENTA) <br>$ " . number_format($e['Importe'], 2) . "<br>" . $e['Forma_Trans'] . " " . ($e['Plazo']?$e['Plazo'] . " meses":"") . "<br>" . $e['Fecha_Mov'];
                else
                    $resp = "ABONO X VENTA <br>$ " . number_format($e['Importe'], 2) . "<br>" . $e['Fecha_Mov'];
            break;
            case "3":
                $resp = ($dec=="INICIAL"?"DECLARACIÓN INICIAL":"ADQUISICIÓN (DONACIÓN)") . "<br>" . ($dec=="INICIAL"?"$ " . number_format($e['Importe'], 2) . "<br>":"") . $e['Fecha_Mov'];
            break;
            case "4":
                $resp = "ENAJENACIÓN (DONACIÓN) <br>" . $e['Observaciones'] . "<br>" . $e['Fecha_Mov'];
            break;
            case "5":
                $resp = "PÈRDIDA <br>" . $e['Observaciones'] . "<br>" . $e['Fecha_Mov'];
            break;
            case "6":
                $resp = "SEPARACIÓN FAMILIAR <br>" . $e['Fecha_Mov'];
            break;
            case "7":
                $resp = "PAGO/LIQUIDACIÓN <br>Importe $ " . number_format($e['Importe'], 2) . "<br>Saldo $ " . number_format($e['Saldo'], 2) . "<br>" . $e['Fecha_Mov'];
            break;
            case "8":
                $resp = "RETIRO/FINIQUITO <br>Importe $ " . number_format($e['Importe'], 2) . "<br>Saldo $ " . number_format($e['Saldo'], 2) . "<br>" . $e['Fecha_Mov'];
            break;
            case "9":
                $resp = "CANCELACIÓN DE VENTA <br>" . $e['Observaciones'] . "<br>" . $e['Fecha_Mov'];
            break;
            case "10":
                $resp = "DEPÒSITO <br>Importe $ " . number_format($e['Importe'], 2) . "<br>Saldo $ " . number_format($e['Saldo'], 2) . "<br>" . $e['Fecha_Mov'];
            break;
            case "12":
                $resp = "ACTUALIZACIÓN <br>" . $e['Fecha_Mov'];
            break;
            case "15":
                $resp = "CESIÓN <br>" . $e['Fecha_Mov'];
            break;
            case "16":
                $resp = "HERENCIA <br>" . $e['Fecha_Mov'];
            break;
            case "17":
                $resp = "PERMUTA <br>" . $e['Fecha_Mov'];
            break;
            case "18":
                $resp = "RIFA <br>" . $e['Fecha_Mov'];
            break;
            case "19":
                $resp = "TRANSPASO <br>" . $e['Fecha_Mov'];
            break;
        }
        return $resp;
    }
    
    function InterpretElem($e, $withrefs = false){
        switch($e['Tipo_Elem']){
            case "inmuebles":
                $resp = $e['Tipo_In'] ." <br>
                        Calle: " . showVar($e['Calle_In']). "<br>
                        Nùmero: " . showVar($e['Numero_In']). "<br>
                        Colonia: " . showVar($e['Colonia_In']) . "<br>
                        Ciudad: " . showVar($e['Ciudad_In']) . "<br>
                        C.P: " . showVar($e['CP_In']) . "<br>
                        Metros terreno: " . showVar($e['TerrenoM2']) . "<br>
                        Metros construidos: " . showVar($e['ConstruccionM2']) . "<br>";
                if($withrefs){
                    $resp .= "<b>Titular: " . ($e['Titular'] ? showVar(reset(explode("|", $e['Titular']))) . " (" . end(explode("|", $e['Titular'])) . ") " : "DECLARANTE") . "<br>
                              DECLARADO: " . $e['Declared'] . "</b>";
                }
            break;
            case "muebles":
                $resp = $e['Tipo_Mue'] . "<br>" . showVar($e['Descripcion_Mue']) . "<br>";
                if($withrefs){
                    $resp .= "<b>Titular: " . ($e['Titular'] ? showVar(reset(explode("|", $e['Titular']))) . " (" . end(explode("|", $e['Titular'])) . ") " : "DECLARANTE") . "<br>
                               DECLARADO: " . $e['Declared'] . "</b>";
                }
            break;
            case "vehiculos":
                $resp = $e['Tipo_Veh'] . "<br>
                        Marca: " . showVar($e['Marca_Veh']) . "<br>
                        Modelo: " . showVar($e['Modelo_Veh']) . "<br>
                        Año: " . showVar($e['Anio_Veh']) . "<br>
                        Serie: " . showVar($e['Serie_Veh']) . "<br>";
                if($withrefs){
                    $resp .= "<b>Titular: " . ($e['Titular'] ? showVar(reset(explode("|", $e['Titular']))) . " (" . end(explode("|", $e['Titular'])) . ") " : "DECLARANTE") . "<br> 
                                DECLARADO: " . $e['Declared'] . "</b>";
                }
            break;
            case "inversiones":
                $inst = showVar($e['Institucion_Inv']);
                $account = showVar($e['Cuenta_Inv']);
                $resp = $e['Tipo_Inv'] ."<br>"
                      . ($inst?"Institución: " . $inst . "<br>":"")
                      . ($account?"Cuenta: " . $account:"") . "<br>";
                if($withrefs){
                    $resp .= "<b>Titular: " . ($e['Titular'] ? showVar(reset(explode("|", $e['Titular']))) . " (" . end(explode("|", $e['Titular'])) . ") " : "DECLARANTE") . "<br>
                                DECLARADO: " . $e['Declared'] . "</b>";
                }
            break;
            case "adeudos":
                $inst = showVar($e['Institucion_Ad']);
                $account = showVar($e['Cuenta_Ad']);
                $term = showVar($e['Plazo_Ad']);
                $pay = showVar($e['Pago_Ad']);
                $resp = $e['Tipo_Ad'] . "<br>"
                      . ($inst?"Institución: " . $inst . "<br>":"")
                      . ($account?"Cuenta: " . $account . "<br>":"")
                      . ($term?"Plazo: " . $term . " meses<br>":"")
                      . ($pay?"Pago $ " . $pay:"") . "<br>";
                if($withrefs){
                     $resp .= "<b>Titular: " . ($e['Titular'] ? showVar(reset(explode("|", $e['Titular']))) . " (" . end(explode("|", $e['Titular'])) . ") " : "DECLARANTE") . "<br>
                                DECLARADO: " . $e['Declared'] . "</b>";
                }
            break;
            case "dependientes":
                $info = explode("|", $e['Info']);
                $work = showVar($info[2]);
                $place = showVar($info[3]);
                $resp = $e['Tipo_Depend'] . "<br>
                        Nombre: " . showVar($e['Nombre_Depend']) . "<br>
                        RFC: " . showVar($e['RFC_Depend']) . "<br>
                        CURP: " . showVar($e['CURP_Depend']) . "<br>
                        Fecha de Nacim: " . ($e['Nacimiento_Depend']) . "<br>
                        Domicilio: " . showVar($info[0]) . "<br>
                        Ocupación: " . showVar($info[1]) . "<br>"
                      . ($work?"Lugar de trabajo: " . $work . "<br>":"")
                      . ($place?"Domicilio de trabajo: " . $place:"");
            break;
            case "ingresos":
                $resp = $e["Tipo"] . "<br>";
                if(in_array($e['Tipo_Ing'], array("2", "3", "5")))
                        $resp.= "Concepto/RFC: " . showVar($e['Concepto_Ing']) . "<br>";
                if($e['Tipo_Ing'] == "3")
                        $resp .= "Contratista: " . showVar($e['Contratista_Ing']) . "<br>";
                if($e['Tipo_Ing'] == "4"){
                    $resp .= $e['Tipo_in'] . "<br>"
                          . showVar($e['Calle_in']) . " " . showVar($e['Numero_In']) . "<br>"
                          . showVar($e['Colonia_In']) . " " . showVar($e['CP_In']) . "<br>"
                          . showVar($e['Ciudad_In']) . "<br>";
                }
            break;
            case "pensiones":
                $resp = "Beneficiarios:<br>" . $e['Observaciones'];
            break;
        }
        if($e['Observaciones'] && $e['Tipo_Elem'] != "pensiones")
            $resp .= "<br>Comentarios: " . $e['Observaciones'];
        if($e['Aclaracion'])
            $resp .= "<br>Aclaración: " . $e['Aclaracion'];
        return $resp;
    }
    
    function CountMsg(){
        global $db;
        if($_SESSION['PRO'] == "#SP")
            $sql = "select COUNT(ID_Mensaje) from mensajes 
                    where Tipo = 2 and (
                    (Alcance = 'GLOBAL' and Fecha_Expiracion <= DATE(NOW()) ) or 
                    (Alcance = 'DEPENDENCIA' and Fecha_Expiracion <= DATE(NOW()) and ID_Receptor = " . $_SESSION['DEP'] . ") or 
                    (Alcance = 'UNICO' and Fecha_Expiracion <= DATE(NOW()) and ID_Receptor = " . $_SESSION['UI'] . ") )";
        else
            $sql = "select COUNT(ID_Mensaje) from mensajes 
                    where Tipo = 1 and Leido = 0 and ID_Receptor = " . $_SESSION['UI'];
        return $db->getOne($sql);
    }
    
    class Menu{
        var $name;
        var $img;
        var $sub;
        
        function __construct($name, $img){
            $this->name = $name;
            $this->img = $img;
        }
        
        function setImg($img){
            $this->img = $img;
        }
        
        function addSub($title, $page){
            $this->sub[] = array("title" => $title, "page" => $page);
        }
        
        function getName(){
            return $this->name;
        }
        
        function getImg(){
            return $this->img;
        }
        
        function getSub(){
            return $this->sub;
        }
    }	
    
    class hex2bin{
            /** convert
              * @access     public
              * @param      string  $hexNumber      convert a hex string to binary string
              * @return     string  binary string
              */
            function convert($hexString)
            {
                    $hexLenght = strlen($hexString);
                    // only hex numbers is allowed
                    if ($hexLenght % 2 != 0 || preg_match("/[^\da-fA-F]/",$hexString)) return FALSE;

                    unset($binString);
                    for ($x = 1; $x <= $hexLenght/2; $x++)
                    {
                            $binString .= chr(hexdec(substr($hexString,2 * $x - 2,2)));
                    }

                    return $binString;
            }
	}
    
?>