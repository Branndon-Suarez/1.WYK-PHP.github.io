<?php

namespace controllers;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\CompraModel;
use \models\MateriaPrimaModel;
use \models\ProductoModel;
use const \config\APP_URL;
use \Dompdf\Dompdf;
use \Dompdf\Options;

class ComprasController
{
    private $compraModel;
    private $materiaPrimaModel;
    private $productoModel;

    public function __construct()
    {
        $this->compraModel = new CompraModel();
        $this->materiaPrimaModel = new MateriaPrimaModel();
        $this->productoModel = new ProductoModel();
    }

    private function checkAdminAccess()
    {
        if (!isset($_SESSION['rolClasificacion']) || $_SESSION['rolClasificacion'] !== 'ADMINISTRADOR') {
            $_SESSION['error_message'] = 'Acceso denegado. No tienes permisos de administrador.';
            header('Location: ' . APP_URL . 'dashboard');
            exit();
        }
    }

    public function reports()
    {
        $this->checkAdminAccess();

        $dashboardDataCompras = [
            'comprasExistentes' => $this->compraModel->getCantComprasExistentes(),
            'comprasPendientes' => $this->compraModel->getCantComprasPendientes(),
            'comprasPagadas' => $this->compraModel->getCantComprasPagadas(),
            'comprasCanceladas' => $this->compraModel->getCantComprasCanceladas(),
            'compras' => $this->compraModel->getCompras()
        ];

        // Mensajes de sesión
        $success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        if (isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }
        // variable sidebar
        $active_page = 'tareas';

        require_once __DIR__ . '/../views/layouts/heads/headDashboard.php';
        require_once __DIR__ . '/../views/compra/dashboardCompra.php';
    }

    public function getDetalleCompraAjax()
    {
        $this->checkAdminAccess();

        // 1. Verificar si es una solicitud AJAX (GET)
        if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido o ID de compra faltante.']);
            exit();
        }

        header('Content-Type: application/json');

        $idCompra = $_GET['id'];

        try {
            // 2. Obtener el detalle de la compra
            $detalle = $this->compraModel->getDetalleCompraById($idCompra);

            if ($detalle !== false) {
                echo json_encode(['success' => true, 'detalle' => $detalle]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Detalle de compra no encontrado.']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
        exit();
    }

    /* ----------------------------------- PARTE DE LA COMPRA ----------------------------------- */

    /* ----------------------------------- LISTADO PARA AJAX ----------------------------------- */

    public function listarMateriaPrimaAjax()
    {
        header('Content-Type: application/json');
        try {
            // 💡 CAMBIO CRUCIAL: Devolvemos los datos directamente como vienen del modelo
            // (que deben tener las claves en MAYÚSCULAS)
            $data = $this->materiaPrimaModel->listarMateriasPrimas();

            // ❌ SE ELIMINA EL MAPEADO A CLAVES EN MINÚSCULAS ('id', 'nombre', etc.)
            // Ya que el JS está buscando las claves en mayúsculas (ID_MATERIA_PRIMA, etc.)

            echo json_encode($data);
            exit;
        } catch (\Exception $e) {
            // ... (manejo de error)
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al obtener Materia Prima: ' . $e->getMessage()]);
            exit;
        }
    }

    public function listarProductosAjax()
    {
        header('Content-Type: application/json');
        try {
            // 💡 CAMBIO CRUCIAL: Devolvemos los datos directamente como vienen del modelo
            // (que deben tener las claves en MAYÚSCULAS)
            $data = $this->productoModel->listarProductos();

            // ❌ SE ELIMINA EL MAPEADO A CLAVES EN MINÚSCULAS ('id', 'nombre', etc.)
            // Ya que el JS está buscando las claves en mayúsculas (ID_PRODUCTO, etc.)

            echo json_encode($data);
            exit;
        } catch (\Exception $e) {
            // ... (manejo de error)
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al obtener Productos: ' . $e->getMessage()]);
            exit;
        }
    }

    public function create()
    {
        // Si es GET, muestra la vista y termina
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../views/layouts/heads/headCreateCompra.php';
            require_once __DIR__ . '/../views/compra/create.php';
            return;
        }

        // --- Inicio de manejo de solicitud POST (AJAX) ---

        ob_start();
        header('Content-Type: application/json');

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data) {
                http_response_code(400);
                throw new \Exception("Datos de compra no válidos o vacíos.");
            }

            // 💡 PASO CRUCIAL 1: Validar si el usuario está logueado y obtener su ID.
            if (!isset($_SESSION['userId'])) {
                http_response_code(401); // 401 Unauthorized
                throw new \Exception("Usuario no autenticado. Inicie sesión para realizar la compra.");
            }

            // 💡 PASO CRUCIAL 2: Inyectar el ID de usuario de la sesión en los datos que se enviarán al modelo.
            $data['usuarioId'] = $_SESSION['userId'];

            // 3. Validar campos requeridos
            // Ajustamos la lista de campos requeridos para coincidir con tu modelo
            $requiredFields = [
                'fecha',
                'tipo',
                'estadoCompra',
                'totalCompra',
                'items',
                'nombreProveedor',
                'marca',
                'telProveedor',
                'emailProveedor',
                'descripcion' // Asumo que este campo también es necesario para el modelo
                // 'usuarioId' ya fue inyectado, pero la validación de su existencia es la de arriba.
            ];

            foreach ($requiredFields as $field) {
                if (!isset($data[$field])) {
                    http_response_code(400); // 400 Bad Request
                    throw new \Exception("Falta el campo obligatorio: " . $field);
                }
            }
            // FIN DE VALIDACIÓN

            // 4. Llamada al modelo (usa $data['usuarioId'])
            $idCompra = $this->compraModel->createCompra($data);

            // 5. Respuesta de éxito
            http_response_code(201); // 201 Created
            $response = [
                "success" => true,
                "message" => "Compra guardada con éxito.",
                "idCompra" => $idCompra
            ];
        } catch (\Exception $e) {
            // 6. Respuesta de error
            if (http_response_code() < 400) {
                http_response_code(500);
            }
            $response = [
                "success" => false,
                "message" => "Error al guardar la compra: " . $e->getMessage()
            ];
        } finally {
            // 7. Limpiamos cualquier salida previa y enviamos solo el JSON
            ob_clean();
            echo json_encode($response);
            exit();
        }
    }
    /* ----------------------------------- PARTE DE LA COMPRA ----------------------------------- */
    public function viewEdit($id)
    {
        $this->checkAdminOrMeseroOrCajeroAccess();

        $rol = $_SESSION['rol'] ?? '';
        $tareas = [];

        if ($rol === 'MESERO') {
            require_once __DIR__ . '/../controllers/TareasController.php';
            $tareaController = new TareasController();
            $tareas = $tareaController->getTareasParaVista();
        } elseif ($rol === 'CAJERO') {
            require_once __DIR__ . '/../controllers/TareasController.php';
            $tareaController = new TareasController();
            $tareas = $tareaController->getTareasParaVista();
        }

        $venta = $this->ventaModel->getVentaById($id);
        if ($venta) {
            require_once __DIR__ . '/../views/layouts/heads/headForm.php';
            require_once __DIR__ . '/../views/venta/update.php';
        } else {
            $_SESSION['error_message'] = 'Venta no encontrada.';
            header('Location: ' . \config\APP_URL . 'ventas');
            exit();
        }
    }

    public function update()
    {
        $this->checkAdminOrMeseroOrCajeroAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idVenta = $_POST['idVenta'];
            $fecha = $_POST['fecha'];
            $total = $_POST['total'];
            $numMesa = $_POST['numMesa'];
            $descripcion = $_POST['descripcion'];
            $estadoPedido = $_POST['estadoPedido'];
            $estadoVenta = $_POST['estadoVenta'];

            try {
                $result = $this->ventaModel->updateVenta($idVenta, $fecha, $total, $numMesa, $descripcion, $estadoPedido, $estadoVenta);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Venta actualizada exitosamente.']);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar la venta.']);
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
