<?php 
    if(!empty($GLOBALS['env']['password'])){
        if(!(isset($_POST['contrasena']) and $_POST['contrasena']==$GLOBALS['env']['password'])){
              header('Location: http://'.$GLOBALS['env']['main_domain']);
                exit;
        }
    }
    ?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="/Abarrotes/library/plantilla_css.css" rel="stylesheet" />
         <script src="/Abarrotes/library/jquery-1.10.2.min.js"></script>
    </head>
    <body>
        <div id="cuadro_inicio">
            <center><h2 style="color:white">"<?php echo $GLOBALS['env']['name']; ?>"</h2></center>
            <?php
                for($i=0;$i<$nUsuarios;$i++){?>
                    <form class="iniciarSesion" action="/Abarrotes/Sesion/Login" method="post">
                    <span>
                        <?php 
                        echo $usuarios[$i]->nombre,' ',
                                $usuarios[$i]->apellido_paterno,' ',$usuarios[$i]->apellido_materno;
                        ?>
                    </span>
                    <input name="id_usuario" type="hidden" value="<?php echo $usuarios[$i]->id_usuario;?>"/>
                    <div><span>Contraseña: </span><input name="contrasena" type="password"/><input type="submit"/></div>
                     </form>
            <?php  }?>
            <script>
                $('#cuadro_inicio form').on('click',function(){
                   $(this).children('div').show(500);
                   $(this).find('[type="password"]').focus();
                   console.log($(this).find('[type="password"]'));
                });
            </script>
        </div>
    </body>
</html>
