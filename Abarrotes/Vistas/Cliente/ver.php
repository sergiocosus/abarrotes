
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
            <form id="formInsertar" action="/Abarrotes/Cliente/Insertar" method="post">
                <h3>Insertar Cliente</h3>
            </form>
           <hr/>
            <form id="formObtenerVarios" action="/Abarrotes/Cliente/ObtenerTodos" method="post">
                <table>
                    <tr>
                        <th colspan="8">
                            Consuta de clientes
                        </th>
                    </tr>
                    <tr>
                        <th>#Cliente</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Celular</th>
                        <th>Dirección</th>
                        
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
                    ' <th>ID</th> <th>Nombre</th> <th>Teléfono</th>\n\
        <th>Celular</th><th>Direccion</th>\n\
<th></th><th></th>');
            lista.append(th);
            
            ////Menú Insertar///////////
            formInsertar.append(
                Cliente.nombre(),'<br/>',
                Cliente.telefono(),'<br/>',
                Cliente.celular(),'<br/>',
                Cliente.direccion(),'<br/>',
                Modelo.agregar()
            );
            
            ////Menú Consulta////////////
            var checkbox=[];
            var span=[];
            var td=[];
            for(var i=0;i<5;i++){
                checkbox[i]=$('<input>',{type:'checkbox'});
                span[i]=$('<span>');
                td[i]=$('<td>').append(checkbox[i],span[i]);
                camposObtenerVarios.append(td[i]);
            }
      
            span[0].append(Cliente.id_cliente().prop('disabled',true).prop('readonly',false));
            span[1].append(Cliente.nombre().prop('disabled',true));
            span[2].append(Cliente.telefono().prop('disabled',true));
            span[3].append(Cliente.celular().prop('disabled',true));
            span[4].append(Cliente.direccion().prop('disabled',true));
     
            
         
           camposObtenerVarios.append($('<td>').append($('<span>').append(Modelo.consultar()))); 
      
            camposObtenerVarios.find('span').on('click',function(){
                $(this).children('input').removeAttr('disabled');
                $(this).prev().prop('checked',true);
                $(this).children('input').select();
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
                    alert("No se encontró ningún cliente");
                }
                else{ 
                    for(var i=0; i<json.length;i++){
                        var formElimina=$('<form>',{'class':'botonEliminar',action:"/Abarrotes/Cliente/Eliminar",method:"post"});
                        hiddenId=Cliente.id_cliente(json[i].id_cliente).attr('type','hidden');
                        
                        submitElimina=$('<input>',{type:'submit',value:"X"});
                        formElimina.append(hiddenId,submitElimina);
                        
                        var form=$('<form>',{action:"/Abarrotes/Cliente/Actualizar",
                            method:"post",id:"form"+i});
                        
                        submit=$('<input>',{type:'submit',value:"✓"});
                        var tr=$('<tr>').append(
                            
                        form.append($('<td>').append(Cliente.id_cliente(json[i].id_cliente).attr('form','form'+i))),
                        $('<td>').append(Cliente.nombre(json[i].nombre).attr('form','form'+i)),
                        $('<td>').append(Cliente.telefono(json[i].telefono).attr('form','form'+i)),
                        $('<td>').append(Cliente.celular(json[i].celular).attr('form','form'+i)),
                        $('<td>').append(Cliente.direccion(json[i].direccion).attr('form','form'+i)),
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
   