
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="/Abarrotes/library/jquery-1.10.2.min.js"></script>
        <script src="/Abarrotes/library/jquery.form.min.js">  </script>
        <script src="/Abarrotes/library/jspdf.debug.js">  </script>
        <script src="/Abarrotes/library/Modelos.js">  </script>
        <script src="/Abarrotes/library/json2csv.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="/Abarrotes/library/plantilla_css.css"/>
    </head>
    <body>
        <?php include_once "library/BarraSuperior.php"; ?>
        <div id="cuadrito">
        <button id="crearPDF">Crear PDF</button>
        <button id="crearCSV">Crear CSV (Excel)</button>
        <span>Ocultar detalle</span><input id="detalle" type="checkbox"/>
        <form id="formObtenerVarios" action="/Abarrotes/VentaR/ObtenerTodos" method="post">
             <table>
                <tr>
                    <th colspan="6">
                        Reporte de ventas
                    </th>
                </tr>
                <tr>
                    <th>#Venta</th>
                    <th>#Usuario</th>
                    <th>#Cliente</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th></th>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"/><span><input disabled name="id_venta" type="number"  step="1" min="0" placeholder="#Venta"/></span>
                    </td>
                    <td>
                        <input type="checkbox"/><span><input disabled name="id_usuario" type="number"  step="1" min="0" placeholder="#Usuario"/></span>
                    </td>
                    <td>
                        <input type="checkbox"/><span><input disabled name="id_cliente" type="number"  step="1" min="0" placeholder="#Cliente"/></span>
                    </td>
                    <td>
                        <input  name="fecha_hora" type="date" />
                    </td>
                    <td>
                        <input  name="fecha_hora2" type="date" />
                    </td>
                    <td>
                        <input type="submit" />    
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
        var crearCSV=$('#crearCSV');
        var detalleVenta=$('#detalle');
    
    crearPDF.on('click',function(){
        guardarPDF(lista[0]);
    });
    
        crearCSV.on('click',function(){
            JSONToCSVFile(actualQuery,"Reporte de inventario",true);
        });
    
       var opcionesConsulta = { 
           beforeSubmit:  antesConsultaCompleta,  // pre-submit callback 
           success:       despuesConsultaCompleta  // post-submit callback   
       }; 

       function antesConsultaCompleta(formData, jqForm, options) { 
           var despuesConsultaCompleta = $.param(formData); 
           return true; 
       } 
       var actualQuery=null;
       function despuesConsultaCompleta(responseText, statusText, xhr, $form)  { 
           //console.log(responseText);
           json=JSON.parse(responseText);
           actualQuery=json;
           lista.empty();
           tr=$('<tr>'); 
           if(json.length==0){
               alert("No se encontró ninguna venta");
           }else{ 
               var idactual=-1;
               table=null;
               var total=0;
               for(var i=0; i<json.length;i++){
                   if(idactual!=json[i].id_venta){
                       var totalVenta=0;
                       div=$('<div>');
                       lista.append(div);
                       t1=$('<span>',{text:"#Venta: ",'class':'negrita'});
                       t2=$('<span>',{text:'Fecha y hora :','class':'negrita'});
                       t3=$('<span>',{text:'#Usuario: ','class':'negrita'});
                       t4=$('<span>',{text:'Nombre: ','class':'negrita'});

                       t6=$('<span>',{text:'#Cliente: ','class':'negrita'});
                       t7=$('<span>',{text:'Nombre: ','class':'negrita'});

                       s1=$('<span>',{text:json[i].id_venta});
                       s2=$('<span>',{text:json[i].fecha_hora});
                       s3=$('<span>',{text:json[i].id_usuario});
                       s4=$('<span>',{text:json[i].usuario_nombre+" "+json[i].usuario_apellido_paterno});

                       s6=$('<span>',{text:json[i].id_cliente});
                       s7=$('<span>',{text:json[i].cliente_nombre});
                       div.append(t1,s1,t2,s2,t3,s3,t4,s4,t6,s6,t7,s7);
                       
                       if(!detalleVenta.prop('checked')){
                            lista.append('<hr/>',div);
                        }
                       idactual=json[i].id_venta;
                       div2=$('<div style="text-align:center">');
                       table=$('<table>');
                       div2.append(table);
                       div.append('<br>',div2);
                       
                       if(!detalleVenta.prop('checked')){
                            tr=$('<tr>'); 
                            table.append(tr);
                            td1=$('<th>',{text:"#Producto"}),td2=$('<th>',{text:"Nombre"}),td3=$('<th>',{text:"Cantidad"}),
                            td4=$('<th>',{text:"Precio"}),td5=$('<th>',{text:"Subtotal"});
                            tr.append(td1,td2,td3,td4,td5);
                            
                        }
                        var $totalVenta=$('<div>');
                        div.append($totalVenta);
                            
                     //  console.log(json[i]);
                   }
                   if(!detalleVenta.prop('checked')){
                        tr=$('<tr>');       
                        td1=$('<td>'),td2=$('<td>'),td3=$('<td>'),td4=$('<td>'),
                           td5=$('<td>');
                       td1.append(json[i].id_producto);
                       td2.append(json[i].producto_nombre);
                       td3.append(json[i].cantidad);
                       td4.append(json[i].precio.formatMoney());
                       td5.append(json[i].total.formatMoney());

                       totalVenta+=parseFloat(json[i].total);
                       $totalVenta.text('Total '+totalVenta.formatMoney());
                       tr.append(td1,td2,td3,td4,td5);
                       table.append(tr);
                   }

                       //formInsertar.children('[name=n_auto]').attr('value',event.data);

                    total+=parseFloat(json[i].total);
               } 
               lista.prepend($('<b>',{text:'<<Gran Total: '+total.formatMoney()+">>"}));
           }
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
            font-weight: 900;
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