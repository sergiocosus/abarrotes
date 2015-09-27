<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="library/plantilla_css.css" rel="stylesheet" />
    </head>
    <body>
        <?php include_once "library/BarraSuperior.php";?> 
        <div id="cuadrito" class="">
            <h4>Aún no se ha creado un turno</h4>
            <h3>Crear Turno</h3>
            <form action="/Abarrotes/Turno/Iniciar" method="post">
                Cantidad Inicial<input name="cantidad_inicial" type="number" min="0" step="0.01"/>
                <input type="submit"/>
            </form>
        </div> 
        <?php include 'library/MuestraUsuario.php'; ?>
    </body>
</html>