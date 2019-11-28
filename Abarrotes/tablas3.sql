Create database abarrotes character set utf8

create table usuario (
	id_usuario int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
	nombre varchar(30) NOT NULL,
	apellido_paterno varchar(30) NOT NULL, 
	apellido_materno varchar(30),
	contrasena varchar(30),
	telefono varchar(30), 
	celular varchar(30), 
	direccion varchar(200),
	nivel enum('a','e','n','g') NOT NULL,
	fecha_hora_de_alta TIMESTAMP, 
	CONSTRAINT pk_usuario PRIMARY KEY (id_usuario)
);

create table producto (
	id_producto int (10) UNSIGNED NOT NULL AUTO_INCREMENT,
	codigo_barras varchar(65) UNIQUE,
	nombre varchar (30) NOT NULL,
	descripcion  varchar(80),
	precio decimal(8,2) UNSIGNED NOT NULL,
	existencias  decimal(9,3) UNSIGNED DEFAULT 0,
	unidad enum('u','k') default 'u'  NOT NULL,
	CONSTRAINT pk_producto PRIMARY KEY (id_producto)	
);


create table venta (
	id_venta int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	id_usuario int(4) UNSIGNED NOT NULL,
	id_cliente int(6) UNSIGNED NOT NULL,
	fecha_hora TIMESTAMP,
	total decimal(9,3) UNSIGNED,
	CONSTRAINT  fk_venta_to_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
	CONSTRAINT  fk_venta_to_cliente FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
	CONSTRAINT pk_venta PRIMARY KEY (id_venta)
);

create table venta_producto(
	id_venta int (10) UNSIGNED NOT NULL,
	id_producto int (10)  UNSIGNED NOT NULL,
	cantidad decimal(9,3) UNSIGNED not null,
	precio decimal(8,2) not null,
	CONSTRAINT fk_vp_to_producto FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
	CONSTRAINT fk_vp_to_venta FOREIGN KEY (id_venta) REFERENCES venta(id_venta),
	CONSTRAINT pk_producto PRIMARY KEY (id_venta,id_producto),
	CONSTRAINT chk_cantidad CHECK (cantidad>0)
);

//////////////////////////////////////////////////////////

create table cliente (
	id_cliente int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
	nombre varchar(30) NOT NULL,
	telefono varchar(30), 
	celular varchar(30), 
	direccion varchar(200), 
	CONSTRAINT pk_cliente PRIMARY KEY (id_cliente)
);


create table usuario_producto(
	id_usuario int (4) UNSIGNED NOT NULL,
	id_producto int (10)  UNSIGNED NOT NULL,
	fecha_hora TIMESTAMP,
	cantidad decimal(9,3)  not null,
	costo decimal(8,2) not null,
	CONSTRAINT fk_pp_to_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
	CONSTRAINT fk_pp_to_producto FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
	CONSTRAINT pk_fecha_hora PRIMARY KEY (fecha_hora),
	CONSTRAINT chk_cantidad CHECK (cantidad>0)
);

create table categoria(
    id int unsigned auto_increment,
    nombre varchar(50),
    constraint categoria_pk primary key (id)
);


insert into categoria values (1,"General");
alter table producto add id_categoria int unsigned;
alter table producto add constraint categoria_fk foreign key (id_categoria) references categoria(id);

update producto set id_categoria=1;


        


/*
create table historial_producto(
	id_producto int (10)  UNSIGNED NOT NULL,
	id_usuario int(4) UNSIGNED NOT NULL,
	motivo enum('i','e','p') NOT NULL,
	cantidad decimal(9,3) not null,
	fecha_hora timestamp,
	CONSTRAINT fk_abp_to_producto FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
	CONSTRAINT fk_abp_to_empleado FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
	CONSTRAINT pk_alta_baja_producto PRIMARY KEY (id_usuario,id_producto,fecha_hora)
);
*/

create view inventario as (
    select p.id_producto as id,p.codigo_barras as codigo_barras, p.nombre as nombre, 
        p.descripcion as descripcion, p.precio as precio, p.existencias as existencias,
        p.existencias*p.precio as subtotal, c.id as id_categoria,
         c.nombre as categoria   from producto as p join categoria as c on (id_categoria=id)
);



alter table producto
    add oculto tinyint(1) default false null;
