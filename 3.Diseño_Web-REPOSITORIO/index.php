<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/config/app.php';
$autoloadPath = __DIR__ . '/app/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';//Generar PDF con Dompdf

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    die("Error: No se puede encontrar autoload.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['boton_login'])) {
        $controllerLogin = new \controllers\LoginController;
        $controllerLogin->handleLogin();
        exit();
    }
}
/**Notas:
 * 1. rtrim($_GET['views'], '/'): Remueve cualquier barra diagonal (/) al final de la cadena de texto.
 * 2. explode('/', ...): Divide la cadena en un array usando '/' como delimitador.
 * 3. $request[0]: La primera parte de la URL, que indica la vista.
 * 4. $request[1]: La segunda parte de la URL, que indica la acción (esto para el controlador y modelos con sus funciones para la CRUD).
 */
$request = isset($_GET['views']) ? explode('/', rtrim($_GET['views'], '/')) : ['home'];
$vista = $request[0];
$action = isset($request[1]) ? $request[1] : 'reports';
$params = array_slice($request, 2);

$validViews = ['home', 'login', 'logout', 'dashboard', 'roles', 'usuarios', 'empleados', 'clientes', 'productos', 'ventas'];

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
            if (isset($_SESSION['userId']) && isset($_SESSION['userName']) && isset($_SESSION['rol'])) {
                require_once __DIR__ . '/app/views/layouts/heads/headDashboard-inicio.php';
                require_once __DIR__ . '/app/views/dashboard/dashboard.php';
            } else {
                header('Location: ' . \config\APP_URL . 'login');
                exit();
            }
            break;
        case 'logout':
            session_start();
            session_unset();
            session_destroy();
            header('Location: ' . \config\APP_URL . 'login');
            exit();
            break;
        case 'roles':
        case 'usuarios':
        case 'empleados':
        case 'clientes':
        case 'productos':
            if (isset($_SESSION['userId']) && isset($_SESSION['userName']) && isset($_SESSION['rol'])) {
                $controllerName = ucfirst($vista) . 'Controller';
                $fullControllerName = '\\controllers\\' . $controllerName;

                if (class_exists($fullControllerName)) {
                    $controller = new $fullControllerName();

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // La lógica para la CRUD se maneja aquí (CREATE, UPDATE, DELETE).
                        // La acción (update, create, delete) viene en la URL.
                        if (method_exists($controller, $action)) {
                            $controller->$action();
                            exit();
                        } else {
                            http_response_code(404);
                            require_once __DIR__ . '/config/error_404-500/404.php';
                            exit();
                        }
                    } else {
                        // Las peticiones GET solo cargan las vistas.
                        if ($action === 'reports' && method_exists($controller, 'reports')) {
                             $controller->reports();
                        } elseif ($action === 'create' && method_exists($controller, 'create')) {
                            $controller->create();
                        }elseif ($action === 'viewEdit' && !empty($params) && method_exists($controller, 'viewEdit')) {
                            $controller->viewEdit($params[0]);
                        } elseif ($action === 'generateReportPDF' && method_exists($controller, 'generateReportPDF')) {
                            $controller->generateReportPDF();
                        } else {
                            http_response_code(404);
                            require_once __DIR__ . '/config/error_404-500/404.php';
                            exit();
                        }
                    }
                } else {
                    http_response_code(404);
                    require_once __DIR__ . '/config/error_404-500/404.php';
                    exit();
                }
            } else {
                header('Location: ' . \config\APP_URL . 'login');
                exit();
            }
            break;
    }
} else {
    http_response_code(404);
    
    if (file_exists(__DIR__ . '/config/error_404-500/404.php')) {
        require_once __DIR__ . '/config/error_404-500/404.php';
    } else {
        echo "<h1>404 - Página No Encontrada</h1>";
        echo "<p>La página '$vista' no existe en nuestra aplicación.</p>";
        echo "<a href='" . \config\APP_URL . "'>Volver al inicio</a>";
    }
    exit;
}

