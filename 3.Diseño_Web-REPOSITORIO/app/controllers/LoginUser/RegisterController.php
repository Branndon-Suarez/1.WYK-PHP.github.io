<?php
require_once '../../models/LoginUser/Register.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['name_usuario']));
    $username = htmlspecialchars(trim($_POST['password']));

    try {
        $register_Model = new Register();
        $registro = $register_Model->findExistenceUser($username);

        if(isset($registro)) {

        } else {
            
        }
    } catch {

    }
} else {

}
