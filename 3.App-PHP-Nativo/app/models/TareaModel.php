<?php

namespace models;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;
use \PDO;

class TareaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public function getTareas()
    {
        try {
            $sql = "CALL CONSULTAR_TAREA";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getTareas: " . $e->getMessage());
            return [];
        }
    }
    public function getTareasByUsuario($id_usuario)
    {
        try {
            $sql = "SELECT ID_TAREA, TAREA, DESCRIPCION, TIEMPO_ESTIMADO_HORAS, ESTADO_TAREA, USUARIO_CREADOR_FK FROM TAREA WHERE USUARIO_ASIGNADO_FK = :id_usuario ORDER BY ID_TAREA";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Asegurarse de que siempre se retorne un array
            return is_array($result) ? $result : [];
        } catch (\PDOException $e) {
            // Manejar o registrar el error
            error_log("Error en la función getTareasByUsuario: " . $e->getMessage());
            return [];
        }
    }

    /* ---------------------------------------- LISTADO TAREAS A EMPLEADOS ---------------------------------------- */
    public function completarTarea($id_tarea)
    {
        try {
            $sql = "UPDATE TAREA SET ESTADO_TAREA = 'COMPLETADA' WHERE ID_TAREA = :id_tarea";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function revertirTarea($id_tarea)
    {
        try {
            $sql = "UPDATE TAREA SET ESTADO_TAREA = 'PENDIENTE' WHERE ID_TAREA = :id_tarea";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
    /* ---------------------------------------- LISTADO TAREAS A EMPLEADOS ---------------------------------------- */

    public function getCantTareasExistentes()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM TAREA";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantTareasExistentes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantTareasPendientes()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM TAREA WHERE ESTADO_TAREA = 'PENDIENTE'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantTareasPendientes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantTareasCompletadas()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM TAREA WHERE ESTADO_TAREA = 'COMPLETADA'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantTareasCompletadas: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantTareasCanceladas()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM TAREA WHERE ESTADO_TAREA = 'CANCELADA'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantTareasCanceladas: " . $e->getMessage());
            return 0;
        }
    }

    public function checkIfTareaExists($tarea)
    {
        try {
            $sql = "SELECT COUNT(*) FROM TAREA WHERE TAREA = :tarea";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':tarea', $tarea, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Error en checkIfProdExists: " . $e->getMessage());
            return false;
        }
    }

    public function createTarea($tarea, $categoria, $descripcion, $tiempo, $prioridad, $user_asignado, $estado)
    {
        try {
            $sql = "CALL INSERTAR_TAREA(:tarea, :categoria, :descripcion, :tiempo, :prioridad, :user_asignado, :usuario_creador, :estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':tarea', $tarea, \PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $categoria, \PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, \PDO::PARAM_STR);
            $stmt->bindParam(':tiempo', $tiempo, \PDO::PARAM_INT);
            $stmt->bindParam(':prioridad', $prioridad, \PDO::PARAM_STR);
            $stmt->bindParam(':user_asignado', $user_asignado, \PDO::PARAM_INT);
            $stmt->bindParam(':usuario_creador', $_SESSION['userId'], \PDO::PARAM_INT);
            $stmt->bindValue(':estado', $estado, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createUsuario: " . $e->getMessage());
            return null;
        }
    }

    public function getTareaById($idTarea)
    {
        try {
            $sql = "SELECT
                    T.ID_TAREA,
                    T.TAREA,
                    T.CATEGORIA,
                    T.DESCRIPCION,
                    T.TIEMPO_ESTIMADO_HORAS,
                    T.PRIORIDAD,
                    T.ESTADO_TAREA,
                    T.USUARIO_ASIGNADO_FK,
                    UA.NOMBRE AS USUARIO_ASIGNADO,
                    T.USUARIO_CREADOR_FK,
                    UC.NOMBRE AS USUARIO_CREADOR
                FROM TAREA T
                INNER JOIN USUARIO UA ON T.USUARIO_ASIGNADO_FK = UA.ID_USUARIO
                INNER JOIN USUARIO UC ON T.USUARIO_CREADOR_FK = UC.ID_USUARIO
                WHERE T.ID_TAREA = :id_tarea
                ORDER BY T.ID_TAREA";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_tarea', $idTarea, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getUsuarioById: " . $e->getMessage());
            return null;
        }
    }

    public function updateProducto($idTarea, $tarea, $categoria, $descripcion, $tiempo, $prioridad, $estado, $user_asignado)
    {
        try {
            $sql = "CALL ACTUALIZAR_TAREA(:idTarea, :tarea, :categoria, :descripcion, :tiempo, :prioridad, :estado, :user_asignado, :usuario_creador)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idTarea', $idTarea, \PDO::PARAM_INT);
            $stmt->bindParam(':tarea', $tarea, \PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $categoria, \PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, \PDO::PARAM_STR);
            $stmt->bindParam(':tiempo', $tiempo, \PDO::PARAM_INT);
            $stmt->bindParam(':prioridad', $prioridad, \PDO::PARAM_STR);
            $stmt->bindValue(':estado', $estado, \PDO::PARAM_STR);
            $stmt->bindValue(':user_asignado', $user_asignado, \PDO::PARAM_INT);
            $stmt->bindParam(':usuario_creador', $_SESSION['userId'], \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateUsuario: " . $e->getMessage());
            return null;
        }
    }

    public function updateProdState($idProd, $estadoProd)
    {
        try {
            // La consulta SQL con marcadores de posición.
            $sql = "UPDATE PRODUCTO SET ESTADO_PRODUCTO = :estado WHERE ID_PRODUCTO = :id";
            $stmt = $this->db->prepare($sql);

            // Vincular los parámetros para evitar inyección SQL.
            $stmt->bindParam(':estado', $estadoProd, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $idProd, \PDO::PARAM_INT);

            $stmt->execute();

            // Verificar si se actualizó al menos una fila.
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            // Registrar el error en el log de XAMPP.
            error_log("Error al actualizar estado del rol: " . $e->getMessage());
            return false;
        }
    }

    public function deleteTarea($idTarea)
    {
        try {
            $sql = "CALL ELIMINAR_TAREA(:id_tarea)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_tarea', $idTarea, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función deleteProd: " . $e->getMessage());
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
