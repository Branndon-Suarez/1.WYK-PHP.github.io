<?php
namespace models;

use config\Connection;
use PDO;
use PDOException;

class Register {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    /**
     * Revisa si un usuario ya existe en la base de datos.
     * @param string $getUserName Nombre de usuario a buscar.
     * @return bool Retorna true si el usuario existe, false en caso contrario.
     */
    public function findExistenceUser($getUserName) {
        try {
            // Sintaxis corregida: se eliminan las comillas del marcador de posición.
            $stmt = $this->db->prepare("SELECT * FROM USUARIO WHERE NOMBRE_USUARIO = :nameUser");
            
            // Se enlaza el parámetro
            $stmt->bindParam(':nameUser', $getUserName, PDO::PARAM_STR);
            $stmt->execute();
            
            // Retorna true si encuentra una fila, false si no
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            error_log("Error en la función findExistenceUser: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Inserta un nuevo usuario en la base de datos.
     * @param string $getUserName Nombre de usuario.
     * @param string $getPassword Contraseña hasheada.
     * @return bool Retorna true si el registro fue exitoso, false en caso contrario.
     */
    public function registerUser($getUserName, $getPassword) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO USUARIO (NOMBRE_USUARIO, PASSWORD_USUARIO, FECHA_REGISTRO, FECHA_ULTIMA_SESION, ROL, ESTADO_USUARIO)
                 VALUES (:nameUser, :passwordUser, NOW(), NOW(), 'usuario', 1)"
            );
            
            // Se enlazan los parámetros para prevenir inyecciones SQL
            $stmt->bindParam(':nameUser', $getUserName, PDO::PARAM_STR);
            $stmt->bindParam(':passwordUser', $getPassword, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en la función registerUser: " . $e->getMessage());
            return false;
        }
    }
}