<?php

namespace models;

use \config\Connection;
use \PDO;

class AjusteInventarioModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public function getAjustesInv() {
        try {
            $sql = "CALL CONSULTAR_AJUSTE_INVENTARIO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getAjustesInv: " . $e->getMessage());
            return [];
        }
    }

    public function getCantAjustesInvExistentes() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM AJUSTE_INVENTARIO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantAjustesInvExistentes: " . $e->getMessage());
            return 0;
        }
    }

    public function createAjustesInv($fecha, $tipo, $cantAjustada, $descripcion, $productoFK)
    {
        try {
            $sql = "CALL INSERTAR_AJUSTE_INVENTARIO(:fecha, :tipo, :cantAjustada, :descripcion, :productoFK, :estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':fecha', $fecha, \PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, \PDO::PARAM_STR);
            $stmt->bindParam(':cantAjustada', $cantAjustada, \PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion, \PDO::PARAM_STR);
            $stmt->bindParam(':productoFK', $productoFK, \PDO::PARAM_INT);
            $stmt->bindValue(':estado', 1, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createAjustesInv: " . $e->getMessage());
            return null;
        }
    }

    public function getAjustesInvById($id) {
        $sql = "SELECT
                A.ID_AJUSTE,
                A.FECHA_AJUSTE,
                A.TIPO_AJUSTE,
                A.CANTIDAD_AJUSTADA,
                A.DESCRIPCION,
                A.ID_PROD_FK_AJUSTE_INVENTARIO,
                P.NOMBRE_PRODUCTO,
                A.ID_USUARIO_FK_AJUSTE_INVENTARIO,
                U.NOMBRE AS USUARIO_REGISTRO
            FROM AJUSTE_INVENTARIO A
            INNER JOIN PRODUCTO P ON A.ID_PROD_FK_AJUSTE_INVENTARIO = P.ID_PRODUCTO
            INNER JOIN USUARIO U ON A.ID_USUARIO_FK_AJUSTE_INVENTARIO = U.ID_USUARIO
            WHERE A.ID_AJUSTE = :id
            ORDER BY A.ID_AJUSTE
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAjustesInv($id, $fecha, $tipo, $cantAjustada, $descripcion, $productoFK)
    {
        try {
            $sql = "CALL ACTUALIZAR_AJUSTE_INVENTARIO(:id, :fecha, :tipo, :cantAjustada, :descripcion, :productoFK, :usuario_fk)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha, \PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, \PDO::PARAM_STR);
            $stmt->bindParam(':cantAjustada', $cantAjustada, \PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion, \PDO::PARAM_STR);
            $stmt->bindParam(':productoFK', $productoFK, \PDO::PARAM_INT);
            $stmt->bindParam(':usuario_fk', $_SESSION['userId'], \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateAjustesInv: " . $e->getMessage());
            return null;
        }
    }

    public function deleteAjustesInv($id)
    {
        try {
            $sql = "CALL ELIMINAR_AJUSTE_INVENTARIO(:id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función deleteProd: " . $e->getMessage());
            return null;
        }
    }

    public function getFilteredAjustesInv($filtros = [])
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
