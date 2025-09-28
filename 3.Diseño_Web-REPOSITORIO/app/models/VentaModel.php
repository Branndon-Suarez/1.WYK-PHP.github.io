<?php

namespace models;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;
use \PDO;

class VentaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public function getVentasAdmin()
    {
        try {
            $sql = "CALL CONSULTAR_VENTA";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getVentasAdmin: " . $e->getMessage());
            return [];
        }
    }

    public function getVentasMesero($idUserMesero)
    {
        try {
            $sql = "CALL CONSULTAR_VENTA_MESERO(:idUserMesero)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam('idUserMesero', $idUserMesero, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getVentasMesero: " . $e->getMessage());
            return [];
        }
    }

    public function getVentasCajero()
    {
        try {
            $sql = "CALL CONSULTAR_VENTA_CAJERO()";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getVentasCajero: " . $e->getMessage());
            return [];
        }
    }

    public function getCantVentasExistentes()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM VENTA";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantTareasExistentes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantPedidosPendientes()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM VENTA WHERE ESTADO_PEDIDO = 'PENDIENTE'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantPedidosPendientes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantPedidosPreparandose()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM VENTA WHERE ESTADO_PEDIDO = 'PREPARANDO'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantPedidosPreparandose: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantPedidosEntregados()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM VENTA WHERE ESTADO_PEDIDO = 'ENTREGADO'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantPedidosEntregados: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantPedidosCancelados()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM VENTA WHERE ESTADO_PEDIDO = 'CANCELADO'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantPedidosCancelados: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantVentasPendientes()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM VENTA WHERE ESTADO_PAGO = 'PENDIENTE'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantVentasPendientes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantVentasPagadas()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM VENTA WHERE ESTADO_PAGO = 'PAGADA'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantVentasPagadas: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantVentasCanceladas()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM VENTA WHERE ESTADO_PAGO = 'CANCELADA'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantVentasCanceladas: " . $e->getMessage());
            return 0;
        }
    }

    public function getDetalleVentaById($idVenta)
    {
        try {
            $sql = "SELECT
                        dv.CANTIDAD,
                        dv.SUB_TOTAL,
                        p.NOMBRE_PRODUCTO,
                        p.VALOR_UNITARIO_PRODUCTO
                    FROM DETALLE_VENTA dv
                    JOIN PRODUCTO p ON dv.ID_PRODUCTO_FK_DET_VENTA = p.ID_PRODUCTO
                    WHERE dv.ID_VENTA_FK_DET_VENTA = :idVenta";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idVenta', $idVenta, \PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en getDetalleVentaById: " . $e->getMessage());
            return [];
        }
    }

    public function getVentaById($idVenta)
    {
        try {
            $sql = "SELECT
                    V.ID_VENTA,
                    V.FECHA_HORA_VENTA,
                    V.TOTAL_VENTA,
                    V.NUMERO_MESA,
                    V.DESCRIPCION,
                    V.ID_USUARIO_FK_VENTA,
                    U.NOMBRE AS USUARIO_VENTA,
                    V.ESTADO_PEDIDO,
                    V.ESTADO_PAGO
                FROM VENTA V
                INNER JOIN USUARIO U ON V.ID_USUARIO_FK_VENTA = U.ID_USUARIO
                WHERE V.ID_VENTA = :id_Venta
                ORDER BY V.ID_VENTA
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_Venta', $idVenta, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getVentaById: " . $e->getMessage());
            return null;
        }
    }

    public function updateVenta($idVenta, $fecha, $total, $numMesa, $descripcion, $estadoPedido, $estadoVenta)
    {
        try {
            $sql = "CALL ACTUALIZAR_VENTA(:idVenta, :fecha, :total, :numMesa, :descripcion, :estadoPedido, :estadoVenta)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idVenta', $idVenta, \PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha, \PDO::PARAM_STR);
            $stmt->bindParam(':total', $total, \PDO::PARAM_INT);
            $stmt->bindParam(':numMesa', $numMesa, \PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion, \PDO::PARAM_STR);
            $stmt->bindParam(':estadoPedido', $estadoPedido, \PDO::PARAM_STR);
            $stmt->bindValue(':estadoVenta', $estadoVenta, \PDO::PARAM_STR);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateVenta: " . $e->getMessage());
            return null;
        }
    }

    public function getFilteredVentas($filtros = [])
    {
        $sql = "SELECT U.*, R.ROL AS NOMBRE_ROL FROM USUARIO U JOIN ROL R ON U.ROL_FK_USUARIO = R.ID_ROL";
        $whereClauses = [];
        $params = [];

        // Filtro de búsqueda de texto global
        if (!empty($filtros['search'])) {
            $searchText = '%' . $filtros['search'] . '%';
            $whereClauses[] = "(U.NUM_DOC LIKE ? OR U.NOMBRE LIKE ? OR U.TEL_USUARIO LIKE ? OR U.EMAIL_USUARIO LIKE ? OR R.ROL LIKE ?)";
            $params[] = $searchText;
            $params[] = $searchText;
            $params[] = $searchText;
            $params[] = $searchText;
            $params[] = $searchText;
        }

        // Filtro de estado
        if (isset($filtros['estado'])) {
            if ($filtros['estado'] === 'activo') {
                $whereClauses[] = "U.ESTADO_USUARIO = 1";
            } elseif ($filtros['estado'] === 'inactivo') {
                $whereClauses[] = "U.ESTADO_USUARIO = 0";
            }
        }

        // Filtros por chips y rangos
        foreach ($filtros as $key => $value) {
            if (strpos($key, 'filtro_') === 0) {
                $columna = str_replace('filtro_', '', $key);
                $valores = explode(',', $value);

                $columnaDB = "";
                switch (strtoupper($columna)) {
                    case 'DOCUMENTO':
                        $columnaDB = 'U.NUM_DOC';
                        break;
                    case 'NOMBRE':
                        $columnaDB = 'U.NOMBRE';
                        break;
                    case 'TELEFONO':
                        $columnaDB = 'U.TEL_USUARIO';
                        break;
                    case 'CORREO':
                    case 'EMAIL': // Añadido para manejar el caso que enviaste en la URL
                        $columnaDB = 'U.EMAIL_USUARIO';
                        break;
                    case 'ROL':
                        $columnaDB = 'R.ROL';
                        break;
                    case 'FECHA_REGISTRO':
                        $columnaDB = 'U.FECHA_REGISTRO';
                        break;
                }

                if (!empty($columnaDB) && !empty($valores)) {
                    $placeholders = implode(',', array_fill(0, count($valores), '?'));
                    $whereClauses[] = $columnaDB . " IN (" . $placeholders . ")";
                    foreach ($valores as $val) {
                        $params[] = $val;
                    }
                }
            }
        }

        // Filtro de rango de fechas
        if (isset($filtros['fecha_inicio']) && isset($filtros['fecha_fin'])) {
            try {
                $fechaInicio = new \DateTime($filtros['fecha_inicio']);
                $fechaFin = new \DateTime($filtros['fecha_fin']);

                if (isset($filtros['diaCompleto']) && $filtros['diaCompleto'] === 'true') {
                    $fechaFin->setTime(23, 59, 59);
                }

                $whereClauses[] = "U.FECHA_REGISTRO BETWEEN ? AND ?";
                $params[] = $fechaInicio->format('Y-m-d H:i:s');
                $params[] = $fechaFin->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                error_log("Error al procesar fechas de filtro: " . $e->getMessage());
            }
        }

        // Construye la cláusula WHERE si hay filtros
        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error al obtener usuarios filtrados: " . $e->getMessage());
            return [];
        }
    }
}
