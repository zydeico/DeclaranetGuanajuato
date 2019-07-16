<?php
date_default_timezone_set('America/Mexico_City');

if (! class_exists ( "DBConn" )) {
//Clase de Acceso a datos unificada...

require_once ('WSConn.php');

DEFINE('ADDRESS', $_SERVER['REMOTE_ADDR']);
DEFINE('SCRIPT', $_SERVER['SCRIPT_NAME']);
DEFINE('USER', $_SESSION['NM']);
DEFINE('PROFILE', $_SESSION['PRO']=="#SP"?"SP":"INTERNO");

class DBConn{
    var $connection; //Arreglo de conexiones que soportara la clase para su disposicion
    var $cn; // Variable contenedora de la conexion activa
    var $ws;
    var $active = "DECLARANET"; // Declara cual sera la conexion x default cuando no se especifique lo contrario
    var $debug = true;
    
    //Esta funcion inicializa los valores del arreglo de conexiones como se muestra
    function Initialize(){
        if($_SERVER['HTTP_HOST'] == "localhost")
            $this->connection['DECLARANET'] = array('HOST' => 'localhost', 'USER' => 'root', 'PWD' => '123456', 'DB' => 'declaranetv2');
        else
            $this->connection['DECLARANET'] = array('HOST' => '', 'USER' => '', 'PWD' => '', 'DB' => '');   
    }
    
    //Constructor, recibe el nombre de la conexion que se desea o en caso contrario adopta la DEFAULT como se declaro antes
    function __construct($conn = ""){
       $this->Initialize(); 
       if(!$this->debug)
           $this->ws = new WSConn();
       if($conn)
           $this->active = $conn;
    }
    
    //Realiza la conexion de la base da datos segun la conexion seleccionada
    function Connect($id){
        $this->cn = mysqli_connect($this->connection[$id]['HOST'],
                                   $this->connection[$id]['USER'],
                                   $this->connection[$id]['PWD']) 
                                   or die($this->saveError("connection"));	
        mysqli_select_db($this->cn, $this->connection[$id]['DB']);
        mysqli_query($this->cn, "SET NAMES 'utf8'");
        mysqli_query($this->cn, "SET time_zone = '" . $this->getTimezone() . "'");
    }
    
    function getTimezone() {
        $year = date("Y");
        $ahora =strtotime(date("Y-m-d"));  
        $inicio_verano = strtotime($year . "-03-31 next Sunday");
        $fin_verano = strtotime($year . "-11-01 last Sunday");
        if ($ahora >= $inicio_verano && $ahora < $fin_verano) 
            return "-5:00";
        else 
            return "-6:00";
    } 
    
    //Ejecuta una instruccion de MySQL recibiendo el query como tal y devuelve los resultados en forma nativa
    //guardando en bitacora la operación asi como el error en caso que se presente 
    function query($sql){
        $this->Connect($this->active);
        $result = mysqli_query($this->cn, $sql) or die($this->saveError($sql));
        mysqli_close($this->cn);
        $this->saveAction($sql);
        return $result;
    }
    
    //Realiza una consulta basada en el query enviado devolviendo los resultados en formato de array asociativo
    function getArray($sql, $format = "ARRAY"){
        $ds = $this->query($sql);
        $result = array();
        switch($format){
            case "ARRAY":
                while($r = mysqli_fetch_assoc($ds))
                    $result[] = $r;
            break;
            case "OBJECT":
                 while($r = mysqli_fetch_object($ds))
                    $result[] = $r;
            break;
        }
        return $result;
    }
    
    //Reeliza una consulta basado en el query enviado devolviendo solo el primer resultado en forma de objeto
    function getObject($sql){
        $ds = $this->query($sql);
        if(mysqli_num_rows($ds) > 0)
            return mysqli_fetch_object($ds);
        else
            return null;
    }
    
    //Reeliza una consulta basado en el query enviado devolviendo un solo dato, en este caso el primero del mismo
    function getOne($sql){
        $ds = $this->query($sql);
        if(mysqli_num_rows($ds) > 0){
            $data = mysqli_fetch_row($ds);
            return $data[0];
        }else
            return null;
            
    }
    
    //Calcula el siguiente valor para la llave primaria de una tabla usando el nombre del campo, la tabla y
    //en caso que se requiera tambien puede recibir una condicion adicional para obtenerla
    function getID($field, $table, $condition = ""){ 	
        $sql = "select IFNULL(max(" . $field . "), 0) from " . $table . ($condition==""?"":" where " . $condition);		
        $ds = $this->query($sql);
        $id = mysqli_fetch_row($ds);
        return $id[0] + 1;
    }
    
    //Evalua si existe un registro que cumpla la condicion enviada en base al nombre del campo y la tabla
    function exist($field, $table, $condition){
        $sql = "select IFNULL(" . $field . ", NULL) from " . $table . " where " . $condition;		
        $ds = $this->query($sql);
        if(mysqli_num_rows($ds) > 0){
            $res = mysqli_fetch_row($ds);				
            return $res[0];
        }else
            return null;	
    }
    
    //Ejecuta una instruccion de MySQL tales como INSERT, UPDATE Y DELETE y devuelve como resultado 
    //el numero de filas afectadas
    function execute($sql){
        $res = $this->query($sql);
    }
    
    //Hace la peticion a un StoreProcedure recibiendo el nombre del mismo y un arreglo con los valores en el orden que
    //deben ser insertados, ademas especifica si requiere que devuelva algun valor como resultado de la operacion
    function queryStored($fn, $param, $resultFormat = ""){
        $str = "( ";
        foreach ($param as $p) 
                $str .= ($p?"'".$p."'":"null") . ",";
        $str = substr($str, 0, -1) . ")";
        $sql = 'CALL ' . $fn . ' ' . $str;
        if($resultFormat)
            return $this->getArray($sql, $resultFormat);
        else
            return $this->execute($sql);
    }
    
    //Almancena el registro de errores de ejecucion en la bitacora
    function saveError($sql){
        if($this->debug)
            echo mysqli_error($this->cn) . " | " . $sql;
        else{
            $id = $this->ws->insertError(mysqli_error($this->cn) . " | " . $sql, USER, PROFILE, ADDRESS, SCRIPT);
            echo "Error de ejecucion " . $id;
        }
    }
    
    //Almancena el registro de operaciones en la bitacora
    function saveAction($sql){
        if(!$this->debug)
            $this->ws->insertAction($sql, USER, PROFILE, ADDRESS, SCRIPT);
    }
}

}

?>
