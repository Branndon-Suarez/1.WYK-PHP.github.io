<?php
namespace app\controllers;
use app\models\viewsModel;

class viewsController extends viewsModel {
    public function obtenerVistasControlador($vista) {
        // Sanitizar el nombre de la vista
        $vista = preg_replace('/[^a-zA-Z0-9]/', '', $vista);
        
        if (!empty($vista)) {
            // Enviar valor $vista al Modelo
            $respuesta = $this->obtenerVistasModelo($vista);
        } else {
            $respuesta = "home"; // Vista por defecto
        }
        return $respuesta;
    }
}
