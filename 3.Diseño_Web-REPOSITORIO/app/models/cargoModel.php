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
            $sql = "SELECT * FROM CARGO ORDER BY NOMBRE_CARGO ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getCargos: " . $e->getMessage());
            return [];
        }
    }

    public function createCargo($nombreCargo, $estadoCargo) {
        try {
            $sql = "INSERT INTO CARGO (NOMBRE_CARGO, ESTADO_CARGO) VALUES (:nombre_cargo, :estado_cargo)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre_cargo', $nombreCargo);
            $stmt->bindParam(':estado_cargo', $estadoCargo);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createCargo: " . $e->getMessage());
            return null;
        }
    }
}
