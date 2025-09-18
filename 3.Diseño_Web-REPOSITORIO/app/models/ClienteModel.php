<?php
namespace models;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;

class ClienteModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function getClientes() {
        try {
            $sql = "CALL CONSULTAR_CLIENTE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getClientes: " . $e->getMessage());
            return [];
        }
    }

    public function getCantClientesExist() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM CLIENTE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantClientesExist: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantClientesActivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM CLIENTE WHERE ESTADO_CLIENTE = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantClientesActivos: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantClientesInactivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM CLIENTE WHERE ESTADO_CLIENTE = 0";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantClientesInactivos: " . $e->getMessage());
            return 0;
        }
    }

    public function checkIfClienteExists($numDocCliente) {
        try {
            $sql = "SELECT COUNT(*) FROM CLIENTE WHERE NUM_DOCUMENTO_CLIENTE = :num_doc_cliente";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':num_doc_cliente', $numDocCliente, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Error en checkIfClienteExists: " . $e->getMessage());
            return false;
        }
    }

    public function createCliente($numDocCliente, $tipoDocCliente, $nomCliente, $telCliente, $emailCliente, $usuarioCliente) {
        try {
            $sql = "CALL INSERTAR_CLIENTE(:num_doc_cliente, :tipo_doc_cliente, :nom_cliente, :tel_cliente, :email_cliente, :usuario_cliente, :estado_cliente)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':num_doc_cliente', $numDocCliente, \PDO::PARAM_INT);
            $stmt->bindParam(':tipo_doc_cliente', $tipoDocCliente, \PDO::PARAM_STR);
            $stmt->bindParam(':nom_cliente', $nomCliente, \PDO::PARAM_STR);
            $stmt->bindParam(':tel_cliente', $telCliente, \PDO::PARAM_INT);
            $stmt->bindParam(':email_cliente', $emailCliente, \PDO::PARAM_STR);
            $stmt->bindParam(':usuario_cliente', $usuarioCliente, \PDO::PARAM_INT);
            $stmt->bindValue(':estado_cliente', 1, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createCliente: " . $e->getMessage());
            return null;
        }
    }

    public function getClienteById($id) {
        try {
            $sql = "SELECT * FROM CLIENTE WHERE ID_CLIENTE = :id_cliente";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente', $id, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getClienteById: " . $e->getMessage());
            return null;
        }
    }

    public function updateCliente($idCliente, $numDocCliente, $tipoDocCliente, $nomCliente, $telCliente, $emailCliente, $usuarioCliente, $estadoCliente) {
        try {
            $sql = "CALL ACTUALIZAR_CLIENTE(:id_cliente, :num_doc_cliente, :tipo_doc_cliente, :nom_cliente, :tel_cliente, :email_cliente, :usuario_cliente, :estado_cliente, :estado_cliente)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente', $idCliente, \PDO::PARAM_INT);
            $stmt->bindParam(':num_doc_cliente', $numDocCliente, \PDO::PARAM_INT);
            $stmt->bindParam(':tipo_doc_cliente', $tipoDocCliente, \PDO::PARAM_STR);
            $stmt->bindParam(':nom_cliente', $nomCliente, \PDO::PARAM_STR);
            $stmt->bindParam(':tel_cliente', $telCliente, \PDO::PARAM_INT);
            $stmt->bindParam(':email_cliente', $emailCliente, \PDO::PARAM_STR);
            $stmt->bindParam(':usuario_cliente', $usuarioCliente, \PDO::PARAM_INT);
            $stmt->bindParam(':estado_cliente', $estadoCliente, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateCliente: " . $e->getMessage());
            return null;
        }
    }

    public function updateClienteState($idCliente, $estadoCliente) {
        try {
            $sql = "UPDATE CLIENTE SET ESTADO_CLIENTE = :estado WHERE ID_CLIENTE = :id";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':estado', $estadoCliente, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $idCliente, \PDO::PARAM_INT);
            
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error al actualizar estado del cliente: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCliente($idCliente) {
        try {
            $sql = "CALL ELIMINAR_CLIENTE(:id_cliente)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cliente', $idCliente, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función deleteCliente: " . $e->getMessage());
            return null;
        }
    }
}
