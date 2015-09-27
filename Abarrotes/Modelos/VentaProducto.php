<?php
include_once("MVC/SQLconexion.php");
class VentaProducto extends SQLconexion{
    public static $tabla = "venta_producto";
    public $id_venta,$id_producto,$cantidad,$precio;
    public static $array=[['id_venta','i'],['id_producto','s'],['cantidad','d'],
    ['precio','i']];
            

        
    static function obtenerTodos($condicion="",$condiciones=array(),$type=""){
        $ventas=array();
        $venta=new stdClass();
        $stmt=self::prepare('select id_venta,id_producto,nombre,cantidad,
            venta_producto.precio,unidad from venta_producto 
            join producto using(id_producto) 
  '.$condicion.' ');
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($venta->id_venta,$venta->id_producto,$venta->nombre,
                $venta->cantidad,$venta->precio,$venta->unidad);
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($ventas,clone $venta);
                $venta=new stdClass();
                $stmt->bind_result($venta->id_venta,$venta->id_producto,$venta->nombre,
                $venta->cantidad,$venta->precio,$venta->unidad);
            }
        else
            return null;
        return $ventas;
    }

 
    function insertar(){
        $result=self::prepare('INSERT INTO '.static::$tabla.' (id_venta,'
                . 'id_producto,cantidad,precio) '
                . 'VALUES (?,?,?,?)');
        $result->bind_param('isdd',  $this->id_venta, $this->id_producto,$this->cantidad,
                $this->precio);
        $result->execute();
        echo $result->error;
       
        return $result->error;
    }
    
   
}
