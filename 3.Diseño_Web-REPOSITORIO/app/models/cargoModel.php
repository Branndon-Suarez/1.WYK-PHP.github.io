<?php
namespace models;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;

class CargoModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function getCargos() {
        try {
            $sql = "CALL CONSULTAR_CARGO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getCargos: " . $e->getMessage());
            return [];
        }
    }

    public function getCantCargosExistentes() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM CARGO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantCargosExistentes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantCargosActivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM CARGO WHERE ESTADO_CARGO = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantCargosActivos: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantCargosInactivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM CARGO WHERE ESTADO_CARGO = 0";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantCargosInactivos: " . $e->getMessage());
            return 0;
        }
    }

    public function createCargo($nombreCargo) {
        try {
            $sql = "CALL INSERTAR_CARGO(:nombre_cargo, :estado_cargo)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre_cargo', $nombreCargo, \PDO::PARAM_STR);
            $stmt->bindValue(':estado_cargo', 1, \PDO::PARAM_INT); // Estado activo por defecto
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createCargo: " . $e->getMessage());
            return null;
        }
    }

    public function getCargoById($idCargo) {
        try {
            $sql = "SELECT * FROM CARGO WHERE ID_CARGO = :id_cargo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cargo', $idCargo, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getCargoById: " . $e->getMessage());
            return null;
        }
    }

    public function updateCargo($idCargo, $nombreCargo, $estadoCargo) {
        try {
            $sql = "CALL ACTUALIZAR_CARGO(:id_cargo, :nombre_cargo, :estado_cargo)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cargo', $idCargo, \PDO::PARAM_INT);
            $stmt->bindParam(':nombre_cargo', $nombreCargo, \PDO::PARAM_STR);
            $stmt->bindValue(':estado_cargo', $estadoCargo, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateCargo: " . $e->getMessage());
            return null;
        }
    }

    public function updateCargoState($idCargo, $estadoCargo) {
        try {
            $sql = "UPDATE CARGO SET ESTADO_CARGO = :estado WHERE ID_CARGO = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':estado', $estadoCargo, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $idCargo, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error al actualizar estado del cargo: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCargo($idCargo) {
        try {
            $sql = "CALL ELIMINAR_CARGO(:id_cargo)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cargo', $idCargo, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función deleteCargo: " . $e->getMessage());
            return null;
        }
    }
}
