<?php
    namespace app\models;
    class viewsModel{
        protected function obtenerVistasModelo($vista){
            $listaBlanca = ["dashboard"];//Obtener todas las palabras de la URL.

            /*'in_array()' : Función pred. php que verifica si un valor específico existe dentro de un array.
                Sintaxis: in_array('valor_encontrar',$array);
                Uso en el código: si el nombre de la vista existe en el array $listaBlanca*/
            if (in_array($vista,$listaBlanca)){
                /*'is_file() : Función pred. php que verifica si un archivo existe o no es un directorio'*/
                if (is_file("./app/views/content/".$vista."-view.php")){
                    $contenido = "./app/views/content/".$vista."-view.php";
                }else{
                    $contenido = "404";
                }
            }elseif ($vista=="login" || $vista=="index"){
                $contenido = "login";
            }else {
                $contenido = "404";
            }

            return $contenido;
        }
    }
