<?php
/**
 * Description of FotoControlador
 *Clase que trabaja todas las acciones de la sección Fotos
 * @author sergio
 */
include_once "Controladores/BaseControlador.php";
class ProveedorControlador extends BaseControlador {
    public  $modelo = "Proveedor";
    function accionVer(){
        sesionNivel('a','e','g');
        include_once 'Vistas/Proveedor/ver.php';
    }
    function actualizaInserta($opcion){
        sesionNivel('a','e','g');
        include_once 'Modelos/'.$this->modelo.'.php';
        $modelo=$this->modelo;
        
        $ok=true;
        for($i=1;$i<=4;$i++){
            if(!isset($_POST[Proveedor::$array[$i][0]])){
                $ok=false;
                break;
            }
        }
        if($ok){   
            $proveedor=new Proveedor();
            if($opcion=="actualizar")
                $proveedor->id_proveedor=$_POST[Proveedor::$array[0][0]];
            $proveedor->nombre=$_POST[Proveedor::$array[1][0]];
            $proveedor->telefono=$_POST[Proveedor::$array[2][0]];
            $proveedor->celular=$_POST[Proveedor::$array[3][0]];
            $proveedor->direccion=$_POST[Proveedor::$array[4][0]];
          
           
            if($proveedor->$opcion()===""){
                echo '0';
            }else{
                echo "-3";
            }
         }
         else{
             echo "-4";
         }
    }
    
    function accionEliminar(){
        sesionNivel('a','e','g');
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        if(isset($_POST[Proveedor::$array[0][0]])){
            if($modelo::eliminar($_POST[Proveedor::$array[0][0]])==0){
                    echo "0";
                }else{
                    echo "1";
                }
        }else
            echo "-4";
    }
}
