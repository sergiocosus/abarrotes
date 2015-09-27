<?php
include_once("MVC/SQLconexion.php");
class Venta extends SQLconexion{
    public static $tabla = "venta";
    public $id_venta,$id_usuario,$fecha_hora,$total;
    public static $array=[['id_venta','i'],['id_usuario','i'],['id_cliente','i'],['total','d']
    ];
            

        
    static function obtenerTodos($condicion="",$condiciones=array(),$type=""){
        $ventas=array();
        $venta=new Venta();
        $stmt=self::prepare('SELECT * FROM '.self::$tabla.' '.$condicion.' ');
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($venta->id_venta,$venta->id_usuario,$venta->id_cliente,$venta->fecha_hora,$venta->total);
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($ventas,clone $venta);
                $venta=new Venta();
                $stmt->bind_result($venta->id_venta,$venta->id_usuario,$venta->id_cliente,$venta->fecha_hora,$venta->total);
            }
        else
            return null;
        return $ventas;
    }
    
    static function obtenerHastaLaFecha(){
       return Venta::obtenerTodos(' where id_usuario='.$_SESSION['usuario']->id_usuario
               .' and fecha_hora between "'
               .$_SESSION['turno']->fecha_hora_inicio.'" and CURRENT_TIMESTAMP');
    }

    function actualizar(){
        $result=self::prepare('UPDATE '.static::$tabla.' SET n_auto=?,'
                . 'RFC=? WHERE n_venta=?');
        $result->bind_param('isdi',$this->id_usuario,  $this->fecha_hora,
                $this->total,$this->id_venta);    
        $result->execute();
        return $result->error; 
    } 
    function insertar(){
        $result=self::prepare('INSERT INTO '.static::$tabla.' (id_usuario,id_cliente,'
                .'total) '
                . 'VALUES (?,?,?)');
        $result->bind_param('iid',  $this->id_usuario,$this->id_cliente,
                $this->total);
        $result->execute();
        echo $result->error;
        return $result->error;
    }
    
    static function eliminar($id){
        
        $result=self::prepare('DELETE FROM '.static::$tabla.' WHERE id_venta=?');
        $result->bind_param('i',$id);
        $result->execute();
        echo $result->error;
        return $result->errno;
    }
    

}
