USE PROYECTO_WYK;
-- Usuario de Administrador
DROP USER IF EXISTS 'admin_wyk'@'localhost';
CREATE USER 'admin_wyk'@'localhost' IDENTIFIED BY 'contraseña_admin';
GRANT ALL PRIVILEGES ON PROYECTO_WYK.* TO 'admin_wyk'@'localhost';

-- Usuarios de Empleados
CREATE USER 'empleado_wyk'@'localhost' IDENTIFIED BY 'contraseña_empleado';

-- Otorgar permisos específicos a los empleados:
-- Los empleados pueden consultar todas las tablas necesarias para su operación diaria.
-- También pueden insertar y actualizar en tablas como PEDIDO, DETALLE_PEDIDO, FACTURA_VENTA, DETALLE_VENTA_PRODUCTO
-- y PRODUCCION, PRODUCTO, MATERIA_PRIMA (si gestionan inventario o producción).
-- Basado en los diagramas de casos de uso:
-- - Gestión de Usuario (Registrar Usuario): INSERT en USUARIO, USUARIO_EMPLEADO.
-- - Login (Iniciar sesión): SELECT en USUARIO.
-- - Gestión de Cargo (Consultar Cargo): SELECT en CARGO.
-- - Gestión de Empleado (Consultar Empleado): SELECT en EMPLEADO.
-- - Gestión de Cliente (Consultar Cliente): SELECT en CLIENTE.
-- - Gestión de Proveedor (Consultar Proveedor): SELECT en PROVEEDOR.
-- - Gestión de Materia Prima (Consultar Materia Prima): SELECT en MATERIA_PRIMA.
-- - Gestión de Producto (Consultar Producto): SELECT en PRODUCTO.
-- - Gestión de Factura Compra (Consultar Factura Compra): SELECT en FACTURA_COMPRA, DETALLE_FACTURA_COMPRA_MATERIA_PRIMA, DETALLE_COMPRA_PRODUCTO.
-- - Gestión de Factura Venta (Consultar Factura Venta): SELECT en FACTURA_VENTA, DETALLE_VENTA_PRODUCTO.
-- - PEDIDO: INSERT, UPDATE, SELECT.
-- - DETALLE_PEDIDO: INSERT, UPDATE, SELECT.
-- - FACTURA_VENTA: INSERT, UPDATE, SELECT.
-- - DETALLE_VENTA_PRODUCTO: INSERT, UPDATE, SELECT.
-- - PRODUCCION: INSERT, UPDATE, SELECT.
DROP USER IF EXISTS 'empleado_wyk'@'localhost';
CREATE USER 'empleado_wyk'@'localhost' IDENTIFIED BY 'tu_contraseña_empleado_segura';

-- Permisos específicos para tablas donde los empleados tienen acciones de escritura/actualización
GRANT INSERT, UPDATE ON PROYECTO_WYK.USUARIO TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.USUARIO_EMPLEADO TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.PEDIDO TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.DETALLE_PEDIDO TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.FACTURA_VENTA TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.DETALLE_VENTA_PRODUCTO TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.PRODUCCION TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.PRODUCTO TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.MATERIA_PRIMA TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.FACTURA_COMPRA TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.DETALLE_FACTURA_COMPRA_MATERIA_PRIMA TO 'empleado_wyk'@'localhost';
GRANT INSERT, UPDATE ON PROYECTO_WYK.DETALLE_COMPRA_PRODUCTO TO 'empleado_wyk'@'localhost';


-- 3. Crear usuario para Clientes
-- Reemplaza 'tu_contraseña_cliente_segura' con una contraseña fuerte.
DROP USER IF EXISTS 'cliente_wyk'@'localhost';
CREATE USER 'cliente_wyk'@'localhost' IDENTIFIED BY 'contraseña_cliente';

-- Otorgar permisos específicos a los clientes:
-- Los clientes solo pueden iniciar sesión y consultar sus propias facturas de venta.
-- Para la consulta de sus propias facturas de venta, se necesitará una lógica en la aplicación
-- que filtre por el ID_CLIENTE asociado al usuario.
GRANT SELECT ON PROYECTO_WYK.USUARIO TO 'cliente_wyk'@'localhost'; -- Para iniciar sesión
GRANT SELECT ON PROYECTO_WYK.FACTURA_VENTA TO 'cliente_wyk'@'localhost';
GRANT SELECT ON PROYECTO_WYK.DETALLE_VENTA_PRODUCTO TO 'cliente_wyk'@'localhost';
GRANT SELECT ON PROYECTO_WYK.PEDIDO TO 'cliente_wyk'@'localhost';


-- Refrescar los privilegios para que los cambios surtan efecto
FLUSH PRIVILEGES;

-- Opcional: Crear un usuario para pruebas o desarrollo con permisos limitados
-- CREATE USER 'dev_wyk'@'localhost' IDENTIFIED BY 'contraseña_dev';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON PROYECTO_WYK.* TO 'dev_wyk'@'localhost';
-- FLUSH PRIVILEGES;
