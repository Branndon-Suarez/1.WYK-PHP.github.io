<?php
spl_autoload_register(function ($className) {
    // dirname(__DIR__) te lleva a la carpeta raíz del proyecto.
    $baseDir = dirname(__DIR__) . '/';
    // Convierte el nombre de la clase con su namespace en una ruta de archivo.
    $filePath = str_replace('\\', '/', $className);

    // Construye la ruta completa al archivo.
    $fullPath = $baseDir . 'app/' . $filePath . '.php';

    // Si el archivo existe, cárgalo.
    if (file_exists($fullPath)) {
        require_once $fullPath;
    } else {
        // Maneja el caso especial para la carpeta 'config'
        $configPath = $baseDir . 'config/' . str_replace('config\\', '', $className) . '.php';
        if (file_exists($configPath)) {
            require_once $configPath;
        } else {
            error_log("Error autocargador: Clase $className no encontrada.");
        }
    }
});