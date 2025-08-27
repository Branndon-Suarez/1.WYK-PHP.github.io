<?php
use app\controllers\viewsController;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); // Para mostrar errores de inicio
error_reporting(E_ALL); // Muestra todos los errores
require_once __DIR__.'/../app/autoload.php';
try {
    /*'$_SERVER['REQUEST_URI']' sirve para obtener la parte de la URL que el usuario solicitó,
    incluyendo la ruta del archivo y la cadena de consulta (los parámetros después del ?)*/
    $request = $_SERVER['REQUEST_URI'];
    $baseDirectory = __DIR__;
    $request = str_replace($baseDirectory, '', $request);

    $url = isset($_GET['views']) ? explode("/", $_GET['views']) : ['login'];
    $vistaSolicitada = $url[0];

    $viewsController = new viewsController();
    $vista = $viewsController->obtenerVistasControlador($vistaSolicitada);

    // Cargar la vista correspondiente
    if ($vista == "login" || $vista == "404") {
        require_once __DIR__ . "/../app/views/users/{$vista}.php";
    } else {
        require_once __DIR__ . "/../app/views/inc/navbar.php";
        require_once __DIR__ . "/../app/views/content/{$vista}.php";
    }

    require_once __DIR__ . "/app/views/inc/script.php";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
