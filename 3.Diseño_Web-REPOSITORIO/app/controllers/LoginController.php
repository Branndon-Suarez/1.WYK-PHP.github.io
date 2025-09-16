<?php
namespace controllers;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

use const config\APP_URL;
use Exception;
use models\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boton_login'])) {

    $username = htmlspecialchars(trim($_POST['name_usuario']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $_SESSION['error_message'] = 'Inicio de sesión fallida.';
    header('Location: ' . APP_URL . 'login');
        exit();
    } elseif ($password !== $confirm_password) {
        $_SESSION['error_message'] = 'Las contraseñas no coinciden.';
    header('Location: ' . APP_URL . 'login');
        exit();
    }

    try {
        $user_model = new User();

        $user = $user_model->findUserByUsername($username);

        if ($user && $user_model->verifyPassword($password, $user['PASSWORD_USUARIO'])) {
            if ($user['ESTADO_USUARIO']) {
                $_SESSION['user_id'] = $user['ID_USUARIO'];
                $_SESSION['username'] = $user['NOMBRE_USUARIO'];
                $_SESSION['rol'] = $user['ROL'];
                $_SESSION['success_message'] = '¡Inicio de sesión exitoso!' . ' Bienvenido, ' . $_SESSION['username'] . '.';

                header('Location: ' . APP_URL . 'dashboard');
                exit();
            } else {
                $_SESSION['error_message'] = 'Tu cuenta ha sido desactivada. Contacta al administrador.';
                header('Location: ' . APP_URL . 'login');
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Usuario o contraseña incorrectos.';
            header('Location: ' . APP_URL . 'login');
            exit();
        }

    } catch (Exception $e) {
        $_SESSION['error_message'] = 'Ocurrió un error. Por favor, inténtalo de nuevo.';
    header('Location: ' . APP_URL . 'login');
        exit();
    }
} else {
    header('Location: ' . \config\APP_URL . 'login');
    exit();
}
