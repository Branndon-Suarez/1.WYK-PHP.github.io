<?php

namespace models;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;
use \PDO;

class UsuarioModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public function getUsuarios()
    {
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

    public function getCantUsuariosExistentes()
    {
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

    public function getCantUsuariosActivos()
    {
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

    public function getCantUsuariosInactivos()
    {
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

    public function checkIfUsuarioExists($numDocUsuario, $nomUsuario)
    {
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

    public function createUsuario($numDocUsuario, $nomUsuario, $passwordUsuario, $telUsuario, $emailUsuario, $fechRegUsuario, $rolUsuario)
    {
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
            error_log("Error en la función createUsuario: " . $e->getMessage());
            return null;
        }
    }

    public function getUsuarioById($idUsuario)
    {
        try {
            $sql = "SELECT 
                    U.ID_USUARIO,
                    U.NUM_DOC,
                    U.NOMBRE,
                    U.PASSWORD_USUARIO,
                    U.TEL_USUARIO,
                    U.EMAIL_USUARIO,
                    U.FECHA_REGISTRO,
                    U.ROL_FK_USUARIO,
                    R.ROL AS NOMBRE_ROL,
                    U.ESTADO_USUARIO
                FROM USUARIO U
                INNER JOIN ROL R ON U.ROL_FK_USUARIO = R.ID_ROL
                WHERE U.ID_USUARIO = :id_usuario
                ORDER BY U.ID_USUARIO;
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_usuario', $idUsuario, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getUsuarioById: " . $e->getMessage());
            return null;
        }
    }

    public function updateUsuario($idUsuario, $numDocUsuario, $nomUsuario, $passwordUsuario, $telUsuario, $emailUsuario, $fechRegUsuario, $rolUsuario, $usuarioEstado)
    {
        try {
            $sql = "CALL ACTUALIZAR_USUARIO(:id_usuario, :num_doc_usuario, :nom_usuario, :password_usuario, :tel_usuario, :email_usuario, :fech_reg_usuario, :rol_usuario, :usuario_estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_usuario', $idUsuario, \PDO::PARAM_INT);
            $stmt->bindParam(':num_doc_usuario', $numDocUsuario, \PDO::PARAM_INT);
            $stmt->bindParam(':nom_usuario', $nomUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':password_usuario', $passwordUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':tel_usuario', $telUsuario, \PDO::PARAM_INT);
            $stmt->bindParam(':email_usuario', $emailUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':fech_reg_usuario', $fechRegUsuario, \PDO::PARAM_STR);
            $stmt->bindParam(':rol_usuario', $rolUsuario, \PDO::PARAM_STR);
            $stmt->bindValue(':usuario_estado', $usuarioEstado, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateUsuario: " . $e->getMessage());
            return null;
        }
    }

    public function updateUsuariosState($idUsuario, $estadoUsuario)
    {
        try {
            // La consulta SQL con marcadores de posición.
            $sql = "UPDATE USUARIO SET ESTADO_USUARIO = :estado WHERE ID_USUARIO = :id";
            $stmt = $this->db->prepare($sql);

            // Vincular los parámetros para evitar inyección SQL.
            $stmt->bindParam(':estado', $estadoUsuario, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $idUsuario, \PDO::PARAM_INT);

            $stmt->execute();

            // Verificar si se actualizó al menos una fila.
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            // Registrar el error en el log de XAMPP.
            error_log("Error al actualizar estado del rol: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUsuario($idRol)
    {
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

public function getFilteredUsuarios($filtros = [])
{
    $sql = "SELECT U.*, R.ROL AS NOMBRE_ROL FROM USUARIO U JOIN ROL R ON U.ROL_FK_USUARIO = R.ID_ROL";
    $whereClauses = [];
    $params = [];

    // Filtro de búsqueda de texto global
    if (!empty($filtros['search'])) {
        $searchText = '%' . $filtros['search'] . '%';
        $whereClauses[] = "(U.NUM_DOC LIKE ? OR U.NOMBRE LIKE ? OR U.TEL_USUARIO LIKE ? OR U.EMAIL_USUARIO LIKE ? OR R.ROL LIKE ?)";
        $params[] = $searchText;
        $params[] = $searchText;
        $params[] = $searchText;
        $params[] = $searchText;
        $params[] = $searchText;
    }

    // Filtro de estado
    if (isset($filtros['estado'])) {
        if ($filtros['estado'] === 'activo') {
            $whereClauses[] = "U.ESTADO_USUARIO = 1";
        } elseif ($filtros['estado'] === 'inactivo') {
            $whereClauses[] = "U.ESTADO_USUARIO = 0";
        }
    }

    // Filtros por chips y rangos
    foreach ($filtros as $key => $value) {
        if (strpos($key, 'filtro_') === 0) {
            $columna = str_replace('filtro_', '', $key);
            $valores = explode(',', $value);
            
            $columnaDB = "";
            switch (strtoupper($columna)) {
                case 'DOCUMENTO':
                    $columnaDB = 'U.NUM_DOC';
                    break;
                case 'NOMBRE':
                    $columnaDB = 'U.NOMBRE';
                    break;
                case 'TELEFONO':
                    $columnaDB = 'U.TEL_USUARIO';
                    break;
                case 'CORREO':
                case 'EMAIL': // Añadido para manejar el caso que enviaste en la URL
                    $columnaDB = 'U.EMAIL_USUARIO';
                    break;
                case 'ROL':
                    $columnaDB = 'R.ROL';
                    break;
                case 'FECHA_REGISTRO':
                    $columnaDB = 'U.FECHA_REGISTRO';
                    break;
            }

            if (!empty($columnaDB) && !empty($valores)) {
                $placeholders = implode(',', array_fill(0, count($valores), '?'));
                $whereClauses[] = $columnaDB . " IN (" . $placeholders . ")";
                foreach ($valores as $val) {
                    $params[] = $val;
                }
            }
        }
    }

    // Filtro de rango de fechas
    if (isset($filtros['fecha_inicio']) && isset($filtros['fecha_fin'])) {
        try {
            $fechaInicio = new \DateTime($filtros['fecha_inicio']);
            $fechaFin = new \DateTime($filtros['fecha_fin']);

            if (isset($filtros['diaCompleto']) && $filtros['diaCompleto'] === 'true') {
                $fechaFin->setTime(23, 59, 59);
            }

            $whereClauses[] = "U.FECHA_REGISTRO BETWEEN ? AND ?";
            $params[] = $fechaInicio->format('Y-m-d H:i:s');
            $params[] = $fechaFin->format('Y-m-d H:i:s');

        } catch (\Exception $e) {
            error_log("Error al procesar fechas de filtro: " . $e->getMessage());
        }
    }

    // Construye la cláusula WHERE si hay filtros
    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Error al obtener usuarios filtrados: " . $e->getMessage());
        return [];
    }
}
}
