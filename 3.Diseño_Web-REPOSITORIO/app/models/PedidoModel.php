<?php

namespace models;

use \config\Connection;
use \PDO;
use \PDOException;

class PedidoModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    /**
     * Guardar un pedido con sus productos
     */
    public function guardarPedido($data)
    {
        try {
            // Inicia una transacción para asegurar la integridad de los datos
            $this->db->beginTransaction();

            // 1. Insertar en la tabla 'VENTA'
            // MODIFICADO: Se incluye ESTADO_PEDIDO y ESTADO_PAGO en lugar del antiguo ESTADO_VENTA
            $stmtVenta = $this->db->prepare("INSERT INTO VENTA (FECHA_HORA_VENTA, NUMERO_MESA, DESCRIPCION, ID_USUARIO_FK_VENTA, ESTADO_PEDIDO, ESTADO_PAGO, TOTAL_VENTA) 
                                            VALUES (:fecha_hora_venta, :numero_mesa, :descripcion, :id_usuario_fk_venta, :estado_pedido, :estado_pago, :total_venta)");

            $stmtVenta->bindValue(':fecha_hora_venta', $data['fecha']);
            // Se permite que $data['mesa'] sea null (el JS lo envía como null si está vacío)
            $stmtVenta->bindValue(':numero_mesa', $data['mesa']);
            $stmtVenta->bindValue(':descripcion', $data['descripcion']);
            $stmtVenta->bindValue(':id_usuario_fk_venta', $data['usuarioId']);

            // NUEVOS VALORES
            $stmtVenta->bindValue(':estado_pedido', $data['estadoPedido']);
            $stmtVenta->bindValue(':estado_pago', $data['estadoPago']);

            // Convierte el total a un entero antes de insertarlo
            $stmtVenta->bindValue(':total_venta', intval($data['total']));
            $stmtVenta->execute();

            // Obtener el ID de la última venta insertada
            $idVenta = $this->db->lastInsertId();

            if (!$idVenta) {
                throw new \Exception("Error al insertar la venta en la base de datos.");
            }

            // 2. Insertar los productos en la tabla 'DETALLE_VENTA'
            $stmtDetalle = $this->db->prepare("INSERT INTO DETALLE_VENTA (CANTIDAD, SUB_TOTAL, ID_VENTA_FK_DET_VENTA, ID_PRODUCTO_FK_DET_VENTA) VALUES (:cantidad, :sub_total, :id_venta, :id_producto)");

            foreach ($data['productos'] as $producto) {
                // Asegura que cantidad y precio sean enteros antes de la multiplicación
                $cantidad = intval($producto['cantidad']);
                $precio = intval($producto['precio']);
                $subTotal = $cantidad * $precio;

                $stmtDetalle->bindValue(':cantidad', $cantidad);
                $stmtDetalle->bindValue(':sub_total', $subTotal);
                $stmtDetalle->bindValue(':id_venta', $idVenta);
                $stmtDetalle->bindValue(':id_producto', $producto['id']);
                $stmtDetalle->execute();
            }

            // 3. Confirmar la transacción
            $this->db->commit();

            return $idVenta;
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            $this->db->rollBack();
            // Relanza la excepción para que el controlador la capture
            throw $e;
        }
    }

    /**
     * Obtener todos los pedidos
     */
    public function obtenerPedidos()
    {
        $sql = "SELECT * FROM VENTA ORDER BY FECHA_HORA_VENTA DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener un pedido con su detalle
     */
    public function obtenerPedidoPorId($idVenta)
    {
        // Info de la venta
        $sqlVenta = "SELECT * FROM VENTA WHERE ID_VENTA = :idVenta";
        $stmtVenta = $this->db->prepare($sqlVenta);
        $stmtVenta->execute([':idVenta' => $idVenta]);
        $venta = $stmtVenta->fetch(PDO::FETCH_ASSOC);

        if (!$venta) {
            return null;
        }

        // Detalles de la venta
        $sqlDetalle = "SELECT dv.*, p.NOMBRE_PRODUCTO
                        FROM DETALLE_VENTA dv
                        INNER JOIN PRODUCTO p 
                            ON dv.ID_PRODUCTO_FK_DET_VENTA = p.ID_PRODUCTO
                        WHERE dv.ID_VENTA_FK_DET_VENTA = :idVenta";
        $stmtDetalle = $this->db->prepare($sqlDetalle);
        $stmtDetalle->execute([':idVenta' => $idVenta]);
        $detalles = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);

        $venta['detalles'] = $detalles;
        return $venta;
    }
}
