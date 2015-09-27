<?php

include_once "Controladores/BaseControlador.php";
class TurnoControlador extends BaseControlador {
    public  $modelo = "Turno";
    function accionVer(){
        sesionNivel('a','e','g');
        include_once 'Vistas/Turno/ver.php';
    }
    function accionCantidadFinal(){
        if(!isset($_SESSION['turno'])){
            header("Location:/Abarrotes/");
        }
        sesionNivel('a','e','g');
        include_once 'Vistas/Turno/finalizarTurno.php';
    }
    function accionRevisarTurnos(){
        sesionNivel('a');
        include_once 'Vistas/Turno/revisarTurnos.php';
    }
    function accionIniciar(){
        sesionNivel('a','e','g');
        include_once 'Modelos/'.$this->modelo.'.php';
        $modelo=$this->modelo;
        
    
        $condiciones=array();
        $condiciones[]=&$_SESSION['usuario']->id_usuario;
        $tipos='i';
        $condicion='where id_usuario=? and finalizado="n"';
        $turno=(Turno::obtenerTodos($condicion, $condiciones,$tipos));
        if(count($turno)===0){
            if(isset($_SESSION['usuario'],$_POST['cantidad_inicial'])){   
                $turno=new Turno();
                $turno->id_usuario=$_SESSION['usuario']->id_usuario;
                $turno->cantidad_inicial=$_POST['cantidad_inicial'];
                if($turno->iniciar()==""){
                    $id=$turno->insert_id();
                    $_SESSION['turno']=Turno::obtenerTodos(' where id_turno='.$id)[0];
                    header("Location: /Abarrotes/");
                }else{
                    echo "-3";
                }
             }
             else{
                 echo "-4";
             }
        }else{
            echo 'Hay turno pendiente!';
        }
    }
    function accionTerminar(){
        sesionNivel('a','e','g');
        include_once 'Modelos/'.$this->modelo.'.php';
        $modelo=$this->modelo;

        if(isset($_SESSION['turno'],$_POST['cantidad_final'],$_POST['total_calculado']
                )){   
            $turno=new Turno();
            $turno=$_SESSION['turno'];
            $turno->cantidad_final=$_POST['cantidad_final'];
            $turno->total_calculado=$_POST['total_calculado'];

            if($turno->terminar()==""){
                unset($_SESSION['turno']);
                header('location:/Abarrotes/');
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
        if(isset($_POST['id_turno'])){
            if($modelo::eliminar($_POST['id_turno'])==0){
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
        for($i=0;$i<count($array);$i++){
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
               $condicion.=' where fecha_hora_inicio between ? and ?';
            }else{
               $condicion.=' and fecha_hora_inicio between ? and ?';
            }
            $fecha1=$_POST['fecha_hora']." 00:00";
            $fecha2=$_POST['fecha_hora2']." 23:59";
             $condiciones[]=&$fecha1;
             $condiciones[]=&$fecha2;
             $tipos.='ss';
            
        }
        $cliente=($modelo::obtenerTodos($condicion, $condiciones,$tipos));
        $json=  json_encode($cliente);

        echo $json;

    }
}
