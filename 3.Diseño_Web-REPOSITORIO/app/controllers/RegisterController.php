<?php
namespace controllers;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

use const config\APP_URL;
use Exception;
use models\UserClientModel;
use models\Register; // Asegúrate de que esta línea esté presente

class RegisterController {
    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // 1. CONTRASEÑA COINCIDE?
            if ($_POST["password"] !== $_POST["confirm_password"]) {
                $_SESSION['error_message'] = "Las contraseñas no coinciden.";
                header('Location: ' . \config\APP_URL . 'login');
                exit;
            }

            // 2. CONTRASEÑA MAYOR A 8 CARACTERES?
            if (strlen($_POST["password"]) < 8) {
                $_SESSION['error_message'] = "La contraseña debe tener al menos 8 caracteres.";
                header('Location: ' . \config\APP_URL . 'login');
                exit;
            }

            // 3. USUARIO YA EXISTE?
            $userName = $_POST["name_usuario"];
            $numDocumento = $_POST["num_documento"];

            $registerModel = new Register();
            if ($registerModel->findExistenceUser($userName)) {
                $_SESSION['error_message'] = "El nombre de usuario ya está en uso.";
                header('Location: ' . \config\APP_URL . 'login');
                exit;
            }

            // 4. CLIENTE YA EXISTE?
            $userClientModel = new UserClientModel();
            if ($userClientModel->findExistenceClient($numDocumento)) {
                $_SESSION['error_message'] = "El número de documento ya está registrado.";
                header('Location: ' . \config\APP_URL . 'login');
                exit;
            }

            $userData = [
                "nombre_usuario" => $userName,
                "password"       => hash('sha256', $_POST["password"])
            ];

            $clientData = [
                "documento"       => $numDocumento,
                "tipo_documento"  => $_POST["tipo_documento"],
                "nombre_completo" => $_POST["nombre_completo"],
                "telefono"        => $_POST["telefono"],
                "email"           => $_POST["email"],
            ];

            // 5. Creación del usuario y cliente
            $model = new UserClientModel();
            try {
                $model->createUserAndClient($userData, $clientData);
                $_SESSION['success_message'] = 'Cuenta creada exitosamente. Por favor, inicia sesión.';
                header('Location: ' . \config\APP_URL . 'login');
                exit;
            } catch (\Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header('Location: ' . \config\APP_URL . 'login');
                exit;
            }
        }
    }
}

$controller = new RegisterController();
$controller->register();
