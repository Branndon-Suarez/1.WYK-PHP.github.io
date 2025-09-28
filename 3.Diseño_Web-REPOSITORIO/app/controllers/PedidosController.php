<?php

namespace controllers;

use \models\PedidoModel;
use const \config\APP_URL;
use Exception;

class PedidosController
{
    private $pedidoModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
    }

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

    public function guardar()
    {
        header('Content-Type: application/json');

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data) {
                http_response_code(400); // Bad Request
                echo json_encode([
                    "success" => false,
                    "message" => "Datos de pedido no válidos o vacíos."
                ]);
                exit();
            }

            if (!isset($data['fecha'], $data['estadoPedido'], $data['estadoPago'], $data['usuarioId'], $data['productos'])) {
                http_response_code(400);
                throw new Exception("Faltan campos obligatorios en el pedido (fecha, estados, usuarioId, productos).");
            }

            // Llamada al modelo
            $idVenta = $this->pedidoModel->guardarPedido($data);

            echo json_encode([
                "success" => true,
                "message" => "Pedido guardado con éxito.",
                "idVenta" => $idVenta
            ]);
            exit();
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Error interno del servidor: " . $e->getMessage()
            ]);
            exit();
        }
    }

    // ... Las funciones listar y ver no necesitan ser modificadas a menos que uses los nuevos estados allí.
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
