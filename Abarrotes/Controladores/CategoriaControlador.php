<?php
/**
 * Description of FotoControlador
 *Clase que trabaja todas las acciones de la sección Fotos
 * @author sergio
 */
include_once "Controladores/BaseControlador.php";
class CategoriaControlador extends BaseControlador {
    public  $modelo = "Categoria";
    function accionVer(){
        sesionNivel('a','e','g');
        include_once 'Vistas/Categoria/ver.php';
    }
    function actualizaInserta($opcion){
        sesionNivel('a');
        include_once 'Modelos/'.$this->modelo.'.php';
        $modelo=$this->modelo;
        $ok=true;
        for($i=1;$i<=1;$i++){
            if(!isset($_POST[Categoria::$array[$i][0]])){
                $ok=false;
                break;
            }
        }
        if($ok){ 
               
            $producto=new Categoria();
            if($opcion=="actualizar")
                $producto->id=$_POST[Categoria::$array[0][0]];
            $producto->nombre=$_POST[Categoria::$array[1][0]];
            
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
        sesionNivel('a','g');
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        if(isset($_POST[Categoria::$array[0][0]])){
            if($modelo::eliminar($_POST[Categoria::$array[0][0]])==0){
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
            $condicion.=" where nombre like CONCAT('%',?,'%')";
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
