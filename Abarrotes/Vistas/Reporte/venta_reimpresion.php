
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="/Abarrotes/library/jquery-1.10.2.min.js"></script>
        <script src="/Abarrotes/library/jquery.form.min.js">  </script>
 
        <script src="/Abarrotes/library/jspdf.debug.js"> </script>
        <script src="/Abarrotes/library/Modelos.js">  </script>
        <link rel="stylesheet" type="text/css" href="/Abarrotes/library/plantilla_css.css"/>
    </head>
    <body>
        <?php include 'library/ticket.php'; ?>
        <?php include_once "library/BarraSuperior.php"; ?>
        <div id="cuadrito">
        <!--<button id="crearPDF">Crear PDF</button> -->
        <form id="formObtenerVarios" action="/Abarrotes/Venta/ObtenerTodos" method="post">
             <table>
                <tr>
                    <th colspan="6">
                        Reimpresión de tickets y cancelación de ventas
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
           tabla=$('<table>');
           tr=$('<tr>'); 
           if(json.length==0){
               alert("No se encontró ninguna venta");
           }else{ 
               tr=$('<tr>'); 
                tabla.append(tr);
                var td1=$('<th>',{text:"#Venta"}),td2=$('<th>',{text:"Fecha y hora"}),td3=$('<th>',{text:"#Usuario"}),
                td4=$('<th>',{text:"#Cliente"}),td5=$('<th>',{text:"Total"}),td6=$('<th>',{text:"Reimprimri"});
                tr.append(td1,td2,td3,td4,td5,td6);
                for(var i=0; i<json.length;i++){
                    tr=$('<tr>');       
                    td1=$('<td>'),td2=$('<td>'),td3=$('<td>'),td4=$('<td>'),td5=$('<td>'),td6=$('<td>'),td7=$('<td>');
                    td1.append(json[i].id_venta);
                    td2.append(json[i].fecha_hora);
                    td3.append(json[i].id_usuario);
                    td4.append(json[i].id_cliente);
                    td5.append(json[i].total.formatMoney());
                    
                    button=$('<button>',{text:'Imprimir',click:function(){ var id=json[i].id_venta; return function(){
                        $.post( "/Abarrotes/VentaR/obtenerTodos", {id_venta: id},function(data){
                            console.log(data);
                            productosEnTabla=JSON.parse(data);

                            for(var i=0; i < productosEnTabla.length; i++){
                                filaTicket = $('<tr>');
                                cantTicket = $('<td>', {text: productosEnTabla[i].cantidad, valign: "top", class: "col"});
                                articuloTicket = $('<td>', {text: productosEnTabla[i].producto_nombre, class: "col-articulo"});
                                precioTicket = $('<td>', {text: productosEnTabla[i].precio, class: "col"});
                                var totalfila = parseFloat(productosEnTabla[i].precio) * parseFloat(productosEnTabla[i].cantidad);
                                totalTicket = $('<td>', {text: totalfila.toFixed(2), class: "col"});
                                filaTicket.append(cantTicket,articuloTicket,precioTicket,totalTicket);
                                $('#tablaTicket').append(filaTicket);
                            }

                            $('#fecha-hora').text(productosEnTabla[0].fecha_hora);
                            $('#total').text(productosEnTabla[0].total);
                            $('#numArticulos').text(productosEnTabla.length);
                            $('#num-venta').text(id);
                            
                            if(confirm("¿Desea reimprimir el ticket?")){
                                window.print();
                            }

                            $('#tablaTicket').find("tr:gt(0)").remove();
                         });
                        }
                        }()
                        }
                    ); 
                    button2=$('<button>',{text:'Eliminar Venta',click:
                        function(){ 
                            var elemento=tr;
                            var id=json[i].id_venta; 
                            return function(){
                                if(confirm("¿Esta seguro de eliminar la venta?\n NO SE PODRÁ DESHACER")){
                                    $.post( "/Abarrotes/Venta/eliminar", {id_venta: id},function(data){
                                        if(data==0){
                                            elemento.remove();
                                        }else{
                                            alert(data);
                                        }
                                        console.log(data);
                                    });
                                }
                               
                            }
                        }()
                        }
                    );         
                            
                  
                    td6.append(button);
                    td7.append(button2);
                    tr.append(td1,td2,td3,td4,td5,td6,td7);
                    tabla.append(tr);
                }

               
           }
           lista.append(tabla);
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

       

        #ticket {
            display: none;
            font-size: 65%;
        }

        #divTablaTicket {
            width: 100%;
        }

        #datosTicket{
            width: 100%;
            text-align: right;
            font-size: 100%;
            border: none;
        }

        #tablaTicket {
            width: 100%;
            border: none;
            font-size: 95%;
        }

        .col {
            text-align: right;
        }

        .col-articulo {
            width: 50%;
        }

        #cambio, #efectivo, #total {
            font-weight: bold;
        }

        #div-venta {
            float: left;
        }

        #div-fecha {
            float: right;
        }

        #cabeceras-ticket {
            text-align: right;
        }

        @media print { 
            #contenido { 
                display: none;
            } 

            #ticket {
                display: inline;
            }
            footer{
                display:none;
            }
            #cuadrito,#menu{
                display:none;
            }

        }
    </style>
    
    </body>
</html>