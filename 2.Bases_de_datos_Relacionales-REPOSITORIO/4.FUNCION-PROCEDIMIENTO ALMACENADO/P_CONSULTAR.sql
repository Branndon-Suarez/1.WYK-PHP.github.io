USE PROYECTO_WYK;

														/*PROCEDIMINETOS DE CONSULTAR*/
                                                        
                                                        /*👮‍PROCEDIMIENTO CONSULTAR CARGO👮‍
_____________________________________________________________________________________________________________________________________________________*/
DELIMITER $
CREATE PROCEDURE CONSULTAR_CARGO()
BEGIN
SELECT*FROM CARGO;
END	$	

CALL CONSULTAR_CARGO();		

														/*🤴PROCEDIMIENTO CONSULTAR USUARIO👸
_____________________________________________________________________________________________________________________________________________________*/	
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_USUARIO()
BEGIN
SELECT*FROM USUARIO;
END	$	

CALL CONSULTAR_USUARIO();	   		

														/*👩‍🍳PROCEDIMIENTO CONSULTAR EMPLEADO👨‍🍳
_____________________________________________________________________________________________________________________________________________________*/

DELIMITER $
CREATE PROCEDURE CONSULTAR_EMPLEADO()
BEGIN
SELECT*FROM EMPLEADO;
END	$	

CALL CONSULTAR_EMPLEADO();	  

														/*👦PROCEDIMIENTO CONSULTAR CLIENTE👦
_____________________________________________________________________________________________________________________________________________________*/                                                      
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_CLIENTE()
BEGIN
SELECT*FROM CLIENTE;
END	$	

CALL CONSULTAR_CLIENTE();	


														/*🍰PROCEDIMIENTO CONSULTAR PEDIDO🍰
_____________________________________________________________________________________________________________________________________________________*/	
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_PEDIDO()
BEGIN
SELECT*FROM PEDIDO;
END	$	

CALL CONSULTAR_PEDIDO();     

														/*🥐PROCEDIMIENTO CONSULTAR PRODUCTO🥐
_____________________________________________________________________________________________________________________________________________________*/    
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_PRODUCTO()
BEGIN
SELECT*FROM PRODUCTO;
END	$	

CALL CONSULTAR_PRODUCTO();   

														/*🚲PROCEDIMIENTO CONSULTAR DETALLE PEDIDO🚲
_____________________________________________________________________________________________________________________________________________________*/
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_DETALLE_PEDIDO()
BEGIN
SELECT*FROM DETALLE_PEDIDO;
END	$	

CALL CONSULTAR_DETALLE_PEDIDO();   

														/*📄PROCEDIMIENTO CONSULTAR FACTURA VENTA📄
_____________________________________________________________________________________________________________________________________________________*/   
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_FACTURA_VENTA()
BEGIN
SELECT*FROM FACTURA_VENTA;
END	$	

CALL CONSULTAR_FACTURA_VENTA();   

														/*🔖PROCEDIMIENTO CONSULTAR DETALLE_VENTA_PRODUCTO🔖
_____________________________________________________________________________________________________________________________________________________*/
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_DETALLE_VENTA_PRODUCTO()
BEGIN
SELECT*FROM DETALLE_VENTA_PRODUCTO;
END	$	

CALL CONSULTAR_DETALLE_VENTA_PRODUCTO();

														/*👩‍💼PROCEDIMIENTO CONSULTAR PROVEEDOR👨‍💼
_____________________________________________________________________________________________________________________________________________________*/
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_PROVEEDOR()
BEGIN
SELECT*FROM PROVEEDOR;
END	$	

CALL CONSULTAR_PROVEEDOR();		

														/*🥣PROCEDIMIENTO CONSULTAR MATERIA PRIMA🥣
_____________________________________________________________________________________________________________________________________________________*/
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_MATERIA_PRIMA()
BEGIN
SELECT*FROM MATERIA_PRIMA;
END	$	

CALL CONSULTAR_MATERIA_PRIMA();	   

														/*📜PROCEDIMIENTO CONSULTAR FACTURA COMPRA📜
_____________________________________________________________________________________________________________________________________________________*/ 
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_FACTURA_COMPRA()
BEGIN
SELECT*FROM FACTURA_COMPRA;
END	$	

CALL CONSULTAR_FACTURA_COMPRA();	 

														/*📰PROCEDIMIENTO CONSULTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA📰
_____________________________________________________________________________________________________________________________________________________*/  
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA()
BEGIN
SELECT*FROM DETALLE_FACTURA_COMPRA_MATERIA_PRIMA;
END	$	

CALL CONSULTAR_DETALLE_FACTURA_COMPRA_MATERIA_PRIMA(); 

														/*🍮PROCEDIMIENTO CONSULTAR_DETALLE_COMPRA_PRODUCTO🍮
_____________________________________________________________________________________________________________________________________________________*/    
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_DETALLE_COMPRA_PRODUCTO()
BEGIN
SELECT*FROM DETALLE_COMPRA_PRODUCTO;
END	$	

CALL CONSULTAR_DETALLE_COMPRA_PRODUCTO();  

														/*🍲PRECEDIMIENTO CONSULTAR PRODUCCION🍲
_____________________________________________________________________________________________________________________________________________________*/  
                                                        
DELIMITER $
CREATE PROCEDURE CONSULTAR_PRODUCCION()
BEGIN
SELECT*FROM PRODUCCION;
END	$	

CALL CONSULTAR_PRODUCCION();													
                                                    