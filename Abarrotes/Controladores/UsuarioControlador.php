<?php
/**
 * Description of FotoControlador
 *Clase que trabaja todas las acciones de la sección Fotos
 * @author sergio
 */
include_once "Controladores/BaseControlador.php";
class UsuarioControlador extends BaseControlador {
    public  $modelo = "Usuario";
    function accionVer(){
        sesionNivel('a','g');
        include_once 'Vistas/Usuario/ver.php';
    }
    
    function accionObtenerTodos(){
        sesionNivel('a','g');
        parent::accionObtenerTodos();
    }
    function actualizaInserta($opcion){
        sesionNivel('a','g');
        include_once 'Modelos/'.$this->modelo.'.php';
        $modelo=$this->modelo;
        
        $ok=true;
        for($i=1;$i<=7;$i++){
            if(!isset($_POST[Usuario::$array[$i][0]])){
                $ok=false;
                break;
            }
        }
        if($ok){   
            $usuario=new Usuario();
            if($opcion=="actualizar"){
                $usuario->id_usuario=$_POST[Usuario::$array[0][0]];
                sesionNivel('a');
            }
            $usuario->nombre=$_POST[Usuario::$array[1][0]];
            $usuario->apellido_paterno=$_POST[Usuario::$array[2][0]];
            $usuario->apellido_materno=$_POST[Usuario::$array[3][0]];
            $usuario->contrasena=$_POST[Usuario::$array[4][0]];
            $usuario->telefono=$_POST[Usuario::$array[5][0]];
            $usuario->celular=$_POST[Usuario::$array[6][0]];
            $usuario->direccion=$_POST[Usuario::$array[7][0]];
            $usuario->nivel=$_POST[Usuario::$array[8][0]];
           
            if($usuario->$opcion()===""){
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
        sesionNivel('a');
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        if(isset($_POST[Usuario::$array[0][0]])){
            if($modelo::eliminar($_POST[Usuario::$array[0][0]])==0){
                    echo "0";
                }else{
                    echo "1";
                }
        }else
            echo "-4";
    }
}
