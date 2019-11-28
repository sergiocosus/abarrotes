<?php
/**
 * Description of FotoControlador
 *Clase que trabaja todas las acciones de la sección Fotos
 * @author sergio
 */
include_once "Controladores/BaseControlador.php";
class ProductoControlador extends BaseControlador {
    public  $modelo = "Producto";
    function accionVer(){
        sesionNivel('a','e','g');
        include_once 'Vistas/Producto/ver.php';
    }
    
    
    function accionInsertar(){
        sesionNivel('a','e','g');
        $this->actualizaInserta("insertar");
    }
    
    function accionActualizar(){
        sesionNivel('a','g');
        $this->actualizaInserta("actualizar");
    }
    
    function actualizaInserta($opcion){
        include_once 'Modelos/'.$this->modelo.'.php';
        $modelo=$this->modelo;
        $ok=true;
        for($i=1;$i<=6;$i++){
            if($i==5)continue;
            if(!isset($_POST[Producto::$array[$i][0]])){
                $ok=false;
                break;
            }
        }
        if($ok){ 
               
            $producto=new Producto();
            if($opcion=="actualizar")
                $producto->id_producto=$_POST[Producto::$array[0][0]];
            $producto->codigo_barras=$_POST[Producto::$array[1][0]];
            $producto->nombre=$_POST[Producto::$array[2][0]];
            $producto->descripcion=$_POST[Producto::$array[3][0]];
            $producto->precio=$_POST[Producto::$array[4][0]];
        
            $producto->minimo=$_POST[Producto::$array[6][0]];
            $producto->unidad=$_POST[Producto::$array[7][0]];
             $producto->id_categoria=$_POST[Producto::$array[8][0]];
            if($producto->$opcion()===""){
                echo $producto->insert_id();
            }else{
                echo "-3";
            }
         }
         else{
             echo "-4";
         }
    }
    
    function accionEliminar(){
        sesionNivel('a');
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        if(isset($_POST[Producto::$array[0][0]])){
            if($modelo::eliminar($_POST[Producto::$array[0][0]])==0){
                    echo "0";
                }else{
                    echo "1";
                }
        }else
            echo "-4";
    }

    function accionOcultar(){
        sesionNivel('a');
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';

        if(isset($_POST['id_producto'])){
            if($modelo::ocultar($_POST['id_producto'], $_POST['oculto'] === 'true' ? 1 : 0)==0){
                    echo "0";
                }else{
                    echo "1";
                }
        }else
            echo "-4";
    }
    
    function accionBusqueda(){
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        $array=$modelo::$array;
        $condiciones=array();
        $tipos='';
        $condicion='';
        
        if(isset($_POST['nombre'])){
            $condicion.=" where nombre like CONCAT('%',?,'%') and oculto = 0";
            $nombre=$_POST['nombre'];
             $condiciones[]=&$nombre;
             $tipos.='s';
            $condicion.=" order by nombre"; 
        }
        
        $cliente=($modelo::obtenerTodos($condicion, $condiciones,$tipos));
        $json=  json_encode($cliente);

        echo $json;
    }
}
