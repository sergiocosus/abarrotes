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
        <div id="eleccion">
            <h2>Actualización de existencias</h2>
            <form id="actualizarExistencias" action="/Abarrotes/UsuarioProducto/Insertar" method="post">
                <div>
                    <span>#Producto</span>
                    <input type="number" required readonly="readonly" name="id_producto"/>
                </div>
                <div>
                    <span>#Nombre</span>
                    <input type="text" readonly="readonly" name="nombre"/>
                </div>
                <div>
                    <span>#Cantidad</span>
                    <input type="number" required name="cantidad" placeholder="Cantidad"/>
                </div>
                <div>
                    <span>Costo anterior</span>
                    <input type="number" name="costo_anterior" disabled />
                </div>
                <div>
                    <span>#Costo</span>
                    <input type="number" required name="costo" step="0.01" placeholder="Costo"/>
                </div>
                <div>
                    <span>Tipo</span>
                    <select name="tipo" required>
                        <option value="">None</option>
                        <option value="Ajuste">Ajuste</option>
                        <option value="Caducado">Caducado</option>
                        <option value="Traslado">Traslado</option>
                        <option value="Conversion">Conversión</option>
                        <option value="Consesion">Consesión</option>
                        <option value="Compra">Compra</option>
                        <option value="Promocion">Promoción</option>
                        <option value="Consumible">Consumible</option>
                        <option value="Comision">Comisión</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>
                <input id="submit-update-product" type="submit"/>
            </form>
            </br>
            <button>Cancelar</button>
        </div>
        <div id="cuadrito">
            <form id="formInsertar" action="/Abarrotes/Producto/Insertar" method="post">
                <a class="link" href="/Abarrotes/Categoria/Ver">Categorias</a>
                <h3>Insertar Producto</h3>
            </form>
           <hr/>
            <form id="formObtenerVarios" action="/Abarrotes/Producto/ObtenerTodos" method="post">
                 <table>
                    <tr>
                        <th colspan="8">
                            Consuta de productos
                        </th>
                    </tr>
                    <tr>
                        <th>#Producto</th>
                        <th>Codigo de Barras</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Existencias</th>
                        <th>Mínimo</th>
                        <th>Unidad</th>
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
        ' <th>ID</th> <th>Barras</th> <th>Nombre</th>\n\
<th>Descripcion</th><th>Categoría</th><th>Precio</th><th>Existencias</th>\n\
<th>Mínimo</th><th>Unidad</th>');
lista.append(th);

////Menú Insertar///////////

var codigo_barras=Producto.codigo_barras();
codigo_barras.on('keypress',function(e){
    if (e.which == 13) {
        $.post("/Abarrotes/Producto/ObtenerTodos", { codigo_barras: codigo_barras.val() },function(data){
            producto =  JSON.parse(data); 
            console.log(producto);
            if(producto.length>0){
                alert('El producto con ese código de barras ya fue insertado');
                codigo_barras.select();
                agregarElementosConsulta(producto);
            }
        });
    }
});


formInsertar.append(codigo_barras,'<br/>',
Producto.nombre(),'<br/>',
     Producto.descripcion(),'<br/>',
     Producto.categoria(),'<br/>',
     Producto.precio(),'<br/>',
     Producto.minimo(),'<br/>',
     Producto.unidad("u",existencias),'<br/>',
     Modelo.agregar()
);

////Menú Consulta////////////
var checkbox=[];
var span=[];
var td=[];


for(var i=0;i<9;i++){
    checkbox[i]=$('<input>',{type:'checkbox'});
    span[i]=$('<span>');
    td[i]=$('<td>').append(checkbox[i],span[i]);
    camposObtenerVarios.append(td[i]);
}

var codigo_barrasConsulta=Producto.codigo_barras().prop('disabled',true);

var existencias=Producto.existencias().prop('disabled',true);
span[0].append(Producto.id_producto().prop('disabled',true).prop('readonly',false));
span[1].append(codigo_barrasConsulta);
span[2].append(Producto.nombre().prop('disabled',true));
span[3].append(Producto.descripcion().prop('disabled',true));
span[4].append(Producto.categoria().prop('disabled',true));
span[5].append(Producto.precio().prop('disabled',true));
span[6].append(existencias);
span[7].append(Producto.minimo().prop('disabled',true));
span[8].append(Producto.unidad("u").prop('disabled',true));

camposObtenerVarios.append($('<td>').append($('<span>').append(Modelo.consultar())));

camposObtenerVarios.find('span').on('click',function(){
    $(this).children('input').removeAttr('disabled');
    $(this).prev().prop('checked',true);
    $(this).children('input').select();
});
camposObtenerVarios.find(':checkbox').on('click',function(){
     $(this).next().children().prop('disabled',!$(this).prop('checked'));
});
var opcionesConsulta = { 
    success:       despuesConsultaCompleta  // post-submit callback   
}; 
function despuesConsultaCompleta(responseText, statusText, xhr, $form)  { 
    formActualizar =$('#formActualizarCliente');
    //console.log(responseText);
    json=JSON.parse(responseText);
  
    if(json.length==0){
        alert("No se encontró ningún producto");
    }
    else{ 
        agregarElementosConsulta(json);
    }
} 
var dataa;
function agregarElementosConsulta(json){
    lista.empty();
    lista.append(th);
    for(var i=0; i<json.length;i++){
        var tr=$('<tr>');
        
        var eliminar=$('<button>',{type:'submit',text:"X"});
        eliminar.on('click',{form:tr,elemento:json[i]},function(e){
            dataa=e;
            if(confirm('¿Desea eliminar "'+e.data.elemento.nombre+'"?')){
                $.post('/Abarrotes/Producto/Eliminar',{id_producto:e.data.elemento.id_producto},function(info){
                    if(info!='0')
                    alert(info);
                    e.data.form.remove();
                });
            }
        });
        
        var form=$('<form>',{action:"/Abarrotes/Producto/Actualizar",
            method:"post",id:"form"+i});

        submit=$('<input>',{type:'submit',value:"✓"});
        var button=$('<button>',{text:json[i].existencias
         });
        button.on('click',{button:button,producto:json[i]},function(e){
            Existencias.actual=e.data.button;
            Existencias.id_producto.attr('value',e.data.producto.id_producto);
            Existencias.nombre.attr('value',e.data.producto.nombre);
            if(e.data.producto.unidad==="k"){
                Existencias.cantidad.attr('step',0.005);
            }else{
                Existencias.cantidad.attr('step',1 );
            }
            eleccion.show();
            Existencias.costoAnterior.attr('value', e.data.producto.costo);
            Existencias.costo.attr('value','');
            Existencias.cantidad.attr('value','0');
            Existencias.cantidad.focus();
         }
        );
        with(Producto){
        tr.append(
            form.append($('<td>').append(id_producto(json[i].id_producto).attr('form','form'+i))),
            $('<td>').append(codigo_barras(json[i].codigo_barras).attr('form','form'+i)),
            $('<td>').append(nombre(json[i].nombre).attr('form','form'+i)),
            $('<td>').append(descripcion(json[i].descripcion).attr('form','form'+i)),
            $('<td>').append(categoria(json[i].id_categoria).attr('form','form'+i)),
            $('<td>').append(precio(json[i].precio).attr('form','form'+i)),
            $('<td>').append(button),
            $('<td>').append(minimo(json[i].minimo).attr('form','form'+i)),
            $('<td>').append(unidad(json[i].unidad,existencias).attr('form','form'+i)),
            $('<td>').append(submit.attr('form','form'+i)),
            $('<td>').append(eliminar)
            );
        }

       
        form.ajaxForm(opcionesActualizar);
        lista.append(tr);                                
    }
}

$(document).ready(function() { 
    formObtenerVarios.ajaxForm(opcionesConsulta);
    formInsertar.ajaxForm(opcionesInsertar2);

});
var opcionesInsertar2 = { 
    success:       despuesInsertar2
}; 
function despuesInsertar2(responseText, statusText, xhr, $form)  { 
    if(responseText>=0){
        $.post( "/Abarrotes/Producto/obtenerTodos", {id_producto: responseText},function(data){
            producto=JSON.parse(data)[0];
            Existencias.actual=null;
             Existencias.id_producto.attr('value',producto.id_producto);
             Existencias.nombre.attr('value',producto.nombre);
             if(producto.unidad==="k"){
                 Existencias.cantidad.attr('step',0.005);
             }else{
                 Existencias.cantidad.attr('step',1 );
             }
             
             eleccion.show(); 
             Existencias.costo.attr('value','0');
             Existencias.cantidad.attr('value','');
             Existencias.cantidad.focus();

         });
        formInsertar.resetForm();
    }else{
        alert("No se pudo insertar u.u \n \n\
"+responseText);
    }
    
} 



////////////////////////////////
var eleccion=$('#eleccion');
var formActInv=eleccion.children('form');
var Existencias=new Object();
Existencias.formActInv=formActInv;
Existencias.id_producto=formActInv.find('[name="id_producto"]');
Existencias.nombre=formActInv.find('[name="nombre"]');
Existencias.cantidad=formActInv.find('[name="cantidad"]');
Existencias.costo=formActInv.find('[name="costo"]');
Existencias.tipo=formActInv.find('[name="tipo"]');
Existencias.costoAnterior=formActInv.find('[name="costo_anterior"]');
Existencias.actual=null;



eleccion.children('button').on('click',function(){
    eleccion.hide(200);
});

var elementos=$('#elementos');
eleccion.hide();

formActInv.ajaxForm(actualizacionOpciones);

var actualizacionOpciones = {
    beforeSubmit: function(){
        $('#submit-update-product').prop('disabled',true);
    },
    success:       despues  // post-submit callback   
}; 

$(formActInv[0]).ajaxForm(actualizacionOpciones);

var testt;
function despues(responseText, statusText, xhr, $form)  {
    $('#submit-update-product').prop('disabled',false);
    if(responseText=="0"){
        eleccion.hide(200);
        Existencias.cantidad.val(0);
        formActInv.resetForm();
        $.post("/Abarrotes/Producto/ObtenerTodos", { id_producto: $form[0][0].value },function(data){
            producto =  JSON.parse(data)[0]; 
            Existencias.actual.html(producto.existencias);
        });;
        //Existencia.actual.
        console.log(responseText);
        formInsertar.find('[name="codigo_barras"]').focus();
    }else{
        console.log(responseText);
        alert('Error \n'+responseText);
    }

}
            
           
    </script> 
    <style>
        .botonEliminar{
            display: inline-block;
        }
    </style>
    <?php include 'library/MuestraUsuario.php'; ?>
    </body>
</html>
 