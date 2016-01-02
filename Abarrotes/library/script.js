var opcionesEliminar = { 
    beforeSubmit:   antesEliminar,
    success:       despuesEliminar 
}; 
function antesEliminar(){
    if(confirm('¿Está seguro de eliminar el producto?\n \n\
        EL CAMBIO NO SE PODRÁ DESHACER')){
        return true;
    }
    return false;
}
function despuesEliminar(responseText, statusText, xhr, $form)  { 
    if(responseText=='0'){
        alert("Eliminado con éxito");
        formObtenerVarios.ajaxSubmit(opcionesConsulta);
    }else{
        if(responseText==1){
            mensaje="Existe una venta relacionada";
        }
        alert("No se pudo eliminar\n"+
            mensaje+"-"+responseText);
    }
    console.log(responseText);
} 

var opcionesActualizar = { 
    success:       despuesActualizar 
}; 

function despuesActualizar(responseText, statusText, xhr, $form)  { 
    if(responseText=='0'){
        alert("Actualizado con Éxito");
    }else{
        alert("No se pudo actualizar u.u\n\
"+responseText);
    }
    console.log(responseText); 
} 

var opcionesInsertar = { 
    success:       despuesInsertar
}; 

function despuesInsertar(responseText, statusText, xhr, $form)  { 
    if(responseText>=0){
        alert("Insertado con Éxito");
        formInsertar.resetForm();
    }else{
        alert("No se pudo insertar u.u \n \n\
"+responseText);
    }
    
}

String.prototype.formatMoney = Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return "$"+s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};