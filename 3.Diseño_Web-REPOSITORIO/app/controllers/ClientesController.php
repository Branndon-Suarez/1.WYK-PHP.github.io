<?php
namespace controllers;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\ClienteModel;
use const \config\APP_URL;
use \Dompdf\Dompdf;
use \Dompdf\Options;

class ClientesController {
    private $clienteModel;

    public function __construct() {
        $this->clienteModel = new ClienteModel();
    }

    public function reports() {
        $dashboardDataClientes = [
            'clientesExistentes' => $this->clienteModel->getCantClientesExist(),
            'clientesActivos' => $this->clienteModel->getCantClientesActivos(),
            'clientesInactivos' => $this->clienteModel->getCantClientesInactivos(),
            'clientes' => $this->clienteModel->getClientes()
        ];

        // Mensajes de sesión
        $success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        if (isset($_SESSION['success_message'])) { unset($_SESSION['success_message']); }
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        if (isset($_SESSION['error_message'])) { unset($_SESSION['error_message']); }

        require_once __DIR__ . '/../views/layouts/heads/headDashboard.php';
        require_once __DIR__ . '/../views/cliente/dashboardCliente.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numDocCliente = $_POST['Num_Doc_Cliente'];
            $tipoDocCliente = $_POST['Tipo_Doc_Cliente'];
            $nomCliente = $_POST['Nom_Cliente'];
            $telCliente = $_POST['Telefono_Cliente'];
            $emailCliente = $_POST['Email_Cliente'];
            $usuarioCliente = $_POST['Usuario_Cliente'];
            try {
                if ($this->clienteModel->checkIfClienteExists($numDocCliente)) {
                    echo json_encode(['success' => false, 'message' => 'El cliente ya existe.']);
                    return;
                }

                $result = $this->clienteModel->createCliente($numDocCliente, $tipoDocCliente, $nomCliente, $telCliente, $emailCliente, $usuarioCliente);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Cliente creado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al crear el cliente.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
            }
            exit();
        }
    }

    public function viewEdit($id) {
        $cliente = $this->clienteModel->getClienteById($id);
        if ($cliente) {
            require_once __DIR__ . '/../views/cliente/update.php';
        } else {
            $_SESSION['error_message'] = 'Cliente no encontrado.';
            header('Location: ' . \config\APP_URL . 'clientes');
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCliente = $_POST['Id_Cliente'];
            $numDocCliente = $_POST['Num_Doc_Cliente'];
            $tipoDocCliente = $_POST['Tipo_Doc_Cliente'];
            $nomCliente = $_POST['Nom_Cliente'];
            $telCliente = $_POST['Telefono_Cliente'];
            $emailCliente = $_POST['Email_Cliente'];
            $usuarioCliente = $_POST['Usuario_Cliente'];
            $estadoCliente = $_POST['Estado_Cliente'];
            try {
                $result = $this->clienteModel->updateCliente($idCliente, $numDocCliente, $tipoDocCliente, $nomCliente, $telCliente, $emailCliente, $usuarioCliente, $estadoCliente);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Cliente actualizado exitosamente.']);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el cliente.']);
                    exit();
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
                exit();
            }
        }
    }

    public function updateState() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido o tipo de contenido incorrecto.']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id']) && isset($data['estado'])) {
            $idCliente = $data['id'];
            $estadoCliente = $data['estado'];
            
            try {
                $result = $this->clienteModel->updateClienteState($idCliente, $estadoCliente);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Estado del cliente actualizado.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo actualizar el estado del cliente.']);
                }
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos.']);
        }
    }
    
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido o tipo de contenido incorrecto.']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id'])) {
            $idCliente = $data['id'];

            try {
                $result = $this->clienteModel->deleteCliente($idCliente);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Cliente eliminado con éxito.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo eliminar el cliente porque está conectado con otro(s) registros.']);
                }
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos.']);
        }
    }

    // ----------------- REPORTE EN PDF ----------------------------
    public function generateReportPDF() {
        $clientes = $this->clienteModel->getClientes();

        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Clientes</title>
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
        <div class="header"><h1>Reporte de Clientes - Panaderia Wyk</h1></div>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>N° Doc.</th>
                        <th>Tipo Doc.</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        if (!empty($clientes)) {
            foreach ($clientes as $cliente) {
                $estado = ($cliente['ESTADO_CLIENTE'] == 1) ? 'Activo' : 'Inactivo';
                $html .= '
                <tr>
                    <td>' . htmlspecialchars($cliente['NUM_DOCUMENTO_CLIENTE']) . '</td>
                    <td>' . htmlspecialchars($cliente['TIPO_DOCUMENTO_CLIENTE']) . '</td>
                    <td>' . htmlspecialchars($cliente['NOMBRE_CLIENTE']) . '</td>
                    <td>' . htmlspecialchars($cliente['TEL_CLIENTE']) . '</td>
                    <td>' . htmlspecialchars($cliente['EMAIL_CLIENTE']) . '</td>
                    <td>' . htmlspecialchars($cliente['NOMBRE_USUARIO']) . '</td>
                    <td>' . $estado . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="2">No se encontraron clientes</td></tr>';
        }

        $html .= '</tbody></table></div></body></html>';

        // 3. Configurar y generar el PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'landscape'); //portrait = vertical, landscape = horizontal
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
        $dompdf->stream("Reporte_Clientes.pdf", array("Attachment" => false));
    }
}
