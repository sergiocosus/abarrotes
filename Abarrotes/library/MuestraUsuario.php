<footer>
    Sucursal: "<?php echo $GLOBALS['env']['name'] ?>" </br>
    Usuario Actual: <?php echo $_SESSION['usuario']->nombre,' ',
        $_SESSION['usuario']->apellido_paterno,' ',
        $_SESSION['usuario']->apellido_materno;
    echo '<br/> Nivel: ';
    switch ($_SESSION['usuario']->nivel){
        case 'a':
            echo 'Administrador';
            break;
        case 'e':
            echo 'Empleado';
            break;
        case 'g':
            echo 'Gerente';
            break;
    }
    ?>
</footer>
<div id="footerIscali">
    <img src="/Abarrotes/imagenes/iscali.png"/>
</div>
