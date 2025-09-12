<?php
namespace models;

use \config\Connection;

class CargoModel extends Connection {
    private $db;

    public function __construct() {
        // Obtenemos la única instancia de la conexión. ¡Más eficiente!
        $this->db = Connection::getConnection(); 
    }
    /* Método para obtener todos los cargos (READ) */
    public function getCargos() {
        try {
            $sql = "SELECT * FROM CARGO ORDER BY NOMBRE_CARGO ASC";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Manejo de errores de la base de datos
            error_log("Error al obtener cargos: " . $e->getMessage());
            return []; // Devuelve un array vacío en caso de error
        }
    }

    /* Método para insertar un nuevo cargo (CREATE) */
    public function createCargo($nombre_cargo, $estado_cargo) {
        try {
            $sql = "INSERT INTO CARGO (NOMBRE_CARGO, ESTADO_CARGO) VALUES (:nombre, :estado)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':nombre', $nombre_cargo);
            $stmt->bindParam(':estado', $estado_cargo, \PDO::PARAM_BOOL);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error al crear cargo: " . $e->getMessage());
            return false;
        }
    }
    
    // Aquí puedes agregar métodos para actualizar (update) y eliminar (delete) un cargo.

    /* Método para obtener un solo cargo por ID (útil para la edición) */
    public function getCargoById($id) {
        try {
            $sql = "SELECT * FROM CARGO WHERE ID_CARGO = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error al obtener cargo por ID: " . $e->getMessage());
            return false;
        }
    }
}
