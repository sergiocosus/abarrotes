<div id="ticket">
    <h1>ABARROTES</h1>

    <div id="div-venta">
        #Venta <span id="num-venta"></span>
    </div>
    <div id="div-fecha">
        <span id="fecha-hora"></span><br>
    </div>
    <br>
    <hr>
    <div id="divTablaTicket">
        <table id="tablaTicket">
            <tr id="cabeceras-ticket">
                <th>Cant</th>
                <th>Artículo</th>
                <th>Precio Unit.</th>
                <th>Precio Total</th>
            </tr>
        </table>
    </div>
    <hr>
    <table id="datosTicket">
        <tr>
            <td><b>Total</b></td>
            <td><span id="total"></span></td>
        </tr>
        <tr>
            <td>
                IVA Incluido
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
        </tr>
        <tr>
            <td><b>Efectivo</b></td>
            <td><span id="efectivo"></span></td>
        </tr>
        <tr>
            <td><b>Cambio</b></td>
            <td><span id="cambio"></span></td>
        </tr>
    </table>
    <br><br>
    <hr>
    Artículos <span id="numArticulos"></span><br>
    Le atendió <span id="cajero"><?php 
        echo $_SESSION['usuario']->nombre.' '.$_SESSION['usuario']->apellido_paterno.
                ' '.$_SESSION['usuario']->apellido_materno;
    ?> </span><br><br>
    ¡GRACIAS POR SU COMPRA!
</div>