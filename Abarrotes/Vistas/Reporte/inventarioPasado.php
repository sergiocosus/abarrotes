
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="/Abarrotes/library/jquery-1.10.2.min.js"></script>
        <script src="/Abarrotes/library/jquery.form.min.js">  </script>
        <script src="/Abarrotes/library/script.js"></script> 
        <script src="/Abarrotes/library/Modelos.js"></script> 
        <script src="/Abarrotes/library/jspdf.debug.js">  </script>
        <script src="/Abarrotes/library/json2csv.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="/Abarrotes/library/plantilla_css.css"/>
    </head>
    <body>
        <?php include_once "library/BarraSuperior.php"; ?>
        <div id="cuadrito">
        <button id="crearPDF">Crear PDF</button>
        <button id="crearCSV">Crear CSV (Excel)</button>
        <form id="formObtenerVarios" action="/Abarrotes/InventarioPasado/ObtenerTodos" method="post">
                Fecha del estado anterior del inventario<input  name="fecha_hora" type="date" />
          </br>
            <b>Ordenar por:</b>  Nombre
             <select name="orderNombre">
                <option value="no">
                    Sin orden
                </option>
                <option value="asc">
                    Ascendente
                </option>
                <option value="desc">
                    Descendente
                </option>
            </select> 
            - Categoria
             <select name="orderCategoria">
                <option value="no">
                    Sin orden
                </option>
                <option value="asc">
                    Ascendente
                </option>
                <option value="desc">
                    Descendente
                </option>
            </select> 
            - Existencias
            <select name="orderExistencia">
                <option value="no">
                    Sin orden
                </option>
                <option value="asc">
                    Ascendente
                </option>
                <option value="desc">
                    Descendente
                </option>
            </select> 
             -  Precio
             <select name="orderPrecio">
                <option value="no">
                    Sin orden
                </option>
                <option value="asc">
                    Ascendente
                </option>
                <option value="desc">
                    Descendente
                </option>
            </select> 
             
             
            <table> 
                <tr>
                    <th colspan="8">
                        Reporte de inventario
                    </th>
                </tr>
             
                <tr>
                    <th>#Producto</th>
                    <th>Codigo de Barras</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Exis. Min</th>
                    <th>Exis. Max</th>
                    <th>Unidad</th>
                </tr>
                <tr id="camposObtenerVarios">
                </tr>
                
            </table>
        </form> 
        <div id="lista">
                
        </div>
        </div>
        <script src="/Abarrotes/library/script.js"></script>
    <script> 
       var lista=$('#lista');
      
        var checkbox=[];
        var span=[];
        var formActualizar=$('#formActualizar');
        var formObtenerVarios=$('#formObtenerVarios');
        var formObtener=$('#formObtener');
        var crearPDF=$('#crearPDF');
        var crearCSV=$('#crearCSV');

        crearPDF.on('click',function(){
            guardarPDF(lista[0]);
        });
        
        crearCSV.on('click',function(){
            JSONToCSVFile(actualQuery,"Reporte de inventario",true);
        });
    
        for(var i=0;i<9;i++){
            checkbox[i]=$('<input>',{type:'checkbox'});
            span[i]=$('<span>');
        }
        var campos=$('#camposObtenerVarios');
        var existencias_min=Producto.existencias_min().prop('disabled',true);
        var existencias_max=Producto.existencias_max().prop('disabled',true);
        
       
        span[0].append(Producto.id_producto().prop('disabled',true).prop('readonly',false));
        span[1].append(Producto.codigo_barras().prop('disabled',true));
        span[2].append(Producto.nombre().prop('disabled',true));
        span[3].append(Producto.descripcion().prop('disabled',true));
        span[4].append(Producto.categoria().prop('disabled',true));
        span[5].append(Producto.precio().prop('disabled',true));
        span[6].append(existencias_min);
        span[7].append(existencias_max);
        span[8].append(Producto.unidad("u").prop('disabled',true));

        for(var i=0;i<9;i++){
            campos.append($('<td>').append(checkbox[i],span[i]));
        }
        campos.append($('<td>').append(Modelo.consultar()));
        
        formObtenerVarios.find('span').on('click',function(){
            $(this).children('input').removeAttr('disabled');
            $(this).prev().prop('checked',true);
            $(this).children('input').focus();
            console.log("hola");
        });
        formObtenerVarios.find(':checkbox').on('click',function(){
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
       var actualQuery=null;
       function despuesConsultaCompleta(responseText, statusText, xhr, $form)  { 
             console.log(responseText);
           json=JSON.parse(responseText);
           actualQuery=json;
           
           lista.empty();
           tabla=$('<table>');
           tr=$('<tr>'); 
           if(json.length==0){
               alert("No se encontró ningun producto");
           }else{ 
               var idactual=-1;
               tabla.html('<tr><th>ID</th><th>#Codigo de Barras</th><th>Nombre</th>\n\
        <th>Descripcion</th><th>Categoría</th><th>Existencias</th><th>Mínimo</th>\n\
        <th>Costo</th><th>Costo Total</th><th>Precio</th><th>Precio Total</th>\n\
     </tr>');
               var totalPrecio=0;
               var totalCosto=0;
               for(var i=0; i<json.length;i++){
                   var row=[];
                  tr=$('<tr>');
                  var costo =(json[i].costo===null)?(""):(fix2(json[i].costo));
                  var costoTotal =(json[i].costoTotal===null)?(""):(fix2(json[i].costoTotal));
                  tr.append(
                        $('<td>',{text:json[i].id}),
                        $('<td>',{text:json[i].codigo_barras}),
                        $('<td>',{text:json[i].nombre}),
                        $('<td>',{text:json[i].descripcion}),
                        $('<td>',{text:json[i].categoria}),
                        $('<td>',{text:json[i].existencias}),
                        $('<td>',{text:(json[i].minimo===null)?(""):(json[i].minimo)}),
                        $('<td>',{text:costo.formatMoney()}),
                        $('<td>',{text:costoTotal.formatMoney()}),
                        $('<td>',{text:json[i].precio.formatMoney()}),
                        $('<td>',{text:json[i].precioTotal.formatMoney()}));
                
                    totalPrecio+=parseFloat(json[i].precio)*parseFloat(json[i].existencias);
                    totalCosto+=parseFloat(json[i].costo||0)*parseFloat(json[i].existencias);
                    tabla.append(tr);
               }
               lista.append(tabla);
               lista.prepend($('<b>',{text:'Cantidad de productos diferentes: '+json.length}));
               lista.prepend($('<br/>'));
               lista.prepend($('<b>',{text:'Valor al Precio del Inventario: '+totalPrecio.formatMoney()}));
               lista.prepend($('<br/>'));
               lista.prepend($('<b>',{text:'Valor al Costo del Inventario: '+totalCosto.formatMoney()}));
               
           }
       } 

       $(document).ready(function() { 
           formObtenerVarios.ajaxForm(opcionesConsulta);
       });

       $('form [type="checkbox"]').on('click',function(){
            $(this).next().prop('disabled',!$(this).prop('checked'));
       });
       
     function fix2(val){
         return parseFloat(val).toFixed(2);
    }

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