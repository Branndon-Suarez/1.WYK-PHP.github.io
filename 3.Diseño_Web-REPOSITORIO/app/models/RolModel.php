<?php
namespace models;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;

class RolModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function getRoles() {
        try {
            $sql = "CALL CONSULTAR_ROL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getRoles: " . $e->getMessage());
            return [];
        }
    }

    public function getCantRolesExistentes() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM ROL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantRolesExistentes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantRolesActivos() {
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

    public function getCantRolesInactivos() {
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
}
