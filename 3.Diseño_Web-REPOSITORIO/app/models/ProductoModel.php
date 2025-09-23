<?php

namespace models;

use \config\Connection;
use \PDO;

class ProductoModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    /**
     * Listar todos los productos
     */
    public function listarProductos()
    {
        $sql = "SELECT 
                    ID_PRODUCTO, 
                    NOMBRE_PRODUCTO, 
                    VALOR_UNITARIO_PRODUCTO, 
                    CANT_EXIST_PRODUCTO, 
                    FECHA_VENCIMIENTO_PRODUCTO,
                    TIPO_PRODUCTO,
                    ESTADO_PRODUCTO
                FROM PRODUCTO";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener un producto por su ID
     */
    public function obtenerProductoPorId($id)
    {
        $sql = "SELECT 
                    ID_PRODUCTO, 
                    NOMBRE_PRODUCTO, 
                    VALOR_UNITARIO_PRODUCTO, 
                    CANT_EXIST_PRODUCTO, 
                    FECHA_VENCIMIENTO_PRODUCTO,
                    TIPO_PRODUCTO,
                    ESTADO_PRODUCTO
                FROM PRODUCTO 
                WHERE ID_PRODUCTO = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insertar un nuevo producto
     */
    public function crearProducto($nombre, $valorUnitario, $cantidad, $fechaVencimiento, $tipo, $usuarioId, $estado)
    {
        $sql = "INSERT INTO PRODUCTO 
                (NOMBRE_PRODUCTO, VALOR_UNITARIO_PRODUCTO, CANT_EXIST_PRODUCTO, FECHA_VENCIMIENTO_PRODUCTO, TIPO_PRODUCTO, ID_USUARIO_FK_PRODUCTO, ESTADO_PRODUCTO) 
                VALUES (:nombre, :valor, :cantidad, :fecha, :tipo, :usuarioId, :estado)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":valor", $valorUnitario);
        $stmt->bindParam(":cantidad", $cantidad);
        $stmt->bindParam(":fecha", $fechaVencimiento);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":usuarioId", $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    /**
     * Actualizar un producto existente
     */
    public function actualizarProducto($id, $nombre, $valorUnitario, $cantidad, $fechaVencimiento, $tipo, $estado)
    {
        $sql = "UPDATE PRODUCTO 
                SET NOMBRE_PRODUCTO = :nombre, 
                    VALOR_UNITARIO_PRODUCTO = :valor, 
                    CANT_EXIST_PRODUCTO = :cantidad, 
                    FECHA_VENCIMIENTO_PRODUCTO = :fecha,
                    TIPO_PRODUCTO = :tipo,
                    ESTADO_PRODUCTO = :estado
                WHERE ID_PRODUCTO = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":valor", $valorUnitario);
        $stmt->bindParam(":cantidad", $cantidad);
        $stmt->bindParam(":fecha", $fechaVencimiento);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    /**
     * Eliminar un producto
     */
    public function eliminarProducto($id)
    {
        $sql = "DELETE FROM PRODUCTO WHERE ID_PRODUCTO = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
