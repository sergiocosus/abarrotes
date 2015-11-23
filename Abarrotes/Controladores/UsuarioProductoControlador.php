<?php
/**
 * Description of FotoControlador
 *Clase que trabaja todas las acciones de la sección Fotos
 * @author sergio
 */
include_once "Controladores/BaseControlador.php";
class UsuarioProductoControlador extends BaseControlador {
    public  $modelo = "UsuarioProducto";
    function accionVer(){
        sesionNivel('a','e','g');
        include_once 'Vistas/Producto/ver.php';
    }
    function actualizaInserta($opcion){
        sesionNivel('a','g','e');
        include_once 'Modelos/'.$this->modelo.'.php';
        $modelo=$this->modelo;
 
        if(isset($_POST['id_producto'],$_POST['cantidad'],$_POST['costo'],$_POST['tipo'])){
               
            $producto=new UsuarioProducto();

            $producto->id_producto=$_POST['id_producto'];
            $producto->cantidad=$_POST['cantidad'];
            $producto->costo=$_POST['costo'];
            $producto->id_usuario=$_SESSION['usuario']->id_usuario;
            $producto->tipo = $_POST['tipo'];
           // var_dump($producto);
            if($producto->cantidad<0){
                sesionNivel('a');
            }            
            if($producto->$opcion()===""){
                 include 'Modelos/Producto.php';
                 if(Producto::modificarExistencias($producto->id_producto, $producto->cantidad)==""){
                    echo '0';
                 }
                else{
                    echo '-3';
                }
            }else{
                echo "-3";
            }
         }
         else{
             echo "-4";
         }
    }
    
    function accionEliminar(){
        sesionNivel('a','g');
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
}
