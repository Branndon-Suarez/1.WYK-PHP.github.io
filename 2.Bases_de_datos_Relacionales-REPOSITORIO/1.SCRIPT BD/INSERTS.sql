USE PROYECTO_WYK;

														   /*INSERTS*/
                                                           
														/*👮‍INSERT CARGO👮‍
____________________________________________________________________________________________________________________________________________________*/                                                           

INSERT INTO CARGO (NOMBRE_CARGO, ESTADO_CARGO) VALUES
('Administrador', 1),
('Panadero', 1),
('Cajero', 1),
('Mesero', 1);

														/*🤴INSERT USUARIO👸
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO USUARIO (NOMBRE_USUARIO,PASSWORD_USUARIO,FECHA_REGISTRO,FECHA_ULTIMA_SESION,ROL,ESTADO_USUARIO) VALUES
-- Usuarios para Empleados Y Admin
('carlos.admin', SHA2('admin123', 256), NOW(), NOW(),'ADMINISTRADOR', 1),
('sofia.panadera', SHA2('empleado123', 256), NOW(), NOW(),'EMPLEADO', 1),
('luis.cajero', SHA2('cajero789', 256), NOW(), NOW(),'EMPLEADO', 1),
('ana.mesera', SHA2('mesera101', 256), NOW(), NOW(),'EMPLEADO', 1),
-- Usuarios para Cliente
('javier.cliente', SHA2('cliente123', 256), NOW(), NOW(),'CLIENTE', 1),
('maria.cliente', SHA2('cliente456', 256), NOW(), NOW(),'CLIENTE', 1),
('pedro.cliente', SHA2('cliente789', 256), NOW(), NOW(),'CLIENTE', 1),
('laura.cliente', SHA2('cliente101', 256), NOW(), NOW(),'CLIENTE', 1);


select*from USUARIO;
														/*👩‍🍳INSERT EMPLEADO👨‍🍳
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO EMPLEADO (CC_EMPLEADO, NOMBRE_EMPLEADO, RH_EMPLEADO, TEL_EMPLEADO, EMAIL_EMPLEADO, ID_CARGO_FK_EMPLEADO,ID_USUARIO_FK_EMPLEADO, ESTADO_EMPLEADO) VALUES
(1001001001, 'Carlos Ramirez', 'O+', 3101234567, 'carlos.ramirez@wyk.com', 1, 1, 1),
(1002002002, 'Sofia Gomez', 'A+', 3111234567, 'sofia.gomez@wyk.com', 2, 2, 1),
(1003003003, 'Luis Fernandez', 'B+', 3121234567, 'luis.fernandez@wyk.com', 3, 3, 1),
(1004004004, 'Ana Martinez', 'AB+', 3131234567, 'ana.martinez@wyk.com', 4, 4, 1);

														/*👦INSERT CLIENTE👦
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO CLIENTE (NUM_DOCUMENTO_CLIENTE, TIPO_DOCUMENTO_CLIENTE, NOMBRE_CLIENTE, TEL_CLIENTE, EMAIL_CLIENTE, ID_EMPLEADO_FK_CLIENTE,ID_USUARIO_FK_CLIENTE, ESTADO_CLIENTE) VALUES
(2001001001, 'CC', 'Javier Torres', 3209876543, 'javier.torres@email.com', 1, 5, 1),
(2002002002, 'CE', 'Maria Rodriguez', 3219876543, 'maria.rodriguez@email.com', 2, 6, 1),
(99010112345, 'TI', 'Pedro Infante', 3229876543, 'pedro.infante@email.com', 3, 7, 1),
(2004004004, 'CC', 'Laura Sanchez', 3239876543, 'laura.sanchez@email.com', 4, 8, 1);

														/*🍰INSERT PEDIDO🍰
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO PEDIDO (FECHA_HORA_PEDIDO, NUMERO_MESA, ID_EMPLEADO_FK_PEDIDO, ID_CLIENTE_FK_PEDIDO, ESTADO_PEDIDO) VALUES
(NOW(), 5, 4, 1, 'EN PREPARACION'),
(NOW(), 2, 4, 2, 'PENDIENTE'),
(NOW(), 8, 4, 3, 'ENTREGADO'),
(NOW(), 1, 4, 4, 'CANCELADO');

														/*🥐INSERT PRODUCTO🥐
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO PRODUCTO (ID_PRODUCTO, NOMBRE_PRODUCTO, VALOR_UNITARIO_PRODUCTO, CANT_EXIST_PRODUCTO, FECHA_VENCIMIENTO_PRODUCTO, TIPO_PRODUCTO_GENERAL, TIPO_PRODUCTO_ESPECIFICO, MARCA_PRODUCTO, ID_EMPLEADO_FK_PRODUCTO, ESTADO_PRODUCTO) VALUES
(770001, 'Pan Frances', 1500, 50, '2025-07-15', 'PANADERIA', 'Baguette', 'Wyk Pan', 2, 1),
(770002, 'Torta de Chocolate', 35000, 10, '2025-07-20', 'PASTELERIA', 'Torta humeda', 'Wyk Pasteles', 2, 1),
(770003, 'Leche Deslactosada', 4000, 30, '2025-10-01', 'VIBERES', 'Lacteo', 'Lala', 1, 1),
(770004, 'Croissant de Almendras', 4500, 40, '2025-07-10', 'PANADERIA', 'Hojaldre', 'Wyk Pan', 2, 1);

														/*🚲INSERT DETALLE PEDIDO🚲
____________________________________________________________________________________________________________________________________________________ */

INSERT INTO DETALLE_PEDIDO (ID_DETALLE_PEDIDO, DESCRIPCION_DETALLE_PEDIDO, ID_PEDIDO_FK_DETALLE_PEDIDO, ID_PRODUCTO_FK_DETALLE_PEDIDO, ESTADO_DETALLE_PEDIDO_PRODUCTO) VALUES
(1, 'Pedido de Pan Frances para la mesa 5', 1, 770001, 1),
(2, 'Pedido de Torta de Chocolate para llevar', 2, 770002, 1),
(3, 'Pedido de Leche para el cafe', 3, 770003, 1),
(4, 'Pedido de Croissant para la mesa 1', 4, 770004, 1);

														/*📄INSERT FACTURA VENTA📄
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO FACTURA_VENTA (TOTAL_FACTURA_VENTA, FECHA_HORA_FACTURA_VENTA, DESCRIPCION_FACTURA_VENTA, ID_EMPLEADO_FK_FACTURA_VENTA, ID_PEDIDO_FK_FACTURA_VENTA, ID_CLIENTE_FK_FACTURA_VENTA, ESTADO_FACTURA_VENTA) VALUES
(1500, NOW(), 'Venta de 1 Pan Frances', 3, 1, 1, 'PAGADA'),
(35000, NOW(), 'Venta de 1 Torta de Chocolate', 3, 2, 2, 'PENDIENTE'),
(4000, NOW(), 'Venta de 1 Leche', 3, 3, 3, 'PAGADA'),
(4500, NOW(), 'Venta de 1 Croissant cancelada', 3, 4, 4, 'CANCELADA');

														/*🔖INSERT DETALLE_VENTA_PRODUCTO🔖
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO DETALLE_VENTA_PRODUCTO (ID_DETALLE_VENTA_PRODUCTO, CANTIDAD_PRODUCTO_VENDIDO, SUB_TOTAL_PRODUCTO_VENDIDO, ID_FACTURA_VENTA_FK_DET_VENTA_PRODUCTO, ID_PRODUCTO_FK_DET_FACTURA_VENTA, ESTADO_DETALLE_VENTA_PRODUCTO) VALUES
(1, 1, 1500, 1, 770001, 1),
(2, 1, 35000, 2, 770002, 1),
(3, 1, 4000, 3, 770003, 1),
(4, 1, 4500, 4, 770004, 0);

														/*👩‍💼INSERT PROVEEDOR👨‍💼
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO PROVEEDOR (CC_PROVEEDOR, NOMBRE_PROVEEDOR, TEL_PROVEEDOR, EMAIL_PROVEEDOR, ID_EMPLEADO_FK_PROVEEDOR, ESTADO_PROVEEDOR) VALUES
(800100200, 'Harinas del Valle', 6011234567, 'ventas@harinasvalle.com', 1, 1),
(800200300, 'Lacteos La Pradera', 6012345678, 'contacto@lapradera.com', 1, 1),
(800300400, 'Distribuidora de Azucar', 6013456789, 'info@azucardist.com', 1, 1),
(800400500, 'Frutas y Verduras Frescas', 6014567890, 'pedidos@frutasfrescas.com', 1, 1);

														/*🥣INSERT MATERIA PRIMA🥣
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO MATERIA_PRIMA (NOMBRE_MATERIA_PRIMA, FECHA_VENCIMIENTO_MATERIA_PRIMA, TIPO_DE_MEDIDA, CANTIDAD_EXIST_MATERIA_PRIMA, MARCA_MATERIA_PRIMA, PRESENTACION_MATERIA_PRIMA, DESCRIPCION_MATERIA_PRIMA, ID_EMPLEADO_FK_MATERIA_PRIMA, ESTADO_MATERIA_PRIMA) VALUES
('Harina de Trigo', '2026-01-15', 'Kilogramos', 100, 'Harinas del Valle', 'Bulto 50kg', 'Harina para panaderia', 1, 1),
('Azucar Blanca', '2026-05-20', 'Kilogramos', 80, 'Incauca', 'Bulto 50kg', 'Azucar refinada para pasteleria', 1, 1),
('Mantequilla', '2025-09-01', 'Kilogramos', 40, 'La Pradera', 'Bloque 5kg', 'Mantequilla sin sal', 1, 1),
('Levadura Fresca', '2025-08-10', 'Gramos', 1000, 'Fleischmann', 'Paquete 500g', 'Levadura para panificacion', 1, 1);

														/*📜INSERT FACTURA COMPRA📜
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO FACTURA_COMPRA (TOTAL_FACTURA_COMPRA, FECHA_HORA_FACTURA_COMPRA, DESCRIPCION_FACTURA_COMPRA, ID_EMPLEADO_FK_FACTURA_COMPRA, ID_PROVEEDOR_FK_FACTURA_COMPRA, ESTADO_FACTURA_COMPRA) VALUES
(250000, NOW(), 'Compra de Harina de Trigo', 1, 1, 'PAGADA'),
(180000, NOW(), 'Compra de Azucar Blanca', 1, 3, 'PENDIENTE'),
(400000, NOW(), 'Compra de Mantequilla', 1, 2, 'PAGADA'),
(50000, NOW(), 'Compra de Levadura Fresca', 1, 4, 'CANCELADA');

														/*📰INSERT DETALLE_FACTURA_COMPRA_MATERIA_PRIMA📰
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO DETALLE_FACTURA_COMPRA_MATERIA_PRIMA (ID_DETALLE_FAC_MAT_PRIM, CANTIDAD_MATERIA_PRIMA_COMPRADA, SUB_TOTAL_MATERIA_PRIMA_COMPRADA, ID_FACTURA_COMPRA_FK_DET_FACT_COMPRA_MATERIA_PRIMA, ID_MATERIA_PRIMA_FK_DET_FACT_COMPRA_MATERIA_PRIMA, ESTADO_DETALLE_COMPRA_MATERIA_PRIMA) VALUES
(1, 100, 250000, 1, 1, 1),
(2, 80, 180000, 2, 2, 1),
(3, 40, 400000, 3, 3, 1),
(4, 10, 50000, 4, 4, 0);

														/*🍮INSERT FACTURA_COMPRA🍮
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO FACTURA_COMPRA (TOTAL_FACTURA_COMPRA, FECHA_HORA_FACTURA_COMPRA, DESCRIPCION_FACTURA_COMPRA, ID_EMPLEADO_FK_FACTURA_COMPRA, ID_PROVEEDOR_FK_FACTURA_COMPRA, ESTADO_FACTURA_COMPRA) VALUES
(120000, NOW(), 'Compra de Leche Deslactosada', 1, 2, 'PAGADA'),
(60000, NOW(), 'Compra de Pan Frances para reventa', 1, 4, 'PAGADA'),
(350000, NOW(), 'Compra de Tortas de Chocolate', 1, 4, 'PENDIENTE'),
(90000, NOW(), 'Compra de Croissants de Almendras', 1, 4, 'PAGADA');

														/*🍮INSERT DETALLE_COMPRA_PRODUCTO🍮
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO DETALLE_COMPRA_PRODUCTO (ID_DETALLE_COMPRA_PRODUCTO, CANTIDAD_PRODUCTO_COMPRADO, SUB_TOTAL_PRODUCTO_COMPRADO, ID_FACTURA_COMPRA_FK_DET_COMPRA_PRODUCTO, ID_PRODUCTO_FK_DET_COMPRA_PRODUCTO, ESTADO_DETALLE_COMPRA_PRODUCTO) VALUES
(1, 30, 120000, 5, 770003, 1),
(2, 40, 60000, 6, 770001, 1),
(3, 10, 350000, 7, 770002, 1),
(4, 20, 90000, 8, 770004, 1);

														/*🍲PRECEDIMIENTO INSERTAR PRODUCCION🍲
_____________________________________________________________________________________________________________________________________________________*/

INSERT INTO PRODUCCION (NOMBRE_PRODUCCION, CANT_PRODUCCION, DESCRIPCION_PRODUCCION, MATERIA_PRIMA_GASTADA, ID_MATERIA_PRIMA_FK_PRODUCCION, ID_PRODUCTO_FK_MATERIA_PRIMA, ID_EMPLEADO_FK_PRODUCCION, ESTADO_PRODUCCION) VALUES
('Produccion Pan Frances', 50, 'Produccion diaria de Pan Frances', 25, 1, 770001, 2, 1),
('Produccion Torta Choco', 10, 'Produccion semanal de Tortas', 5, 2, 770002, 2, 1),
('Produccion Croissant', 40, 'Produccion diaria de Croissants', 10, 3, 770004, 2, 1),
('Pruebas de Panaderia', 5, 'Pruebas con nueva levadura', 1, 4, 770001, 2, 0);