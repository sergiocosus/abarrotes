<?php
include_once("MVC/SQLconexion.php");
class Minimos extends SQLconexion{
    public static $tabla = "minimos";
    public $id,$codigo_barras,$nombre,$descripcion,$existencias,$precio,
            $costo,$id_categoria,$categoria;
    public static $array=[['id','s'],['codigo_barras','s'],['nombre','s'],
        ['descripcion','s'],['existencias','d'],['minimo','i'],['faltante','d'],
        ['precio','d'],    
        ['costo','d'],
        ['categoria','s']
    ];
 
    static function obtenerTodos($condicion="",$condiciones=array(),$type="",$order=""){
        $productos=array();
        $producto=new Minimos();
     
        $stmt=self::prepare('   select p.id_producto as id,
    p.codigo_barras as codigo_barras,
    p.nombre as nombre, 
    p.descripcion as descripcion, 
    p.existencias as existencias,
    p.minimo as minimo,
    p.minimo - p.existencias as faltante,
    p.precio as precio, 
    p.costo as costo,
    c.nombre as categoria   

    from producto as p join categoria as c on (id_categoria=id)  '.$condicion.' '.$order);
        //echo 'SELECT * FROM '.self::$tabla.' '.$condicion.' '.$order;
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($producto->id,$producto->codigo_barras,$producto->nombre,
                $producto->descripcion,$producto->existencias,$producto->minimo,$producto->faltante,
                $producto->precio,$producto->costo,$producto->categoria);
        echo $stmt->error;
  
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($productos,clone $producto);
                $producto=new Minimos();
                $stmt->bind_result($producto->id,$producto->codigo_barras,$producto->nombre,
                $producto->descripcion,$producto->existencias,$producto->minimo,$producto->faltante,
                $producto->precio,$producto->costo,$producto->categoria);
            }
        else{
            echo $stmt->error;
        return null;
        
        }
        
        
        return $productos;
    }
    
      
}
