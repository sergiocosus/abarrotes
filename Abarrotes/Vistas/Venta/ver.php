<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="/Abarrotes/library/jquery-1.10.2.min.js"></script>
        <script src="/Abarrotes/library/jquery.form.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/Abarrotes/library/plantilla_css.css"/>
    </head>
    <body>
        <?php include 'library/ticket.php'; ?>
        <div id="contenido">
        <?php include_once "library/BarraSuperior.php"; ?>
        <div id="eleccion">
            <h2>Seleccione un producto</h2>
            <span id="buscar">
                Nombre:<input id="busquedaProducto"/>
            </span>
            <div id="elementos"></div>
            </br>
            <button>Cancelar</button>
        </div>
        <div id="cuadrito">
            <form id="formInsertar" >
                <h3>Crear Venta</h3>
                <div class="venta">
                    <table class="accionesVenta">
                        <tr>
                            <td>Codigo</td>
                            <td>
                                <input id="codigoBarras" name="codigoBarras" 
                                   placeholder="Código de Barras" tabindex="1" accesskey="c" title="Alt+C"/>
                            </td>
                        </tr>
                        <tr>
                            <td>#Producto</td>
                            <td>
                                <input id="idProducto" name="idProducto"  placeholder="ID Producto" 
                               type="number" step="1" min="1" accesskey="i" tabindex="2" title="Alt+I"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="busqueda" type="button" value="Búsqueda" 
                               accesskey="b" tabindex="3" title="Alt+B"/>
                            </td>
                        </tr>
                    </table>
                    <table class="datosVenta">
                        <tr>
                            <td>Nombre</td>
                            <td>
                                <input name="nombre" placeholder="Nombre del producto" readonly="readonly"/>
                            <td/>
                        </tr>
                        <tr>
                            <td>Descripción</td>
                            <td>
                                <input name="descripcion" type="text" placeholder="Descripción" readonly="readonly"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Precio/U</td>
                            <td>
                                <input id="precioU" name="precioUnitario" placeholder="Precio Unitario" readonly="readonly"/>
                            </td>
                        </tr>
                    </table>
                    <table class="detallesVenta">
                        <tr>
                            <td colspan="2">
                                <input id="cant" name="cantidad" required="required" 
                               type="number" placeholder="Cantidad" tabindex="4"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="precioT" name="precioTotal" placeholder="Precio Total" readonly="readonly" style="font-weight: bold"/>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <input id="aceptar" type="submit" value="Agregar"
                               accesskey="a" tabindex="5" title="Alt+A"/>
                            </td>    
                            <td>
                                <input id="cancelar" type="button" tabindex="6" value="Limpiar" accesskey="l" title="Alt+L"/>
                            </td>
                        </tr>
                    </table>
                </div>
                
            </form>
            
            <hr/>
            <form id="formTabla" action="/Abarrotes/Venta/Insertar" method="post">
                <table id="listaProductos">
                    <tr>
                        <th>ID</th>
                        <th>Código de barras</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Precio Total</th> 
                        <th>Modificar</th>
                        <th>Eliminar</th> 
                    </tr>
                </table>
                <hr/>
            Cliente: <input type="button"  id="elegirCliente" accesskey="g" title="Alt+G"  value="Elegir Cliente">
            <input id="id_cliente" type="hidden" name="id_cliente" tabindex="7" form="formTabla" value="0"/>
                <span id="nombreCliente">Venta al público</span>
                <hr>
                <table>
                    <tr>
                        <td><b>Total</b></td>
                        <td><input readonly="readonly" type="number" step="0.01" id="granTotal" value="0"/></td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><b>Efectivo</b></td>
                        <td><input type="number" required step="0.01" id="efectivoLista" tabindex="8" accesskey="o" title="Alt+O"/></td>
                    </tr>
                    <tr>
                        <td><b>Cambio</b></td>
                        <td><input readonly="readonly" step="0.01" id="cambioLista"/></td>
                    </tr>
                </table>
                
                <div id="divGranTotal">Total: $0.00</div>
                <br>
                <input id="cancelarVenta" type="button" value="Cancelar Venta" accesskey="x"/>
                <input id="realizar-venta" type="submit" value="Realizar Venta" accesskey="r" tabindex="9" title="Alt+R"/>
            </form>
            <br>
        </div>
        <script src="/Abarrotes/library/script.js"></script>
        <script>
            var eleccion = $('#eleccion');
            var elementos = $('#elementos');
            
            var productoActual = null;
            var granTotal = 0;
            
            var precioU = $('#precioU');
            var precioT=$('#precioT');
            var cant = $('#cant');

            var formInsertar = $('#formInsertar');
            var listaProductos = $('#listaProductos');
            
            var id_cliente=$('#id_cliente');
            var codigoBarras=$('#codigoBarras');
            var cancelarVenta=$('#cancelarVenta');
            var cancelar=$('#cancelar');
            var idProducto=$('#idProducto');
            var busqueda=$('#busqueda');
            var formTabla=$('#formTabla');
            var nombreCliente=$('#nombreCliente');
            var divGranTotal=$('#divGranTotal');
            var efectivoLista=$('#efectivoLista');
            var cambioLista=$('#cambioLista');
            
            var buscar=$('#buscar');
            var busquedaProducto=$('#busquedaProducto');
                    
                    
                    
            codigoBarras.focus();
            eleccion.hide().children('button').on('click',function(){eleccion.hide(200);});

            cant.on('change', function () {
                var total = parseFloat(precioU.val().substring(1)) * parseFloat($(this).val());
                precioT.val('$'+total.toFixed(2));
            });
            
            efectivoLista.on('change',calcularCambio);
            efectivoLista.on('keyup',calcularCambio);
            
            function calcularCambio(){
                cambioLista.val((parseFloat($('#efectivoLista').val())-calcularTotal()).formatMoney());
            }
            
            cancelarVenta.on('click',function(){
                if (productosEnTabla.length != 0){
                    var respuesta = confirm("Presione Aceptar para cancelar la venta");
                    if (respuesta){
                        reiniciarVenta();
                    }
                }
            });
            function reiniciarVenta(){
                limpiarFormulario();
                productosEnTabla = [];
                listaProductos.find("tr:gt(0)").remove();
                $('#granTotal').val('0');
                $('#efectivoLista').val('0');
                cambioLista.val('0');
                divGranTotal.val('0');
                granTotal = 0;
            }
            
            function limpiarFormulario() {
                productoActual = null;
                formInsertar.each(function(){
                    formInsertar[0].reset();
                });
                formInsertar.find('[name=codigoBarras]').attr('value',"");
                formInsertar.find('[name=idProducto]').attr('value',"");
                formInsertar.find('[name=codigoBarras]').removeAttr('readonly');
                formInsertar.find('[name=idProducto]').removeAttr('readonly');
                formInsertar.find('[name=nombre]').attr('value',"");
                formInsertar.find('[name=descripcion]').attr('value',"");
                formInsertar.find('[name=precioUnitario]').attr('value',"");
                nombreCliente.text('Venta al público');
                _nombre_cliente='Venta al público';
                id_cliente.attr('value','0');
                _id_cliente=0;
                formInsertar.find('#cant').removeAttr("step min max value");
                codigoBarras.focus();
                
            }
           
            formInsertar.ajaxForm({
                beforeSubmit: function(){
                    aceptar();
                    return false;
                }
            });
            
            function llenarCampos(producto) {        
                productoActual = producto;
                eleccion.hide(200);
                formInsertar.find('[name=codigoBarras]').attr({value: productoActual.codigo_barras, readonly: "readonly"});
                formInsertar.find('[name=idProducto]').attr({value: productoActual.id_producto, readonly: "readonly"});
                formInsertar.find('[name=nombre]').attr('value',productoActual.nombre);
                formInsertar.find('[name=descripcion]').attr('value',productoActual.descripcion);
                formInsertar.find('[name=precioUnitario]').attr('value','$'+productoActual.precio);
                if(productoActual.unidad == 'u'){
                    if(productoActual.existencias > 0){
                        minimo = 1;
                        valor = 1;
                    } else {
                        valor = 0;
                        minimo = productoActual.existencias;
                    }
                    paso = 1;
                } else {
                    if(productoActual.existencias >= 0.005){
                        minimo = 0.005;
                        valor = 0.005;
                    } else {
                        valor = 0;
                        minimo = productoActual.existencias;
                    }
                    paso = 0.005;
                }
                maximo = productoActual.existencias;
                cant.attr({value: valor, step: paso, min: minimo, max: maximo});
                precioT.val('$'+(parseFloat(precioU.val().substring(1)) * parseFloat($('#cant').val())).toFixed(2));;
                cant.focus();
                $(productoActual).attr({cantidad: $('#cant').val()});
            }
            
            function calcularTotal(){
                var total=0;
                for(i=0;i<productosEnTabla.length;i++){
                    total+=parseFloat(productosEnTabla[i].precio)*parseFloat(productosEnTabla[i].cantidad);
                }
                return total.toFixed(2);
            }
            
            
            
            codigoBarras.keypress(function (e) {
              if (e.which == 13) {
                $.post("/Abarrotes/Producto/ObtenerTodos", { codigo_barras: $('#codigoBarras').val(), oculto: false },function(data){
                     productos =  JSON.parse(data);
                    
                    if(productos.length!==0){
                        producto=productos[0];
                        if(producto.existencias > 0){
                            llenarCampos(producto);
                        } else {
                            alert("Producto agotado");
                        }
                    } else {
                        producto=null;
                        alert("No existe el producto");
                        limpiarFormulario();
                    }
                    
                });
                e.preventDefault();
              }
            });
            
            idProducto.keypress(function (e) {
              if (e.which == 13) {
                $.post("/Abarrotes/Producto/ObtenerTodos", { id_producto: $('#idProducto').val() },function(data){
                    productos =  JSON.parse(data);
                    
                    if(productos.length!==0){
                        producto=productos[0];
                        if(producto.existencias > 0){
                            llenarCampos(producto);
                        } else {
                            alert("Producto agotado");
                        }
                    } else {
                        producto=null;
                        alert("No existe el producto");
                        limpiarFormulario();
                    }
                });
                e.preventDefault();
              }
            });
            
            
            busqueda.on('click',function(){    
                limpiarFormulario();
                $.get( "/Abarrotes/Producto/ObtenerTodos", function( data ) {
                eleccion.show(200);
                buscar.show();
                busquedaProducto.select();
                elementos.empty();
                    ajax=JSON.parse(data);
                    mostrarDatos(ajax);
                });
            });
            
            function mostrarDatos(ajax){
                for(i=0;i<ajax.length;i++){
                      if(ajax[i].existencias > 0){
                          div=$('<a>',{href:'javascript:void(0)'});

                          div.text('#'+ajax[i].id_producto+/*" - "+ajax[i].codigo_barras+*/" - "+
                                  ajax[i].nombre+" - "+ajax[i].descripcion+" - $"+ajax[i].precio+" - "+
                                  ajax[i].existencias+ajax[i].unidad);

                          div.on('click',ajax[i],function(event){
                              llenarCampos(event.data);
                              eleccion.hide(200);

                          });
                          elementos.append(div);
                      }
                  }
                  
            }
            
            busquedaProducto.on('keyup',function(){
                var nombre=busquedaProducto.val();
                    $.post('/Abarrotes/Producto/Busqueda',{nombre:nombre},function(data){
                    eleccion.show(200);
                    elementos.empty();
                    ajax=JSON.parse(data);
                    mostrarDatos(ajax);
                });
            });
            
            var _id_cliente=0;
            var _nombre_cliente="Venta al público";
            
            $('#elegirCliente').on('click',function(){    
                $.get( "/Abarrotes/Cliente/ObtenerTodos", function( data ) {
                eleccion.show(200);
                elementos.empty();
                buscar.hide();
                    console.log(data);            
                    ajax=JSON.parse(data);
                    for(i=0;i<ajax.length;i++){
                        div=$('<a>',{href:'javascript:void(0)'});
                        div.text(ajax[i].id_cliente+" - "+ajax[i].nombre);
                        div.on('click',ajax[i],function(event){
                            _id_cliente=event.data.id_cliente;
                            nombreCliente.text(event.data.id_cliente+" - "
                                    +event.data.nombre);
                            _nombre_cliente=event.data.nombre;
                            id_cliente.attr('value',event.data.id_cliente);
                            eleccion.hide(200);
                        });
                        elementos.append(div,$('<hr>'));
                    }
                });
            });
            
            
            cancelar.on('click',function(){
                limpiarFormulario();
                codigoBarras.select();
            });
            
            var productosEnTabla = [];
            var totalArticulos = 0;
            
            
            function aceptar() {
                console.log("hola");
                if(productoActual != null){
                    existe=false;
                    for(i=0;i<productosEnTabla.length;i++){
                        if(productosEnTabla[i].id_producto==productoActual.id_producto){
                            existe=true;
                            break;
                        }
                    };
                    
                    if((productosEnTabla.indexOf(productoActual)) < 0 && !existe){
                        fila = $('<tr>');
                        tdID = $('<td>'); 
                        id = $('<input>', {name: "id_producto[]", readonly: "readonly", value: productoActual.id_producto});
                        tdID.append(id);
                        cb = $('<td>', {text: productoActual.codigo_barras});
                        nom = $('<td>', {text: productoActual.nombre});
                        tdCant = $('<td>');
                        cantidad = $('<input>', {name: "cantidad[]", readonly: "readonly", value: $('#cant').val()});
                        tdCant.append(cantidad);
                        tdPU = $('<td>');
                        pu = $('<input>', {name: "precioUnitario[]", readonly: "readonly", value: productoActual.precio});
                        tdPU.append(pu);
                        pt = $('<td>', {text: $('#precioT').val()});
                        modif = $('<td>');
                        elim = $('<td>');
                        btnModif = $('<input>',{type:'button',value:'M'});
                        btnModif.on('click',function(e){
                            var index = $(this).closest('tr').index() - 1;
                            productoActual = productosEnTabla[index];
                            //console.log(productoActual);
                            formInsertar.find('[name=codigoBarras]').attr({value: productoActual.codigo_barras, readonly: "readonly"});
                            formInsertar.find('[name=idProducto]').attr({value: productoActual.id_producto, readonly: "readonly"});
                            formInsertar.find('[name=nombre]').attr('value',productoActual.nombre);
                            formInsertar.find('[name=descripcion]').attr('value',productoActual.descripcion);
                            formInsertar.find('[name=precioUnitario]').attr('value','$'+productoActual.precio);
                            if(productoActual.unidad == 'u'){
                                if(productoActual.existencias > 0){
                                    minimo = 1;
                                    valor = 1;
                                } else {
                                    valor = 0;
                                    minimo = productoActual.existencias;
                                }
                                paso = 1;
                            } else {
                                if(productoActual.existencias >= 0.005){
                                    minimo = 0.005;
                                    valor = 0.005;
                                } else {
                                    valor = 0;
                                    minimo = productoActual.existencias;
                                }
                                paso = 0.005;
                            }
                            maximo = productoActual.existencias;
                            var c = $($(this).closest('tr').children().get(3)).children().val();
                            formInsertar.find('#cant').attr({value: c, step: paso, min: minimo, max: maximo});
                            precioTotal=parseFloat(precioU.val().substring(1)) * parseFloat($('#cant').val());
                            $('#precioT').val('$'+precioTotal);
                            productosEnTabla.splice(index,1);
                            $(this).closest('tr').remove();
                            $('#cant').focus();
                             $('#granTotal').val(calcularTotal());
                            divGranTotal.text('Total: $'+(calcularTotal()));
                        });
                        modif.append(btnModif);
                        btnElim=$('<input>',{type:'button',value:'X'});
                        btnElim.on('click',function(){
                            var index = $(this).closest('tr').index() - 1;
                            productosEnTabla.splice(index,1);
                            $(this).closest('tr').remove();
                              $('#granTotal').val(calcularTotal());
                            divGranTotal.text('Total: $'+(calcularTotal()));
                        });
                        elim.append(btnElim);
                        fila.append(tdID,cb,nom,tdCant,tdPU,pt,modif,elim);
                        listaProductos.append(fila);
                        productoActual.cantidad=$('#cant').val();
                        productosEnTabla.push(productoActual);
                        granTotal = calcularTotal();
                        if(productoActual.unidad == 'u'){
                            totalArticulos = totalArticulos + parseInt(cantidad.val());
                        } else {
                            totalArticulos = totalArticulos + 1;
                        }
                        $('#granTotal').val(calcularTotal());
                        divGranTotal.text('Total: $'+calcularTotal());
                        limpiarFormulario();
                    } else {
                        alert('El producto ya fue agregado, si quiere cambiar la cantidad haga clic en M para modificar')
                        var indice = productosEnTabla.indexOf(productoActual);
                        console.log(indice);
                    }
                }
            }


            var options = { 
                beforeSubmit:  showRequest,  // pre-submit callback 
                success:       showResponse  // post-submit callback 

            }; 
            
            function showRequest(formData, jqForm, options) { 
                
                if(productosEnTabla.length == 0){
                    alert('No se han seleccionado productos');
                    return false;
                }  
                console.log("hooola1");
                if(parseFloat(calcularTotal())>parseFloat($('#efectivoLista').val())){
                    alert('El efectivo es menor a la venta Total');
                    return false;
                }
                console.log("hooola2");
                $('#realizar-venta').prop('disabled',true);
                if(confirm("¿Desea realizar la venta?")) {
                    return true;
                }else{
                    $('#realizar-venta').prop('disabled',false);
                    return false;
                }
                console.log("hooola3");
                
                
                
            } 
            
            function showResponse(responseText, statusText, xhr, $form)  {
                $('#realizar-venta').prop('disabled',false);

                console.log(productosEnTabla);
                if(responseText>0){
                    for(var i=0; i < productosEnTabla.length; i++){
                        filaTicket = $('<tr>');
                        cantTicket = $('<td>', {text: productosEnTabla[i].cantidad, valign: "top", class: "col"});
                        articuloTicket = $('<td>', {text: productosEnTabla[i].nombre, class: "col-articulo"});
                        precioTicket = $('<td>', {text: productosEnTabla[i].precio, class: "col"});
                        var totalfila = parseFloat(productosEnTabla[i].precio) * parseFloat(productosEnTabla[i].cantidad);
                        totalTicket = $('<td>', {text: totalfila.toFixed(2), class: "col"});
                        filaTicket.append(cantTicket,articuloTicket,precioTicket,totalTicket);
                        $('#tablaTicket').append(filaTicket);
                    }

                    var currentdate = new Date(); 
                    var datetime = currentdate.getDate() + "/"
                        + (currentdate.getMonth()+1)  + "/" 
                        + currentdate.getFullYear() + " "  
                        + currentdate.getHours() + ":"  
                        + currentdate.getMinutes();
                    $('#fecha-hora').text(datetime);
                    $('#total').text(calcularTotal());
                    $('#efectivo').text($('#efectivoLista').val());
                    $('#cambio').text(($('#efectivoLista').val() - calcularTotal()).formatMoney());
                    $('#numArticulos').text(productosEnTabla.length);
                    $('#num-venta').text(responseText);

                    if(confirm("Venta Completada \n Id de venta:" + responseText+"\n ¿Desea imprimir el ticket?")){
                        window.print();
                    }

                    divGranTotal.text('Total: $0');
                    limpiarFormulario();
                    $('#tablaTicket').find("tr:gt(0)").remove();
                    reiniciarVenta(true);
                    granTotal = 0;
                }else{
                    alert('Hubo un error en la venta' + responseText );
                }
            } 
            formTabla.ajaxForm(options);
            
            
            
        </script>
        </div>
        <style>
            .botonEliminar{
                display: inline-block;
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
                #footerIscali{
                    display:none;
                }
                
            }
        </style>
    <?php include 'library/MuestraUsuario.php'; ?>
    </body>
</html>
