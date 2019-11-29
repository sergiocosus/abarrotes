<?php
include_once("MVC/SQLconexion.php");
class Producto extends SQLconexion{
    public static $tabla = "producto";
    public $id_producto,$codigo_barras,$nombre,$descripcion,$precio,$existencias,$minimo,$unidad,$id_categoria,$costo,$oculto;
    public static $array=[['id_producto','s'],['codigo_barras','s'],['nombre','s'],
    ['descripcion','s'],['precio','d'],['existencias','d'],['minimo','i'],['unidad','s'],['id_categoria','i'],
        ['id_categoria','i']
   ];
 
    static function obtenerPorCondicion($condicion,$condiciones,$type){
        $producto = new Producto();
        $stmt=self::prepare('SELECT * FROM '.self::$tabla." $condicion");
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($producto->id_producto,$producto->codigo_barras,$producto->nombre,
                $producto->descripcion,$producto->precio,$producto->existencias,
                $producto->unidad,$producto->id_categoria,$producto->costo,$producto->minimo, $producto->oculto);
        if($stmt->execute()){
            if ($renglon = $stmt->fetch())      
                return $producto;
        }
        else    
            return null;
    }
    static function obtenerTodos($condicion="",$condiciones=array(),$type="",$order=""){
        $productos=array();
        $producto=new Producto();
        $stmt=self::prepare('SELECT * FROM '.self::$tabla.' '.$condicion.' '.$order);
        //echo 'SELECT * FROM '.self::$tabla.' '.$condicion.' '.$order;
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($producto->id_producto,$producto->codigo_barras,$producto->nombre,
                $producto->descripcion,$producto->precio,$producto->existencias,
                $producto->unidad,$producto->id_categoria,$producto->costo,$producto->minimo, $producto->oculto);
        echo $stmt->error;
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($productos,clone $producto);
                $producto=new Producto();
                $stmt->bind_result($producto->id_producto,$producto->codigo_barras,$producto->nombre,
                $producto->descripcion,$producto->precio,$producto->existencias,
                $producto->unidad,$producto->id_categoria,$producto->costo,$producto->minimo, $producto->oculto);
            }
        else
            return null;
        
        return $productos;
    }

    function actualizar(){
        if($this->codigo_barras==""){
            $this->codigo_barras=null;
        }
        //var_dump($this);
        $result=self::prepare('UPDATE '.static::$tabla.' SET codigo_barras=?,'
                . 'nombre=?,descripcion=?,precio=?,minimo=?,unidad=?,id_categoria=? WHERE id_producto=?');
        $result->bind_param('sssdisii',$this->codigo_barras,  $this->nombre,
                $this->descripcion,$this->precio,$this->minimo,
                $this->unidad,$this->id_categoria,$this->id_producto);    
        $result->execute();
        
     
        echo $result->error;
        return $result->error; 
    }
    
    static function reducirExistencias($id_producto,$cantidad){
        $result=self::prepare('UPDATE '.static::$tabla.
                ' SET existencias = existencias + (-?) WHERE id_producto=?');
        
        $result->bind_param('di',$cantidad,$id_producto);  
        $result->execute();
        echo $result->error;
        return $result->error;
    }
    
    static function modificarExistencias($id_producto,$cantidad){
        $result=self::prepare('UPDATE '.static::$tabla.
                ' SET existencias = existencias + (?) WHERE id_producto=?');
        $cantidadF=(float)$cantidad;
        $result->bind_param('di',$cantidadF,$id_producto);  
        $result->execute();
        echo $result->error;
        return $result->error;
    }
    
    function insertar(){
        if($this->codigo_barras==""){
            $this->codigo_barras=null;
        }
        if($this->unidad==""){
            $this->unidad='u';
        }
        $result=self::prepare('INSERT INTO '.static::$tabla.' (codigo_barras,nombre,'
                . 'descripcion,precio,minimo,unidad,id_categoria) '
                . 'VALUES (?,?,?,?,?,?,?)');
        $result->bind_param('sssdisi',  $this->codigo_barras,$this->nombre,
                $this->descripcion,$this->precio,$this->minimo,
                $this->unidad,$this->id_categoria);
        $result->execute();
        if($result->error)
            echo $result->error;
        return $result->error;
    }
    
    static function eliminar($id){
        
        $result=self::prepare('DELETE FROM '.static::$tabla.' WHERE id_producto=?');
        $result->bind_param('s',$id);
        $result->execute();
        echo $result->error;
        return $result->errno;
    }

    static function ocultar($id, $oculto){
        $result=self::prepare('UPDATE '.static::$tabla.' set oculto=?  WHERE id_producto=?');
        $result->bind_param('dd', $oculto, $id);
        $result->execute();
        echo $result->error;
        return $result->errno;
    }
}
