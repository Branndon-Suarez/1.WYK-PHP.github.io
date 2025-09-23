<?php
namespace models;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;
use \PDO;

class TareaModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function getTareas() {
        try {
            $sql = "CALL INSERTAR_TAREA";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getTareas: " . $e->getMessage());
            return [];
        }
    }

    public function getTareasByUsuario($id_usuario) {
        try {
            $sql = "SELECT ID_TAREA, TAREA, DESCRIPCION, TIEMPO_ESTIMADO_HORAS, ESTADO_TAREA, USUARIO_CREADOR_FK FROM TAREA WHERE USUARIO_ASIGNADO_FK = :id_usuario ORDER BY ID_TAREA";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Asegurarse de que siempre se retorne un array
            return is_array($result) ? $result : [];
        } catch (\PDOException $e) {
            // Manejar o registrar el error
            error_log("Error en la función getTareasByUsuario: " . $e->getMessage());
            return [];
        }
    }

    public function completarTarea($id_tarea) {
        try {
            $sql = "UPDATE TAREA SET ESTADO_TAREA = 'COMPLETADA' WHERE ID_TAREA = :id_tarea";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
    
    public function revertirTarea($id_tarea) {
        try {
            $sql = "UPDATE TAREA SET ESTADO_TAREA = 'PENDIENTE' WHERE ID_TAREA = :id_tarea";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getCantTareasExistentes() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM TAREA";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantTareasExistentes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantTareasActivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM ROL WHERE ESTADO_ROL = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantRolesActivos: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantTareasInactivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM ROL WHERE ESTADO_ROL = 0";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantRolesInactivos: " . $e->getMessage());
            return 0;
        }
    }

    public function checkIfRolExists($rol) {
        try {
            $sql = "SELECT COUNT(*) FROM ROL WHERE ROL = :rol";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':rol', $rol, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Error en checkIfRolExists: " . $e->getMessage());
            return false;
        }
    }

    public function createRol($rol, $rolClasificacion) {
        try {
            $sql = "CALL INSERTAR_ROL(:rol, :rol_clasificacion, :rol_estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':rol', $rol, \PDO::PARAM_STR);
            $stmt->bindParam(':rol_clasificacion', $rolClasificacion, \PDO::PARAM_STR);
            $stmt->bindValue(':rol_estado', 1, \PDO::PARAM_INT); // Estado activo por defecto
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createCargo: " . $e->getMessage());
            return null;
        }
    }

    public function getRolById($idRol) {
        try {
            $sql = "SELECT * FROM ROL WHERE ID_ROL = :id_rol";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_rol', $idRol, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getRolById: " . $e->getMessage());
            return null;
        }
    }

    public function updateRol($idRol, $rol, $rolCategoria, $rolEstado) {
        try {
            $sql = "CALL ACTUALIZAR_ROL(:id_rol, :rol, :rol_clasificacion, :rol_estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_rol', $idRol, \PDO::PARAM_INT);
            $stmt->bindParam(':rol', $rol, \PDO::PARAM_STR);
            $stmt->bindParam(':rol_clasificacion', $rolCategoria, \PDO::PARAM_STR);
            $stmt->bindValue(':rol_estado', $rolEstado, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateRol: " . $e->getMessage());
            return null;
        }
    }

    public function updateRolState($idRol, $estadoRol) {
        try {
            // La consulta SQL con marcadores de posición.
            $sql = "UPDATE ROL SET ESTADO_ROL = :estado WHERE ID_ROL = :id";
            $stmt = $this->db->prepare($sql);

            // Vincular los parámetros para evitar inyección SQL.
            $stmt->bindParam(':estado', $estadoRol, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $idRol, \PDO::PARAM_INT);
            
            $stmt->execute();

            // Verificar si se actualizó al menos una fila.
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            // Registrar el error en el log de XAMPP.
            error_log("Error al actualizar estado del rol: " . $e->getMessage());
            return false;
        }
    }

    public function deleteRol($idRol) {
        try {
            $sql = "CALL ELIMINAR_ROL(:id_rol)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_rol', $idRol, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función deleteRol: " . $e->getMessage());
            return null;
        }
    }

    public function getFilteredRoles($searchText = null, $estado = null, $chipFilters = []) {
        $sql = "SELECT * FROM ROL WHERE 1=1";
        $params = [];

        // Filter by text search (ROL or CLASIFICACION)
        if (!empty($searchText)) {
            $sql .= " AND (ROL LIKE ? OR CLASIFICACION LIKE ?)";
            $params[] = '%' . $searchText . '%';
            $params[] = '%' . $searchText . '%';
        }

        // Filter by role status
        if ($estado === 'activo') {
            $sql .= " AND ESTADO_ROL = 1";
        } elseif ($estado === 'inactivo') {
            $sql .= " AND ESTADO_ROL = 0";
        }

        // Loop through the chip filters
        foreach ($chipFilters as $columna => $valores) {
            // Decodificar el nombre de la columna que viene de la URL
            $columnaDecodificada = urldecode($columna);

            // Validar la columna decodificada
            if (in_array($columnaDecodificada, ['ROL', 'CLASIFICACION'])) {
                $placeholders = implode(',', array_fill(0, count($valores), '?'));
                $sql .= " AND " . $columnaDecodificada . " IN (" . $placeholders . ")";
                foreach ($valores as $valor) {
                    // Decodifica los valores de la URL
                    $params[] = urldecode($valor);
                }
            }
        }

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            error_log("Error al obtener roles filtrados: " . $e->getMessage());
            return [];
        }
    }
}
