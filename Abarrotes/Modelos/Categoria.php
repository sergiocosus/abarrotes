<?php
include_once("MVC/SQLconexion.php");
class Categoria extends SQLconexion{
    public static $tabla = "categoria";
    public $id,$nombre;
    public static $array=[['id','s'],['nombre','s']];
 
    static function obtenerPorCondicion($condicion,$condiciones,$type){
        $categoria = new Categoria();
        $stmt=self::prepare('SELECT * FROM '.self::$tabla." $condicion");
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($categoria->id,$categoria->nombre);
        if($stmt->execute()){
            if ($renglon = $stmt->fetch())      
                return $categoria;
        }
        else    
            return null;
    }
    static function obtenerTodos($condicion="",$condiciones=array(),$type=""){
        $categorias=array();
        $categoria=new Categoria();
        $stmt=self::prepare('SELECT * FROM '.self::$tabla.' '.$condicion.' ');
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($categoria->id,$categoria->nombre);
        echo $stmt->error;
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($categorias,clone $categoria);
                $categoria=new Categoria();
                $stmt->bind_result($categoria->id,$categoria->nombre);
            }
        else
            return null;
        
        return $categorias;
    }

    function actualizar(){
        $result=self::prepare('UPDATE '.static::$tabla.' SET '
                . 'nombre=? WHERE id=?');
        $result->bind_param('si',$this->nombre,
                $this->id);    
        $result->execute();
        
     
        echo $result->error;
        return $result->error; 
    }
    
    function insertar(){
      
        $result=self::prepare('INSERT INTO '.static::$tabla.' (nombre) '
                . 'VALUES (?)');
        $result->bind_param('s', $this->nombre);
        $result->execute();
        if($result->error)
            echo $result->error;
        return $result->error;
    }
    
    static function eliminar($id){
        
        $result=self::prepare('DELETE FROM '.static::$tabla.' WHERE id=?');
        $result->bind_param('s',$id);
        $result->execute();
        echo $result->error;
        return $result->errno;
    }
}
