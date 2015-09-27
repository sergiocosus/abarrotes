<?php

include_once 'MVC/SQLconexion.php';
abstract class Base extends SQLconexion{
    public $id;
    public $link;
    public $catId;

  
    abstract function  actualizar();
    abstract function  insertar();

    function eliminame(){
        return self::eliminar($this->id);
    }
    abstract static function obtenerTodos($d,$condicion,$condiciones,$type);
  
    static function siguienteId(){
        $stmt=self::query('SHOW TABLE STATUS LIKE "'.static::$tabla.'"');
        $row=$stmt->fetch_assoc();
        return $row['Auto_increment'];
    }
}
