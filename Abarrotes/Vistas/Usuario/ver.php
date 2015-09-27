
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="/Abarrotes/library/jquery-1.10.2.min.js"></script>
        <script src="/Abarrotes/library/jquery.form.min.js">  </script>
        <script src="/Abarrotes/library/Modelos.js">  </script>
        <link rel="stylesheet" type="text/css" href="/Abarrotes/library/plantilla_css.css"/>
    </head>
    <body>
         <?php include_once "library/BarraSuperior.php"; ?>
     
        <div id="cuadrito">
            <form id="formInsertar" action="/Abarrotes/Usuario/Insertar" method="post">
                <h3>Insertar Usuario</h3>
            </form>
           <hr/>
            <form id="formObtenerVarios" action="/Abarrotes/Usuario/ObtenerTodos" method="post">
                <<table>
                    <tr>
                        <th colspan="8">
                            Consuta de usuarios
                        </th>
                    </tr>
                    <tr>
                        <th>#Usuario</th>
                        <th>Nombre</th>
                        <th>ApellidoP</th>
                        <th>ApellidoM</th>
                        <th>Teléfono</th>
                        <th>Celular</th>
                        <th>Dirección</th>
                        <th>Tipo</th>
                        
                    </tr>
                    <tr id="camposObtenerVarios">
                    </tr>
                </table>

            </form>

            <table id="lista"> 
                
                
            </table>
        </div>
        <script src="/Abarrotes/library/script.js"></script>
         <script> 
             
             
            var lista=$('#lista');
            var formInsertar=$('#formInsertar');
            var formActualizar=$('#formActualizar');
            var formObtenerVarios=$('#formObtenerVarios');
            var formObtener=$('#formObtener');
            var camposObtenerVarios=$('#camposObtenerVarios');
      
            var th=$('<tr>').html(
                    ' <th>ID</th> <th>Nombre</th> <th>Apellido Paterno</th>\n\
        <th>Apellido Materno</th><th>Contraseña</th><th>Teléfono</th>\n\
<th>Celular</th><th>Dirección</th><th>Nivel</th><th>Fecha de Alta</th>\n\
<th></th><th></th>');
            lista.append(th);
            
            ////Menú Insertar///////////
            formInsertar.append(Usuario.nombre(),'</br>',
            Usuario.apellido_paterno(),'</br>',
                 Usuario.apellido_materno(),'</br>',
                 Usuario.contrasena(),'</br>',
                 Usuario.telefono(),'</br>',
                 Usuario.celular(),'</br>',
                 Usuario.direccion(),'</br>',
                 Usuario.nivel(),'</br>',
                 Modelo.agregar()
            );
    
            
            ////Menú Consulta////////////
            var checkbox=[];
            var span=[];
            var td=[];
            for(var i=0;i<8;i++){
                checkbox[i]=$('<input>',{type:'checkbox'});
                span[i]=$('<span>');
                td[i]=$('<td>').append(checkbox[i],span[i]);
                camposObtenerVarios.append(td[i]);
            }
            span[0].append(Usuario.id_usuario().prop('disabled',true).prop('readonly',false));
            span[1].append(Usuario.nombre().prop('disabled',true));
            span[2].append(Usuario.apellido_paterno().prop('disabled',true));
            span[3].append(Usuario.apellido_materno().prop('disabled',true));
            
            span[4].append(Usuario.telefono().prop('disabled',true));
            span[5].append(Usuario.celular().prop('disabled',true));
            span[6].append(Usuario.direccion().prop('disabled',true));
            span[7].append(Usuario.nivel().prop('disabled',true));
            
            camposObtenerVarios.append($('<td>').append($('<span>').append(Modelo.consultar()))); 
           
      
            camposObtenerVarios.find('span').on('click',function(){
                $(this).children('input').removeAttr('disabled');
                $(this).prev().prop('checked',true);
                $(this).children('input').focus();
                console.log("hola");
            });
            camposObtenerVarios.find(':checkbox').on('click',function(){
                 $(this).next().children().prop('disabled',!$(this).prop('checked'));
            });
            var opcionesConsulta = { 
                beforeSubmit:  antesConsultaCompleta,  // pre-submit callback 
                success:       despuesConsultaCompleta  // post-submit callback   
            }; 
            function antesConsultaCompleta(formData, jqForm, options) { 
                var despuesConsultaCompleta = $.param(formData); 
                return true; 
            } 
            function despuesConsultaCompleta(responseText, statusText, xhr, $form)  { 
                formActualizar =$('#formActualizarCliente');
                console.log(responseText);
                json=JSON.parse(responseText);
                lista.empty();
                lista.append(th);
                if(json.length==0){
                    alert("No se encontró ningún usuario");
                }
                else{ 
                    for(var i=0; i<json.length;i++){
                        var formElimina=$('<form>',{'class':'botonEliminar',action:"/Abarrotes/Usuario/Eliminar",method:"post"});
                        hiddenId=Usuario.id_usuario(json[i].id_usuario).attr('type','hidden');
                        
                        submitElimina=$('<input>',{type:'submit',value:"X"});
                        formElimina.append(hiddenId,submitElimina);
                        
                        var form=$('<form>',{action:"/Abarrotes/Usuario/Actualizar",
                            method:"post",id:"form"+i});
                        
                        submit=$('<input>',{type:'submit',value:"✓"});
                        var tr=$('<tr>').append(
                            
                                form.append($('<td>').append(Usuario.id_usuario(json[i].id_usuario).attr('form','form'+i))),
                                $('<td>').append(Usuario.nombre(json[i].nombre).attr('form','form'+i)),
                                $('<td>').append(Usuario.apellido_paterno(json[i].apellido_paterno).attr('form','form'+i)),
                                $('<td>').append(Usuario.apellido_materno(json[i].apellido_materno).attr('form','form'+i)),
                                $('<td>').append(Usuario.contrasena(json[i].contrasena).attr('form','form'+i)),
                                $('<td>').append(Usuario.telefono(json[i].telefono).attr('form','form'+i)),
                                $('<td>').append(Usuario.celular(json[i].celular).attr('form','form'+i)),
                                $('<td>').append(Usuario.direccion(json[i].direccion).attr('form','form'+i)),
                                $('<td>').append(Usuario.nivel(json[i].nivel).attr('form','form'+i)),
                                $('<td>').append($('<input>',{type:'datetime',readonly:'readlonly',value:json[i].fecha_hora_de_alta}).attr('form','form'+i)),
                                $('<td>').append(submit.attr('form','form'+i)),
                                $('<td>').append(formElimina));
                        
                        formElimina.ajaxForm(opcionesEliminar);
                        form.ajaxForm(opcionesActualizar);
                        lista.append(tr);                                
                    }
                }
            } 
            
            $(document).ready(function() { 
                formObtenerVarios.ajaxForm(opcionesConsulta);
                formInsertar.ajaxForm(opcionesInsertar);

            });
           
           
    </script>
    <style>
        .botonEliminar{
            display: inline-block;
        }
    </style>
    <?php include 'library/MuestraUsuario.php'; ?>
    </body>
</html>
 