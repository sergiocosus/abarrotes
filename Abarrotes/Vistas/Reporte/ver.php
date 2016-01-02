<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="/Abarrotes/library/plantilla_css.css" rel="stylesheet" />
    </head>
    <body>
        <?php include_once "library/BarraSuperior.php"; ?>
    <div id="cuadro_inicio" >
        <h3>Reportes</h3>
            <ul id="menuI">
                <a href="/Abarrotes/Reporte/Venta"><li>Reporte de venta</li> </a>
                <a href="/Abarrotes/Reporte/Reimpresion"><li>Reimpresión de tickets</li> </a>
                <a href="/Abarrotes/Reporte/EntradaSalida" ><li>Reporte de entradas y salidas</li></a>
                <a href="/Abarrotes/Reporte/Inventario" ><li>Reporte de inventario</li></a>
                <a href="/Abarrotes/Reporte/InventarioPasado" ><li>Reporte de inventario pasado</li></a>
                 <a href="/Abarrotes/Reporte/Minimo" ><li>Reporte de mínimos</li></a>
            </ul>
        </div> 
    <?php include 'library/MuestraUsuario.php'; ?>
    </body>
</html>