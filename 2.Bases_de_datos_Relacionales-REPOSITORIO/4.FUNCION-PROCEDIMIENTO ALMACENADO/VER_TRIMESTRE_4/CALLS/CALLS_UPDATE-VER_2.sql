USE PROYECTO_WYK;
DELIMITER $

START TRANSACTION;

-- CALL PROCEDIMIENTO ACTUALIZAR ROL
-- Ejemplo: actualizar el estado de un rol
CALL ACTUALIZAR_ROL(2, 'Empleado Panadería', 'EMPLEADO', 0);

-- CALL PROCEDIMIENTO ACTUALIZAR USUARIO
-- Ejemplo: cambiar teléfono y correo de un usuario
CALL ACTUALIZAR_USUARIO(1002, 3112345678, 'Maria Lopez', NULL, 3123456789, 'maria.lopez@correo.com', NULL, 2, 1);

-- CALL PROCEDIMIENTO ACTUALIZAR TAREA
-- Ejemplo: marcar tarea como completada
CALL ACTUALIZAR_TAREA(1, 'Revisar inventario', 'Inventario', 'Control actualizado', 2, 'ALTA', 'COMPLETADA', 2, 1);

-- CALL PROCEDIMIENTO ACTUALIZAR PRODUCTO
-- Ejemplo: cambiar precio y existencia
CALL ACTUALIZAR_PRODUCTO(101, 'Pan de Trigo', 1600, 180, '2025-12-31', 'PANADERIA', 2, 1);

-- CALL PROCEDIMIENTO ACTUALIZAR VENTA
-- Ejemplo: actualizar total y estado de venta
CALL ACTUALIZAR_VENTA(1, NOW(), 15500, 1, 'Venta mostrador corregida', 3, 'PAGADA');

-- CALL PROCEDIMIENTO ACTUALIZAR DETALLE_VENTA
-- Ejemplo: actualizar cantidad de un detalle de venta
CALL ACTUALIZAR_DETALLE_VENTA(1, 3, 4500, 1, 101);

-- CALL PROCEDIMIENTO ACTUALIZAR AJUSTE_INVENTARIO
-- Ejemplo: corregir cantidad ajustada
CALL ACTUALIZAR_AJUSTE_INVENTARIO(2, NOW(), 'PERDIDA', 3, 'Pérdida ajustada', 102, 2);

-- CALL PROCEDIMIENTO ACTUALIZAR MATERIA_PRIMA
-- Ejemplo: actualizar cantidad y estado
CALL ACTUALIZAR_MATERIA_PRIMA(1, 'Harina Trigo', '2026-01-01', 480, 'Kg', 'Harina de alta calidad', 2, 1);

-- CALL PROCEDIMIENTO ACTUALIZAR COMPRA
-- Ejemplo: actualizar total y estado factura
CALL ACTUALIZAR_COMPRA(1, NOW(), 'MATERIA PRIMA', 510000, 'Proveedor Harinas', 'Harimsa', 3201234567, 'proveedor1@correo.com', 'Compra mensual harina ajustada', 2, 'PAGADA');

-- CALL PROCEDIMIENTO ACTUALIZAR DETALLE_COMPRA_MATERIA_PRIMA
-- Ejemplo: actualizar cantidad comprada
CALL ACTUALIZAR_DETALLE_COMPRA_MATERIA_PRIMA(1, 110, 110000, 1, 1, 1);

-- CALL PROCEDIMIENTO ACTUALIZAR DETALLE_COMPRA_PRODUCTO
-- Ejemplo: actualizar cantidad comprada de producto
CALL ACTUALIZAR_DETALLE_COMPRA_PRODUCTO(1, 12, 36000, 1, 101, 1);

-- CALL PROCEDIMIENTO ACTUALIZAR RECETA
-- Ejemplo: actualizar cantidad requerida de materia prima
CALL ACTUALIZAR_RECETA(1, 101, 1, 0.6, 'Kg');

-- CALL PROCEDIMIENTO ACTUALIZAR PRODUCCION
-- Ejemplo: actualizar cantidad de producción
CALL ACTUALIZAR_PRODUCCION(1, 'Producción Pan Trigo', 120, 'Elaboración diaria pan actualizada', 101, 2, 1);

-- CALL PROCEDIMIENTO ACTUALIZAR DETALLE_PRODUCCION
-- Ejemplo: actualizar cantidad usada en producción
CALL ACTUALIZAR_DETALLE_PRODUCCION(1, 1, 1, 55, 55);

COMMIT;
SELECT 'Todos los CALL ACTUALIZAR ejecutados correctamente. COMMIT realizado.' AS Mensaje;

/*ROLLBACK; ejecutar en caso de error.*/
