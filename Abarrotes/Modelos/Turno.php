<?php
include_once("MVC/SQLconexion.php");
class Turno extends SQLconexion{
    public static $tabla = "turno";
    public $id_turno,$id_usuario,$fecha_hora_inicio,$fecha_hora_fin,
            $cantidad_inicial,$deuda,$total_calculado,$cantidad_final,$finalizado;
    public static $array=[['id_turno','i'],['id_usuario','i'],['fecha_hora_inicio','s'],
['fecha_hora_fin','s'],['cantidad_inicial','d'],['deuda','d'],['total_calculado','d'],['cantidad_final','d'],['finalizado','s']];
           
        
    static function obtenerTodos($condicion="",$condiciones=array(),$type=""){
        $turnos=array();
        $turno=new Turno();
        $stmt=self::prepare('SELECT * FROM '.self::$tabla.' '.$condicion.' ');
        echo $stmt->error;
        if(count($condiciones)!=0)
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $condiciones));
        $stmt->bind_result($turno->id_turno,$turno->id_usuario,$turno->fecha_hora_inicio,
                $turno->fecha_hora_fin,$turno->cantidad_inicial,$turno->deuda,$turno->total_calculado,$turno->cantidad_final,$turno->finalizado);
        if($stmt->execute())
            while($stmt->fetch()){
                array_push($turnos,clone $turno);
                $turno=new Usuario();
                $stmt->bind_result($turno->id_turno,$turno->id_usuario,$turno->fecha_hora_inicio,
                $turno->fecha_hora_fin,$turno->cantidad_inicial,$turno->deuda,$turno->total_calculado,$turno->cantidad_final,$turno->finalizado);
            }
        else
            return null;
        return $turnos;
    }

    function terminar(){
        $result=self::prepare('UPDATE '.static::$tabla.' SET fecha_hora_fin=CURRENT_TIMESTAMP,'
                . 'cantidad_final=?,total_calculado=?,deuda=?,finalizado="s" WHERE id_turno=?');
        $result->bind_param('dddi',$this->cantidad_final, $this->total_calculado ,$this->deuda, $this->id_turno);    
        $result->execute();
        var_dump($this);
        return $result->error; 
    } 
    function iniciar(){
        $result=self::prepare('INSERT INTO '.static::$tabla.' (id_usuario,'
                . 'cantidad_inicial) '
                . 'VALUES (?,?)');
        $result->bind_param('ss',  $this->id_usuario,$this->cantidad_inicial);
        $result->execute();
        echo $result->error;   
        return $result->error;
    }
    
   
    
    static function eliminar($id){
        $result=self::prepare('DELETE FROM '.static::$tabla.' WHERE id_turno=?');
        $result->bind_param('i',$id);
        $result->execute();
        return $result->errno;
    }
    

}
