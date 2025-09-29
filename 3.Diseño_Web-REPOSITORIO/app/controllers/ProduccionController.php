<?php

namespace controllers;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\ProduccionModel;
use \models\ProductoModel;
use const \config\APP_URL;
use \Dompdf\Dompdf;
use \Dompdf\Options;
use \PDO;

class ProduccionController
{
    private $produccionModel;
    private $productoModel;

    // Necesitas un modelo que maneje la Materia Prima para listar en el modal/select
    private $materiaPrimaModel;

    public function __construct()
    {
        $this->produccionModel = new ProduccionModel();
        $this->productoModel = new ProductoModel();
        // Usamos ProduccionModel para listar MP, ya que lo incluimos allí por simplicidad.
        // Si tienes un MateriaPrimaModel, deberías usarlo.
        // En este caso, lo incluiremos en ProduccionModel.
        $this->materiaPrimaModel = $this->produccionModel; // Reutilizamos para no crear una instancia nueva si no es necesario.
    }

    private function checkAdminAccess()
    {
        if (!isset($_SESSION['rolClasificacion']) || $_SESSION['rolClasificacion'] !== 'ADMINISTRADOR') {
            $_SESSION['error_message'] = 'Acceso denegado. No tienes permisos de administrador.';
            header('Location: ' . APP_URL . 'dashboard');
            exit();
        }
    }

    // Las funciones reports() y getDetalleProduccionAjax() se mantienen igual.
    public function reports()
    {
        $this->checkAdminAccess();

        $dashboardDataProduccion = [
            'produccionesExistentes' => $this->produccionModel->getCantProduccionesExistentes(),
            'produccionesPendientes' => $this->produccionModel->getCantProduccionesPendientes(),
            'produccionesProceso' => $this->produccionModel->getCantProduccionesProceso(),
            'produccionesFinalizadas' => $this->produccionModel->getCantProduccionesFinalizadas(),
            'produccionesCanceladas' => $this->produccionModel->getCantProduccionesCanceladas(),
            'producciones' => $this->produccionModel->getProducciones()
        ];

        $success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        if (isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }
        $active_page = 'tareas';

        require_once __DIR__ . '/../views/layouts/heads/headDashboard.php';
        require_once __DIR__ . '/../views/produccion/dashboardProduccion.php';
    }

    public function getDetalleProduccionAjax()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido o ID de producción faltante.']);
            exit();
        }

        header('Content-Type: application/json');

        $idProduccion = $_GET['id'];

        try {
            $detalle = $this->produccionModel->getDetalleProduccionById($idProduccion);

            if ($detalle !== false) {
                echo json_encode(['success' => true, 'detalle' => $detalle]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Detalle de producción no encontrado (Error en la consulta).']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
        exit();
    }

    /* ----------------------------------- LISTADO PARA AJAX (Vuelve a ser necesario) ----------------------------------- */

    public function listarProductosAjax()
    {
        // Verifica permisos si es necesario
        header('Content-Type: application/json');
        try {
            // Asumiendo que productoModel->listarProductos() existe y funciona.
            $productos = $this->productoModel->listarProductos(); 

            echo json_encode(['success' => true, 'productos' => $productos]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al obtener Productos: ' . $e->getMessage()]);
            exit;
        }
    }

    /**
     * Endpoint para listar MATERIA PRIMA (usado en el modal de selección de MP).
     */
    public function listarMateriaPrimaAjax()
    {
        header('Content-Type: application/json');
        try {
            // Llama al método correcto del modelo
            $data = $this->produccionModel->listarMateriasPrimasActivas();

            echo json_encode($data);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al obtener Materia Prima: ' . $e->getMessage()]);
            exit;
        }
    }

    /* ----------------------------------- CREAR PRODUCCIÓN ----------------------------------- */

    public function create()
    {
        // 1. Lógica para GET (Mostrar la vista)
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $productos = $this->productoModel->listarProductos();

            require_once __DIR__ . '/../views/layouts/heads/headCreateProduccion.php';
            require_once __DIR__ . '/../views/produccion/create.php';
            return;
        }

        // 2. Lógica para POST (Manejo de solicitud AJAX de creación)
        ob_start();
        header('Content-Type: application/json');

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data) {
                http_response_code(400);
                throw new \Exception("Datos de producción no válidos o vacíos.");
            }

            // 2.1. Validar usuario y obtener ID (Asegúrate que la variable de sesión sea 'userId')
            if (!isset($_SESSION['userId'])) {
                http_response_code(401);
                throw new \Exception("Usuario no autenticado. Inicie sesión para registrar la producción.");
            }
            $data['usuarioId'] = $_SESSION['userId'];
            
            // Si la descripción no viene, la inicializamos vacía para que la DB no falle si es NOT NULL.
            $data['descripcion'] = $data['descripcion'] ?? ''; 

            // 2.2. Validar campos requeridos
            $requiredFields = ['idProducto', 'cantidadProducida', 'detalles'];

            foreach ($requiredFields as $field) {
                if (!isset($data[$field])) {
                    http_response_code(400);
                    throw new \Exception("Falta el campo obligatorio de Producción: " . $field);
                }
            }

            if (!is_array($data['detalles']) || empty($data['detalles'])) {
                http_response_code(400);
                throw new \Exception("Debe especificar al menos una Materia Prima utilizada.");
            }

            // 2.3. Llamada al modelo de Producción (La transacción está dentro del modelo)
            $idProduccion = $this->produccionModel->createProduccion($data);

            // 2.4. Respuesta de éxito
            http_response_code(201);
            $response = [
                "success" => true,
                "message" => "Producción registrada con éxito. Stock actualizado.",
                "idProduccion" => $idProduccion
            ];
        } catch (\Exception $e) {
            // 2.5. Respuesta de error
            $statusCode = http_response_code();
            if ($statusCode < 400) {
                 $statusCode = 500;
                 http_response_code($statusCode);
            }
            $response = [
                "success" => false,
                "message" => "Error al guardar la producción: " . $e->getMessage()
            ];
        } finally {
            ob_clean(); // Limpiar cualquier salida inesperada antes de enviar el JSON
            echo json_encode($response);
            exit();
        }
    }
    /* ----------------------------------- CREAR PRODUCCIÓN ----------------------------------- */

    public function viewEdit($id)
    {
        $this->checkAdminAccess();

        $compra = $this->compraModel->getCompraById($id);
        if ($compra) {
            require_once __DIR__ . '/../views/layouts/heads/headForm.php';
            require_once __DIR__ . '/../views/compra/update.php';
        } else {
            $_SESSION['error_message'] = 'Compra no encontrada.';
            header('Location: ' . \config\APP_URL . 'compras');
            exit();
        }
    }

    public function update()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCompra = $_POST['idCompra'];
            $fecha = $_POST['fecha'];
            $tipo = $_POST['tipo'];
            $total = $_POST['total'];
            $proveedor = $_POST['proveedor'];
            $marca = $_POST['marca'];
            $tel = $_POST['tel'];
            $email = $_POST['email'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];

            try {
                $result = $this->compraModel->updateVenta($idCompra, $fecha, $tipo, $total, $proveedor, $marca, $tel, $email, $descripcion, $estado);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Compra actualizada exitosamente.']);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar la compra.']);
                    exit();
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
                exit();
            }
        }
    }

    // ----------------- REPORTE EN PDF ----------------------------
    public function generateReportPDF()
    {
        $this->checkAdminOrMeseroAccess();

        $searchText = $_GET['search'] ?? null;
        $estadoFilter = $_GET['estado'] ?? null;

        // Get the new chip filters from the URL
        $chipFilters = [];
        foreach ($_GET as $key => $value) {
            if (strpos($key, 'filtro_') === 0) {
                $columna = str_replace('filtro_', '', $key);
                $chipFilters[strtoupper($columna)] = explode(',', $value);
            }
        }

        $roles = $this->ventaModel->getFilteredRoles($searchText, $estadoFilter, $chipFilters);

        // 3. Construir el HTML
        // ... (el resto de tu código HTML permanece igual) ...
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Roles</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
                .header { width: 100%; text-align: center; position: fixed; top: 0px; background-color: #f0f0f0; padding: 10px 0; }
                .footer { width: 100%; text-align: center; position: fixed; bottom: 0px; font-size: 10px; color: #555; }
                .content { margin-top: 60px; margin-bottom: 30px; padding: 20px; }
                h1 { font-size: 20px; color: #333; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; word-wrap: break-word; }
                th { background-color: #45341fd8; color: white; }
            </style>
        </head>
        <body>
        <div class="header"><h1>Reporte de Roles - Panaderia Wyk</h1></div>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>clasificación</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        if (!empty($roles)) {
            foreach ($roles as $rol) {
                $estado = ($rol['ESTADO_ROL'] == 1) ? 'Activo' : 'Inactivo';
                $html .= '
                <tr>
                    <td>' . htmlspecialchars($rol['ROL']) . '</td>
                    <td>' . htmlspecialchars($rol['CLASIFICACION']) . '</td>
                    <td>' . $estado . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="3" style="text-align:center;">No se encontraron roles con los filtros aplicados.</td></tr>';
        }

        $html .= '</tbody></table></div></body></html>';

        // 4. Configurar y generar el PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        // Manejo de la paginación
        $dompdf->getCanvas()->page_script('
            $font = $fontMetrics->getFont("Arial", "normal");
            $size = 10;
            $page_text = "Página " . $PAGE_NUM . " de " . $PAGE_COUNT;
            $y = $pdf->get_height() - 25;
            $x = $pdf->get_width() - 150;
            $pdf->text($x, $y, $page_text, $font, $size);
        ');

        // Envía el PDF al navegador
        $dompdf->stream("Reporte_Roles.pdf", array("Attachment" => false));
    }
}
