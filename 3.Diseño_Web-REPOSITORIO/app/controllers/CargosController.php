<?php
namespace controllers;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\CargoModel;
use const \config\APP_URL;

class CargosController {
    private $cargoModel;

    public function __construct() {
        $this->cargoModel = new CargoModel();
    }

     public function reports() {
        require_once __DIR__ . '/../views/layouts/heads/headDashboard.php';
        require_once __DIR__ . '/../views/cargo/dashboardCargo.php';

    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCargo = $_POST['Nom_Cargo'];
            try {
                $result = $this->cargoModel->createCargo($nombreCargo);
                if ($result) {
                    $_SESSION['success_message'] = 'Cargo creado exitosamente.';
                    header('Location: ' . APP_URL . 'cargos');
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Error al crear el cargo.';
                    exit();
                }
            } catch (\Exception $e) {
                $_SESSION['error_message'] = 'Excepción al crear el cargo: ' . $e->getMessage();
            }
        }
        require_once __DIR__ . '/../views/cargo/create.php';
        exit();
    }
}
