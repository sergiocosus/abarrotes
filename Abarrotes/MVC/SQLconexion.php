<?php

class SQLconexion {
    static private $db;
    static function conectar(){
      //if(self::$db = new mysqli("localhost","root","pato2000","abarrotes")){
       if(self::$db = new mysqli(
                $GLOBALS['env']['db_host'],
                $GLOBALS['env']['db_user'],
                $GLOBALS['env']['db_pass'],
                $GLOBALS['env']['db_base'])){
           self::$db->query('SET time_zone = "Mexico/General"');
            mysqli_set_charset(self::$db, "latin1");   
           // mysql_query("SET NAMES 'utf8'");
            return "Conexión correcta"; 
        }else{
            die("No hay conexión a la base de gatos");
            header('Location: error-conexion.php');
            return 0;
        }
        
    }
    
    static function desconectar(){
        self::$db->close();
    }
    static function getConexion(){
        return self::$db;
    }  
    static function query($consulta){
        return self::$db->query($consulta);
    }
    static function prepare($consulta){
        $stmt=self::$db->stmt_init();
        $stmt->prepare($consulta);
        return $stmt; 
    }
    static function insert_id(){
        return mysqli_insert_id(self::$db);
    }
}
