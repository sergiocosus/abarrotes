<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="library/plantilla_css.css" rel="stylesheet" />
    </head>
    <body>
        <?php include_once "library/BarraSuperior.php"; ?>
    <div id="cuadro_inicio" class="">
            <ul id="menuI">
                <a href="/Abarrotes/Venta/Ver"><li>Ventas</li></a>
                <a href="/Abarrotes/Producto/Ver"><li>Productos</li></a>
                <a href="/Abarrotes/Cliente/Ver" ><li>Clientes</li></a>
                <a href="/Abarrotes/Reporte/Ver"><li>Reportes</li></a>
                <a href="/Abarrotes/Sesion/Logout"><li>Cerrar sesión</li></a>
            </ul>
        </div> 
        <?php include 'library/MuestraUsuario.php'; ?>
    </body>
</html>