<?php
spl_autoload_register(function($className) {
    $classPath = str_replace('\\', '/', $className);
        $archivo = __DIR__ . '/' . $classPath . '.php';
    
    if (is_file($archivo)) {
        require_once $archivo;
    } else {
        error_log("Error autocargador: Clase $className no encontrada en: $archivo");
    }
});
