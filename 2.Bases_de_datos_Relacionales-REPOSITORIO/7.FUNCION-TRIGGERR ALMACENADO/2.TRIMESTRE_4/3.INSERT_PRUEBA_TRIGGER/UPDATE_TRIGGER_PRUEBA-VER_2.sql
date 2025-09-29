USE PROYECTO_WYK;

START TRANSACTION;

-- ----------------------------------------------------------
-- 👑 UPDATE ROL
-- ----------------------------------------------------------
UPDATE ROL 
SET ROL='Administrador Global', CLASIFICACION='ADMINISTRADOR', ESTADO_ROL=0 
WHERE ID_ROL=1;

-- ----------------------------------------------------------
-- 👤 UPDATE USUARIO
-- ----------------------------------------------------------
UPDATE USUARIO 
SET NOMBRE='Juan P. Actualizado', PASSWORD_USUARIO='NewPass#2025', TEL_USUARIO=3205559999, ESTADO_USUARIO=0
WHERE ID_USUARIO=1;

-- ----------------------------------------------------------
-- 📋 UPDATE TAREA
-- ----------------------------------------------------------
UPDATE TAREA
SET TAREA='Revisión inventario general', CATEGORIA='Inventario Central', DESCRIPCION='Revisión completa de bodega principal',
    TIEMPO_ESTIMADO_HORAS=3.0, PRIORIDAD='ALTA', ESTADO_TAREA='COMPLETADA'
WHERE ID_TAREA=1;

-- ----------------------------------------------------------
-- 🍞 UPDATE PRODUCTO
-- ----------------------------------------------------------
UPDATE PRODUCTO
SET NOMBRE_PRODUCTO='Pan Baguette Integral', VALOR_UNITARIO_PRODUCTO=2500, CANT_EXIST_PRODUCTO=60,
    FECHA_VENCIMIENTO_PRODUCTO='2026-01-15', TIPO_PRODUCTO='PANADERIA', ESTADO_PRODUCTO=0
WHERE ID_PRODUCTO=101;

-- ----------------------------------------------------------
-- 🛒 UPDATE VENTA
-- ----------------------------------------------------------
UPDATE VENTA
SET TOTAL_VENTA=2500, NUMERO_MESA=7, DESCRIPCION='Venta mesa 7 actualizada', ESTADO_PEDIDO='CANCELADO', ESTADO_PAGO='CANCELADA'
WHERE ID_VENTA=1;

-- ----------------------------------------------------------
-- 📦 UPDATE DETALLE_VENTA
-- ----------------------------------------------------------
UPDATE DETALLE_VENTA
SET CANTIDAD=2, SUB_TOTAL=5000
WHERE ID_DETALLE_VENTA=1;

-- ----------------------------------------------------------
-- 📉 UPDATE AJUSTE_INVENTARIO
-- ----------------------------------------------------------
UPDATE AJUSTE_INVENTARIO
SET TIPO_AJUSTE='PERDIDA', CANTIDAD_AJUSTADA=3, DESCRIPCION='Producto perdido por mal estado'
WHERE ID_AJUSTE=1;

-- ----------------------------------------------------------
-- 🌾 UPDATE MATERIA_PRIMA
-- ----------------------------------------------------------
UPDATE MATERIA_PRIMA
SET NOMBRE_MATERIA_PRIMA='Harina de Trigo Premium', VALOR_UNITARIO_MAT_PRIMA=3500,
    FECHA_VENCIMIENTO_MATERIA_PRIMA='2026-02-28', CANTIDAD_EXIST_MATERIA_PRIMA=120,
    PRESENTACION_MATERIA_PRIMA='Sacos 25Kg', DESCRIPCION_MATERIA_PRIMA='Harina de alta calidad', ESTADO_MATERIA_PRIMA=0
WHERE ID_MATERIA_PRIMA=1;

-- ----------------------------------------------------------
-- 🧾 UPDATE COMPRA
-- ----------------------------------------------------------
UPDATE COMPRA
SET TOTAL_COMPRA=350000, NOMBRE_PROVEEDOR='Molinos Actualizados', MARCA='HarinaFina',
    TEL_PROVEEDOR=3161112222, EMAIL_PROVEEDOR='nuevo@molinos.com', ESTADO_FACTURA_COMPRA='CANCELADA'
WHERE ID_COMPRA=1;

-- ----------------------------------------------------------
-- 📑 UPDATE DETALLE_COMPRA_MATERIA_PRIMA
-- ----------------------------------------------------------
UPDATE DETALLE_COMPRA_MATERIA_PRIMA
SET CANTIDAD_MAT_PRIMA_COMPRADA=60, SUB_TOTAL_MAT_PRIMA_COMPRADA=180000, ESTADO_DET_COMPRA_MAT_PRIMA=0
WHERE ID_DET_COMPRA_MAT_PRIM=201;

-- ----------------------------------------------------------
-- 🧺 UPDATE DETALLE_COMPRA_PRODUCTO
-- ----------------------------------------------------------
UPDATE DETALLE_COMPRA_PRODUCTO
SET CANTIDAD_PROD_COMPRADO=15, SUB_TOTAL_PROD_COMPRADO=30000, ESTADO_DET_COMPRA_PROD=0
WHERE ID_DET_COMPRA_PROD=301;

-- ----------------------------------------------------------
-- 🏭 UPDATE PRODUCCION
-- ----------------------------------------------------------
UPDATE PRODUCCION
SET NOMBRE_PRODUCCION='Producción Especial Pan', CANT_PRODUCCION=120,
    DESCRIPCION_PRODUCCION='Pan fresco integral del día', ESTADO_PRODUCCION = 'FINALIZADA'
WHERE ID_PRODUCCION=1;

-- ----------------------------------------------------------
-- 📝 UPDATE DETALLE_PRODUCCION
-- ----------------------------------------------------------
UPDATE DETALLE_PRODUCCION
SET CANTIDAD_REQUERIDA=25
WHERE ID_DETALLE_PRODUCCION=1;

COMMIT;

-- ----------------------------------------------------------
-- 🔍 VERIFICAR DATOS ACTUALIZADOS
-- ----------------------------------------------------------
SELECT * FROM ROL;
SELECT * FROM USUARIO;
SELECT * FROM TAREA;
SELECT * FROM PRODUCTO;
SELECT * FROM VENTA;
SELECT * FROM DETALLE_VENTA;
SELECT * FROM AJUSTE_INVENTARIO;
SELECT * FROM MATERIA_PRIMA;
SELECT * FROM COMPRA;
SELECT * FROM DETALLE_COMPRA_MATERIA_PRIMA;
SELECT * FROM DETALLE_COMPRA_PRODUCTO;
SELECT * FROM PRODUCCION;
SELECT * FROM DETALLE_PRODUCCION;

-- ----------------------------------------------------------
-- 📂 VERIFICAR AUDITORÍAS DE TRIGGERS UPDATE
-- ----------------------------------------------------------
SELECT * FROM T_ACTUALIZAR_ROL;
SELECT * FROM T_ACTUALIZAR_USUARIO;
SELECT * FROM T_ACTUALIZAR_TAREA;
SELECT * FROM T_ACTUALIZAR_PRODUCTO;
SELECT * FROM T_ACTUALIZAR_VENTA;
SELECT * FROM T_ACTUALIZAR_DETALLE_VENTA;
SELECT * FROM T_ACTUALIZAR_AJUSTE_INVENTARIO;
SELECT * FROM T_ACTUALIZAR_MATERIA_PRIMA;
SELECT * FROM T_ACTUALIZAR_COMPRA;
SELECT * FROM T_ACTUALIZAR_DET_COMPRA_MP;
SELECT * FROM T_ACTUALIZAR_DET_COMPRA_PROD;
SELECT * FROM T_ACTUALIZAR_PRODUCCION;
SELECT * FROM T_ACTUALIZAR_DET_PRODUCCION;

-- ✅ Mensaje de confirmación
SELECT 'Todos los UPDATE ejecutados y triggers de actualización disparados correctamente. COMMIT realizado.' AS Mensaje;
