<?php

namespace models;

use \config\Connection;
use \PDO;

class MateriaPrimaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public function getMatPrimas() {
        try {
            $sql = "CALL CONSULTAR_MATERIA_PRIMA";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getRoles: " . $e->getMessage());
            return [];
        }
    }

    public function listarMateriasPrimas()
    {
        $sql = "SELECT 
                    ID_MATERIA_PRIMA, 
                    NOMBRE_MATERIA_PRIMA, 
                    FECHA_VENCIMIENTO_MATERIA_PRIMA, 
                    CANTIDAD_EXIST_MATERIA_PRIMA, 
                    PRESENTACION_MATERIA_PRIMA,
                    DESCRIPCION_MATERIA_PRIMA,
                    ID_USUARIO_FK_MATERIA_PRIMA,
                    ESTADO_MATERIA_PRIMA
                FROM MATERIA_PRIMA";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener un producto por su ID
     */
    public function getMatPrimaById($id) {
        $sql = "SELECT
                M.ID_MATERIA_PRIMA,
                M.NOMBRE_MATERIA_PRIMA,
                M.VALOR_UNITARIO_MAT_PRIMA,
                M.FECHA_VENCIMIENTO_MATERIA_PRIMA,
                M.CANTIDAD_EXIST_MATERIA_PRIMA,
                M.PRESENTACION_MATERIA_PRIMA,
                M.DESCRIPCION_MATERIA_PRIMA,
                M.ID_USUARIO_FK_MATERIA_PRIMA,
                U.NOMBRE AS USUARIO_REGISTRO,
                M.ESTADO_MATERIA_PRIMA
            FROM MATERIA_PRIMA M
            INNER JOIN USUARIO U ON M.ID_USUARIO_FK_MATERIA_PRIMA = U.ID_USUARIO
            WHERE M.ID_MATERIA_PRIMA = :id
            ORDER BY M.ID_MATERIA_PRIMA";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCantMatPrimaExistentes() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM MATERIA_PRIMA";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantMatPrimaExistentes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantMatPrimaActivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM MATERIA_PRIMA WHERE ESTADO_MATERIA_PRIMA = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantMatPrimaActivos: " . $e->getMessage());
            return 0;
        }
    }

    public function getCanMatPrimaInactivos()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM MATERIA_PRIMA WHERE ESTADO_MATERIA_PRIMA = 0";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCanMatPrimaInactivos: " . $e->getMessage());
            return 0;
        }
    }

    public function checkIfMatPrimaExists($nombre)
    {
        try {
            $sql = "SELECT COUNT(*) FROM MATERIA_PRIMA WHERE NOMBRE_MATERIA_PRIMA = :nombre";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Error en checkIfProdExists: " . $e->getMessage());
            return false;
        }
    }

    public function createMatPrima($nombre, $valorUnitario, $fechVenc, $cantExist, $presentacion, $descripcion)
    {
        try {
            $sql = "CALL INSERTAR_MATERIA_PRIMA(:nombre, :valorUnitario, :fechVenc, :cantExist, :presentacion, :descripcion, :usuario_fk, :estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, \PDO::PARAM_STR);
            $stmt->bindParam(':valorUnitario', $valorUnitario, \PDO::PARAM_INT);
            $stmt->bindParam(':fechVenc', $fechVenc, \PDO::PARAM_STR);
            $stmt->bindParam(':cantExist', $cantExist, \PDO::PARAM_INT);
            $stmt->bindParam(':presentacion', $presentacion, \PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, \PDO::PARAM_STR);
            $stmt->bindParam(':usuario_fk', $_SESSION['userId'], \PDO::PARAM_INT);
            $stmt->bindValue(':estado', 1, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createMatPrima: " . $e->getMessage());
            return null;
        }
    }

    public function updateMatPrima($id, $nombre, $valorUnit, $fechVenc, $cantExist, $presentacion, $descripcion, $estado)
    {
        try {
            $sql = "CALL ACTUALIZAR_MATERIA_PRIMA(:id, :nombre, :valorUnit, :fechVenc, :cantExist, :presentacion, :descripcion, :usuario_fk, :estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, \PDO::PARAM_STR);
            $stmt->bindParam(':valorUnit', $valorUnit, \PDO::PARAM_INT);
            $stmt->bindParam(':fechVenc', $fechVenc, \PDO::PARAM_STR);
            $stmt->bindParam(':cantExist', $cantExist, \PDO::PARAM_INT);
            $stmt->bindParam(':presentacion', $presentacion, \PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, \PDO::PARAM_STR);
            $stmt->bindParam(':usuario_fk', $_SESSION['userId'], \PDO::PARAM_INT);
            $stmt->bindValue(':estado', $estado, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateUsuario: " . $e->getMessage());
            return null;
        }
    }

    public function updateMatPrimaState($id, $estado)
    {
        try {
            // La consulta SQL con marcadores de posición.
            $sql = "UPDATE MATERIA_PRIMA SET ESTADO_MATERIA_PRIMA = :estado WHERE ID_MATERIA_PRIMA = :id";
            $stmt = $this->db->prepare($sql);

            // Vincular los parámetros para evitar inyección SQL.
            $stmt->bindParam(':estado', $estado, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            $stmt->execute();

            // Verificar si se actualizó al menos una fila.
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            // Registrar el error en el log de XAMPP.
            error_log("Error al actualizar estado de la materia prima: " . $e->getMessage());
            return false;
        }
    }

    public function deleteMatPrima($id)
    {
        try {
            $sql = "CALL ELIMINAR_MATERIA_PRIMA(:id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función deleteMatPrima: " . $e->getMessage());
            return null;
        }
    }

    public function getFilteredUsuarios($filtros = [])
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
