<?php

namespace controllers;

use \models\PedidoModel;
use const \config\APP_URL;
use Exception;

class PedidosController
{
    private $pedidoModel;

    public function __construct() {
        $this->pedidoModel = new PedidoModel();
    }

    /**
     * Listar todos los pedidos
     */
    public function listar()
    {
        try {
            $pedidos = $this->pedidoModel->obtenerPedidos();
            echo json_encode([
                'success' => true,
                'data' => $pedidos
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Guardar un nuevo pedido
     */
    public function guardar() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                throw new Exception("Datos de pedido no válidos.");
            }

            if (!isset($data['fecha'], $data['mesa'], $data['estado'], $data['usuarioId'], $data['productos'])) {
                throw new Exception("Faltan campos obligatorios en el pedido.");
            }

            $idVenta = $this->pedidoModel->guardarPedido($data);

            return [
                "success" => true,
                "message" => "Pedido guardado con éxito.",
                "idVenta" => $idVenta
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => "Error interno del servidor: " . $e->getMessage()
            ];
        }
    }

    /**
     * Mostrar un pedido por ID
     */
    public function ver($idVenta)
    {
        try {
            $pedido = $this->pedidoModel->obtenerPedidoPorId($idVenta);

            if (!$pedido) {
                throw new Exception("No se encontró el pedido con ID: $idVenta");
            }

            echo json_encode([
                'success' => true,
                'data' => $pedido
            ]);
        } catch (Exception $e) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}