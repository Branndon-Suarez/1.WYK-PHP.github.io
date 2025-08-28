<?php
namespace app\controllers\LoginUser;

session_start();

use Exception;
use app\models\LoginUser\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boton_login'])) {

    $username = htmlspecialchars(trim($_POST['name_usuario']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = 'Inicio de sesión fallida.';
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
    header('Location: ' . APP_URL . 'login');
    exit();
}
