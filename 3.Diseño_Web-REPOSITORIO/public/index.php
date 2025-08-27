<?php
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

    // Enrutamiento simple
    switch ($request) {
        case '/':
        case '':
        case '/home':
            require_once __DIR__ . '/../app/views/home.php';
            break;
        case '/login':
            require_once __DIR__ . '/../app/controllers/LoginController.php';
            break;
        default:
            // Manejar otras rutas
            http_response_code(404);
            echo "Página no encontrada";
            break;
    }
} catch (Exception $e) {
    // Manejo de errores
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
