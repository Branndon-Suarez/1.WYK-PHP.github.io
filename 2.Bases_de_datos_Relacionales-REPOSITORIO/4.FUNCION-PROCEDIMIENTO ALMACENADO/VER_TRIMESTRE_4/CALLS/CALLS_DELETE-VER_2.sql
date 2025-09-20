USE PROYECTO_WYK;

START TRANSACTION;

-- ==================================================
-- INSERTAR UN REGISTRO EN CADA TABLA PARA PRUEBA
-- ==================================================

-- 👮‍♂️ INSERTAR ROL
CALL INSERTAR_ROL('Rol Test', 'EMPLEADO', 1);
SET @id_rol_test = LAST_INSERT_ID();

-- 🤴 INSERTAR USUARIO
CALL INSERTAR_USUARIO(999999, 'Usuario Test', 'pass123', 3109999999, 'usuario.test@mail.com', NOW(), @id_rol_test, 1);
SET @id_usuario_test = LAST_INSERT_ID();

-- 👩‍🍳 INSERTAR TAREA
CALL INSERTAR_TAREA('Tarea Test', 'Categoria Test', 'Descripcion prueba', 2, 'ALTA', 'PENDIENTE', @id_usuario_test, @id_usuario_test);
SET @id_tarea_test = LAST_INSERT_ID();

-- 🥐 INSERTAR PRODUCTO
SET @id_producto_test = 999999;
CALL INSERTAR_PRODUCTO(@id_producto_test, 'Producto Test', 1000, 10, '2026-01-01', 'PANADERIA', @id_usuario_test, 1);

-- 🛍️ INSERTAR VENTA
CALL INSERTAR_VENTA(NOW(), 5000, NULL, 'Venta prueba', @id_usuario_test, 'PAGADA');
SET @id_venta_test = LAST_INSERT_ID();

-- 🥣 INSERTAR MATERIA_PRIMA
CALL INSERTAR_MATERIA_PRIMA('Materia Prima Test', '2026-12-31', 50, 'Kg', 'Descripcion prueba', @id_usuario_test, 1);
SET @id_materia_test = LAST_INSERT_ID();

-- 📜 INSERTAR COMPRA
CALL INSERTAR_COMPRA(NOW(), 'MATERIA PRIMA', 100000, 'Proveedor Test', 'Marca Test', 3201111111, 'proveedor.test@mail.com', 'Descripcion compra', @id_usuario_test, 'PAGADA');
SET @id_compra_test = LAST_INSERT_ID();

-- 🛒 INSERTAR DETALLE_VENTA
CALL INSERTAR_DETALLE_VENTA(2, 2000, @id_venta_test, @id_producto_test);
SET @id_det_venta_test = LAST_INSERT_ID();

-- 🗄️ INSERTAR AJUSTE_INVENTARIO
CALL INSERTAR_AJUSTE_INVENTARIO(NOW(), 'DAÑADO', 1, 'Ajuste prueba', @id_producto_test, @id_usuario_test);
SET @id_ajuste_test = LAST_INSERT_ID();

-- 📰 INSERTAR DETALLE_COMPRA_MATERIA_PRIMA
SET @id_det_compra_mat_test = 8888;
CALL INSERTAR_DETALLE_COMPRA_MAT_PRIMA(@id_det_compra_mat_test, 10, 50000, @id_compra_test, @id_materia_test, 1);

-- 🍮 INSERTAR DETALLE_COMPRA_PRODUCTO
SET @id_det_compra_prod_test = 7777;
CALL INSERTAR_DETALLE_COMPRA_PRODUCTO(@id_det_compra_prod_test, 5, 25000, @id_compra_test, @id_producto_test, 1);

-- 🍫 INSERTAR RECETA (CORREGIDO)
CALL INSERTAR_RECETA(@id_producto_test, @id_materia_test, 2, 'Kg');
SET @id_receta_test = LAST_INSERT_ID(); -- <-- ÚNICO CAMBIO REALIZADO

-- 🍲 INSERTAR PRODUCCION
CALL INSERTAR_PRODUCCION('Producción Test', 5, 'Descripcion producción', @id_producto_test, @id_usuario_test, 1);
SET @id_produccion_test = LAST_INSERT_ID();

-- 🥄 INSERTAR DETALLE_PRODUCCION
CALL INSERTAR_DETALLE_PRODUCCION(@id_produccion_test, @id_materia_test, 2, 2);
SET @id_det_prod_test = LAST_INSERT_ID();

-- ==================================================
-- ELIMINAR LOS REGISTROS (ORDEN CORRECTO SEGÚN FK)
-- ==================================================

-- 1. Eliminar los detalles más profundos y tablas de relación
CALL ELIMINAR_DETALLE_PRODUCCION(@id_det_prod_test);
CALL ELIMINAR_DETALLE_VENTA(@id_det_venta_test);
CALL ELIMINAR_DETALLE_COMPRA_PRODUCTO(@id_det_compra_prod_test);
CALL ELIMINAR_DETALLE_COMPRA_MATERIA_PRIMA(@id_det_compra_mat_test);
CALL ELIMINAR_RECETA(@id_receta_test); -- Ahora funciona con el ID correcto
CALL ELIMINAR_AJUSTE_INVENTARIO(@id_ajuste_test);
CALL ELIMINAR_TAREA(@id_tarea_test);

-- 2. Eliminar las tablas de transacciones principales que ya no tienen detalles
CALL ELIMINAR_PRODUCCION(@id_produccion_test);
CALL ELIMINAR_VENTA(@id_venta_test);
CALL ELIMINAR_COMPRA(@id_compra_test);

-- 3. Eliminar las tablas de datos maestros que ya no son referenciadas por ninguna transacción
CALL ELIMINAR_PRODUCTO(@id_producto_test);
CALL ELIMINAR_MATERIA_PRIMA(@id_materia_test);

-- 4. Finalmente, eliminar las tablas de configuración y usuarios
CALL ELIMINAR_USUARIO(@id_usuario_test);
CALL ELIMINAR_ROL(@id_rol_test);

COMMIT;

SELECT 'Todos los registros de prueba fueron insertados y eliminados correctamente. COMMIT realizado.' AS Mensaje;
