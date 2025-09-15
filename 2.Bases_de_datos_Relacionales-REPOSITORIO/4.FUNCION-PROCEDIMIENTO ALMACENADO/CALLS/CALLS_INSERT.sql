USE PROYECTO_WYK;

START TRANSACTION;

-- 👮‍CALL CARGO👮‍
CALL INSERTAR_CARGO('Cocinero', 1);
CALL INSERTAR_CARGO('Panadero', 1);
CALL INSERTAR_CARGO('Cajero', 1);
CALL INSERTAR_CARGO('Mesero', 1);

-- 🤴CALL USUARIO👸
/*CALL INSERTAR_USUARIO('carlos.admin', '$2y$10$9CGt8sMotuvICJefdYczFegaquDClFGStqddVp1NkfmtnaYq24iWK', NOW(), NOW(), 'ADMINISTRADOR', 1);
CALL INSERTAR_USUARIO('sofia.panadera', '$2y$10$spag8SgXTedv8UX0tZWzfOa/7yMQQd.pwwFsCYeGui2Wa22gC8R76', NOW(), NOW(), 'EMPLEADO', 1);
CALL INSERTAR_USUARIO('luis.cajero', '$2y$10$1lJ9isiLLi5U9P2/9RN8MucQdjbyB2gggjmrTWXmZ3aCi5/hZeST.', NOW(), NOW(), 'EMPLEADO', 1);
CALL INSERTAR_USUARIO('ana.mesera', '$2y$10$KI7WgM1ptD2IY1dYKyOxBu4aP4DzNSuabeXN2PF.3WU1B05Fd9xC.', NOW(), NOW(), 'EMPLEADO', 1);
CALL INSERTAR_USUARIO('javier.cliente', '$2y$10$ithOoyBTIedvkhZ00UuCMuokFvUuSD3C.28hVoBPYLP7f3A6M9fBy', NOW(), NOW(), 'CLIENTE', 1);
CALL INSERTAR_USUARIO('maria.cliente', '$2y$10$w5o6LR4dSXtY755IjEQr7eUfMp1EImOnSPuyRGefHfPHHpSVT2eDu', NOW(), NOW(), 'CLIENTE', 1);
CALL INSERTAR_USUARIO('pedro.cliente', '$2y$10$j/Le56.q2LITDFW5NRjU.OYgAOVZJ5gZSYCn138lyNdkaHeIzFqrS', NOW(), NOW(), 'CLIENTE', 0);
CALL INSERTAR_USUARIO('laura.cliente', '$2y$10$Efm6QAlkliVmV/gN95HLS.obxjcmNJoWiL1P59Oyt6WRPTqC/9fp.', NOW(), NOW(), 'CLIENTE', 0);*/

-- 👩‍🍳CALL EMPLEADO👨‍🍳
CALL INSERTAR_EMPLEADO(1001001001, 'Carlos Ramirez', 'O+', 3101234567, 'carlos.ramirez@wyk.com', 1, 1, 1);
CALL INSERTAR_EMPLEADO(1002002002, 'Sofia Gomez', 'A+', 3111234567, 'sofia.gomez@wyk.com', 2, 2, 1);
CALL INSERTAR_EMPLEADO(1003003003, 'Luis Fernandez', 'B+', 3121234567, 'luis.fernandez@wyk.com', 3, 3, 1);
CALL INSERTAR_EMPLEADO(1004004004, 'Ana Martinez', 'AB+', 3131234567, 'ana.martinez@wyk.com', 4, 4, 1);

-- 👦CALL CLIENTE👦
CALL INSERTAR_CLIENTE(2001001001, 'CC', 'Javier Torres', 3209876543, 'javier.torres@email.com', 1, 5, 1);
CALL INSERTAR_CLIENTE(2002002002, 'CE', 'Maria Rodriguez', 3219876543, 'maria.rodriguez@email.com', 2, 6, 1);
CALL INSERTAR_CLIENTE(99010112345, 'TI', 'Pedro Infante', 3229876543, 'pedro.infante@email.com', 3, 7, 1);
CALL INSERTAR_CLIENTE(2004004004, 'CC', 'Laura Sanchez', 3239876543, 'laura.sanchez@email.com', 4, 8, 1);

-- 🍰CALL PEDIDO🍰
CALL INSERTAR_PEDIDO(NOW(), 5, 4, 1, 'EN PREPARACION');
CALL INSERTAR_PEDIDO(NOW(), 2, 4, 2, 'PENDIENTE');
CALL INSERTAR_PEDIDO(NOW(), 8, 4, 3, 'ENTREGADO');
CALL INSERTAR_PEDIDO(NOW(), 1, 4, 4, 'CANCELADO');

-- 🥐CALL PRODUCTO🥐
CALL INSERTAR_PRODUCTO(770001, 'Pan Frances', 1500, 50, '2025-07-15', 'PANADERIA', 'Baguette', 'Wyk Pan', 2, 1);
CALL INSERTAR_PRODUCTO(770002, 'Torta de Chocolate', 35000, 10, '2025-07-20', 'PASTELERIA', 'Torta humeda', 'Wyk Pasteles', 2, 1);
CALL INSERTAR_PRODUCTO(770003, 'Leche Deslactosada', 4000, 30, '2025-10-01', 'VIBERES', 'Lacteo', 'Lala', 1, 1);
CALL INSERTAR_PRODUCTO(770004, 'Croissant de Almendras', 4500, 40, '2025-07-10', 'PANADERIA', 'Hojaldre', 'Wyk Pan', 2, 1);

-- 🚲CALL DETALLE PEDIDO🚲
CALL INSERTAR_DETALLE_PEDIDO(1, 'Pedido de Pan Frances para la mesa 5', 1, 770001, 1);
CALL INSERTAR_DETALLE_PEDIDO(2, 'Pedido de Torta de Chocolate para llevar', 2, 770002, 1);
CALL INSERTAR_DETALLE_PEDIDO(3, 'Pedido de Leche para el cafe', 3, 770003, 1);
CALL INSERTAR_DETALLE_PEDIDO(4, 'Pedido de Croissant para la mesa 1', 4, 770004, 1);

-- 📄CALL FACTURA VENTA📄
CALL INSERTAR_FACTURA_VENTA(1500, NOW(), 'Venta de 1 Pan Frances', 3, 1, 1, 'PAGADA');
CALL INSERTAR_FACTURA_VENTA(35000, NOW(), 'Venta de 1 Torta de Chocolate', 3, 2, 2, 'PENDIENTE');
CALL INSERTAR_FACTURA_VENTA(4000, NOW(), 'Venta de 1 Leche', 3, 3, 3, 'PAGADA');
CALL INSERTAR_FACTURA_VENTA(4500, NOW(), 'Venta de 1 Croissant cancelada', 3, 4, 4, 'CANCELADA');

-- 🔖CALL DETALLE_VENTA_PRODUCTO🔖
CALL INSERTAR_DETALLE_VENTA_PRODUCTO(1, 1, 1500, 1, 770001, 1);
CALL INSERTAR_DETALLE_VENTA_PRODUCTO(2, 1, 35000, 2, 770002, 1);
CALL INSERTAR_DETALLE_VENTA_PRODUCTO(3, 1, 4000, 3, 770003, 1);
CALL INSERTAR_DETALLE_VENTA_PRODUCTO(4, 1, 4500, 4, 770004, 0);

-- 👩‍💼CALL PROVEEDOR👨‍💼
CALL INSERTAR_PROVEEDOR(800100200, 'Harinas del Valle', 6011234567, 'ventas@harinasvalle.com', 1, 1);
CALL INSERTAR_PROVEEDOR(800200300, 'Lacteos La Pradera', 6012345678, 'contacto@lapradera.com', 1, 1);
CALL INSERTAR_PROVEEDOR(800300400, 'Distribuidora de Azucar', 6013456789, 'info@azucardist.com', 1, 1);
CALL INSERTAR_PROVEEDOR(800400500, 'Frutas y Verduras Frescas', 6014567890, 'pedidos@frutasfrescas.com', 1, 1);

-- 🥣CALL MATERIA PRIMA🥣
CALL INSERTAR_MATERIA_PRIMA('Harina de Trigo', '2026-01-15', 'Kilogramos', 100, 'Harinas del Valle', 'Bulto 50kg', 'Harina para panaderia', 1, 1);
CALL INSERTAR_MATERIA_PRIMA('Azucar Blanca', '2026-05-20', 'Kilogramos', 80, 'Incauca', 'Bulto 50kg', 'Azucar refinada para pasteleria', 1, 1);
CALL INSERTAR_MATERIA_PRIMA('Mantequilla', '2025-09-01', 'Kilogramos', 40, 'La Pradera', 'Bloque 5kg', 'Mantequilla sin sal', 1, 1);
CALL INSERTAR_MATERIA_PRIMA('Levadura Fresca', '2025-08-10', 'Gramos', 1000, 'Fleischmann', 'Paquete 500g', 'Levadura para panificacion', 1, 1);

-- 📜CALL FACTURA COMPRA📜
CALL INSERTAR_FACTURA_COMPRA(250000, NOW(), 'Compra de Harina de Trigo', 1, 1, 'PAGADA');
CALL INSERTAR_FACTURA_COMPRA(180000, NOW(), 'Compra de Azucar Blanca', 1, 3, 'PENDIENTE');
CALL INSERTAR_FACTURA_COMPRA(400000, NOW(), 'Compra de Mantequilla', 1, 2, 'PAGADA');
CALL INSERTAR_FACTURA_COMPRA(50000, NOW(), 'Compra de Levadura Fresca', 1, 4, 'CANCELADA');
CALL INSERTAR_FACTURA_COMPRA(120000, NOW(), 'Compra de Leche Deslactosada', 1, 2, 'PAGADA');
CALL INSERTAR_FACTURA_COMPRA(60000, NOW(), 'Compra de Pan Frances para reventa', 1, 4, 'PAGADA');
CALL INSERTAR_FACTURA_COMPRA(350000, NOW(), 'Compra de Tortas de Chocolate', 1, 4, 'PENDIENTE');
CALL INSERTAR_FACTURA_COMPRA(90000, NOW(), 'Compra de Croissants de Almendras', 1, 4, 'PAGADA');

-- 📰CALL DETALLE_FACTURA_COMPRA_MATERIA_PRIMA📰
CALL INSERTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA(1, 100, 250000, 1, 1, 1);
CALL INSERTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA(2, 80, 180000, 2, 2, 1);
CALL INSERTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA(3, 40, 400000, 3, 3, 1);
CALL INSERTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA(4, 10, 50000, 4, 4, 0);

-- 🍮CALL DETALLE_COMPRA_PRODUCTO🍮
CALL INSERTAR_DETALLE_COMPRA_PRODUCTO(1, 30, 120000, 5, 770003, 1);
CALL INSERTAR_DETALLE_COMPRA_PRODUCTO(2, 40, 60000, 6, 770001, 1);
CALL INSERTAR_DETALLE_COMPRA_PRODUCTO(3, 10, 350000, 7, 770002, 1);
CALL INSERTAR_DETALLE_COMPRA_PRODUCTO(4, 20, 90000, 8, 770004, 1);

-- 🍲CALL PRODUCCION🍲
CALL INSERTAR_PRODUCCION('Produccion Pan Frances', 50, 'Produccion diaria de Pan Frances', 25, 1, 770001, 2, 1);
CALL INSERTAR_PRODUCCION('Produccion Torta Choco', 10, 'Produccion semanal de Tortas', 5, 2, 770002, 2, 1);
CALL INSERTAR_PRODUCCION('Produccion Croissant', 40, 'Produccion diaria de Croissants', 10, 3, 770004, 2, 1);
CALL INSERTAR_PRODUCCION('Pruebas de Panaderia', 5, 'Pruebas con nueva levadura', 1, 4, 770001, 2, 0);

COMMIT;
SELECT 'Todos los CALL ejecutados correctamente. COMMIT realizado.' AS Mensaje;

/*ROLLBACK; ejecutar en caso de error.*/
