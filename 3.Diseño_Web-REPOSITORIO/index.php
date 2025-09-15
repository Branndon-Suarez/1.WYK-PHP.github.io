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
/**Notas:
 * 1. rtrim($_GET['views'], '/'): Remueve cualquier barra diagonal (/) al final de la cadena de texto.
 * 2. explode('/', ...): Divide la cadena en un array usando '/' como delimitador.
 * 3. $request[0]: La primera parte de la URL, que indica la vista.
 * 4. $request[1]: La segunda parte de la URL, que indica la acción (esto para el controlador y modelos con sus funciones para la CRUD).
 */
$request = isset($_GET['views']) ? explode('/', rtrim($_GET['views'], '/')) : ['home'];
$vista = $request[0];
$action = isset($request[1]) ? $request[1] : 'reports';

$validViews = ['home', 'login', 'logout', 'dashboard', 'cargos', 'usuarios', 'empleados', 'clientes', 'productos', 'ventas'];

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
        case 'cargos':
        case 'productos':
        case 'clientes':
        case 'empleados':
        case 'usuarios':
            if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['rol'])) {
                $controllerName = ucfirst($vista) . 'Controller';
                $fullControllerName = '\\controllers\\' . $controllerName;

                if (class_exists($fullControllerName)) {
                    $controller = new $fullControllerName();

                    if (method_exists($controller, $action)) {
                        /*Nota:
                            1. array_slice(): Se utiliza para extraer una porción de un array y la devuelve como un nuevo array, sin modificar el original.
                                1.1 Sintaxis: array_slice($array, $offset, $length, $preserve_keys)
                                1.2 $array: El array del cual se extraerá la porción, en este caso, $request.
                                1.3 offset: Indica el índice de posición desde donde se empezará a extraer. En este caso, 2, porque queremos los elementos después de $vista y $acción.
                        */
                        $params = array_slice($request, 2);
                        //Se verifica si hay parámetros adicionales en la URL luego de el $vista y $acción
                        if (count($params) > 0) {
                            /*Nota:
                                1. call_user_func_array(): Permite llamar a una función de una clase pasando el valor de sus parametros como un array.
                                    1.1 Sintaxis: call_user_func_array(callable $callback, array $args)
                                    1.2 $callback: Un array que contiene el objeto y el nombre del método a llamar, en este caso, [$controller, $action].
                                        1.2.1. $controller: La instancia del controlador que contiene el método a llamar.
                                        1.2.2. $action: El nombre del método a llamar dentro del controlador.
                                    1.3 $args: Un array donde sus valores son los parámetros que se pasarán al método llamado. En este caso, $params.
                            */
                            call_user_func_array([$controller, $action], $params);
                        } else {
                            $controller->$action();
                        }
                    } else {
                        http_response_code(404);
                        exit();
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
