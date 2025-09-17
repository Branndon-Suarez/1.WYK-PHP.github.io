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

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function reports() {
        $dashboardDataUsuarios = [
            'usuariosExistentes' => $this->usuarioModel->getCantUsuariosExist(),
            'usuariosActivos' => $this->usuarioModel->getCantUsuariosActivos(),
            'usuariosInactivos' => $this->usuarioModel->getCantUsuariosInactivos(),
            'usuarios' => $this->usuarioModel->getUsuarios()
        ];

        // Mensajes de sesión
        $success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        if (isset($_SESSION['success_message'])) { unset($_SESSION['success_message']); }
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        if (isset($_SESSION['error_message'])) { unset($_SESSION['error_message']); }

        require_once __DIR__ . '/../views/layouts/heads/headDashboard.php';
        require_once __DIR__ . '/../views/usuario/dashboardUsuario.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreUsuario = $_POST['Nom_Usuario'];
            $password = $_POST['Password_Usuario'];
            // 1. Cifrar la contraseña ANTES de enviarla al modelo
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            // 2. Obtener la fecha y hora actuales en el formato correcto
            $fechaActual = date('Y-m-d H:i:s');
            $rolUsuario = $_POST['Rol_Usuario'];

            try {
                if ($this->usuarioModel->checkIfUsuarioExists($nombreUsuario)) {
                    // Si el cargo ya existe, responde con un JSON de error.
                    echo json_encode(['success' => false, 'message' => 'El usuario ya existe.']);
                    return;
                }

                $result = $this->usuarioModel->createUsuario($nombreUsuario, $hashedPassword, $fechaActual, $rolUsuario);
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
        }
        require_once __DIR__ . '/../views/usuario/create.php';
    }

    public function viewEdit($id) {
        $usuario = $this->usuarioModel->getUsuarioById($id);
        if ($usuario) {
            require_once __DIR__ . '/../views/usuario/update.php';
        } else {
            $_SESSION['error_message'] = 'Usuario no encontrado.';
            header('Location: ' . \config\APP_URL . 'usuarios');
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_POST['id_usuario'];
            $nombreUsuario = $_POST['nombre_usuario'];
            $rol = $_POST['rol_usuario'];
            $estadoUsuario = $_POST['estado_usuario'];
            
            //Obtener la información actual del usuario de la base de datos
            $usuarioActual = $this->usuarioModel->getUsuarioById($idUsuario);
            if (!$usuarioActual) {
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
                exit();
            }

            $password = $usuarioActual['PASSWORD_USUARIO'];
            if (!empty($_POST['password'])) {
                $password = hash('sha256', $_POST['password']);
            }

            $fechaRegistro = $usuarioActual['FECHA_REGISTRO'];
            if (!empty($_POST['fecha_registro'])) {
                $fechaRegistro = $_POST['fecha_registro'];
            }
            
            $fechaultSesion = $usuarioActual['FECHA_ULTIMA_SESION'];
            if (!empty($_POST['fecha_ultima_sesion'])) {
                $fechaultSesion = $_POST['fecha_ultima_sesion'];
            }
            
            try {
                $result = $this->usuarioModel->updateUsuario($idUsuario, $nombreUsuario, $password, $fechaRegistro, $fechaultSesion, $rol, $estadoUsuario);
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Usuario actualizado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el usuario.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
            }
            exit();
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
            $idUsuario = $data['id'];
            $estadoUsuario = $data['estado'];
            
            try {
                $result = $this->usuarioModel->updateUsuarioState($idUsuario, $estadoUsuario);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Estado del usuario actualizado.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo actualizar el estado del usuario.']);
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
            $idUsuario = $data['id'];

            try {
                $result = $this->usuarioModel->deleteUsuario($idUsuario);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Usuario eliminado con éxito.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo eliminar el usuario porque esta conectado con otro(s) registros.']);
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
        $usuarios = $this->usuarioModel->getUsuarios();

        // 2. Construir el HTML
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Usuarios</title>
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
        <div class="header"><h1>Reporte de Usuarios - Panaderia Wyk</h1></div>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>Nombre Usuario</th>
                        <th>Fecha Registro </th>
                        <th>Última Sesión</th>
                        <th>Rol</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        if (!empty($usuarios)) {
            foreach ($usuarios as $usuario) {
                // Asume que la columna de estado es 'ESTADO_CARGO' y es un valor booleano o numérico (1/0)
                $estado = ($usuario['ESTADO_USUARIO'] == 1) ? 'Activo' : 'Inactivo';
                $html .= '
                <tr>
                    <td>' . htmlspecialchars($usuario['NOMBRE_USUARIO']) . '</td>
                    <td>' . htmlspecialchars($usuario['FECHA_REGISTRO']) . '</td>
                    <td>' . htmlspecialchars($usuario['FECHA_ULTIMA_SESION']) . '</td>
                    <td>' . htmlspecialchars($usuario['ROL']) . '</td>
                    <td>' . $estado . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="5">No se encontraron usuarios</td></tr>';
        }

        $html .= '</tbody></table></div></body></html>';

        // Configurar y generar el PDF
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
        $dompdf->stream("Reporte_Usuarios.pdf", array("Attachment" => false));
    }
}
