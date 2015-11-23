<?php
include_once("MVC/SQLconexion.php");
class EntradaSalida extends SQLconexion{
   public static $array=[['fecha_hora','s'],['id_usuario','i'],['usuario.nombre','s'],['tipo','s'],
    ['id_producto','i'],['producto.nombre','s'],['usuario_producto.cantidad','d'],
    ['costo','d']];
  
    static function obtenerTodos($condicion="",$condiciones=array(),$type=""){
        $array=array();
        $elem=new stdClass();
        //var_dump($_POST);
        $stmt=self::prepare('select fecha_hora,id_usuario,usuario.nombre,'
                . 'id_producto,producto.nombre,usuario_producto.cantidad,'
                . 'usuario_producto.costo costo,usuario_producto.tipo tipo '
                . 'from usuario join usuario_producto using (id_usuario) '
                . 'join producto using(id_producto) '." $condicion ");
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($elem->fecha_hora,$elem->id_usuario,$elem->usuario_nombre,
                $elem->id_producto,$elem->producto_nombre,$elem->usuario_producto_cantidad,
                $elem->costo, $elem->tipo);
        echo $stmt->error;
        if($stmt->execute()){
            while($stmt->fetch()){
                array_push($array,clone $elem);
                $elem=new stdClass();
                $stmt->bind_result($elem->fecha_hora,$elem->id_usuario,$elem->usuario_nombre,
                $elem->id_producto,$elem->producto_nombre,$elem->usuario_producto_cantidad,
                $elem->costo, $elem->tipo);
            }
       } else
            return null;
        return $array;
    }
    static function obtenerHastaLaFecha(){
       return EntradaSalida::obtenerTodos(' where id_usuario='.$_SESSION['usuario']->id_usuario
               .' and fecha_hora between "'
               .$_SESSION['turno']->fecha_hora_inicio.'" and CURRENT_TIMESTAMP');
    }
}
