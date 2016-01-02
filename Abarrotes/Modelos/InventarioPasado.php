<?php
include_once("MVC/SQLconexion.php");
class InventarioPasado extends SQLconexion{
    public static $tabla = "InventarioPasado";
    public $id,$codigo_barras,$nombre,$descripcion,$existencias,$precio,
            $precioTotal,$costo,$costoTotal,$id_categoria,$categoria;
    public static $array=[['id','s'],['codigo_barras','s'],['nombre','s'],
        ['descripcion','s'],['existencias','d'],['minimo','i'],['precio','d'],
        ['precioTotal','d'],['costo','d'],
        ['costoTotal','d'],['id_categoria','i'],['categoria','s']
    ];
 
    static function obtenerTodos($condicion="",$condiciones=array(),$type="",$order=""){
        $productos=array();
        $producto=new InventarioPasado();

        $stmt=self::prepare('select p.id_producto as id,
       p.codigo_barras as codigo_barras,
       p.nombre as nombre,
       p.descripcion as descripcion,
      (p.existencias - ifnull(usuario_producto_total.cantidad_total,0) + ifnull(venta_producto_total.cantidad_total,0)) as existencias,
       p.minimo as minimo,
       p.precio as precio,
  (p.existencias - ifnull(usuario_producto_total.cantidad_total,0) + ifnull(venta_producto_total.cantidad_total,0))*p.precio as precioTotal,
       p.costo as costo,
  (p.existencias - ifnull(usuario_producto_total.cantidad_total,0) + ifnull(venta_producto_total.cantidad_total,0))*p.costo as costoTotal,
       c.id as id_categoria,
       c.nombre as categoria

from producto as p
        left JOIN  (select usuario_producto.*, sum(cantidad) as cantidad_total from usuario_producto
                     where usuario_producto.fecha_hora >= ?
                    GROUP BY usuario_producto.id_producto) as usuario_producto_total
              ON (p.id_producto = usuario_producto_total.id_producto)
       left JOIN (
                 SELECT venta_producto.*, subventa.fecha_hora,sum(venta_producto.cantidad) as cantidad_total from venta_producto
                     JOIN venta as subventa on venta_producto.id_venta = subventa.id_venta
                     where subventa.fecha_hora >= ?
                     GROUP BY venta_producto.id_producto) as venta_producto_total

              on (p.id_producto = venta_producto_total.id_producto)

       join categoria as c on (id_categoria=id)

GROUP BY p.id_producto  '.$condicion.' '.$order);
        //echo 'SELECT * FROM '.self::$tabla.' '.$condicion.' '.$order;
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($producto->id,$producto->codigo_barras,$producto->nombre,
                $producto->descripcion,$producto->existencias,$producto->minimo,$producto->precio,
                $producto->precioTotal,$producto->costo,$producto->costoTotal,
                $producto->id_categoria,$producto->categoria);
        echo $stmt->error;
  
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($productos,clone $producto);
                $producto=new InventarioPasado();
                $stmt->bind_result($producto->id,$producto->codigo_barras,$producto->nombre,
                $producto->descripcion,$producto->existencias,$producto->minimo,$producto->precio,
                $producto->precioTotal,$producto->costo,$producto->costoTotal,
                $producto->id_categoria,$producto->categoria);
            }
        else{
            echo $stmt->error;
            return null;
        
        }
        
        
        return $productos;
    }
    
      
}
