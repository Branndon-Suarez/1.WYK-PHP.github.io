<?php
namespace models;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;
use \PDO;

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
            error_log("Error en la función getRoles: " . $e->getMessage());
            return [];
        }
    }

    public function getCantUsuariosExistentes() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM USUARIO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantRolesExistentes: " . $e->getMessage());
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
            error_log("Error en la función getCantRolesActivos: " . $e->getMessage());
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
            error_log("Error en la función getCantRolesInactivos: " . $e->getMessage());
            return 0;
        }
    }

    public function checkIfUsuarioExists($numDocUsuario, $nomUsuario) {
        try {
            $sql = "SELECT COUNT(*) FROM USUARIO WHERE NUM_DOC = :num_doc_usuario OR NOMBRE = :name_usuario";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':num_doc_usuario', $numDocUsuario, \PDO::PARAM_INT);
            $stmt->bindParam(':name_usuario', $nomUsuario, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Error en checkIfUsuarioExists: " . $e->getMessage());
            return false;
        }
    }

    public function createUsuario($numDocUsuario, $nomUsuario, $passwordUsuario, $telUsuario, $emailUsuario, $fechRegUsuario, $rolUsuario) {
        try {
            $sql = "CALL INSERTAR_USUARIO(:num_doc_usuario, :nom_usuario, :password_usuario, :tel_email, :email_usuario, :fech_reg_usuario, :rol_usuario, :rol_estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':num_doc_usuario', $numDocUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':nom_usuario', $nomUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':password_usuario', $passwordUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':tel_email', $telUsuario, \PDO::PARAM_INT);
            $stmt->bindParam(':email_usuario', $emailUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':fech_reg_usuario', $fechRegUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':rol_usuario', $rolUsuario, \PDO::PARAM_STR);
            $stmt->bindValue(':rol_estado', 1, \PDO::PARAM_INT); // Estado activo por defecto
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createCargo: " . $e->getMessage());
            return null;
        }
    }

    public function getRolById($idRol) {
        try {
            $sql = "SELECT * FROM ROL WHERE ID_ROL = :id_rol";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_rol', $idRol, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getRolById: " . $e->getMessage());
            return null;
        }
    }

    public function updateRol($idRol, $rol, $rolCategoria, $rolEstado) {
        try {
            $sql = "CALL ACTUALIZAR_ROL(:id_rol, :rol, :rol_clasificacion, :rol_estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_rol', $idRol, \PDO::PARAM_INT);
            $stmt->bindParam(':rol', $rol, \PDO::PARAM_STR);
            $stmt->bindParam(':rol_clasificacion', $rolCategoria, \PDO::PARAM_STR);
            $stmt->bindValue(':rol_estado', $rolEstado, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateRol: " . $e->getMessage());
            return null;
        }
    }

    public function updateRolState($idRol, $estadoRol) {
        try {
            // La consulta SQL con marcadores de posición.
            $sql = "UPDATE ROL SET ESTADO_ROL = :estado WHERE ID_ROL = :id";
            $stmt = $this->db->prepare($sql);

            // Vincular los parámetros para evitar inyección SQL.
            $stmt->bindParam(':estado', $estadoRol, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $idRol, \PDO::PARAM_INT);
            
            $stmt->execute();

            // Verificar si se actualizó al menos una fila.
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            // Registrar el error en el log de XAMPP.
            error_log("Error al actualizar estado del rol: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUsuario($idRol) {
        try {
            $sql = "CALL ELIMINAR_USUARIO(:id_rol)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_rol', $idRol, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función deleteUsuario: " . $e->getMessage());
            return null;
        }
    }

    public function getFilteredRoles($searchText = null, $estado = null, $chipFilters = []) {
        $sql = "SELECT * FROM ROL WHERE 1=1";
        $params = [];

        // Filter by text search (ROL or CLASIFICACION)
        if (!empty($searchText)) {
            $sql .= " AND (ROL LIKE ? OR CLASIFICACION LIKE ?)";
            $params[] = '%' . $searchText . '%';
            $params[] = '%' . $searchText . '%';
        }

        // Filter by role status
        if ($estado === 'activo') {
            $sql .= " AND ESTADO_ROL = 1";
        } elseif ($estado === 'inactivo') {
            $sql .= " AND ESTADO_ROL = 0";
        }

        // Loop through the chip filters
        foreach ($chipFilters as $columna => $valores) {
            // Decodificar el nombre de la columna que viene de la URL
            $columnaDecodificada = urldecode($columna);

            // Validar la columna decodificada
            if (in_array($columnaDecodificada, ['ROL', 'CLASIFICACION'])) {
                $placeholders = implode(',', array_fill(0, count($valores), '?'));
                $sql .= " AND " . $columnaDecodificada . " IN (" . $placeholders . ")";
                foreach ($valores as $valor) {
                    // Decodifica los valores de la URL
                    $params[] = urldecode($valor);
                }
            }
        }

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            error_log("Error al obtener roles filtrados: " . $e->getMessage());
            return [];
        }
    }
}
