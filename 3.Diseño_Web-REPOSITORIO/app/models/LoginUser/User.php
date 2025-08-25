<?php
require_once "../../../config/Connection.php";

class User extends Connection {
    public function findUserByUsername($getUserName)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM USUARIO WHERE NOMBRE_USUARIO = :1_userName"
            );
            $stmt->bindParam(':1_userName', $getUserName);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en la función findUserByUsername: " . $e->getMessage());
            return false;
        }
    }

    public function verifyPassword($password, $passwordDB) {
        $passwordHash = hash('sha256', $password);
        return $passwordHash === $passwordDB;
    }
}
