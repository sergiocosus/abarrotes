<?php 
class AplicacionControlador {
    //Acció Index que muestra el menú principal que está en la vista index de la carpeta Aplicacion
    function accionIndex(){
        if(isset($_SESSION['usuario'])){
            if(isset($_SESSION['turno'])){
                $condiciones=array();
                $condiciones[]=&$_SESSION['turno']->id_turno;
                $tipos='i';
                $condicion='where id_turno=? and finalizado="n"';
                $turno=(Turno::obtenerTodos($condicion, $condiciones,$tipos));
               
                if(count($turno)===1){
                    include_once 'Vistas/Aplicacion/index.php';
                }else{
                    include_once 'Vistas/Turno/crearTurno.php';
                }
            }else{
                 $condiciones=array();
                $condiciones[]=&$_SESSION['usuario']->id_usuario;
                $tipos='i';
                $condicion='where id_usuario=? and finalizado="n"';
                $turno=(Turno::obtenerTodos($condicion, $condiciones,$tipos));
               
                if(count($turno)>=1){
                    $_SESSION['turno']=$turno[0];
                    include_once 'Vistas/Aplicacion/index.php';
                }else{
                    include_once 'Vistas/Turno/crearTurno.php';
                }
            }
        }else{
            
            header("Location: /Abarrotes/Sesion/Ingresar");
        
        }
    }
 
}   