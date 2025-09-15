<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/../../../config/app.php';
require_once __DIR__ . '/../../autoload.php';

use app\models\LoginUser\UserClientModel;

class RegisterController {

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($_POST["password"] !== $_POST["confirm_password"]) {
                $_SESSION['error_message'] = "Las contraseñas no coinciden.";
                header('Location: ' . \config\APP_URL . 'login');
                exit;
            }

            if (strlen($_POST["password"]) < 8) {
                $_SESSION['error_message'] = "La contraseña debe tener al menos 8 caracteres.";
                header('Location: ' . \config\APP_URL . 'login');
                exit;
            }

            $userData = [
                "nombre_usuario" => $_POST["name_usuario"],
                "password"       => hash('sha256', $_POST["password"])
            ];

            $clientData = [
                "documento"          => $_POST["num_documento"],
                "tipo_documento"     => $_POST["tipo_documento"],
                "nombre_completo"    => $_POST["nombre_completo"],
                "telefono"           => $_POST["telefono"],
                "email"              => $_POST["email"],
                "id_empleado_sistema"=> 1 // el ID del empleado "sistema"
            ];

            $model = new UserClientModel();
            try {
                $model->createUserAndClient($userData, $clientData);
                $_SESSION['success_message'] = 'Cuenta creada exitosamente. Por favor, inicia sesión.';
                header('Location: ' . \config\APP_URL . 'login');
                exit;
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage();
                $_SESSION['error_message'] = 'Error al crear cuenta.';
                header('Location: ' . \config\APP_URL . 'login');
            }
        }
    }
}

$controller = new RegisterController();
$controller->register();
