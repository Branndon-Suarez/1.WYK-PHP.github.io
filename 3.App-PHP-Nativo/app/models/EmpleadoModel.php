<?php
namespace models;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;

class EmpleadoModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function getEmpleados() {
        try {
            $sql = "CALL CONSULTAR_EMPLEADO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getEmpleados: " . $e->getMessage());
            return [];
        }
    }

    public function getCantEmpleadosExist() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM EMPLEADO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantEmpleadosExist: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantEmpleadosActivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM EMPLEADO WHERE ESTADO_EMPLEADO = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantEmpleadosActivos: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantEmpleadosInactivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM EMPLEADO WHERE ESTADO_EMPLEADO = 0";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantEmpleadosInactivos: " . $e->getMessage());
            return 0;
        }
    }

    public function checkIfEmpleadoExists($cedulaEmpleado) {
        try {
            $sql = "SELECT COUNT(*) FROM CARGO WHERE CC_EMPLEADO = :cedula_empleado";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':cedula_empleado', $cedulaEmpleado, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Error en checkIfCargoExists: " . $e->getMessage());
            return false;
        }
    }

    public function createEmpleado($cedulaEmpleado, $nombreEmpleado, $rhEmpleado, $telEmpleado, $emailEmpleado, $cargoEmpleado, $usuarioEmpleado) {
        try {
            $sql = "CALL INSERTAR_EMPLEADO(:cedula_empleado, :nombre_empleado, :RH_empleado, :tel_empleado, :email_empleado, :cargo_empleado, :usuario_empleado, :estado_empleado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':cedula_empleado', $cedulaEmpleado, \PDO::PARAM_INT);
            $stmt->bindParam(':nombre_empleado', $nombreEmpleado, \PDO::PARAM_STR);
            $stmt->bindParam(':RH_empleado', $rhEmpleado, \PDO::PARAM_STR);
            $stmt->bindParam(':tel_empleado', $telEmpleado, \PDO::PARAM_INT);
            $stmt->bindParam(':email_empleado', $emailEmpleado, \PDO::PARAM_STR);
            $stmt->bindParam(':cargo_empleado', $cargoEmpleado, \PDO::PARAM_INT);
            $stmt->bindParam(':usuario_empleado', $usuarioEmpleado, \PDO::PARAM_INT);
            $stmt->bindValue(':estado_empleado', 1, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createCargo: " . $e->getMessage());
            return null;
        }
    }

    public function getEmpleadoById($id) {
        try {
            $sql = "SELECT * FROM EMPLEADO WHERE ID_EMPLEADO = :id_empleado";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_empleado', $id, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getEmpleadoById: " . $e->getMessage());
            return null;
        }
    }

    public function updateEmpleado($idEmpleado, $cedulaEmpleado, $nombreEmpleado, $rhEmpleado, $telEmpleado, $emailEmpleado, $cargoEmpleado, $usuarioEmpleado, $estadoEmpleado) {
        try {
            $sql = "CALL ACTUALIZAR_EMPLEADO(:id_empleado, :cedula_empleado, :nombre_empleado, :RH_empleado, :tel_empleado, :email_empleado, :cargo_empleado, :usuario_empleado, :estado_empleado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_empleado', $idEmpleado, \PDO::PARAM_INT);
            $stmt->bindParam(':cedula_empleado', $cedulaEmpleado, \PDO::PARAM_INT);
            $stmt->bindParam(':nombre_empleado', $nombreEmpleado, \PDO::PARAM_STR);
            $stmt->bindParam(':RH_empleado', $rhEmpleado, \PDO::PARAM_STR);
            $stmt->bindParam(':tel_empleado', $telEmpleado, \PDO::PARAM_INT);
            $stmt->bindParam(':email_empleado', $emailEmpleado, \PDO::PARAM_STR);
            $stmt->bindParam(':cargo_empleado', $cargoEmpleado, \PDO::PARAM_INT);
            $stmt->bindParam(':usuario_empleado', $usuarioEmpleado, \PDO::PARAM_INT);
            $stmt->bindParam(':estado_empleado', $estadoEmpleado, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateEmpleado: " . $e->getMessage());
            return null;
        }
    }

    public function updateEmpleadoState($idEmpleado, $estadoEmpleado) {
        try {
            $sql = "UPDATE EMPLEADO SET ESTADO_EMPLEADO = :estado WHERE ID_EMPLEADO = :id";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':estado', $estadoEmpleado, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $idEmpleado, \PDO::PARAM_INT);
            
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error al actualizar estado del empleado: " . $e->getMessage());
            return false;
        }
    }

    public function deleteEmpleado($idEmpleado) {
        try {
            $sql = "CALL ELIMINAR_EMPLEADO(:id_empleado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_empleado', $idEmpleado, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función deleteEmpleado: " . $e->getMessage());
            return null;
        }
    }
}
