<?php
/**
 * Description of FotoControlador
 *Clase que trabaja todas las acciones de la sección Fotos
 * @author sergio
 */
include_once "Controladores/BaseControlador.php";
class VentaControlador extends BaseControlador {
    public  $modelo = "Venta";
    function accionVer(){
        sesionNivel('a','e','g');
        if(isset($_SESSION['turno'])){
            include_once 'Vistas/Venta/ver.php';
        }else{
             header("Location:/Abarrotes/");
        }
        
    }
    function actualizaInserta($opcion){
        sesionNivel('a','e','g');
        
        include 'Modelos/'.$this->modelo.'.php';
        include 'Modelos/VentaProducto.php';
        include 'Modelos/Producto.php';
        $modelo=$this->modelo;
        $ok=true;
        if(!isset($_POST['id_producto'],$_POST['id_cliente'])){
            $ok=false;
        }
        if($ok){   
            $venta=new Venta();
            $venta->id_usuario=$_SESSION['usuario']->id_usuario;
            $count=count($_POST['cantidad']);
            $venta->total=0;  
            if(isset($_POST['cantidad'])){
                for($i=0;$i<$count;$i++){
                    $venta->total+=floatval($_POST['cantidad'][$i])*floatval($_POST['precioUnitario'][$i]);
                }
            }
            $venta->id_cliente=$_POST['id_cliente'];
            
            if($venta->insertar()===""){
                $n_venta=$venta->insert_id();
                $ventaProducto=new VentaProducto();
                for($i=0;$i<count($_POST['id_producto']);$i++){
                    $ventaProducto->id_producto=$_POST['id_producto'][$i];
                    $ventaProducto->id_venta=$n_venta;
                    $ventaProducto->cantidad=$_POST['cantidad'][$i];
                    $ventaProducto->precio=$_POST['precioUnitario'][$i];
                    $ventaProducto->insertar();
                    Producto::reducirExistencias($ventaProducto->id_producto,
                        $ventaProducto->cantidad);
                }
                echo json_encode($n_venta);
                
            }else{
                echo '-3';
            }
            
         }
         else{
             echo "-4";
         }
    }
    
    function accionEliminar(){
        sesionNivel('a','g');
        $modelo=$this->modelo;
        include 'Modelos/VentaProducto.php';
        include 'Modelos/Producto.php';
        include_once 'Modelos/'.$modelo.'.php';
        if(isset($_POST[Venta::$array[0][0]])){
            
            $ventaProductos=VentaProducto::obtenerTodos(' where id_venta=?',array(&$_POST['id_venta']),'i');
            $n_ventaProductos=count($ventaProductos);
            for($i=0;$i<$n_ventaProductos;$i++){
                Producto::modificarExistencias($ventaProductos[$i]->id_producto,
                    $ventaProductos[$i]->cantidad);
            }
           
            if($modelo::eliminar($_POST[Venta::$array[0][0]])==0){
                    echo "0";
                }else{
                    echo "1";
                }
        }else
            echo "-4";
    }
    
    function accionObtenerTodos(){
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        $array=$modelo::$array;
        $condiciones=array();
        $tipos='';
        $condicion='';
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
