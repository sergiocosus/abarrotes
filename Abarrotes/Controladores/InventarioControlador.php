<?php
/**
 * Description of FotoControlador
 *Clase que trabaja todas las acciones de la sección Fotos
 * @author sergio
 */
include_once "Controladores/BaseControlador.php";
class InventarioControlador extends BaseControlador {
    public  $modelo = "Inventario";
    
    
    function accionObtenerMinimos(){
        $this->modelo="Minimos";
        $this->accionObtenerTodos("minimo");
    }
   function accionObtenerTodos($minimo=NULL){
        $modelo=$this->modelo;
        include_once 'Modelos/'.$modelo.'.php';
        
        $array=$modelo::$array;
       
        $condiciones=array();
        $tipos='';
        $condicion='';
        for($i=0;$i<count($array);$i++){
            if(isset($_POST[$array[$i][0]])){
                if($array[$i][0]==="nombre"){
                    $nombre=$_POST['nombre'];
                    $condiciones[]=&$nombre;
                    $tipos.=$array[$i][1];
                    if(count($condiciones)==1)
                        $condicion.="where nombre like CONCAT('%',?,'%')";
                    else
                        $condicion.=" and nombre like CONCAT('%',?,'%')";
                }else{
                    $condiciones[]=&$_POST[$array[$i][0]];
                    $tipos.=$array[$i][1];
                    if(count($condiciones)==1)
                        $condicion.='where '.$array[$i][0].'=?';
                    else
                        $condicion.=' and '.$array[$i][0].'=?';
                }
            }
        }
        $order="";
        $arrayOrder=array('orderExistencia'=>'existencias','orderPrecio'=>'precio',
            'orderNombre'=>'nombre','orderCategoria'=>'categoria');
        foreach($arrayOrder  as $orderTipo => $arrayValor){
            if(isset($_POST[$orderTipo])){
                switch ($_POST[$orderTipo]){
                case 'no':break;
                case 'asc':
                case 'desc':    
                    if($order!=""){
                        $order.=',';
                    }else{
                        $order='order by ';
                    }
                    $order.=$arrayValor;
                    if($_POST[$orderTipo]=='desc'){
                        $order.=' desc';
                    }
                    break;
                }
            }
        }
        
        if(isset($_POST['existencias_min'])){
            $condiciones[]=&$_POST['existencias_min'];
            $tipos.='d';
            if(count($condiciones)==1)
                $condicion.='where existencias>= ?';
            else
                $condicion.=' and existencias>= ?';
        }
        
         if(isset($_POST['existencias_max'])){
            $condiciones[]=&$_POST['existencias_max'];
            $tipos.='d';
            if(count($condiciones)==1)
                $condicion.='where existencias<= ?';
            else
                $condicion.=' and existencias<= ?';
        }
        
         if($minimo!=null){
            
            if(count($condiciones)==1)
                $condicion.='where existencias<= minimo';
            else
                $condicion.=' and existencias<= minimo';
        }
        $cliente=($modelo::obtenerTodos($condicion, $condiciones,$tipos,$order));
        $json=  json_encode($cliente);
        
        echo $json;
        
    }
}
