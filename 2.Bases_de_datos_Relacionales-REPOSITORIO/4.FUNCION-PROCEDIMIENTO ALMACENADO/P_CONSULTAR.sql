USE PROYECTO_WYK;
														/*PROCEDIMINETOS DE CONSULTAR*/
                                                        
                                                        /*👮‍PROCEDIMIENTO CONSULTAR CARGO👮‍
_____________________________________________________________________________________________________________________________________________________*/
DELIMITER $
CREATE PROCEDURE CONSULTAR_CARGO()
BEGIN
	SELECT*FROM CARGO;
END	$

														/*🤴PROCEDIMIENTO CONSULTAR USUARIO👸
_____________________________________________________________________________________________________________________________________________________*/	
DELIMITER $
CREATE PROCEDURE CONSULTAR_USUARIO()
BEGIN
	SELECT*FROM USUARIO;
END	$

														/*👩‍🍳PROCEDIMIENTO CONSULTAR EMPLEADO👨‍🍳
_____________________________________________________________________________________________________________________________________________________*/
DELIMITER $
CREATE PROCEDURE CONSULTAR_EMPLEADO()
BEGIN
	SELECT*FROM EMPLEADO;
END	$

														/*👦PROCEDIMIENTO CONSULTAR CLIENTE👦
_____________________________________________________________________________________________________________________________________________________*/                                                      
DELIMITER $
CREATE PROCEDURE CONSULTAR_CLIENTE()
BEGIN
	SELECT*FROM CLIENTE;
END	$

														/*🍰PROCEDIMIENTO CONSULTAR PEDIDO🍰
_____________________________________________________________________________________________________________________________________________________*/	
DELIMITER $
CREATE PROCEDURE CONSULTAR_PEDIDO()
BEGIN
	SELECT*FROM PEDIDO;
END	$

														/*🥐PROCEDIMIENTO CONSULTAR PRODUCTO🥐
_____________________________________________________________________________________________________________________________________________________*/    
DELIMITER $
CREATE PROCEDURE CONSULTAR_PRODUCTO()
BEGIN
	SELECT*FROM PRODUCTO;
END	$

														/*🚲PROCEDIMIENTO CONSULTAR DETALLE PEDIDO🚲
_____________________________________________________________________________________________________________________________________________________*/
DELIMITER $
CREATE PROCEDURE CONSULTAR_DETALLE_PEDIDO()
BEGIN
	SELECT*FROM DETALLE_PEDIDO;
END	$

														/*📄PROCEDIMIENTO CONSULTAR FACTURA VENTA📄
_____________________________________________________________________________________________________________________________________________________*/   
DELIMITER $
CREATE PROCEDURE CONSULTAR_FACTURA_VENTA()
BEGIN
	SELECT*FROM FACTURA_VENTA;
END	$
  
														/*🔖PROCEDIMIENTO CONSULTAR DETALLE_VENTA_PRODUCTO🔖
_____________________________________________________________________________________________________________________________________________________*/
DELIMITER $
CREATE PROCEDURE CONSULTAR_DETALLE_VENTA_PRODUCTO()
BEGIN
	SELECT*FROM DETALLE_VENTA_PRODUCTO;
END	$

														/*👩‍💼PROCEDIMIENTO CONSULTAR PROVEEDOR👨‍💼
_____________________________________________________________________________________________________________________________________________________*/
DELIMITER $
CREATE PROCEDURE CONSULTAR_PROVEEDOR()
BEGIN
	SELECT*FROM PROVEEDOR;
END	$

														/*🥣PROCEDIMIENTO CONSULTAR MATERIA PRIMA🥣
_____________________________________________________________________________________________________________________________________________________*/
DELIMITER $
CREATE PROCEDURE CONSULTAR_MATERIA_PRIMA()
BEGIN
	SELECT*FROM MATERIA_PRIMA;
END	$

														/*📜PROCEDIMIENTO CONSULTAR FACTURA COMPRA📜
_____________________________________________________________________________________________________________________________________________________*/ 
DELIMITER $
CREATE PROCEDURE CONSULTAR_FACTURA_COMPRA()
BEGIN
	SELECT*FROM FACTURA_COMPRA;
END	$

														/*📰PROCEDIMIENTO CONSULTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA📰
_____________________________________________________________________________________________________________________________________________________*/  
DELIMITER $
CREATE PROCEDURE CONSULTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA()
BEGIN
	SELECT*FROM DETALLE_FACTURA_COMPRA_MATERIA_PRIMA;
END	$
														/*🍮PROCEDIMIENTO CONSULTAR_DETALLE_COMPRA_PRODUCTO🍮
_____________________________________________________________________________________________________________________________________________________*/    
DELIMITER $
CREATE PROCEDURE CONSULTAR_DETALLE_COMPRA_PRODUCTO()
BEGIN
	SELECT*FROM DETALLE_COMPRA_PRODUCTO;
END	$

														/*🍲PRECEDIMIENTO CONSULTAR PRODUCCION🍲
_____________________________________________________________________________________________________________________________________________________*/  
DELIMITER $
CREATE PROCEDURE CONSULTAR_PRODUCCION()
BEGIN
	SELECT*FROM PRODUCCION;
END	$

DELIMITER ;