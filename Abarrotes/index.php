<?php 

$path='';
include '../env.php';
function dameURL(){
    $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $url;
} 

error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'Modelos/Usuario.php';
include 'Modelos/Turno.php';
function salir(){
    SQLconexion::desconectar();
    die('No se tiene los permisos para realizar esta acción!');
}


function sesionNivel(){
    if(isset($_SESSION["usuario"])){
        $niveles=func_get_args();
        $cNiveles=count($niveles);
        for($i=0;$i<$cNiveles;$i++){
            if($_SESSION['usuario']->nivel==$niveles[$i]){
                return;
            }
        }
        salir();
    }else{
        salir();
    }
}
    
include_once("MVC/SQLconexion.php");
SQLconexion::conectar();
$urlArray = array();
session_start();


if(isset($_GET['url'])) {
    $url = $_GET['url'];
    $urlArray = explode("/",$url);
    if($urlArray[count($urlArray)-1]=="")
        unset($urlArray[count($urlArray)-1]);

    if(isset($GLOBALS['env']['nginx'])) {
        unset($urlArray[0]);
        unset($urlArray[1]);
        $urlArray = array_values($urlArray);
    }



    if(file_exists( "Controladores/$urlArray[0]"."Controlador.php"))
        require "Controladores/$urlArray[0]"."Controlador.php";
    else{
        header('Location: ../');
        SQLconexion::desconectar();
        exit();
    }
    $controlador = "$urlArray[0]"."Controlador";
    $accion_general = "accion"."$urlArray[1]";
}else {
    require_once("Controladores/AplicacionControlador.php");
    $controlador = "AplicacionControlador";
    $accion_general = "accionIndex";

}


if(!class_exists($accion_general))
    $objeto_general = new $controlador;
else
    header('Location: ../');


 if (method_exists($objeto_general,$accion_general)) {
	header('Content-Type: text/html; charset=utf-8');
         $objeto_general->$accion_general(NULL);
    } else {
        SQLconexion::desconectar();
        header('Location: ../');
    }

SQLconexion::desconectar();
