<?php
include_once("MVC/SQLconexion.php");
class Usuario extends SQLconexion{
    public static $tabla = "usuario";
    public $id_usuario,$nombre,$apellido_paterno,$apellido_materno,$contrasena,
            $telefono,$celular,$direccion,$nivel,$fecha_hora_de_alta;
    public static $array=[['id_usuario','i'],['nombre','s'],['apellido_paterno','s'],
    ['apellido_materno','s'],['contrasena','s'],['telefono','s'],['celular','s'],['direccion','s'],
    ['nivel','s'], ['fecha_hora_de_alta','s']];
            
        
    static function obtenerTodos($condicion="",$condiciones=array(),$type=""){
        $usuarios=array();
        $usuario=new Usuario();
        $stmt=self::prepare('SELECT * FROM '.self::$tabla.' '.$condicion.' ');
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($usuario->id_usuario,$usuario->nombre,$usuario->apellido_paterno,
                $usuario->apellido_materno,$usuario->contrasena,$usuario->telefono,$usuario->celular,
                $usuario->direccion,$usuario->nivel,$usuario->fecha_hora_de_alta);
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($usuarios,clone $usuario);
                $usuario=new Usuario();
                $stmt->bind_result($usuario->id_usuario,$usuario->nombre,$usuario->apellido_paterno,
                $usuario->apellido_materno,$usuario->contrasena,$usuario->telefono,$usuario->celular,
                $usuario->direccion,$usuario->nivel,$usuario->fecha_hora_de_alta);
            }
        else
            return null;
        return $usuarios;
    }

    function actualizar(){
        $result=self::prepare('UPDATE '.static::$tabla.' SET nombre=?,apellido_paterno=?,'
                . 'apellido_materno=?,contrasena=?,telefono=?,celular=?,direccion=?,nivel=? WHERE id_usuario=?');
        $result->bind_param('ssssssssi',$this->nombre,  $this->apellido_paterno,
                $this->apellido_materno,$this->contrasena,$this->telefono,$this->celular,
                $this->direccion,$this->nivel,$this->id_usuario);    
        $result->execute();
        return $result->error; 
    } 
    function insertar(){
        $result=self::prepare('INSERT INTO '.static::$tabla.' (nombre,'
                . 'apellido_paterno,apellido_materno,contrasena,telefono,celular,direccion,nivel) '
                . 'VALUES (?,?,?,?,?,?,?,?)');
        $result->bind_param('ssssssss',  $this->nombre,$this->apellido_paterno,
                $this->apellido_materno,$this->contrasena,$this->telefono,$this->celular,
                $this->direccion,$this->nivel);
        $result->execute();
        echo $result->error;
                
        return $result->error;
    }
    
    static function eliminar($id){
        $result=self::prepare('DELETE FROM '.static::$tabla.' WHERE id_usuario=?');
        $result->bind_param('i',$id);
        $result->execute();
        return $result->errno;
    }
    

}
