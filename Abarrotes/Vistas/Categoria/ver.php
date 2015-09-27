
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
            <form id="formInsertar" action="/Abarrotes/Categoria/Insertar" method="post">
                <h3>Insertar Categoria</h3>
            </form>
           <hr/>
            <form id="formObtenerVarios" action="/Abarrotes/Categoria/ObtenerTodos" method="post">
                <table>
                    <tr>
                        <th colspan="8">
                            Consuta de categorias
                        </th>
                    </tr>
                    <tr>
                        <th>#Categoria</th>
                        <th>Nombre</th>
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
                    ' <th>ID</th> <th>Nombre</th> \n\
<th></th><th></th>');
            lista.append(th);
            
            ////Menú Insertar///////////
            formInsertar.append(Categoria.nombre(),'</br>',
                 Modelo.agregar()
            );
    
            
            ////Menú Consulta////////////
            var checkbox=[];
            var span=[];
            var td=[];
            for(var i=0;i<2;i++){
                checkbox[i]=$('<input>',{type:'checkbox'});
                span[i]=$('<span>');
                td[i]=$('<td>').append(checkbox[i],span[i]);
                camposObtenerVarios.append(td[i]);
            }
            span[0].append(Categoria.id().prop('disabled',true).prop('readonly',false));
            span[1].append(Categoria.nombre().prop('disabled',true));
            
            
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
                    alert("No se encontró ningún categoria");
                }
                else{ 
                    for(var i=0; i<json.length;i++){
                        var formElimina=$('<form>',{'class':'botonEliminar',action:"/Abarrotes/Categoria/Eliminar",method:"post"});
                        hiddenId=Categoria.id(json[i].id).attr('type','hidden');
                        
                        submitElimina=$('<input>',{type:'submit',value:"X"});
                        formElimina.append(hiddenId,submitElimina);
                        
                        var form=$('<form>',{action:"/Abarrotes/Categoria/Actualizar",
                            method:"post",id:"form"+i});
                        
                        submit=$('<input>',{type:'submit',value:"✓"});
                        var tr=$('<tr>').append(
                            
                                form.append($('<td>').append(Categoria.id(json[i].id).attr('form','form'+i))),
                                $('<td>').append(Categoria.nombre(json[i].nombre).attr('form','form'+i)),
                              
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
 