<?php

class SesionControlador {
    function  accionLogin(){
        if(isset($_POST["id_usuario"]) && isset($_POST["contrasena"])){
            $condiciones=array();
            $condiciones[]=&$_POST['id_usuario'];
            $condiciones[]=&$_POST['contrasena'];
            $tipos='is';
            $condicion='where id_usuario=? and contrasena=? and nivel<>"n"';
            $usuario=(Usuario::obtenerTodos($condicion, $condiciones,$tipos));
            if(count($usuario)!==0){
                $_SESSION['usuario']=$usuario[0];
                header("Location: /Abarrotes/ ");
            }else{
                echo 'Error en la contraseña....';
            }
        }else{
            header("Location: " . $_SERVER['HTTP_REFERER'].'?error');
        }
    }
    function  accionLogin2(){   
        $_SESSION["admin"]='ok';
      
    }
    function accionLogout(){
        session_destroy();
        header("Location: /Abarrotes/ ");;
    }
    function accionIngresar(){
        $usuarios=Usuario::obtenerTodos(' where nivel<>"n"');
        $nUsuarios=count($usuarios);
        include 'Vistas/Sesion/ingresar.php';
    }
}