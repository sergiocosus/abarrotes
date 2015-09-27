<?php

abstract class BaseControlador {
    public  $modelo;
     
    function accionInsertar(){
        $this->actualizaInserta("insertar");
    }
    
    function accionActualizar(){
         $this->actualizaInserta("actualizar");
    }

  
      function accionObtener(){
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        $array=$modelo::$array;
       
        $condiciones=array();
        $tipos='';
        $condicion='';
        for($i=0;$i<count($array);$i++){
            if(isset($_POST[$array[$i][0]])){
               
                $condiciones[]=&$_POST[$array[$i][0]];
                $tipos.=$array[$i][1];
                if(count($condiciones)==1)
                    $condicion.='where '.$array[$i][0].'=?';
                else
                    $condicion.=' and '.$array[$i][0].'=?';
            }
        }
    
        $cliente=($modelo::obtenerPorCondicion($condicion, $condiciones,$tipos));
        $json=  json_encode($cliente);
        echo $json;
        
    }
    function accionObtenerTodos(){
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        
        $array=$modelo::$array;
       
        $condiciones=array();
        $tipos='';
        $condicion='';
        for($i=0;$i<count($array);$i++){
            if(isset($_POST[$array[$i][0]])){
                if($array[$i][0]==="nombre"){
                    $nombre=$_POST['nombre'];
                    $condiciones[]=&$nombre;
                    $tipos.=$array[$i][1];
                    if(count($condiciones)==1)
                        $condicion.="where nombre like CONCAT('%',?,'%')";
                    else
                        $condicion.=" and nombre like CONCAT('%',?,'%')";
                }else{
                    $condiciones[]=&$_POST[$array[$i][0]];
                    $tipos.=$array[$i][1];
                    if(count($condiciones)==1)
                        $condicion.='where '.$array[$i][0].'=?';
                    else
                        $condicion.=' and '.$array[$i][0].'=?';
                }
            }
        }
        $order="";
        $arrayOrder=array('orderExistencia'=>'existencias','orderPrecio'=>'precio');
        foreach($arrayOrder  as $orderTipo => $arrayValor){
            if(isset($_POST[$orderTipo])){
                switch ($_POST[$orderTipo]){
                case 'no':break;
                case 'asc':
                     if($order!=""){
                        $order.=',';
                    }else{
                        $order='order by ';
                    }
                    $order.=$arrayValor;
                    break;
                case 'desc':
                     if($order!=""){
                        $order.=',';
                    }else{
                        $order='order by ';
                    }
                    $order.=$arrayValor.' desc';
                    break;
                }
            }
        }
        
        if(isset($_POST['existencias_min'])){
            $condiciones[]=&$_POST['existencias_min'];
            $tipos.='d';
            if(count($condiciones)==1)
                $condicion.='where existencias>= ?';
            else
                $condicion.=' and existencias>= ?';
        }
        
         if(isset($_POST['existencias_max'])){
            $condiciones[]=&$_POST['existencias_max'];
            $tipos.='d';
            if(count($condiciones)==1)
                $condicion.='where existencias<= ?';
            else
                $condicion.=' and existencias<= ?';
        }
        $cliente=($modelo::obtenerTodos($condicion, $condiciones,$tipos,$order));
        $json=  json_encode($cliente);
        
        echo $json;
        
    }
  
}
