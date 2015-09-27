<ul id="menu">
    <?php if($_SESSION['usuario']->nivel=='a'){?><a href="/Abarrotes/Usuario/Ver"><li>Usuarios</li></a><?php } ?>
    <a href="/Abarrotes/Venta/Ver"><li>Ventas</li></a>
    <a href="/Abarrotes/Producto/Ver" ><li>Productos</li></a>
    <a href="/Abarrotes/Cliente/Ver"><li>Clientes</li></a>
    <a href="/Abarrotes/Reporte/Ver"><li>Reportes</li></a>
    <a href="/Abarrotes/Turno/Ver"><li>Turno</li></a>
    <a href="/Abarrotes/Sesion/Logout"><li>Cerrar sesión</li></a>
</ul>