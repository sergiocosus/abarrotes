select p.id_producto as id,
       p.codigo_barras as codigo_barras,
       p.nombre as nombre,
       p.descripcion as descripcion,
       p.existencias - ifnull(usuario_producto_total.cantidad_total,0) + ifnull(venta_producto_total.cantidad_total,0) as existencias,
       venta_producto_total.cantidad_total vendidos,
       usuario_producto_total.cantidad_total movidos,
       p.existencias as existencia_actual,
       p.minimo as minimo,
       p.precio as precio,
       p.existencias*p.precio as precioTotal,
       p.costo as costo,
       p.existencias*p.costo as costoTotal,
       c.id as id_categoria,
       c.nombre as categoria

from producto as p
        left JOIN  (select usuario_producto.*, sum(cantidad) as cantidad_total from usuario_producto
                     where usuario_producto.fecha_hora >= "2015-11-01"
                    GROUP BY usuario_producto.id_producto) as usuario_producto_total
              ON (p.id_producto = usuario_producto_total.id_producto)
       left JOIN (
                 SELECT venta_producto.*, subventa.fecha_hora,sum(venta_producto.cantidad) as cantidad_total from venta_producto
                     JOIN venta as subventa on venta_producto.id_venta = subventa.id_venta
                     where subventa.fecha_hora >= "2015-11-01"
                     GROUP BY venta_producto.id_producto) as venta_producto_total

              on (p.id_producto = venta_producto_total.id_producto)

       join categoria as c on (id_categoria=id)

GROUP BY p.id_producto;