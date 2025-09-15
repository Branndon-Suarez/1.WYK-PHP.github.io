USE PROYECTO_WYK;

START TRANSACTION;

-- 👮‍CALL CARGO👮‍
CALL ACTUALIZAR_CARGO(1, 'Cocinero Actualizado', 1);

/* 🤴CALL USUARIO👸
CALL ACTUALIZAR_USUARIO(1, 'usuario_nuevo', 'pass123', NOW(), NOW(), 'Administrador', TRUE);*/

-- 👩‍🍳CALL EMPLEADO👨‍🍳
CALL ACTUALIZAR_EMPLEADO(1, 1001001009, 'Carlos Ramirez Editado', 'O-', 3109998888, 'carlos.ramirez.editado@wyk.com', 1, 1, 1);

-- 👦CALL CLIENTE👦
CALL ACTUALIZAR_CLIENTE(1, 2001001999, 'CC', 'Javier Torres Editado', 3201112222, 'javier.torres.editado@email.com', 1, 5, 1);

-- 🍰CALL PEDIDO🍰
CALL ACTUALIZAR_PEDIDO(1, NOW(), 9, 4, 1, 'ENTREGADO');

-- 🥐CALL PRODUCTO🥐
CALL ACTUALIZAR_PRODUCTO(770001, 'Pan Frances Editado', 2000, 60, '2025-08-01', 'PANADERIA', 'Baguette Grande', 'Wyk Pan Editado', 2, 1);

-- 🚲CALL DETALLE PEDIDO🚲
CALL ACTUALIZAR_DETALLE_PEDIDO(1, 'Pedido de Pan Frances actualizado para mesa 9', 1, 770001, 1);

-- 📄CALL FACTURA VENTA📄
CALL ACTUALIZAR_FACTURA_VENTA(1, 2000, NOW(), 'Venta editada de Pan Frances', 3, 1, 1, 'PENDIENTE');

-- 🔖CALL DETALLE_VENTA_PRODUCTO🔖
CALL ACTUALIZAR_DETALLE_VENTA_PRODUCTO(1, 2, 3000, 1, 770001, 1);

-- 👩‍💼CALL PROVEEDOR👨‍💼
CALL ACTUALIZAR_PROVEEDOR(1, 800100299, 'Harinas del Valle Editado', 6019990000, 'ventas.editado@harinasvalle.com', 1, 1);

-- 🥣CALL MATERIA PRIMA🥣
CALL ACTUALIZAR_MATERIA_PRIMA(1, 'Harina de Trigo Editada', '2026-02-01', 'Kilogramos', 120, 'Harinas del Valle Premium', 'Bulto 25kg', 'Harina especial para panadería', 1, 1);

-- 📜CALL FACTURA COMPRA📜
CALL ACTUALIZAR_FACTURA_COMPRA(1, 260000, NOW(), 'Compra editada de Harina de Trigo', 1, 1, 'PENDIENTE');

-- 📰CALL DETALLE_FACTURA_COMPRA_MATERIA_PRIMA📰
CALL ACTUALIZAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA(1, 120, 260000, 1, 1, 1);

-- 🍮CALL DETALLE_COMPRA_PRODUCTO🍮
CALL ACTUALIZAR_DETALLE_COMPRA_PRODUCTO(1, 35, 140000, 5, 770003, 1);

-- 🍲CALL PRODUCCION🍲
CALL ACTUALIZAR_PRODUCCION(1, 'Produccion Pan Frances Editada', 55, 'Produccion ajustada de Pan Frances', 30, 1, 770001, 2, 1);

COMMIT;
SELECT 'Todos los CALL ejecutados correctamente. COMMIT realizado.' AS Mensaje;

/*ROLLBACK; ejecutar en caso de error.*/