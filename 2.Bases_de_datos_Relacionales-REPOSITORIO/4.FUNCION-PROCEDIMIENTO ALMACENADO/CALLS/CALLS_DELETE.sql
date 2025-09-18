USE PROYECTO_WYK;

START TRANSACTION;

-- 👮‍♀️ CALL CARGO 👮‍♀️
CALL INSERTAR_CARGO('TesterCargo', 1);
CALL ELIMINAR_CARGO(LAST_INSERT_ID());

-- 🤴 CALL USUARIO 👸
CALL INSERTAR_USUARIO('usuario.test', 'password_test', NOW(), NOW(), 'CLIENTE', 1);
CALL ELIMINAR_USUARIO(LAST_INSERT_ID());

-- 👩‍🍳 CALL EMPLEADO 👨‍🍳
CALL INSERTAR_EMPLEADO(999999001, 'Empleado Test', 'O+', 3000000001, 'empleado.test@wyk.com', 1, 1, 1);
CALL ELIMINAR_EMPLEADO(LAST_INSERT_ID());

-- 👦 CALL CLIENTE 👦
CALL INSERTAR_CLIENTE(999999002, 'CC', 'Cliente Test', 3000000002, 'cliente.test@email.com', 1, 1);
CALL ELIMINAR_CLIENTE(LAST_INSERT_ID());

-- 🥐 CALL PRODUCTO 🥐
-- El ID_PRODUCTO no es AUTO_INCREMENT, así que debemos usar el mismo ID para insertar y eliminar.
SET @id_producto_test = 779999;
CALL INSERTAR_PRODUCTO(@id_producto_test, 'Producto Test', 1000, 10, '2026-01-01', 'PRUEBA', 'Producto de prueba', 'Wyk Test', 1, 1);
CALL ELIMINAR_PRODUCTO(@id_producto_test);

-- 🛍️ CALL VENTA 🛍️
CALL INSERTAR_VENTA(NOW(), 5000, 1, 'Venta de prueba para eliminar', 'PAGADA', 1, 1);
CALL ELIMINAR_VENTA(LAST_INSERT_ID());

-- 🛒 CALL DETALLE VENTA 🛒
CALL INSERTAR_DETALLE_VENTA(5, 5000, 1, 770001);
CALL ELIMINAR_DETALLE_VENTA(LAST_INSERT_ID());

-- 🗄️ CALL AJUSTE INVENTARIO 🗄️
CALL INSERTAR_AJUSTE_INVENTARIO(770001, 'MERMA', 2, NOW(), 'Ajuste de prueba para eliminar', 1);
CALL ELIMINAR_AJUSTE_INVENTARIO(LAST_INSERT_ID());

-- 👩‍💼 CALL PROVEEDOR 👨‍💼
CALL INSERTAR_PROVEEDOR(899999001, 'Proveedor Test', 6015551111, 'proveedor.test@email.com', 1, 1);
CALL ELIMINAR_PROVEEDOR(LAST_INSERT_ID());

-- 🥣 CALL MATERIA PRIMA 🥣
CALL INSERTAR_MATERIA_PRIMA('Materia Prima Test', '2026-02-02', 'Kilogramos', 10, 'MarcaTest', 'Caja 1kg', 'Materia prima de prueba', 1, 1);
CALL ELIMINAR_MATERIA_PRIMA(LAST_INSERT_ID());

-- 📜 CALL FACTURA COMPRA 📜
CALL INSERTAR_FACTURA_COMPRA(25000, NOW(), 'Factura compra test', 1, 1, 'PENDIENTE');
CALL ELIMINAR_FACTURA_COMPRA(LAST_INSERT_ID());

-- 📰 CALL DETALLE_FACTURA_COMPRA_MATERIA_PRIMA 📰
-- El ID_DETALLE_FAC_MAT_PRIM no es AUTO_INCREMENT. Usamos una variable para el ID.
SET @id_detalle_fac_mat_prima_test = 5;
CALL INSERTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA(@id_detalle_fac_mat_prima_test, 5, 10000, 1, 1, 1);
CALL ELIMINAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA(@id_detalle_fac_mat_prima_test);

-- 🍮 CALL DETALLE_COMPRA_PRODUCTO 🍮
-- El ID_DETALLE_COMPRA_PRODUCTO no es AUTO_INCREMENT. Usamos una variable para el ID.
SET @id_detalle_compra_producto_test = 5;
CALL INSERTAR_DETALLE_COMPRA_PRODUCTO(@id_detalle_compra_producto_test, 5, 15000, 1, 770001, 1);
CALL ELIMINAR_DETALLE_COMPRA_PRODUCTO(@id_detalle_compra_producto_test);

-- 🍲 CALL PRODUCCION 🍲
CALL INSERTAR_PRODUCCION('Producción Test', 5, 'Prueba de producción', 2, 1, 770001, 1, 1);
CALL ELIMINAR_PRODUCCION(LAST_INSERT_ID());

COMMIT;
SELECT 'Todos los procedimientos de inserción y eliminación se han ejecutado correctamente. COMMIT realizado.' AS Mensaje;