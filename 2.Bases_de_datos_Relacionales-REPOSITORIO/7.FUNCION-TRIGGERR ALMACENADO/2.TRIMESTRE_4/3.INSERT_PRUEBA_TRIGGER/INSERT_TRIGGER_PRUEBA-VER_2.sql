USE PROYECTO_WYK;

START TRANSACTION;

-- ----------------------------------------------------------
-- 👑 INSERTAR ROL
-- ----------------------------------------------------------
INSERT INTO ROL (ROL, CLASIFICACION, ESTADO_ROL)
VALUES ('Administrador General','ADMINISTRADOR',1);

-- ----------------------------------------------------------
-- 👤 INSERTAR USUARIO
-- ----------------------------------------------------------
INSERT INTO USUARIO (NUM_DOC, NOMBRE, PASSWORD_USUARIO, TEL_USUARIO, EMAIL_USUARIO, FECHA_REGISTRO, ROL_FK_USUARIO, ESTADO_USUARIO)
VALUES (1001,'Juan Perez','Pass123*',3101234567,'juan.perez@empresa.com',NOW(),1,1);

-- ----------------------------------------------------------
-- 📋 INSERTAR TAREA
-- ----------------------------------------------------------
INSERT INTO TAREA (TAREA, CATEGORIA, DESCRIPCION, TIEMPO_ESTIMADO_HORAS, PRIORIDAD, ESTADO_TAREA, USUARIO_ASIGNADO_FK, USUARIO_CREADOR_FK)
VALUES ('Revisión inventario','Inventario','Revisar existencias en bodega',2.5,'MEDIA','PENDIENTE',1,1);

-- ----------------------------------------------------------
-- 🍞 INSERTAR PRODUCTO
-- ----------------------------------------------------------
INSERT INTO PRODUCTO (ID_PRODUCTO, NOMBRE_PRODUCTO, VALOR_UNITARIO_PRODUCTO, CANT_EXIST_PRODUCTO, FECHA_VENCIMIENTO_PRODUCTO, TIPO_PRODUCTO, ID_USUARIO_FK_PRODUCTO, ESTADO_PRODUCTO)
VALUES (101,'Pan Baguette',2000,50,'2025-12-31','PANADERIA',1,1);

-- ----------------------------------------------------------
-- 🛒 INSERTAR VENTA
-- ----------------------------------------------------------
INSERT INTO VENTA (FECHA_HORA_VENTA, TOTAL_VENTA, NUMERO_MESA, DESCRIPCION, ID_USUARIO_FK_VENTA, ESTADO_VENTA)
VALUES (NOW(),2000,5,'Venta mesa 5',1,'PAGADA');

-- ----------------------------------------------------------
-- 📦 INSERTAR DETALLE_VENTA
-- ----------------------------------------------------------
INSERT INTO DETALLE_VENTA (CANTIDAD, SUB_TOTAL, ID_VENTA_FK_DET_VENTA, ID_PRODUCTO_FK_DET_VENTA)
VALUES (1,2000,1,101);

-- ----------------------------------------------------------
-- 📉 INSERTAR AJUSTE_INVENTARIO
-- ----------------------------------------------------------
INSERT INTO AJUSTE_INVENTARIO (FECHA_AJUSTE, TIPO_AJUSTE, CANTIDAD_AJUSTADA, DESCRIPCION, ID_PROD_FK_AJUSTE_INVENTARIO, ID_USUARIO_FK_AJUSTE_INVENTARIO)
VALUES (NOW(),'MUESTRA',2,'Se dieron muestras del producto',101,1);

-- ----------------------------------------------------------
-- 🌾 INSERTAR MATERIA_PRIMA
-- ----------------------------------------------------------
INSERT INTO MATERIA_PRIMA (NOMBRE_MATERIA_PRIMA, VALOR_UNITARIO_MAT_PRIMA, FECHA_VENCIMIENTO_MATERIA_PRIMA, CANTIDAD_EXIST_MATERIA_PRIMA, PRESENTACION_MATERIA_PRIMA, DESCRIPCION_MATERIA_PRIMA, ID_USUARIO_FK_MATERIA_PRIMA, ESTADO_MATERIA_PRIMA)
VALUES ('Harina de Trigo',3000,'2025-11-30',100,'Kg','Harina para panadería',1,1);

-- ----------------------------------------------------------
-- 🧾 INSERTAR COMPRA
-- ----------------------------------------------------------
INSERT INTO COMPRA (FECHA_HORA_COMPRA, TIPO, TOTAL_COMPRA, NOMBRE_PROVEEDOR, MARCA, TEL_PROVEEDOR, EMAIL_PROVEEDOR, DESCRIPCION_COMPRA, ID_USUARIO_FK_COMPRA, ESTADO_FACTURA_COMPRA)
VALUES (NOW(),'MATERIA PRIMA',300000,'Molinos SA','RicaHarina',3159876543,'proveedor@molinos.com','Compra de harina',1,'PAGADA');

-- ----------------------------------------------------------
-- 📑 INSERTAR DETALLE_COMPRA_MATERIA_PRIMA
-- ----------------------------------------------------------
INSERT INTO DETALLE_COMPRA_MATERIA_PRIMA (ID_DET_COMPRA_MAT_PRIM, CANTIDAD_MAT_PRIMA_COMPRADA, SUB_TOTAL_MAT_PRIMA_COMPRADA, ID_COMPRA_FK_DET_COMPRA_MAT_PRIMA, ID_MAT_PRIMA_FK_DET_COMPRA_MAT_PRIMA, ESTADO_DET_COMPRA_MAT_PRIMA)
VALUES (201,50,150000,1,1,1);

-- ----------------------------------------------------------
-- 🧺 INSERTAR DETALLE_COMPRA_PRODUCTO
-- ----------------------------------------------------------
INSERT INTO DETALLE_COMPRA_PRODUCTO (ID_DET_COMPRA_PROD, CANTIDAD_PROD_COMPRADO, SUB_TOTAL_PROD_COMPRADO, ID_COMPRA_FK_DET_COMPRA_PROD, ID_PROD_FK_DET_COMPRA_PROD, ESTADO_DET_COMPRA_PROD)
VALUES (301,10,20000,1,101,1);

-- ----------------------------------------------------------
-- 📚 INSERTAR RECETA
-- ----------------------------------------------------------
INSERT INTO RECETA (ID_PRODUCTO_FK_RECETA, ID_MATERIA_PRIMA_FK_RECETA, CANTIDAD_REQUERIDA, UNIDAD_RECETA)
VALUES (101,1,0.50,'Kg');

-- ----------------------------------------------------------
-- 🏭 INSERTAR PRODUCCION
-- ----------------------------------------------------------
INSERT INTO PRODUCCION (NOMBRE_PRODUCCION, CANT_PRODUCCION, DESCRIPCION_PRODUCCION, ID_PRODUCTO_FK_PRODUCCION, ID_USUARIO_FK_PRODUCCION, ESTADO_PRODUCCION)
VALUES ('Producción diaria pan',100,'Pan fresco del día',101,1,1);

-- ----------------------------------------------------------
-- 📝 INSERTAR DETALLE_PRODUCCION
-- ----------------------------------------------------------
INSERT INTO DETALLE_PRODUCCION (ID_PRODUCCION, ID_MATERIA_PRIMA, CANTIDAD_REQUERIDA, CANTIDAD_USADA)
VALUES (1,1,20,18);

COMMIT;

-- ----------------------------------------------------------
-- VERIFICAR DATOS
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
SELECT * FROM RECETA;
SELECT * FROM PRODUCCION;
SELECT * FROM DETALLE_PRODUCCION;

-- ----------------------------------------------------------
-- VERIFICAR AUDITORÍAS DE TRIGGERS
-- ----------------------------------------------------------
SELECT * FROM T_INSERTAR_ROL;
SELECT * FROM T_INSERTAR_USUARIO;
SELECT * FROM T_INSERTAR_TAREA;
SELECT * FROM T_INSERTAR_PRODUCTO;
SELECT * FROM T_INSERTAR_VENTA;
SELECT * FROM T_INSERTAR_DETALLE_VENTA;
SELECT * FROM T_INSERTAR_AJUSTE_INVENTARIO;
SELECT * FROM T_INSERTAR_MATERIA_PRIMA;
SELECT * FROM T_INSERTAR_COMPRA;
SELECT * FROM T_INSERTAR_DET_COMPRA_MP;
SELECT * FROM T_INSERTAR_DET_COMPRA_PROD;
SELECT * FROM T_INSERTAR_RECETA;
SELECT * FROM T_INSERTAR_PRODUCCION;
SELECT * FROM T_INSERTAR_DET_PRODUCCION;

-- Mensaje de confirmación
SELECT 'Todos los INSERT ejecutados y triggers disparados correctamente. COMMIT realizado.' AS Mensaje;

