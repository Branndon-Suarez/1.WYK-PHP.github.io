<?php

namespace controllers;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\VentaModel;
use const \config\APP_URL;
use \Dompdf\Dompdf;
use \Dompdf\Options;

class VentasController
{
    private $ventaModel;

    public function __construct()
    {
        $this->ventaModel = new VentaModel();
    }

    private function checkAdminAccess()
    {
        if (!isset($_SESSION['rolClasificacion']) || $_SESSION['rolClasificacion'] !== 'ADMINISTRADOR') {
            $_SESSION['error_message'] = 'Acceso denegado. Se requiere el rol de Administrador.';
            header('Location: ' . APP_URL . 'dashboard');
            exit();
        }
    }

    private function checkAdminOrMeseroAccess()
    {
        $rol = $_SESSION['rol'] ?? '';
        $rolClasificacion = $_SESSION['rolClasificacion'] ?? '';

        if ($rolClasificacion === 'ADMINISTRADOR' || $rol === 'MESERO') {
            return;
        }
        $_SESSION['error_message'] = 'Acceso denegado. Se requiere el rol de Administrador o Mesero.';
        header('Location: ' . APP_URL . 'dashboard');
        exit();
    }

    public function reports()
    {
        $rol = $_SESSION['rol'] ?? '';
        $rolClasificacion = $_SESSION['rolClasificacion'] ?? '';
        $idUserMesero = $_SESSION['userId'] ?? null;
        $ventas = [];
        $tareas = [];

        if ($rolClasificacion === 'ADMINISTRADOR') {
            $ventas = $this->ventaModel->getVentasAdmin();
        } elseif ($rol === 'MESERO' && $idUserMesero) {
            require_once __DIR__ . '/../controllers/TareasController.php';
            $tareaController = new TareasController();
            $tareas = $tareaController->getTareasParaVista();
            $ventas = $this->ventaModel->getVentasMesero($idUserMesero);
        }

        $dashboardDataVentas = [
            'ventasExistentes' => $this->ventaModel->getCantVentasExistentes(),
            'pedidosPendientes' => $this->ventaModel->getCantPedidosPendientes(),
            'pedidosPagados' => $this->ventaModel->getCantPedidosPreparandose(),
            'ventasCanceladas' => $this->ventaModel->getCantPedidosEntregados(),
            'ventasCanceladas' => $this->ventaModel->getCantPedidosCancelados(),

            'ventasCanceladas' => $this->ventaModel->getCantVentasPendientes(),
            'ventasCanceladas' => $this->ventaModel->getCantVentasPagadas(),
            'ventasCanceladas' => $this->ventaModel->getCantVentasCanceladas(),
            'ventas' => $ventas,
            'tareas' => $tareas
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
        require_once __DIR__ . '/../views/venta/dashboardVenta.php';
    }

    public function getDetalleVentaAjax()
    {
        // 1. Verificar si es una solicitud AJAX (GET)
        if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido o ID de venta faltante.']);
            exit();
        }

        header('Content-Type: application/json');

        $idVenta = $_GET['id'];

        try {
            // 2. Obtener el detalle de la venta
            $detalle = $this->ventaModel->getDetalleVentaById($idVenta);

            if ($detalle !== false) {
                echo json_encode(['success' => true, 'detalle' => $detalle]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Detalle de venta no encontrado.']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
        exit();
    }


    public function viewEdit($id) {
        $this->checkAdminOrMeseroAccess();

        $rol = $_SESSION['rol'] ?? '';
        $tareas = [];

        if ($rol === 'MESERO') {
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
        $this->checkAdminOrMeseroAccess();

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
    public function generateReportPDF() {
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
