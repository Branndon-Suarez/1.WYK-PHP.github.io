<?php
namespace models;

use PDO;
use PDOException;
use Exception;
use config\Connection;

class UserClientModel {
    private $db;
    private $idEmpleadoSistema;

    public function __construct() {
        $this->db = Connection::getConnection();
        // Asume que el ID de 'sistema' es 1.
        $this->idEmpleadoSistema = 1;
    }

    public function findExistenceClient($documento) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM CLIENTE WHERE NUM_DOCUMENTO_CLIENTE = :documento");
            $stmt->bindParam(':documento', $documento, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error en la función findExistenceClient: " . $e->getMessage());
            return false;
        }
    }

    public function createUserAndClient($userData, $clientData) {
        try {
            $this->db->beginTransaction();

            // Insertar en la tabla USUARIO
            $sqlUser = "INSERT INTO USUARIO
                        (NOMBRE_USUARIO, PASSWORD_USUARIO, FECHA_REGISTRO, FECHA_ULTIMA_SESION, ROL, ESTADO_USUARIO)
                        VALUES (:nombre, :password, NOW(), NOW(), 'CLIENTE', 1)";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->bindParam(':nombre', $userData['nombre_usuario'], PDO::PARAM_STR);
            $stmtUser->bindParam(':password', $userData['password'], PDO::PARAM_STR);
            $stmtUser->execute();

            $userId = $this->db->lastInsertId();

            // Insertar en la tabla CLIENTE
            $sqlClient = "INSERT INTO CLIENTE
                          (NUM_DOCUMENTO_CLIENTE, TIPO_DOCUMENTO_CLIENTE, NOMBRE_CLIENTE, TEL_CLIENTE, EMAIL_CLIENTE, ID_EMPLEADO_FK_CLIENTE, ID_USUARIO_FK_CLIENTE, ESTADO_CLIENTE)
                          VALUES (:documento, :tipo_doc, :nombre, :telefono, :email, :id_empleado_sistema, :id_usuario, 1)";
            $stmtClient = $this->db->prepare($sqlClient);
            $stmtClient->bindParam(':documento', $clientData['documento'], PDO::PARAM_INT);
            $stmtClient->bindParam(':tipo_doc', $clientData['tipo_documento'], PDO::PARAM_STR);
            $stmtClient->bindParam(':nombre', $clientData['nombre_completo'], PDO::PARAM_STR);
            $stmtClient->bindParam(':telefono', $clientData['telefono'], PDO::PARAM_INT);
            $stmtClient->bindParam(':email', $clientData['email'], PDO::PARAM_STR);
            $stmtClient->bindParam(':id_empleado_sistema', $this->idEmpleadoSistema, PDO::PARAM_INT);
            $stmtClient->bindParam(':id_usuario', $userId, PDO::PARAM_INT);
            $stmtClient->execute();

            $this->db->commit();
            return true;

        } catch (\PDOException $e) {
            $this->db->rollBack();
            // Lanza una excepción genérica que el controlador capturará.
            throw new \Exception("Error en el registro: " . $e->getMessage());
        }
    }
}
