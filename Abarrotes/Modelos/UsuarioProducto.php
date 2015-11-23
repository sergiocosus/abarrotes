<?php
include_once("MVC/SQLconexion.php");
class UsuarioProducto extends SQLconexion{
    public static $tabla = "usuario_producto";
    public $id_usuario,$id_producto,$fecha_hora,$cantidad,$costo,$tipo;
    public static $array=[['id_usuario','i'],['id_producto','i'],['fecha_hora','s'],
    ['cantidad','d'],['costo','d'],['costo','s']];
            

        
    static function obtenerTodos($condicion="",$condiciones=array(),$type=""){
        $ventas=array();
        $venta=new stdClass();
        $stmt=self::prepare('select id_usuario,usuario.nombre,producto.nombre,
            historial_producto.cantidad,unidad,motivo from historial_producto
            join producto using(id_producto) 
  '.$condicion.' ');
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($venta->id_producto,$venta->nombre,$venta->cantidad,
                $venta->unidad,$venta->motivo);
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($ventas,clone $venta);
                $venta=new stdClass();
                $stmt->bind_result($venta->id_producto,$venta->nombre,$venta->cantidad,
                $venta->unidad,$venta->motivo);
            }
        else
            return null;
        return $ventas;
    }
    

 
    function insertar(){
        $result=self::prepare('INSERT INTO '.static::$tabla.' (id_usuario,'
                . 'id_producto,cantidad,costo,tipo) '
                . 'VALUES (?,?,?,?,?)');
        $result->bind_param('iidds',  $this->id_usuario, $this->id_producto,$this->cantidad,
                $this->costo,$this->tipo);
        $result->execute();
        
        echo $result->error;
        $result=self::prepare('update  producto set costo=? where id_producto=?');
        $result->bind_param('di',  $this->costo, $this->id_producto);
        $result->execute();
        echo $result->error;
        return $result->error;
    }
    
   
}
