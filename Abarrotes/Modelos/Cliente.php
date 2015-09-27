<?php
include_once("MVC/SQLconexion.php");
class Cliente extends SQLconexion{
    public static $tabla = "cliente";
    public $id_cliente,$nombre,$telefono,$celular,$direccion;
    public static $array=[['id_cliente','i'],['nombre','s'],['telefono','s'],
    ['celular','s'],['direccion','s']];
            
    static function obtenerTodos($condicion="",$condiciones=array(),$type=""){
        $usuarios=array();
        $usuario=new Cliente();
        $stmt=self::prepare('SELECT * FROM '.self::$tabla.' '.$condicion.' ');
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($usuario->id_cliente,$usuario->nombre,$usuario->telefono,
                $usuario->celular,$usuario->direccion);
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($usuarios,clone $usuario);
                $usuario=new Cliente();
                $stmt->bind_result($usuario->id_cliente,$usuario->nombre,$usuario->telefono,
                $usuario->celular,$usuario->direccion);
            }
        else
            return null;
        return $usuarios;
    }

    function actualizar(){
        $result=self::prepare('UPDATE '.static::$tabla.' SET nombre=?,telefono=?,'
                . 'celular=?,direccion=? WHERE id_cliente=?');
        $result->bind_param('ssssi',$this->nombre,  $this->telefono,
                $this->celular,$this->direccion,$this->id_cliente);    
        $result->execute();
        return $result->error; 
    } 
    function insertar(){
        $result=self::prepare('INSERT INTO '.static::$tabla.' (nombre,'
                . 'telefono,celular,direccion) '
                . 'VALUES (?,?,?,?)');
        $result->bind_param('ssss',  $this->nombre,$this->telefono,
                $this->celular,$this->direccion);
        $result->execute();
        echo $result->error;
                
        return $result->error;
    }
    
    static function eliminar($id){
        $result=self::prepare('DELETE FROM '.static::$tabla.' WHERE id_cliente=?');
        $result->bind_param('i',$id);
        $result->execute();
        return $result->errno;
    }
    

}
