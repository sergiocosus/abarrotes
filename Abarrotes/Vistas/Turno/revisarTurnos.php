
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="/Abarrotes/library/jquery-1.10.2.min.js"></script>
        <script src="/Abarrotes/library/jquery.form.min.js">  </script>
        <script src="/Abarrotes/library/jspdf.debug.js">  </script>
        <script src="/Abarrotes/library/Modelos.js">  </script>
        <script src="/Abarrotes//library/jspdf.debug.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="/Abarrotes/library/plantilla_css.css"/>
    </head>
    <body>
        <?php include_once "library/BarraSuperior.php"; ?>
        <div id="cuadrito">
        <button id="crearPDF">Crear PDF</button>
       
        <form id="formObtenerVarios" action="/Abarrotes/Turno/ObtenerTodos" method="post">
            <table>
                <tr>
                    <th colspan="5">
                        Historial de turnos
                    </th>
                </tr>
                <tr>
                    <th>#Turno</th>
                    <th>#Usuario</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th></th>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"/><span><input disabled name="id_turno" type="number"  step="1" min="0" placeholder="#Turno"/></span>
                    </td>
                    <td>
                        <input type="checkbox"/><span><input disabled name="id_usuario" type="number"  step="1" min="0" placeholder="#Usuario"/></span>
                    </td>
                    <td>
                        <input  name="fecha_hora" type="date" />
                    </td>
                    <td>
                        <input  name="fecha_hora2" type="date" />
                    </td>
                    <td>
                        <input type="submit" value="Consultar"/>            
                    </td>
                </tr>
            </table>
        </form> 
        <div id="lista">
                
        </div>
        </div>
        <script src="/Abarrotes/library/script.js"></script>
    <script> 
        
        
      
       var lista=$('#lista');
       var formInsertar=$('#formInsertar');
       var formActualizar=$('#formActualizar');
       var formObtenerVarios=$('#formObtenerVarios');
       var formObtener=$('#formObtener');
       var crearPDF=$('#crearPDF');

    crearPDF.on('click',function(){
        guardarPDF(lista[0]);
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
           console.log(responseText);
           json=JSON.parse(responseText);
           lista.empty();
           table=$('<table>');
           tr=$('<tr>'); 
           if(json.length==0){
               alert("No se encontró ninguna venta");
           }else{ 
               var idactual=-1;
               table.html('<tr><th>#Turno</th><th>#Usuario</th><th>Inicio</th><th>Fin</th><th>Cantidad Inicial</th><th>Total Calculado</th><th>Cantidad Final</th><th>Estado</th></tr>');
               
               for(var i=0; i<json.length;i++){
                    tr=$('<tr>');

                    s1=$('<td>',{text:json[i].id_turno});
                    s2=$('<td>',{text:json[i].id_usuario});
                    s3=$('<td>',{text:json[i].fecha_hora_inicio});
                    s4=$('<td>',{text:json[i].fecha_hora_fin});

                    s5=$('<td>',{text:json[i].cantidad_inicial});
          
                    s6=$('<td>',{text:json[i].total_calculado});
                    s7=$('<td>',{text:json[i].cantidad_final});
                    s8=$('<td>',{text:(json[i].finalizado==="s")?'Terminado':'No Terminado'});
                    tr.append(s1,s2,s3,s4,s5,s6,s7,s8);
                    table.append(tr);
               }
           }
           lista.append(table);
       } 

       $(document).ready(function() { 
           formObtenerVarios.ajaxForm(opcionesConsulta);
           formInsertar.ajaxForm(opcionesInsertar);

       });

       $('form [type="checkbox"]').on('click',function(){
            $(this).next().prop('disabled',!$(this).prop('checked'));
       });
       
       Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});


    formObtenerVarios.find('span').on('click',function(){
            $(this).children('input').removeAttr('disabled');
            $(this).prev().prop('checked',true);
            $(this).children('input').focus();
            console.log("hola");
        });
        formObtenerVarios.find(':checkbox').on('click',function(){
             $(this).next().children().prop('disabled',!$(this).prop('checked'));
        });

    $('[name="fecha_hora"]').val(new Date().toDateInputValue());
    $('[name="fecha_hora2"]').val(new Date().toDateInputValue());

</script>
    <style>
        .botonEliminar{
            display: inline-block;
        }
        .negrita{
            margin-left:10px;
            font-weight: bolder;
        }

        #lista div{
            text-align: left; 
        }
        #lista form{
            float:right;
        }

    </style>
    
    </body>
</html>