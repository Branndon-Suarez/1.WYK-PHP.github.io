<?php
namespace controllers;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\EmpleadoModel;
use const \config\APP_URL;
use \Dompdf\Dompdf;
use \Dompdf\Options;

class EmpleadosController {
    private $empleadoModel;

    public function __construct() {
        $this->empleadoModel = new EmpleadoModel();
    }

    public function reports() {
        $dashboardDataEmpleados = [
            'empleadosExistentes' => $this->empleadoModel->getCantEmpleadosExist(),
            'empleadosActivos' => $this->empleadoModel->getCantEmpleadosActivos(),
            'empleadosInactivos' => $this->empleadoModel->getCantEmpleadosInactivos(),
            'empleados' => $this->empleadoModel->getEmpleados()
        ];

        // Mensajes de sesión
        $success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        if (isset($_SESSION['success_message'])) { unset($_SESSION['success_message']); }
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        if (isset($_SESSION['error_message'])) { unset($_SESSION['error_message']); }

        require_once __DIR__ . '/../views/layouts/heads/headDashboard.php';
        require_once __DIR__ . '/../views/empleado/dashboardEmpleado.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedulaEmpleado = $_POST['Cedula_Empleado'];
            $nombreEmpleado = $_POST['Nom_Empleado'];
            $rhEmpleado = $_POST['RH_Empleado'];
            $telEmpleado = $_POST['Telefono_Empleado'];
            $emailEmpleado = $_POST['Email_Empleado'];
            $cargoEmpleado = $_POST['Cargo_Empleado'];
            $usuarioEmpleado = $_POST['Usuario_Empleado'];
            try {
                if ($this->empleadoModel->checkIfEmpleadoExists($cedulaEmpleado)) {
                    echo json_encode(['success' => false, 'message' => 'El empleado ya existe.']);
                    return;
                }

                $result = $this->empleadoModel->createEmpleado($cedulaEmpleado, $nombreEmpleado, $rhEmpleado, $telEmpleado, $emailEmpleado, $cargoEmpleado, $usuarioEmpleado);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Empleado creado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al crear el empleado.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
            }
            exit();
        }
        require_once __DIR__ . '/../views/empleado/create.php';
    }

    public function viewEdit($id) {
        $empleado = $this->empleadoModel->getEmpleadoById($id);
        if ($empleado) {
            require_once __DIR__ . '/../views/empleado/update.php';
        } else {
            $_SESSION['error_message'] = 'Empleado no encontrado.';
            header('Location: ' . \config\APP_URL . 'empleados');
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idEmpleado = $_POST['Id_Empleado'];
            $cedulaEmpleado = $_POST['Cedula_Empleado'];
            $nombreEmpleado = $_POST['Nom_Empleado'];
            $rhEmpleado = $_POST['RH_Empleado'];
            $telEmpleado = $_POST['Telefono_Empleado'];
            $emailEmpleado = $_POST['Email_Empleado'];
            $cargoEmpleado = $_POST['Cargo_Empleado'];
            $usuarioEmpleado = $_POST['Usuario_Empleado'];
            $estadoEmpleado = $_POST['Estado_Empleado'];
            try {
                $result = $this->empleadoModel->updateEmpleado($idEmpleado, $cedulaEmpleado, $nombreEmpleado, $rhEmpleado, $telEmpleado, $emailEmpleado, $cargoEmpleado, $usuarioEmpleado, $estadoEmpleado);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Empleado actualizado exitosamente.']);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el empleado.']);
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
            $idEmpleado = $data['id'];
            $estadoEmpleado = $data['estado'];
            
            try {
                $result = $this->empleadoModel->updateEmpleadoState($idEmpleado, $estadoEmpleado);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Estado del empleado actualizado.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo actualizar el estado del empleado.']);
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
            $idEmpleado = $data['id'];

            try {
                $result = $this->empleadoModel->deleteEmpleado($idEmpleado);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Empleado eliminado con éxito.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo eliminar el empleado porque esta conectado con otro(s) registros.']);
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
        $empleados = $this->empleadoModel->getEmpleados();

        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Empleados</title>
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
        <div class="header"><h1>Reporte de Empleados - Panaderia Wyk</h1></div>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>RH</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Cargo</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        if (!empty($empleados)) {
            foreach ($empleados as $empleado) {
                $estado = ($empleado['ESTADO_EMPLEADO'] == 1) ? 'Activo' : 'Inactivo';
                $html .= '
                <tr>
                    <td>' . htmlspecialchars($empleado['CC_EMPLEADO']) . '</td>
                    <td>' . htmlspecialchars($empleado['NOMBRE_EMPLEADO']) . '</td>
                    <td>' . htmlspecialchars($empleado['RH_EMPLEADO']) . '</td>
                    <td>' . htmlspecialchars($empleado['TEL_EMPLEADO']) . '</td>
                    <td>' . htmlspecialchars($empleado['EMAIL_EMPLEADO']) . '</td>
                    <td>' . htmlspecialchars($empleado['NOMBRE_CARGO']) . '</td>
                    <td>' . htmlspecialchars($empleado['NOMBRE_USUARIO']) . '</td>
                    <td>' . $estado . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="2">No se encontraron empleados</td></tr>';
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
        $dompdf->stream("Reporte_Empleados.pdf", array("Attachment" => false));
    }
}
