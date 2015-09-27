<?php
include_once "Controladores/BaseControlador.php";
class ClienteControlador extends BaseControlador {
    public  $modelo = "Cliente";
    function accionVer(){
        sesionNivel('a','e','g');
        include_once 'Vistas/Cliente/ver.php';
    }
    function actualizaInserta($opcion){
        sesionNivel('a','e','g');
        include_once 'Modelos/'.$this->modelo.'.php';
        $modelo=$this->modelo;
        
        $ok=true;
        for($i=1;$i<=4;$i++){
            if(!isset($_POST[Cliente::$array[$i][0]])){
                $ok=false;
                break;
            } 
        } 
        if($ok){   
            $cliente=new Cliente();
            if($opcion=="actualizar")
                $cliente->id_cliente=$_POST[Cliente::$array[0][0]];
            $cliente->nombre=$_POST[Cliente::$array[1][0]];
            $cliente->telefono=$_POST[Cliente::$array[2][0]];
            $cliente->celular=$_POST[Cliente::$array[3][0]];
            $cliente->direccion=$_POST[Cliente::$array[4][0]];
          
           
            if($cliente->$opcion()===""){
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
        if(isset($_POST[Cliente::$array[0][0]])){
            if($modelo::eliminar($_POST[Cliente::$array[0][0]])==0){
                    echo "0";
                }else{
                    echo "1";
                }
        }else
            echo "-4";
    }
}
