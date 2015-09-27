function Modelo(){};
Modelo.consultar=function(){
    return $('<input>',{type:'submit',value:'Consultar'});
};

Modelo.agregar=function(){
    return $('<input>',{type:'submit',value:'Agregar'});
};

var Usuario=new Object();
Usuario.prototype=new Modelo;           
Usuario.id_usuario=function(valor){
    return $('<input>',{name:'id_usuario',type:'number',readonly:'readonly',
        placeholder:'Id del usuario',step:'1',min:1,
        value:(typeof(valor)!==undefined?valor:"")});
};
Usuario.nombre=function(valor){
    return $('<input>',{name:'nombre',type:'text',maxlength:30,
        required:'required',placeholder:'Nombre',
        value:(typeof(valor)!==undefined?valor:"")});
};
Usuario.apellido_paterno=function(valor){
    return $('<input>',{name:'apellido_paterno',type:'text',
        maxlength:30,required:'required',placeholder:'Apellido Paterno',
        value:(typeof(valor)!==undefined?valor:"")});
};
Usuario.apellido_materno=function(valor){
    return $('<input>',{name:'apellido_materno',type:'text',
        maxlength:30,placeholder:'Apellido Materno',
        value:(typeof(valor)!==undefined?valor:"")});
};
Usuario.contrasena=function(valor){
    return $('<input>',{name:'contrasena',type:'password',
        maxlength:30,required:'required',placeholder:'Contraseña',
        value:(typeof(valor)!==undefined?valor:"")});
};
Usuario.telefono=function(valor){
    return $('<input>',{name:'telefono',type:'text',
        maxlength:30,placeholder:'Teléfono',
        value:(typeof(valor)!==undefined?valor:"")});
};
Usuario.celular=function(valor){
    return $('<input>',{name:'celular',type:'text',
        maxlength:30,placeholder:'Celular',
        value:(typeof(valor)!==undefined?valor:"")});
};
Usuario.direccion=function(valor){
    return $('<input>',{name:'direccion',type:'text',
        maxlength:30,required:'required',placeholder:'Dirección',
        value:(typeof(valor)!==undefined?valor:"")});
};
Usuario.nivel=function(valor){
   var select= $('<select>',{name:'nivel',required:'required',placeholder:'Contraseña'});
   var option1=$('<option>',{value:'e',text:'Empleado'});
   var option2=$('<option>',{value:'g',text:'Supervisor'});
   var option3=$('<option>',{value:'a',text:'Administrador'});
   var option4=$('<option>',{value:'n',text:'No disponible'});
   switch (valor){
       case 'e':
           option1.prop('selected',true);
           break;
       case 'g':
           option2.prop('selected',true);
           break;
       case 'a':
           option3.prop('selected',true);
           break;
       case 'n':
           option4.prop('selected',true);
           break;
   }
   select.append(option1,option2,option3,option4);
   return  select;
};

/////////////////////////////////////////////////////////

var Cliente=new Object();
Cliente.prototype=new Modelo(); 

Cliente.id_cliente=function(valor){
    return $('<input>',{name:'id_cliente',type:'number',readonly:'readonly',
        placeholder:'Id del cliente',step:'1',min:1,
        value:(typeof(valor)!==undefined?valor:"")});
};
Cliente.nombre=function(valor){
    return $('<input>',{name:'nombre',type:'text',maxlength:30,
        required:'required',placeholder:'Nombre',
        value:(typeof(valor)!==undefined?valor:"")});
};
Cliente.telefono=function(valor){
    return $('<input>',{name:'telefono',type:'text',
        maxlength:30,placeholder:'Teléfono',
        value:(typeof(valor)!==undefined?valor:"")});
};
Cliente.celular=function(valor){
    return $('<input>',{name:'celular',type:'text',
        maxlength:30,placeholder:'Celular',
        value:(typeof(valor)!==undefined?valor:"")});
};
Cliente.direccion=function(valor){
    return $('<input>',{name:'direccion',type:'text',
        maxlength:30,placeholder:'direccion',
        value:(typeof(valor)!==undefined?valor:"")});
};


//////////Productos/////////////


 var Producto=new Object();
Producto.prototype=new Modelo();              
Producto.id_producto=function(valor){
    return $('<input>',{name:'id_producto',type:'number',readonly:'readonly',
        placeholder:'Id del producto',step:'1',min:1,
        value:(typeof(valor)!==undefined?valor:"")});
};
Producto.codigo_barras=function(valor){
    return $('<input>',{name:'codigo_barras',type:'text',maxlength:65,
        placeholder:'Código de Barras',
        value:(typeof(valor)!==undefined?valor:"")});
};
Producto.nombre=function(valor){
    return $('<input>',{name:'nombre',type:'text',
        maxlength:30,required:'required',placeholder:'Nombre',
        value:(typeof(valor)!==undefined?valor:"")});
};
Producto.descripcion=function(valor){
    return $('<input>',{name:'descripcion',type:'text',
        maxlength:80,placeholder:'Descripción',
        value:(typeof(valor)!==undefined?valor:"")});
};


Producto.categorias=null;

Producto.categoriaId=function(id){
    for(i=0;i<Producto.categorias.length;i++){
        if(Producto.categorias[i].id==id)
            return Producto.categorias[i].nombre;
    }
    return "";
}
Producto.categoria=function(valor){
    var select=$('<select>',{name:'id_categoria'});
    if(Producto.categorias===null){
        a=function (select){
            $.post("/Abarrotes/Categoria/ObtenerTodos",function(data){
                Producto.categorias=JSON.parse(data);
                Producto.categoriaSelect(valor,select)
            });
        }(select);
    }else{
       // console.log(valor);
        Producto.categoriaSelect(valor,select);
    }
   
    return select;
};


Producto.categoriaSelect=function(valor,select){
    for(var i=0;i<Producto.categorias.length;i++){
       var option=$('<option>',{
           value:Producto.categorias[i].id,
           text:Producto.categorias[i].nombre
       });

       if(valor==Producto.categorias[i].id){
           option.attr("selected","selected");
          // console.log(option); 
       }
       select.append(option);
   }
};

Producto.precio=function(valor){
    return $('<input>',{name:'precio',type:'number',
        min:0,step:0.01,required:'required',placeholder:'Precio',
        value:(typeof(valor)!==undefined?valor:"")});
};

Producto.existencias=function(valor,unidad){
    switch (unidad){ 
       case 'u':
           return $('<input>',{name:'existencias',type:'number',
        min:0,step:1,placeholder:'Existencias',
        value:(typeof(valor)!==undefined?valor:"")});
       case 'k':
           return $('<input>',{name:'existencias',type:'number',
        min:0,step:0.001,placeholder:'Existencias',
        value:(typeof(valor)!==undefined?valor:"")});
           break;
       default: 
            return $('<input>',{name:'existencias',type:'number',
        min:0,step:1,placeholder:'Existencias',
        value:(typeof(valor)!==undefined?valor:"")});
    }
};
Producto.minimo=function(valor){
    return $('<input>',{name:'minimo',type:'number',
        min:0,step:1,required:'required',placeholder:'Mínimo',
        value:(typeof(valor)!==undefined?valor:"")});
};
Producto.existencias_min=function(valor,unidad){
    switch (unidad){ 
       case 'u':
           return $('<input>',{name:'existencias_min',type:'number',
        min:0,step:1,placeholder:'Existencias (Min)',
        value:(typeof(valor)!==undefined?valor:"")});
       case 'k':
           return $('<input>',{name:'existencias_min',type:'number',
        min:0,step:0.001,placeholder:'Existencias (Min)',
        value:(typeof(valor)!==undefined?valor:"")});
           break;
       default: 
            return $('<input>',{name:'existencias_min',type:'number',
        min:0,step:1,placeholder:'Existencias (Min)',
        value:(typeof(valor)!==undefined?valor:"")});
    }
};

Producto.existencias_max=function(valor,unidad){
    switch (unidad){ 
       case 'u':
           return $('<input>',{name:'existencias_max',type:'number',
        min:0,step:1,placeholder:'Existencias (Max)',
        value:(typeof(valor)!==undefined?valor:"")});
       case 'k':
           return $('<input>',{name:'existencias_max',type:'number',
        min:0,step:0.001,placeholder:'Existencias (Max)',
        value:(typeof(valor)!==undefined?valor:"")});
           break;
       default: 
            return $('<input>',{name:'existencias_max',type:'number',
        min:0,step:1,placeholder:'Existencias (Max)',
        value:(typeof(valor)!==undefined?valor:"")});
    }
};





Producto.unidad=function(valor,existencias){
   var select= $('<select>',{name:'unidad',required:'required'});
   var option1=$('<option>',{value:'u',text:'Unidad'});
   var option2=$('<option>',{value:'k',text:'Kg'});
   switch (valor){
       case 'u':
           option1.prop('selected',true);
           break;
       case 'k':
           option2.prop('selected',true);
           break
       default:
           option1.prop('selected',true);
           
   }
   select.append(option1,option2);
 
   select.on('change',function(e){
        switch ($(this).val()){
        case 'u':
            existencias.attr('step',1);
            break;
        case 'k':
            existencias.attr('step',0.001);
            break
        }
   });
   return  select;
};



var Categoria=new Object();
Categoria.prototype=new Modelo;           
Categoria.id=function(valor){
    return $('<input>',{name:'id',type:'number',readonly:'readonly',
        placeholder:'Id de la categoría',step:'1',min:1,
        value:(typeof(valor)!==undefined?valor:"")});
};
Categoria.nombre=function(valor){
    return $('<input>',{name:'nombre',type:'text',maxlength:30,
        required:'required',placeholder:'Nombre',
        value:(typeof(valor)!==undefined?valor:"")});
};


function guardarPDF(source){
    var pdf = new jsPDF('p', 'pt', 'letter');
    specialElementHandlers = {
        '#crearPDF': function (element, renderer) {
            return true
        }
    };
    margins = {
        top: 20,
        bottom: 20,
        left: 20,
        width: 622
    };
    pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top, { // y coord
        'width': margins.width, // max width of content on PDF
        'elementHandlers': specialElementHandlers
    },
    function (dispose) {
        pdf.save('ventas.pdf');
    }, margins);
}
