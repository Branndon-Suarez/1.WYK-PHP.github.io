<?php

namespace controllers;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\TareaModel;
use const \config\APP_URL;
use \Dompdf\Dompdf;
use \Dompdf\Options;

class TareasController
{
    private $tareaModel;

    public function __construct()
    {
        $this->tareaModel = new TareaModel();
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

        $dashboardDataTareas = [
            'tareasExistentes' => $this->tareaModel->getCantTareasExistentes(),
            'tareasPendientes' => $this->tareaModel->getCantTareasPendientes(),
            'tareasCopletadas' => $this->tareaModel->getCantTareasCompletadas(),
            'tareasCanceladas' => $this->tareaModel->getCantTareasCanceladas(),
            'tareas' => $this->tareaModel->getTareas()
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
        require_once __DIR__ . '/../views/tarea/dashboardTarea.php';
    }

    /* ---------------------------------------- LISTADO TAREAS A EMPLEADOS ---------------------------------------- */
    public function getTareasParaVista()
    {
        if (!isset($_SESSION['userId'])) {
            return [];
        }
        $id_usuario = $_SESSION['userId'];
        return $this->tareaModel->getTareasByUsuario($id_usuario);
    }

    public function completarTarea($id)
    {
        if ($this->tareaModel->completarTarea($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al completar la tarea']);
        }
    }

    public function revertirTarea($id)
    {
        if (isset($_SESSION['userId'])) {
            $id_usuario = $_SESSION['userId'];
            if ($this->tareaModel->revertirTarea($id, $id_usuario)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al deshacer la acción o tarea no asignada a este usuario.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
        }
    }
    /* ---------------------------------------- LISTADO TAREAS A EMPLEADOS ---------------------------------------- */

    public function create()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tarea = $_POST['tarea'];
            $categoria = $_POST['categoria'];
            $descripcion = $_POST['descripcion'];
            $tiempo = $_POST['tiempo'];
            $prioridad = $_POST['prioridad'];
            $user_asignado = $_POST['user_asignado'];
            $estado = $_POST['user_asignado'];
            try {
                if ($this->tareaModel->checkIfTareaExists($tarea)) {
                    echo json_encode(['success' => false, 'message' => 'La tarea ya existe.']);
                    return;
                }

                if (empty($user_asignado)) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'El usuario asignado es un campo requerido.']);
                    return;
                }

                $result = $this->tareaModel->createTarea($tarea, $categoria, $descripcion, $tiempo, $prioridad, $user_asignado, $estado);
                if ($result) {
                    // Si es exitoso, responde con un JSON de éxito.
                    echo json_encode(['success' => true, 'message' => 'Tarea creada exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al crear la tarea.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
            }
            exit();
        } else {
            require_once __DIR__ . '/../views/layouts/heads/headForm.php';
            require_once __DIR__ . '/../views/tarea/create.php';
        }
    }

    public function viewEdit($id)
    {
        $this->checkAdminAccess();

        $tarea = $this->tareaModel->getTareaById($id);
        if ($tarea) {
            require_once __DIR__ . '/../views/layouts/heads/headForm.php';
            require_once __DIR__ . '/../views/tarea/update.php';
        } else {
            $_SESSION['error_message'] = 'Tarea no encontrado.';
            header('Location: ' . \config\APP_URL . 'tareas');
            exit();
        }
    }

    public function update()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idTarea = $_POST['id_tarea'];
            $tarea = $_POST['tarea'];
            $categoria = $_POST['categoria'];
            $descripcion = $_POST['descripcion'];
            $tiempo = $_POST['tiempo'];
            $prioridad = $_POST['prioridad'];
            $estado = $_POST['estado_tarea'];
            $user_asignado = $_POST['user_asignado'];

            try {
                if (empty($user_asignado)) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'El usuario asignado es un campo requerido.']);
                    return;
                }
                $result = $this->tareaModel->updateProducto($idTarea, $tarea, $categoria, $descripcion, $tiempo, $prioridad, $estado, $user_asignado);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Tarea actualizada exitosamente.']);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el tarea.']);
                    exit();
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
                exit();
            }
        }
    }

    public function delete()
    {
        $this->checkAdminAccess();
        //Verificar que la petición sea POST y que el contenido sea JSON
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido o tipo de contenido incorrecto.']);
            return;
        }

        //Leer y decodificar el JSON del cuerpo de la petición
        $data = json_decode(file_get_contents('php://input'), true);

        //Validar que el ID esté presente
        if (isset($data['id'])) {
            $idTarea = $data['id'];

            try {
                //Llamar al modelo para eliminar el registro
                $result = $this->tareaModel->deleteTarea($idTarea);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Trea eliminada con éxito.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo eliminarla tarea. Esta relacionada con otro(s) registros']);
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
    public function generateReportPDF()
    {
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

        $roles = $this->tareaModel->getFilteredRoles($searchText, $estadoFilter, $chipFilters);

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
