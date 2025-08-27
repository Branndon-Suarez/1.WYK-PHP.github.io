<?php
$autoloadPath = __DIR__ . '/../app/autoload.php';

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    die("Error: No se puede encontrar autoload.php");
}

if (isset($_GET['views'])) {
    $vista = $_GET['views'];
} else {
    $vista = 'home';
}

// Cargar la vista correspondiente
if ($vista === 'login') {
    // Cargar login.php desde la carpeta users
    require_once __DIR__ . '/../app/views/users/login.php';
} elseif ($vista === 'home') {
    // Cargar home.php desde la carpeta views
    require_once __DIR__ . '/../app/views/home.php';
} else {
    // Vista no encontrada - error 404
    http_response_code(404);
    echo "Página no encontrada";
    exit;
}