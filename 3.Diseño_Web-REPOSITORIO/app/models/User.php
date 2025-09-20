<?php
namespace models;
/**Nota: La clase PDO de PHP de conexion a BD ya tiene namespace por defecto, lo que me permite usarlo con 'use'*/
use PDO;
use PDOException;
use config\Connection;

class User {
    private $db;
    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function findUser($numDocLogin)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT U.*, R.*
                FROM USUARIO U
                INNER JOIN ROL R ON U.ROL_FK_USUARIO = R.ID_ROL
                WHERE U.NUM_DOC = :num_Doc_Login AND U.ESTADO_USUARIO = 1"
            );
            $stmt->bindParam(':num_Doc_Login', $numDocLogin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en la función findUser: " . $e->getMessage());
            return false;
        }
    }

    public function verifyPassword($password, $passwordDB) {
        $passwordHash = hash('sha256', $password);
        return $passwordHash === $passwordDB;
    }
}
