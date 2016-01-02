<?php
/**
 * Description of FotoControlador
 *Clase que trabaja todas las acciones de la sección Fotos
 * @author sergio
 */
include_once "Controladores/BaseControlador.php";
class ReporteControlador extends BaseControlador {
    public  $modelo = "Reporte";
    function accionVer(){
        sesionNivel('a','e','g');
        include_once 'Vistas/Reporte/ver.php';
    }
    
    function accionVenta(){
        sesionNivel('a');
        include 'Vistas/Reporte/venta.php';
    }
    
    function accionEntradaSalida(){
        sesionNivel('a','g'); 
        include 'Vistas/Reporte/entradaSalida.php';
    }
    function accionInventario(){
        sesionNivel('a','g');
        include 'Vistas/Reporte/inventario.php';
    }

    function accionInventarioPasado(){
        sesionNivel('a','g');
        include 'Vistas/Reporte/inventarioPasado.php';
    }

    function accionReimpresion(){
        sesionNivel('a','e','g');
        include 'Vistas/Reporte/venta_reimpresion.php';
    }
    function accionMinimo(){
        sesionNivel('a','g');
        include 'Vistas/Reporte/minimo.php';
    }
}
