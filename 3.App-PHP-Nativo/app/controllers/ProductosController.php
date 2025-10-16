<?php

namespace controllers;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \models\ProductoModel;
use const \config\APP_URL;
use \Dompdf\Dompdf;
use \Dompdf\Options;

class ProductosController
{
    private $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }

    public function listar()
    {
        try {
            $productos = $this->productoModel->listarProductos();

            header('Content-Type: application/json');
            echo json_encode($productos);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function checkAdminAccess()
    {
        if (!isset($_SESSION['rolClasificacion']) || $_SESSION['rolClasificacion'] !== 'ADMINISTRADOR') {
            $_SESSION['error_message'] = 'Acceso denegado. No tienes permisos de administrador.';
            header('Location: ' . APP_URL . 'dashboard');
            exit();
        }
    }

    public function reports()
    {
        $this->checkAdminAccess();

        $dashboardDataProductos = [
            'productosExistentes' => $this->productoModel->getCantProdExistentes(),
            'productosActivos' => $this->productoModel->getCantProdActivos(),
            'productosInactivos' => $this->productoModel->getCanProdInactivos(),
            'productos' => $this->productoModel->getProductos()
        ];

        // Mensajes de sesión
        $success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
        if (isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }
        // variable sidebar
        $active_page = 'usuarios';

        require_once __DIR__ . '/../views/layouts/heads/headDashboard.php';
        require_once __DIR__ . '/../views/producto/dashboardProducto.php';
    }

    public function getProductosAjax() {
        $this->checkAdminAccess();
        header('Content-Type: application/json');
        try {
            $productos = $this->productoModel->getProductos();
            echo json_encode(['success' => true, 'data' => $productos]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }

    public function create()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProd = $_POST['id_prod'];
            $nombreProd = $_POST['name_prod'];
            $valorUnitProd = $_POST['valor_unit_prod'];
            $cantExistProd = $_POST['cant_exist_prod'];
            $fechVencProd = $_POST['fech_venc_prod'];
            $tipoProd = $_POST['tipo_prod'];
            try {
                if ($this->productoModel->checkIfProdExists($idProd, $nombreProd)) {
                    echo json_encode(['success' => false, 'message' => 'El producto ya existe.']);
                    return;
                }

                $result = $this->productoModel->createProducto($idProd, $nombreProd, $valorUnitProd, $cantExistProd, $fechVencProd, $tipoProd);
                if ($result) {
                    // Si es exitoso, responde con un JSON de éxito.
                    echo json_encode(['success' => true, 'message' => 'Producto creado exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al crear el producto.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
            }
            exit();
        } else {
            require_once __DIR__ . '/../views/layouts/heads/headForm.php';
            require_once __DIR__ . '/../views/producto/create.php';
        }
    }

    public function viewEdit($id)
    {
        $this->checkAdminAccess();

        $producto = $this->productoModel->obtenerProductoPorId($id);
        if ($producto) {
            require_once __DIR__ . '/../views/layouts/heads/headForm.php';
            require_once __DIR__ . '/../views/producto/update.php';
        } else {
            $_SESSION['error_message'] = 'Producto no encontrado.';
            header('Location: ' . \config\APP_URL . 'productos');
            exit();
        }
    }

    public function update()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProd = $_POST['Id_Prod'];
            $nombreProd = $_POST['name_prod'];
            $valorUnitProd = $_POST['valor_unit_prod'];
            $cantExistProd = $_POST['cant_exist_prod'];
            $fechVencProd = $_POST['fech_venc_prod'];
            $tipoProd = $_POST['tipo_prod'];
            $estadoProd = $_POST['estado_producto'];
            try {
                $result = $this->productoModel->updateProducto($idProd, $nombreProd, $valorUnitProd, $cantExistProd, $fechVencProd, $tipoProd, $estadoProd);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Producto actualizado exitosamente.']);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto.']);
                    exit();
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
                exit();
            }
        }
    }

    public function updateState()
    {
        $this->checkAdminAccess();

        //Verificar que la petición sea POST y que el contenido sea JSON.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido o tipo de contenido incorrecto.']);
            return;
        }

        //Decodificar el JSON del cuerpo de la petición.
        $data = json_decode(file_get_contents('php://input'), true);

        //Validar que los datos necesarios (id y estado) estén presentes.
        if (isset($data['id']) && isset($data['estado'])) {
            $idProd = $data['id'];
            $estadoProd = $data['estado'];

            try {
                //Llamar al método del modelo para actualizar la base de datos.
                $result = $this->productoModel->updateProdState($idProd, $estadoProd);

                //Enviar una respuesta JSON al cliente (el JavaScript).
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Estado del prodcuto actualizado.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo actualizar el estado del prodcuto.']);
                }
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos.']);
        }
    }

    public function delete()
    {
        $this->checkAdminAccess();
        //Verificar que la petición sea POST y que el contenido sea JSON
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido o tipo de contenido incorrecto.']);
            return;
        }

        //Leer y decodificar el JSON del cuerpo de la petición
        $data = json_decode(file_get_contents('php://input'), true);

        //Validar que el ID esté presente
        if (isset($data['id'])) {
            $idProd = $data['id'];

            try {
                //Llamar al modelo para eliminar el registro
                $result = $this->productoModel->deleteProd($idProd);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Producto eliminado con éxito.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'No se pudo eliminar el producto. Esta relacionado con otro(s) registros']);
                }
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos.']);
        }
    }

    // ----------------- REPORTE EN PDF ----------------------------
    public function generateReportPDF()
    {
        // Captura todos los parámetros GET para pasarlos al modelo
        $filtros = $_GET;

        // Llama al modelo para obtener los datos filtrados
        $this->usuarioModel = new \models\UsuarioModel();
        $usuarios = $this->usuarioModel->getFilteredUsuarios($filtros);

        // Generación del HTML para el PDF con los datos filtrados
        $html = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Usuarios</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            .header { width: 100%; text-align: center; position: fixed; top: 0px; background-color: #f0f0f0; padding: 10px 0; }
            .footer { width: 100%; text-align: center; position: fixed; bottom: 0px; font-size: 10px; color: #555; }
            .content { margin-top: 60px; margin-bottom: 30px; padding: 20px; }
            h1 { font-size: 20px; color: #333; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; word-wrap: break-word; }
            th { background-color: #45341fd8; color: white; }
        </style>
    </head>
    <body>
        <div class="header"><h1>Reporte de Usuarios - Panaderia Wyk</h1></div>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Fecha de Registro</th>
                    </tr>
                </thead>
                <tbody>';

        if (!empty($usuarios)) {
            foreach ($usuarios as $usuario) {
                $estado = ($usuario['ESTADO_USUARIO'] == 1) ? 'Activo' : 'Inactivo';
                $html .= '
            <tr>
                <td>' . htmlspecialchars($usuario['NUM_DOC']) . '</td>
                <td>' . htmlspecialchars($usuario['NOMBRE']) . '</td>
                <td>' . htmlspecialchars($usuario['TEL_USUARIO']) . '</td>
                <td>' . htmlspecialchars($usuario['EMAIL_USUARIO']) . '</td>
                <td>' . htmlspecialchars($usuario['NOMBRE_ROL']) . '</td>
                <td>' . $estado . '</td>
                <td>' . htmlspecialchars($usuario['FECHA_REGISTRO']) . '</td>
            </tr>';
            }
        } else {
            $html .= '<tr><td colspan="7" style="text-align:center;">No se encontraron usuarios con los filtros aplicados.</td></tr>';
        }

        $html .= '</tbody></table></div></body></html>';

        // Configuración y generación del PDF con Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'landscape');
        $dompdf->render();

        $dompdf->getCanvas()->page_script('
        $font = $fontMetrics->getFont("Arial", "normal");
        $size = 10;
        $page_text = "Página " . $PAGE_NUM . " de " . $PAGE_COUNT;
        $y = $pdf->get_height() - 25;
        $x = $pdf->get_width() - 150;
        $pdf->text($x, $y, $page_text, $font, $size);
    ');

        $dompdf->stream("Reporte_Usuarios.pdf", array("Attachment" => false));
    }
}
