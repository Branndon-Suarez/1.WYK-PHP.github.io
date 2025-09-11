<?php
namespace app\models;

class viewsModel {
    protected function obtenerVistasModelo($vista) {
        $listaBlanca = ["home", "login"]; // Vistas permitidas
        
        if (in_array($vista, $listaBlanca)) {
            if ($vista == "home" && is_file(__DIR__ . '/../views/home.php')) {
                return "home";
            } elseif ($vista == "login" && is_file(__DIR__ . '/../views/users/userLogin/login.php')) {
                return "login";
            } else {
                return "404"; // Vista no encontrada
            }
        } elseif ($vista == "index") {
            return "home"; // Redirigir index a home
        } else {
            return "404"; // Vista no permitida
        }
    }
}
