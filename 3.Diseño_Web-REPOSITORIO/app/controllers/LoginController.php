<?php
namespace controllers;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use const config\APP_URL;
use Exception;
use models\User;

class LoginController {
    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boton_login'])) {

            $numDocLogin = htmlspecialchars(trim($_POST['num_doc_login']));
            $emailLogin = htmlspecialchars(trim($_POST['email_login']));
            $passwordLogin = htmlspecialchars(trim($_POST['password_login']));

            if (empty($numDocLogin) || empty($emailLogin) || empty($passwordLogin)) {
                $_SESSION['error_message'] = 'Inicio de sesión fallida.';
            header('Location: ' . APP_URL . 'login');
                exit();
            }

            try {
                $user_model = new User();

                $user = $user_model->findUser($numDocLogin);

                if ($user && $user['EMAIL_USUARIO'] === $emailLogin && $user['PASSWORD_USUARIO'] === $passwordLogin /* password_verify($passwordLogin, $user['PASSWORD_USUARIO']) */) {
                    if ($user['ESTADO_USUARIO']) {
                        //Campos de la tabla ROL según el USUARIO correspondiente
                        $_SESSION['rolId'] = $user['ID_ROL'];
                        $_SESSION['rol'] = $user['ROL'];
                        $_SESSION['rolClasificacion'] = $user['CLASIFICACION'];
                        $_SESSION['rolEstado'] = $user['ESTADO_ROL'];

                        //Campos de la tabla USUARIO
                        $_SESSION['userId'] = $user['ID_USUARIO'];
                        $_SESSION['numDocUser'] = $user['NUM_DOC'];
                        $_SESSION['userName'] = $user['NOMBRE'];
                        $_SESSION['userTel'] = $user['TEL_USUARIO'];
                        $_SESSION['userEmail'] = $user['EMAIL_USUARIO'];
                        $_SESSION['userFechRegistro'] = $user['FECHA_REGISTRO'];
                        $_SESSION['success_message'] = '¡Inicio de sesión exitoso!' . ' Bienvenido, ' . $_SESSION['userName'] . '.';

                        header('Location: ' . APP_URL . 'dashboard');
                        exit();
                    } else {
                        $_SESSION['error_message'] = 'Tu cuenta ha sido desactivada. Contacta al administrador.';
                        header('Location: ' . APP_URL . 'login');
                        exit();
                    }
                } else {
                    $_SESSION['error_message'] = 'Usuario, email o contraseña incorrectos.';
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
    }
}
