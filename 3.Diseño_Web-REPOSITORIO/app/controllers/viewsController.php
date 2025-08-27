<?php
    namespace app\controllers;
    use app\models\viewsModel;

    class viewsController extends viewsModel{
        public function obtenerVistasControlador($vista){
            if (isset($vista)) {
                /*enviar valor $vista al Modelo*/
                $respuesta = $this->obtenerVistasModelo($vista);
            } else {
                $respuesta = "login";
            }
            return $respuesta;
        }
    }
