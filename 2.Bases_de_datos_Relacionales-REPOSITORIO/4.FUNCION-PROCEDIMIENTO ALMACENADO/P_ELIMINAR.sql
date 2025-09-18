USE PROYECTO_WYK;

DELIMITER $

-- 👮‍ PROCEDIMIENTO ELIMINAR CARGO 👮‍
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_CARGO(IN P_ID_CARGO INT)
BEGIN
	DELETE FROM CARGO WHERE ID_CARGO = P_ID_CARGO;
END$

-- 🤴 PROCEDIMIENTO ELIMINAR USUARIO 👸
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_USUARIO(IN P_ID_USUARIO INT)
BEGIN
	DELETE FROM USUARIO WHERE ID_USUARIO = P_ID_USUARIO;
END$

-- 👩‍🍳 PROCEDIMIENTO ELIMINAR EMPLEADO 👨‍🍳
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_EMPLEADO(IN P_ID_EMPLEADO INT)
BEGIN
	DELETE FROM EMPLEADO WHERE ID_EMPLEADO = P_ID_EMPLEADO;
END$

-- 👦 PROCEDIMIENTO ELIMINAR CLIENTE 👦
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_CLIENTE(IN P_ID_CLIENTE INT)
BEGIN
	DELETE FROM CLIENTE WHERE ID_CLIENTE = P_ID_CLIENTE;
END$

-- 🥐 PROCEDIMIENTO ELIMINAR PRODUCTO 🥐
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_PRODUCTO(IN P_ID_PRODUCTO BIGINT)
BEGIN
	DELETE FROM PRODUCTO WHERE ID_PRODUCTO = P_ID_PRODUCTO;
END$

-- 🛍️ PROCEDIMIENTO ELIMINAR VENTA 🛍️
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_VENTA(IN P_ID_VENTA BIGINT)
BEGIN
	DELETE FROM VENTA WHERE ID_VENTA = P_ID_VENTA;
END$

-- 🛒 PROCEDIMIENTO ELIMINAR DETALLE VENTA 🛒
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_DETALLE_VENTA(IN P_ID_DETALLE_VENTA INT)
BEGIN
	DELETE FROM DETALLE_VENTA WHERE ID_DETALLE_VENTA = P_ID_DETALLE_VENTA;
END$

-- 🗄️ PROCEDIMIENTO ELIMINAR AJUSTE INVENTARIO 🗄️
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_AJUSTE_INVENTARIO(IN P_ID_AJUSTE INT)
BEGIN
	DELETE FROM AJUSTE_INVENTARIO WHERE ID_AJUSTE = P_ID_AJUSTE;
END$

-- 👩‍💼 PROCEDIMIENTO ELIMINAR PROVEEDOR 👨‍💼
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_PROVEEDOR(IN P_ID_PROVEEDOR INT)
BEGIN
	DELETE FROM PROVEEDOR WHERE ID_PROVEEDOR = P_ID_PROVEEDOR;
END$

-- 🥣 PROCEDIMIENTO ELIMINAR MATERIA PRIMA 🥣
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_MATERIA_PRIMA(IN P_ID_MATERIA_PRIMA BIGINT)
BEGIN
	DELETE FROM MATERIA_PRIMA WHERE ID_MATERIA_PRIMA = P_ID_MATERIA_PRIMA;
END$

-- 📜 PROCEDIMIENTO ELIMINAR FACTURA COMPRA 📜
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_FACTURA_COMPRA(IN P_ID_FACTURA_COMPRA BIGINT)
BEGIN
	DELETE FROM FACTURA_COMPRA WHERE ID_FACTURA_COMPRA = P_ID_FACTURA_COMPRA;
END$

-- 📰 PROCEDIMIENTO ELIMINAR DETALLE FACTURA COMPRA MATERIA PRIMA 📰
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA(IN P_ID_DETALLE_FAC_MAT_PRIM INT)
BEGIN
	DELETE FROM DETALLE_FACTURA_COMPRA_MATERIA_PRIMA WHERE ID_DETALLE_FAC_MAT_PRIM = P_ID_DETALLE_FAC_MAT_PRIM;
END$

-- 🍮 PROCEDIMIENTO ELIMINAR DETALLE COMPRA PRODUCTO 🍮
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_DETALLE_COMPRA_PRODUCTO(IN P_ID_DETALLE_COMPRA_PRODUCTO INT)
BEGIN
	DELETE FROM DETALLE_COMPRA_PRODUCTO WHERE ID_DETALLE_COMPRA_PRODUCTO = P_ID_DETALLE_COMPRA_PRODUCTO;
END$

-- 🍲 PROCEDIMIENTO ELIMINAR PRODUCCION 🍲
-- _____________________________________________________________________________________________________________________________________________________
CREATE PROCEDURE ELIMINAR_PRODUCCION(IN P_ID_PRODUCCION BIGINT)
BEGIN
	DELETE FROM PRODUCCION WHERE ID_PRODUCCION = P_ID_PRODUCCION;
END$

DELIMITER ;