<?php
namespace app\models\LoginUser;

use config\Connection;
use PDO;
use Exception;

class UserClientModel extends Connection {

    private $idEmpleadoSistema = 1;

    public function createUserAndClient($userData, $clientData) {
        try {
            $this->db->beginTransaction();

            // Insert usuario
            $sqlUser = "INSERT INTO USUARIO
                        (NOMBRE_USUARIO, PASSWORD_USUARIO, FECHA_REGISTRO, FECHA_ULTIMA_SESION, ROL, ESTADO_USUARIO)
                        VALUES (:nombre, :password, NOW(), NOW(), 'CLIENTE', 1)";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->bindParam(':nombre', $userData['nombre_usuario'], PDO::PARAM_STR);
            $stmtUser->bindParam(':password', $userData['password'], PDO::PARAM_STR);
            $stmtUser->execute();

            $userId = $this->db->lastInsertId();

            // Insert cliente
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

            /*Error 23000 de MySQL que indica un violation de constraint (restricción de integridad), como un UNIQUE, PRIMARY KEY o FOREIGN KEY.
            Útil en este caso para corroborar si el usuario o cliente ya existe en la base de datos debido a que los campos NOMBRE_USUARIO y NUM_DOCUMENTO_CLIENTE son UNIQUE.
            */
            if ($e->getCode() == 23000) {
                if (strpos($e->getMessage(), 'USUARIO') !== false) {
                    throw new \Exception("El nombre de usuario ya está registrado.");
                } elseif (strpos($e->getMessage(), 'CLIENTE') !== false) {
                    throw new \Exception("El  N° documento ya está registrado.");
                } else {
                    throw new \Exception("Datos duplicados detectados.");
                }
            }

            throw new \Exception("Error en el registro: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw new \Exception("Error en el registro: " . $e->getMessage());
        }
    }
}
