<?php
include_once("MVC/SQLconexion.php");
class Inventario extends SQLconexion{
    public static $tabla = "inventario";
    public $id,$codigo_barras,$nombre,$descripcion,$existencias,$precio,
            $precioTotal,$costo,$costoTotal,$id_categoria,$categoria;
    public static $array=[['id','s'],['codigo_barras','s'],['nombre','s'],
        ['descripcion','s'],['existencias','d'],['minimo','i'],['precio','d'],
        ['precioTotal','d'],['costo','d'],
        ['costoTotal','d'],['id_categoria','i'],['categoria','s']
    ];
 
    static function obtenerTodos($condicion="",$condiciones=array(),$type="",$order=""){
        $productos=array();
        $producto=new Inventario();
       /* $stmt=self::prepare(' select * from inventario  '.$condicion.' '.$order);
        * */
        $stmt=self::prepare('   select p.id_producto as id,
    p.codigo_barras as codigo_barras,
    p.nombre as nombre, 
    p.descripcion as descripcion, 
    p.existencias as existencias,
    p.minimo as minimo,
    p.precio as precio, 
    p.existencias*p.precio as precioTotal, 
    p.costo as costo,
    p.existencias*p.costo as costoTotal,
    c.id as id_categoria,
    c.nombre as categoria   

    from producto as p join categoria as c on (id_categoria=id)  '.$condicion.' '.$order);
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
                $producto=new Inventario();
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
