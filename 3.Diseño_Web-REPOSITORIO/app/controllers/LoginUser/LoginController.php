<?php
session_start();
require_once '../../models/LoginUser/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boton_login'])) {

    $username = htmlspecialchars(trim($_POST['name_usuario']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = 'Inicio de sesión fallida.';
        header('Location: ../../views/users/userLogin/login.php');
        exit();
    }

    try {
        $user_model = new User();

        $user = $user_model->findUserByUsername($username);

        if ($user && $user_model->verifyPassword($password, $user['PASSWORD_USUARIO'])) {
            if ($user['ESTADO_USUARIO']) {
                // Guarda los datos importantes del usuario en la sesión.
                $_SESSION['user_id'] = $user['ID_USUARIO'];
                $_SESSION['username'] = $user['NOMBRE_USUARIO'];
                $_SESSION['rol'] = $user['ROL'];

                header('Location: ../../views/dashboard/dashboard.php');
                exit();
            } else {
                $_SESSION['error_message'] = 'Tu cuenta ha sido desactivada. Contacta al administrador.';
                header('Location: ../../views/users/userLogin/login.php');
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Usuario o contraseña incorrectos.';
            header('Location: ../../views/users/userLogin/login.php');
            exit();
        }

    } catch (Exception $e) {
        $_SESSION['error_message'] = 'Ocurrió un error. Por favor, inténtalo de nuevo.';
        header('Location: ../../views/users/userLogin/login.php');
        exit();
    }
} else {
    header('Location: ../../views/users/userLogin/login.php');
    exit();
}
