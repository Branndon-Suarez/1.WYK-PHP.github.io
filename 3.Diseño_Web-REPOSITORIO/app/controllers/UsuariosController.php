<?php
namespace controllers;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\UsuarioModel;
use const \config\APP_URL;
use \Dompdf\Dompdf;
use \Dompdf\Options;

class UsuariosController {
    private $usuarioModel;
    private $rolModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    private function checkAdminAccess() {
        if (!isset($_SESSION['rolClasificacion']) || $_SESSION['rolClasificacion'] !== 'ADMINISTRADOR') {
            $_SESSION['error_message'] = 'Acceso denegado. No tienes permisos de administrador.';
            header('Location: ' . APP_URL . 'dashboard');
            exit();
        }
    }

    public function reports() {
        $this->checkAdminAccess();

        $dashboardDataUsuarios = [
            'usuariosExistentes' => $this->usuarioModel->getCantUsuariosExistentes(),
            'usuariosActivos' => $this->usuarioModel->getCantUsuariosActivos(),
            'usuariosInactivos' => $this->usuarioModel->getCantUsuariosInactivos(),
            'usuarios' => $this->usuarioModel->getUsuarios()
        ];

        // Mensajes de sesión
        $success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        if (isset($_SESSION['success_message'])) { unset($_SESSION['success_message']); }
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        if (isset($_SESSION['error_message'])) { unset($_SESSION['error_message']); }
        // variable sidebar
        $active_page = 'roles';

        require_once __DIR__ . '/../views/layouts/heads/headDashboard.php';
        require_once __DIR__ . '/../views/usuario/dashboardUsuario.php';
    }

    public function create() {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numDocUsuario = $_POST['num_doc_usuario'];
            $nomUsuario = $_POST['nom_usuario'];
            $passwordUsuario = $_POST['password_usuario'];
            $telUsuario = $_POST['tel_usuario'];
            $emailUsuario = $_POST['email_usuario'];
            $fechRegUsuario = $_POST['fech_Reg_usuario'];
            $rolUsuario = $_POST['rol_fk'];
            try {
                if ($this->usuarioModel->checkIfUsuarioExists($numDocUsuario, $nomUsuario)) {
                    echo json_encode(['success' => false, 'message' => 'El usuario ya existe.']);
                    return;
                }

                $result = $this->usuarioModel->createUsuario($numDocUsuario, $nomUsuario, $passwordUsuario, $telUsuario, $emailUsuario, $fechRegUsuario, $rolUsuario);
                if ($result) {
                    // Si es exitoso, responde con un JSON de éxito.
                    echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al crear el usuario.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
            }
            exit();
        } else {
            require_once __DIR__ . '/../views/layouts/heads/headForm.php';
            require_once __DIR__ . '/../views/usuario/create.php';
        }
    }

    public function viewEdit($id) {
        $this->checkAdminAccess();

        $rol = $this->usuarioModel->getRolById($id);
        if ($rol) {
            require_once __DIR__ . '/../views/layouts/heads/headForm.php';
            require_once __DIR__ . '/../views/rol/update.php';
        } else {
            $_SESSION['error_message'] = 'Rol no encontrado.';
            header('Location: ' . \config\APP_URL . 'roles');
            exit();
        }
    }

    public function update() {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRol = $_POST['Id_Rol'];
            $rol = $_POST['Rol'];
            $rolClasificacion = $_POST['Clasificacion_Rol'];
            $rolEstado = $_POST['Estado_Rol'];
            try {
                $result = $this->usuarioModel->updateRol($idRol, $rol, $rolClasificacion, $rolEstado);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Rol actualizado exitosamente.']);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el rol.']);
                    exit();
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
                exit();
            }
        }
    }

    public function updateState() {
        $this->checkAdminAccess();

        //Verificar que la petición sea POST y que el contenido sea JSON.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido o tipo de contenido incorrecto.']);
            return;
        }

        //Decodificar el JSON del cuerpo de la petición.
        $data = json_decode(file_get_contents('php://input'), true);

        //Validar que los datos necesarios (id y estado) estén presentes.
        if (isset($data['id']) && isset($data['estado'])) {
            $idRol = $data['id'];
            $estadoRol = $data['estado'];
            
            try {
                //Llamar al método del modelo para actualizar la base de datos.
                $result = $this->usuarioModel->updateRolState($idRol, $estadoRol);

                //Enviar una respuesta JSON al cliente (el JavaScript).
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Estado del rol actualizado.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo actualizar el estado del rol.']);
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
            $idUsuario = $data['id'];

            try {
                //Llamar al modelo para eliminar el registro
                $result = $this->usuarioModel->deleteUsuario($idUsuario);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Usuario eliminado con éxito.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo eliminar el usuario. Esta relacionado con otro(s) registros']);
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

        $roles = $this->usuarioModel->getFilteredRoles($searchText, $estadoFilter, $chipFilters);

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
