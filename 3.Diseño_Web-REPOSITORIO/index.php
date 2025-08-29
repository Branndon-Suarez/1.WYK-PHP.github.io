<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

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

$validViews = ['home', 'login', 'dashboard', 'logout'];

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
            if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['rol'])) {
                require_once __DIR__ . '/app/views/layouts/heads/headDashboard.php';
                require_once __DIR__ . '/app/views/layouts/headers/headerDashboard.php';
                require_once __DIR__ . '/app/views/dashboard/dashboard.php';
            } else {
                header('Location: ' . \Config\APP_URL . 'login');
                exit();
            }
            break;
        case 'logout':
            session_start();
            session_unset();
            session_destroy();
            header('Location: ' . \Config\APP_URL . 'login');
            exit();
            break;
    }
} else {
    http_response_code(404);
    
    if (file_exists(__DIR__ . '/config/error_404-500/404.php')) {
        require_once __DIR__ . '/config/error_404-500/404.php';
    } else {
        echo "<h1>404 - Página No Encontrada</h1>";
        echo "<p>La página '$vista' no existe en nuestra aplicación.</p>";
        echo "<a href='" . \Config\APP_URL . "'>Volver al inicio</a>";
    }
    exit;
}
