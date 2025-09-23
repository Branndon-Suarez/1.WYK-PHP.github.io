<?php

namespace controllers;

use \models\ProductoModel;

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
}
