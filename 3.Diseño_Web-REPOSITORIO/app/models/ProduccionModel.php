<?php

namespace models;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \config\Connection;
use \PDO;

class ProduccionModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public function getProducciones()
    {
        try {
            $sql = "CALL CONSULTAR_PRODUCCION";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en la función getProducciones: " . $e->getMessage());
            return [];
        }
    }

    public function getCantProduccionesExistentes()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM PRODUCCION";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantProduccionesExistentes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantProduccionesPendientes()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM PRODUCCION WHERE ESTADO_PRODUCCION = 'PENDIENTE'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantProduccionesPendientes: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantProduccionesProceso()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM PRODUCCION WHERE ESTADO_PRODUCCION = 'EN_PROCESO'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantProduccionesProceso: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantProduccionesFinalizadas()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM PRODUCCION WHERE ESTADO_PRODUCCION = 'FINALIZADA'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantProduccionesFinalizadas: " . $e->getMessage());
            return 0;
        }
    }

    public function getCantProduccionesCanceladas()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM PRODUCCION WHERE ESTADO_PRODUCCION = 'CANCELADA'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error en la función getCantProduccionesCanceladas: " . $e->getMessage());
            return 0;
        }
    }

    public function getDetalleProduccionById($idProduccion)
    {
        try {
            $sqlDetalle = "SELECT
                            mp.NOMBRE_MATERIA_PRIMA AS NOMBRE_ITEM,
                            dp.CANTIDAD_REQUERIDA AS CANTIDAD,
                            mp.UNIDAD_MEDIDA_MAT_PRIMA AS UNIDAD_MEDIDA,
                            'Materia Prima' as TIPO_ITEM
                       FROM DETALLE_PRODUCCION dp
                       JOIN MATERIA_PRIMA mp ON dp.ID_MATERIA_PRIMA = mp.ID_MATERIA_PRIMA
                       WHERE dp.ID_PRODUCCION = :idProduccion";

            $stmtDetalle = $this->db->prepare($sqlDetalle);
            $stmtDetalle->bindParam(':idProduccion', $idProduccion, \PDO::PARAM_INT);
            $stmtDetalle->execute();

            return $stmtDetalle->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en getDetalleProduccionById: " . $e->getMessage());
            return false;
        }
    }

    /* ----------------------------------- PARTE DE LA COMPRA ----------------------------------- */
    // --- Métodos de Listado para el Modal ---

    public function obtenerMateriaPrima()
    {
        $sql = "SELECT ID_MATERIA_PRIMA, NOMBRE_MAT_PRIMA, COSTO_UNITARIO_MAT_PRIMA, CANT_EXIST_MAT_PRIMA FROM MATERIA_PRIMA";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCompra($data)
    {
        try {
            $this->db->beginTransaction();

            // 1. Insertar en la tabla 'COMPRA'
            // 💡 CORRECCIÓN CRUCIAL: Se eliminó ID_PROVEEDOR_FK_COMPRA
            // y se agregaron NOMBRE_PROVEEDOR, MARCA, TEL_PROVEEDOR, EMAIL_PROVEEDOR.
            // Además, se corrigieron DESCRIPCION_COMPRA y ESTADO_FACTURA_COMPRA.
            $sqlCompra = "INSERT INTO COMPRA (
                            FECHA_HORA_COMPRA, TIPO, TOTAL_COMPRA, 
                            NOMBRE_PROVEEDOR, MARCA, TEL_PROVEEDOR, EMAIL_PROVEEDOR, 
                            DESCRIPCION_COMPRA, ID_USUARIO_FK_COMPRA, ESTADO_FACTURA_COMPRA
                        ) 
                        VALUES (
                            :fecha_hora, :tipo, :totalCompra, 
                            :nombre_proveedor, :marca, :tel_proveedor, :email_proveedor, 
                            :descripcion, :id_usuario, :estado_compra
                        )";

            $stmtCompra = $this->db->prepare($sqlCompra);

            $stmtCompra->bindValue(':fecha_hora', $data['fecha']);
            $stmtCompra->bindValue(':tipo', $data['tipo']);
            $stmtCompra->bindValue(':totalCompra', intval($data['totalCompra']));

            // 💡 NUEVOS BINDINGS para los datos del proveedor
            $stmtCompra->bindValue(':nombre_proveedor', $data['nombreProveedor']);
            $stmtCompra->bindValue(':marca', $data['marca']);
            $stmtCompra->bindValue(':tel_proveedor', $data['telProveedor']);
            $stmtCompra->bindValue(':email_proveedor', $data['emailProveedor']);

            // 💡 BINDINGS para las columnas corregidas y usuario
            $stmtCompra->bindValue(':descripcion', $data['descripcion']);
            $stmtCompra->bindValue(':id_usuario', $data['usuarioId']);
            $stmtCompra->bindValue(':estado_compra', $data['estadoCompra']);

            $stmtCompra->execute();

            $idCompra = $this->db->lastInsertId();

            if (!$idCompra) {
                throw new \Exception("Error al insertar la compra en la base de datos.");
            }

            // 2. Insertar los detalles (ESTA PARTE NO CAMBIA)
            $tipo = $data['tipo'];

            /*descometnar esto a futuro si necesito depurar un error y mostrarlo en xammp error_log(print_r($data['items'], true));
        die('<pre>' . print_r($data['items'], true) . '</pre>');  */

            if ($tipo === 'MATERIA PRIMA') {
                $stmtDetalle = $this->db->prepare("INSERT INTO DETALLE_COMPRA_MATERIA_PRIMA (
                CANTIDAD_MAT_PRIMA_COMPRADA,
                SUB_TOTAL_MAT_PRIMA_COMPRADA,
                ID_COMPRA_FK_DET_COMPRA_MAT_PRIMA,
                ID_MAT_PRIMA_FK_DET_COMPRA_MAT_PRIMA,
                ESTADO_DET_COMPRA_MAT_PRIMA)
                VALUES (:cantidad, :sub_total, :id_compra, :id_item, 1)");
            } else { // 'PRODUCTO TERMINADO'
                $stmtDetalle = $this->db->prepare("INSERT INTO DETALLE_COMPRA_PRODUCTO (
                CANTIDAD_PROD_COMPRADO,
                SUB_TOTAL_PROD_COMPRADO,
                ID_COMPRA_FK_DET_COMPRA_PROD,
                ID_PROD_FK_DET_COMPRA_PROD,
                ESTADO_DET_COMPRA_PROD)
                VALUES (:cantidad, :sub_total, :id_compra, :id_item, 1)");
            }

            foreach ($data['items'] as $item) {
                $cantidad = intval($item['cantidad']);
                $precio_unitario = intval($item['precio_unitario']);
                $subTotal = $cantidad * $precio_unitario;

                $stmtDetalle->bindValue(':cantidad', $cantidad);
                $stmtDetalle->bindValue(':sub_total', $subTotal);
                $stmtDetalle->bindValue(':id_compra', $idCompra);
                $stmtDetalle->bindValue(':id_item', $item['id']);
                $stmtDetalle->execute();
            }

            // 3. Confirmar la transacción
            $this->db->commit();

            return $idCompra;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    /* ----------------------------------- PARTE DE LA COMPRA ----------------------------------- */

    public function getCompraById($idCompra)
    {
        try {
            $sql = "SELECT
                        C.ID_COMPRA,
                        C.FECHA_HORA_COMPRA,
                        C.TIPO,
                        C.TOTAL_COMPRA,
                        C.NOMBRE_PROVEEDOR,
                        C.MARCA,
                        C.TEL_PROVEEDOR,
                        C.EMAIL_PROVEEDOR,
                        C.DESCRIPCION_COMPRA,
                        C.ID_USUARIO_FK_COMPRA,
                        U.NOMBRE AS USUARIO_REGISTRO,
                        C.ESTADO_FACTURA_COMPRA
                    FROM COMPRA C
                    INNER JOIN USUARIO U ON C.ID_USUARIO_FK_COMPRA = U.ID_USUARIO
                    WHERE C.ID_COMPRA = :idCompra
                    ORDER BY C.ID_COMPRA
                ";
            $stmt = $this->db->prepare($sql);
            // ... (resto del código es correcto)
            $stmt->bindParam(':idCompra', $idCompra, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Nota: También corregí el mensaje de error para que sea "getCompraById" en lugar de "getVentaById"
            error_log("Error en la función getCompraById: " . $e->getMessage());
            return null;
        }
    }

    public function updateVenta($idCompra, $fecha, $tipo, $total, $proveedor, $marca, $tel, $email, $descripcion, $estado)
    {
        try {
            $sql = "CALL ACTUALIZAR_COMPRA(:idCompra, :fecha, :tipo, :total, :proveedor, :marca, :tel, :email, :descripcion, :usuarioFK, :estado)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idCompra', $idCompra, \PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha, \PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, \PDO::PARAM_STR);
            $stmt->bindParam(':total', $total, \PDO::PARAM_INT);
            $stmt->bindParam(':proveedor', $proveedor, \PDO::PARAM_STR);
            $stmt->bindParam(':marca', $marca, \PDO::PARAM_STR);
            $stmt->bindParam(':tel', $tel, \PDO::PARAM_INT);
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, \PDO::PARAM_STR);
            $stmt->bindParam(':usuarioFK', $_SESSION['userId'], \PDO::PARAM_INT);
            $stmt->bindValue(':estado', $estado, \PDO::PARAM_STR);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en la función updateVenta: " . $e->getMessage());
            return null;
        }
    }

    public function getFilteredVentas($filtros = [])
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
