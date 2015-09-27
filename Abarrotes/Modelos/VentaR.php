<?php
include_once("MVC/SQLconexion.php");
class VentaR extends SQLconexion{
   public static $array=[['fecha_hora','s'],['id_venta','i'],['id_usuario','i'],
    ['usuario.nombre','s'],['usuario.apellido_paterno','s'],['id_cliente','i'],
    ['cliente.nombre','s'],['id_producto','i'],['producto.nombre','s'],
    ['venta_producto.cantidad','d'],['venta_producto.precio','d'],
    ['total','d']];
  
    static function obtenerTodos($condicion="",$condiciones=array(),$type=""){
        $array=array();
        $elem=new stdClass();
        //var_dump($_POST);
        $stmt=self::prepare('select id_venta,fecha_hora,id_usuario,usuario.nombre,usuario.apellido_paterno,'
                . 'id_cliente,cliente.nombre,id_producto,producto.nombre,'
                . 'venta_producto.cantidad,venta_producto.precio,venta_producto.cantidad*venta_producto.precio total '  
                . 'from venta join venta_producto using (id_venta) '
                . 'join usuario using(id_usuario) join producto using(id_producto) join '
                . 'cliente using (id_cliente)  '." $condicion");
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($elem->id_venta,$elem->fecha_hora,$elem->id_usuario,
                $elem->usuario_nombre,$elem->usuario_apellido_paterno,$elem->id_cliente,
                $elem->cliente_nombre,$elem->id_producto,$elem->producto_nombre,$elem->cantidad,$elem->precio,$elem->total);
        echo $stmt->error;
        if($stmt->execute()){
            while($stmt->fetch()){
                array_push($array,clone $elem);
                $elem=new stdClass();
                $stmt->bind_result($elem->id_venta,$elem->fecha_hora,$elem->id_usuario,
                $elem->usuario_nombre,$elem->usuario_apellido_paterno,$elem->id_cliente,
                $elem->cliente_nombre,$elem->id_producto,$elem->producto_nombre,$elem->cantidad,$elem->precio,$elem->total);
            }
            
            
       } else
            return null;
        return $array;
    }

}
