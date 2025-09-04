<?php
namespace app\controllers\LoginUser;
use Exception;
use app\models\LoginUser\LoginUser\Register;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['name_usuario']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($username) || empty($password)) {
        $_SESSION['message_register'] = "Por favor, complete todos los campos.";
        header('Location: ../../views/users/userLogin/login.php');
        exit();
    }

    try {
        $register_Model = new Register();
        $userRegister = $register_Model->findExistenceUser($username);

        if(isset($userRegister)) {
            $_SESSION['message_register'] = "El usuario ya existe.";
            header('Location: ../../views/users/userLogin/login.php');
            exit();
        } else {
            $register_Model->registerUser($username, $password);
            $_SESSION['message_register'] = "Registro exitoso.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['message_register'] = "Error en el registro. Intente más tarde.";
        header('Location: ../../views/users/userLogin/login.php');
        exit();
    }
} else {
    header('Location: ../../views/users/userLogin/login.php');
    exit();
}
