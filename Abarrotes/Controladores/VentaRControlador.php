<?php
/**
 * Description of FotoControlador
 *Clase que trabaja todas las acciones de la sección Fotos
 * @author sergio
 */
include_once "Controladores/BaseControlador.php";
class VentaRControlador extends BaseControlador {
    public  $modelo = "VentaR";
    function accionObtenerTodos(){
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        $array=$modelo::$array;

        $condiciones=array();
        $tipos='';
        $condicion='';
        
           if(isset($_POST['usuario_nombre'])){
            $_POST['usuario.nombre']=$_POST['usuario_nombre'];
        }
        if(isset($_POST['usuario_apellido_paterno'])){
            $_POST['usuario.apellido_paterno']=$_POST['usuario_apellido_paterno'];
        }
        if(isset($_POST['cliente_nombre'])){
            $_POST['cliente.nombre']=$_POST['cliente_nombre'];
        }
        if(isset($_POST['venta_producto_cantidad'])){
            $_POST['venta.producto_cantidad']=$_POST['venta_producto_cantidad'];
        }
        if(isset($_POST['venta_producto_cantidad'])){
            $_POST['venta.producto_precio']=$_POST['venta_producto_precio'];
        }
        for($i=1;$i<count($array);$i++){
            if(isset($_POST[$array[$i][0]])){

                $condiciones[]=&$_POST[$array[$i][0]];
                $tipos.=$array[$i][1];
                if(count($condiciones)==1)
                    $condicion.='where '.$array[$i][0].'=?';
                else
                    $condicion.=' and '.$array[$i][0].'=?';
            }
        }
        if(isset($_POST['fecha_hora'],$_POST['fecha_hora'])){
            if(count($condiciones)==0){
               $condicion.=' where fecha_hora between ? and ?';
            }else{
               $condicion.=' and fecha_hora between ? and ?';
            }
            
            $fecha1=$_POST['fecha_hora']." 00:00";
            $fecha2=$_POST['fecha_hora2']." 23:59";
             $condiciones[]=&$fecha1;
             $condiciones[]=&$fecha2;
             $tipos.='ss';
            $condicion.=" order by id_venta";
        }
         
        $cliente=($modelo::obtenerTodos($condicion, $condiciones,$tipos));
        $json=  json_encode($cliente);

        echo $json;

    }
}
