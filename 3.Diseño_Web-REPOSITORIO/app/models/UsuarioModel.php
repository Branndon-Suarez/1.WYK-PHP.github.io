<?php
namespace models;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;

class UsuarioModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function getUsuarios() {
        try {
            $sql = "CALL CONSULTAR_USUARIO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getUsuarios: " . $e->getMessage());
            return [];
        }
    }

    public function getCantUsuariosExist() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM USUARIO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantUsuariosExist: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantUsuariosActivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM USUARIO WHERE ESTADO_USUARIO = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantUsuariosActivos: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantUsuariosInactivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM USUARIO WHERE ESTADO_USUARIO = 0";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantUsuariosInactivos: " . $e->getMessage());
            return 0;
        }
    }

    public function checkIfUsuarioExists($nombreUsuario) {
        try {
            $sql = "SELECT COUNT(*) FROM CARGO WHERE NOMBRE_USUARIO = :nombre_usuario";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombreUsuario, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Error en checkIfCargoExists: " . $e->getMessage());
            return false;
        }
    }

    public function createUsuario($nombreUsuario, $passwordCifrada, $fechaActual, $rolUsuario) {
        try {
            $sql = "CALL INSERTAR_USUARIO(:nombre_usuario, :password, :fecha_registro, :fecha_ulti_sesion, :rol, :estado_usuario)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombreUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordCifrada, \PDO::PARAM_STR);
            $stmt->bindParam(':fecha_registro', $fechaActual, \PDO::PARAM_STR);
            $stmt->bindParam(':fecha_ulti_sesion', $fechaActual, \PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rolUsuario, \PDO::PARAM_STR);
            $stmt->bindValue(':estado_usuario', 1, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createUsuario: " . $e->getMessage());
            return null;
        }
    }

    public function getUsuarioById($id) {
        try {
            $sql = "SELECT * FROM USUARIO WHERE ID_USUARIO = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getUsuarioById: " . $e->getMessage());
            return null;
        }
    }

    public function updateUsuario($idUsuario, $nombreUsuario, $password, $fechaRegistro, $fechaultSesion, $rol, $estadoUsuario) {
        try {
            $sql = "CALL ACTUALIZAR_USUARIO(:id_usuario, :nombre_usuario, :password, :fecha_registro, :fecha_ulti_sesion, :rol, :estado_usuario)";
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':id_usuario', $idUsuario, \PDO::PARAM_INT);
            $stmt->bindParam(':nombre_usuario', $nombreUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
            $stmt->bindParam(':fecha_registro', $fechaRegistro, \PDO::PARAM_STR);
            $stmt->bindParam(':fecha_ulti_sesion', $fechaultSesion, \PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, \PDO::PARAM_STR);
            $stmt->bindValue(':estado_usuario', $estadoUsuario, \PDO::PARAM_INT);
            
            return $stmt->execute();
            
        } catch (\PDOException $e) {
            error_log("Error en la función updateUsuario: " . $e->getMessage());
            return false;
        }
    }

    public function updateUsuarioState($idUsuario, $estadoUsuario) {
        try {
            $sql = "UPDATE USUARIO SET ESTADO_USUARIO = :estado WHERE ID_USUARIO = :id";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':estado', $estadoUsuario, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $idUsuario, \PDO::PARAM_INT);
            
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error al actualizar estado del usuario: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUsuario($idUsuario) {
        try {
            $sql = "CALL ELIMINAR_USUARIO(:id_usuario)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_usuario', $idUsuario, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función deleteUsuario: " . $e->getMessage());
            return null;
        }
    }
}
