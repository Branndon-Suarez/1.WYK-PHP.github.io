<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/app.php';
$autoloadPath = __DIR__ . '/app/autoload.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['boton_login'])) {
        require_once __DIR__ . '/app/controllers/LoginUser/LoginController.php';
        exit;
    } elseif (isset($_POST['boton_register'])) {
        require_once __DIR__ . '/app/controllers/LoginUser/RegisterController.php';
        exit;
    }
}

$validViews = ['home', 'login', 'dashboard'];

if (in_array($vista, $validViews)) {
    switch ($vista) {
        case 'login':
            require_once __DIR__ . '/app/views/layouts/heads/headLogin.php';
            require_once __DIR__ . '/app/views/users/userLogin/login.php';
            break;
        case 'home':
            require_once __DIR__ . '/app/views/layouts/heads/headHome.php';
            require_once __DIR__ . '/app/views/layouts/headers/headerHome.php';
            require_once __DIR__ . '/app/views/home.php';
            break;
        case 'dashboard':
            require_once __DIR__ . '/app/views/dashboard.php';
            break;
    }
} else {
    http_response_code(404);
    
    if (file_exists(__DIR__ . '/config/error_404-500/404.php')) {
        require_once __DIR__ . '/config/error_404-500/404.php';
    } else {
        echo "<h1>404 - Página No Encontrada</h1>";
        echo "<p>La página '$vista' no existe en nuestra aplicación.</p>";
        echo "<a href='" . APP_URL . "'>Volver al inicio</a>";
    }
    exit;
}
