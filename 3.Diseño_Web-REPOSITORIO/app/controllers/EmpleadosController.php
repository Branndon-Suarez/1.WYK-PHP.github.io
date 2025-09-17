<?php
namespace controllers;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\CargoModel;
use const \config\APP_URL;
use \Dompdf\Dompdf;
use \Dompdf\Options;

class CargosController {
    private $cargoModel;

    public function __construct() {
        $this->cargoModel = new CargoModel();
    }

    public function reports() {
        $dashboardDataCargos = [
            'cargosExistentes' => $this->cargoModel->getCantCargosExistentes(),
            'cargosActivos' => $this->cargoModel->getCantCargosActivos(),
            'cargosInactivos' => $this->cargoModel->getCantCargosInactivos(),
            'cargos' => $this->cargoModel->getCargos()
        ];

        // Mensajes de sesión
        $success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        if (isset($_SESSION['success_message'])) { unset($_SESSION['success_message']); }
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        if (isset($_SESSION['error_message'])) { unset($_SESSION['error_message']); }

        require_once __DIR__ . '/../views/layouts/heads/headDashboard.php';
        require_once __DIR__ . '/../views/cargo/dashboardCargo.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCargo = $_POST['Nom_Cargo'];
            try {
                if ($this->cargoModel->checkIfCargoExists($nombreCargo)) {
                    // Si el cargo ya existe, responde con un JSON de error.
                    echo json_encode(['success' => false, 'message' => 'El cargo ya existe.']);
                    return;
                }

                $result = $this->cargoModel->createCargo($nombreCargo);
                if ($result) {
                    // Si es exitoso, responde con un JSON de éxito.
                    echo json_encode(['success' => true, 'message' => 'Cargo creado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al crear el cargo.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
            }
            exit();
        }
        // Si el método es GET (al precionar el boton de añadir cargo en el dashboardCargo.php), simplemente muestra la vista de creación para luego realizar el envio por metodo post(arriba).
        require_once __DIR__ . '/../views/cargo/create.php';
    }

    public function viewEdit($id) {
        $cargo = $this->cargoModel->getCargoById($id);
        if ($cargo) {
            require_once __DIR__ . '/../views/cargo/update.php';
        } else {
            $_SESSION['error_message'] = 'Cargo no encontrado.';
            header('Location: ' . \config\APP_URL . 'cargos');
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCargo = $_POST['Id_Cargo'];
            $nombreCargo = $_POST['Nom_Cargo'];
            $estadoCargo = $_POST['Estado_Cargo'];
            try {
                $result = $this->cargoModel->updateCargo($idCargo, $nombreCargo, $estadoCargo);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Cargo actualizado exitosamente.']);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el cargo.']);
                    exit();
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
                exit();
            }
        }
    }

    public function updateState() {
        // 1. Verificar que la petición sea POST y que el contenido sea JSON.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido o tipo de contenido incorrecto.']);
            return;
        }

        // 2. Decodificar el JSON del cuerpo de la petición.
        $data = json_decode(file_get_contents('php://input'), true);

        // 3. Validar que los datos necesarios (id y estado) estén presentes.
        if (isset($data['id']) && isset($data['estado'])) {
            $idCargo = $data['id'];
            $estadoCargo = $data['estado'];
            
            try {
                // 4. Llamar al método del modelo para actualizar la base de datos.
                $result = $this->cargoModel->updateCargoState($idCargo, $estadoCargo);

                // 5. Enviar una respuesta JSON al cliente (el JavaScript).
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Estado del cargo actualizado.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo actualizar el estado del cargo.']);
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
        // 1. Verificar que la petición sea POST y que el contenido sea JSON
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido o tipo de contenido incorrecto.']);
            return;
        }

        // 2. Leer y decodificar el JSON del cuerpo de la petición
        $data = json_decode(file_get_contents('php://input'), true);

        // 3. Validar que el ID esté presente
        if (isset($data['id'])) {
            $idCargo = $data['id'];

            try {
                // 4. Llamar al modelo para eliminar el registro
                $result = $this->cargoModel->deleteCargo($idCargo);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Cargo eliminado con éxito.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo eliminar el cargo.']);
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
        // 1. Obtener los datos del modelo
        $cargos = $this->cargoModel->getCargos();

        // 2. Construir el HTML
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Cargos</title>
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
        <div class="header"><h1>Reporte de Cargos - Panaderia Wyk</h1></div>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>Cargo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        if (!empty($cargos)) {
            foreach ($cargos as $cargo) {
                // Asume que la columna de estado es 'ESTADO_CARGO' y es un valor booleano o numérico (1/0)
                $estado = ($cargo['ESTADO_CARGO'] == 1) ? 'Activo' : 'Inactivo';
                $html .= '
                <tr>
                    <td>' . htmlspecialchars($cargo['NOMBRE_CARGO']) . '</td>
                    <td>' . $estado . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="2">No se encontraron cargos</td></tr>';
        }

        $html .= '</tbody></table></div></body></html>';

        // 3. Configurar y generar el PDF
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
        $dompdf->stream("Reporte_Cargos.pdf", array("Attachment" => false));
    }
}
