<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="/Abarrotes/library/jquery-1.10.2.min.js"></script>
        <link href="/Abarrotes/library/plantilla_css.css" rel="stylesheet" />
    </head>
    <body>
        
        <?php include_once "library/BarraSuperior.php";
        include 'Modelos/Venta.php';
        include 'Modelos/EntradaSalida.php';
        $ventas=Venta::obtenerHastaLaFecha();
        $altas= EntradaSalida::obtenerHastaLaFecha();
        $total_alta=0;
        $total=0;
        foreach($altas as $alta){
            $total_alta+=floatval($alta->usuario_producto_cantidad)*$alta->costo;
        }
        foreach ($ventas as $venta){
            $total+=$venta->total;
        }
        ?> 
        <div id="cuadrito" class="">
            <h3>Terminar Turno / Corte de Caja</h3>
            <form id="terminarTurno" action="/Abarrotes/Turno/Terminar" method="post">
                <table>
                    <tr>
                        <td>
                           Fecha Inicial 
                        </td>
                        <td>
                            <input  readonly="readonly" 
                                           value="<?php echo $_SESSION['turno']->fecha_hora_inicio;?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Cantidad Inicial
                        </td>
                        <td>
                            $<input  readonly="readonly" 
                                            value="<?php echo $_SESSION['turno']->cantidad_inicial;?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Venta calculada
                        </td>
                        <td>
                            $<input  readonly="readonly" 
                                            value="<?php echo $total;?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Inventario calculado
                        </td>
                        <td>
                            $<input  readonly="readonly" 
                                            value="<?php echo $total_alta;?>"/>
                        </td>
                    </tr>
                  
                    <tr>
                        <td>
                            TOTAL calculado
                        </td>
                        <td>
                            $<input   name="total_calculado" readonly="readonly" 
                                            value="<?php echo $total+$_SESSION['turno']->cantidad_inicial?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Cantidad final
                        </td>
                        <td>
                            $<input name="cantidad_final" 
                                           type="number" min="0" step="0.01" value=""/>
                        </td>
                    
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit"/>
                        </td>
                    </tr>
                    
            </form>
        </div> 
        <?php include 'library/MuestraUsuario.php'; ?>
        <script>
            $('#terminarTurno').submit(function(e){
                console.log("hola");
                return confirm("¿Está seguro que desea enviar?");
            });
            
            
           
        </script>
        
    </body>
</html>