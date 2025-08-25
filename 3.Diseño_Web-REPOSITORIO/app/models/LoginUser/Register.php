<?php
require_once "../../../config/Connection.php";

class Register extends Connection {
    public function findExistenceUser($getUserName) {
        try {
            $stmt = $this->db->prepare(
                "SELECT*FROM USUARIO WHERE NOMBRE_USUARIO = ':1_nameUser'"
            );
            $stmt->bindParam('1_nameUser', $getUserName);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            error_log("Error en la función findExistenceUser: " . $e->getMessage());
            return false;
        }
    }
}
