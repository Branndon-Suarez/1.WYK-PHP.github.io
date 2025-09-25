<?php

namespace models;

use \config\Connection;
use \PDO;

class ProductoModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public function getUsuarios() {
        try {
            $sql = "CALL CONSULTAR_PRODUCTO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getRoles: " . $e->getMessage());
            return [];
        }
    }

    public function listarProductos()
    {
        $sql = "SELECT 
                    ID_PRODUCTO, 
                    NOMBRE_PRODUCTO, 
                    VALOR_UNITARIO_PRODUCTO, 
                    CANT_EXIST_PRODUCTO, 
                    FECHA_VENCIMIENTO_PRODUCTO,
                    TIPO_PRODUCTO,
                    ESTADO_PRODUCTO
                FROM PRODUCTO";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener un producto por su ID
     */
    public function obtenerProductoPorId($id) {
        $sql = "SELECT 
                P.ID_PRODUCTO,
                P.NOMBRE_PRODUCTO,
                P.VALOR_UNITARIO_PRODUCTO,
                P.CANT_EXIST_PRODUCTO,
                P.FECHA_VENCIMIENTO_PRODUCTO,
                P.TIPO_PRODUCTO,
                P.ID_USUARIO_FK_PRODUCTO,
                U.NOMBRE AS USUARIO_REGISTRO,
                P.ESTADO_PRODUCTO
            FROM PRODUCTO P
            INNER JOIN USUARIO U ON P.ID_USUARIO_FK_PRODUCTO = U.ID_USUARIO
            WHERE P.ID_PRODUCTO = :id
            ORDER BY P.ID_PRODUCTO";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCantProdExistentes() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM PRODUCTO";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantProdExistentes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantProdActivos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM PRODUCTO WHERE ESTADO_PRODUCTO = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantRolesActivos: " . $e->getMessage());
            return 0;
        }
    }

    public function getCanProdInactivos()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM PRODUCTO WHERE ESTADO_PRODUCTO = 0";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCanProdInactivos: " . $e->getMessage());
            return 0;
        }
    }

    public function checkIfProdExists($idProd, $nombreProd)
    {
        try {
            $sql = "SELECT COUNT(*) FROM PRODUCTO WHERE ID_PRODUCTO = :id_prod OR NOMBRE_PRODUCTO = :nombre_prod";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_prod', $idProd, \PDO::PARAM_INT);
            $stmt->bindParam(':nombre_prod', $nombreProd, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            error_log("Error en checkIfProdExists: " . $e->getMessage());
            return false;
        }
    }

    public function createUsuario($idProd, $nombreProd, $valorUnitProd, $cantExistProd, $fechVencProd, $tipoProd)
    {
        try {
            $sql = "CALL INSERTAR_PRODUCTO(:id_prod, :nombre_prod, :valor_unit_prod, :cant_exist_prod, :fech_venc_prod, :tipo_prod, :usuario_FK, :prod_estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_prod', $idProd, \PDO::PARAM_INT);
            $stmt->bindParam(':nombre_prod', $nombreProd, \PDO::PARAM_STR);
            $stmt->bindParam(':valor_unit_prod', $valorUnitProd, \PDO::PARAM_INT);
            $stmt->bindParam(':cant_exist_prod', $cantExistProd, \PDO::PARAM_INT);
            $stmt->bindParam(':fech_venc_prod', $fechVencProd, \PDO::PARAM_STR);
            $stmt->bindParam(':tipo_prod', $tipoProd, \PDO::PARAM_STR);
            $stmt->bindParam(':usuario_FK', $_SESSION['userId'], \PDO::PARAM_INT);
            $stmt->bindValue(':prod_estado', 1, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función createUsuario: " . $e->getMessage());
            return null;
        }
    }

    public function updateProducto($idProd, $nombreProd, $valorUnitProd, $cantExistProd, $fechVencProd, $tipoProd, $estadoProd)
    {
        try {
            $sql = "CALL ACTUALIZAR_PRODUCTO(:id_prod, :nombre_prod, :valor_unit_prod, :cant_exist_prod, :fech_venc_prod, :tipo_prod, :usuario_fk, :prod_estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_prod', $idProd, \PDO::PARAM_INT);
            $stmt->bindParam(':nombre_prod', $nombreProd, \PDO::PARAM_STR);
            $stmt->bindParam(':valor_unit_prod', $valorUnitProd, \PDO::PARAM_INT);
            $stmt->bindParam(':cant_exist_prod', $cantExistProd, \PDO::PARAM_INT);
            $stmt->bindParam(':fech_venc_prod', $fechVencProd, \PDO::PARAM_STR);
            $stmt->bindParam(':tipo_prod', $tipoProd, \PDO::PARAM_STR);
            $stmt->bindParam(':usuario_fk', $_SESSION['userId'], \PDO::PARAM_INT);
            $stmt->bindValue(':prod_estado', $estadoProd, \PDO::PARAM_INT);
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

    public function deleteProd($idProd)
    {
        try {
            $sql = "CALL ELIMINAR_PRODUCTO(:id_rol)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_rol', $idProd, \PDO::PARAM_INT);
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
