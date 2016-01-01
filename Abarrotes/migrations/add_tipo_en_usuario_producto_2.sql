ALTER TABLE abarrotes.usuario_producto CHANGE tipo tipo
    enum("Traslado","Caducado","Ajuste","Conversion","Consesion","Compra","Promocion","Consumible","Otros","Comision")
    DEFAULT "Ajuste";
