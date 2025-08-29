<?php
spl_autoload_register(function($className) {
    $classPath = str_replace('app\\', '', $className);
    $classPath = str_replace('\\', '/', $classPath);
    $archivoApp = __DIR__ . '/' . $classPath . '.php';
    $archivoConfig = dirname(__DIR__) . '/config/' . basename($classPath) . '.php';

    error_log("Buscando clase en: $archivoApp");
    if (is_file($archivoApp)) {
        require_once $archivoApp;
    } elseif (is_file($archivoConfig)) {
        error_log("Buscando clase en: $archivoConfig");
        require_once $archivoConfig;
    } else {
        error_log("Error autocargador: Clase $className no encontrada en: $archivoApp ni en: $archivoConfig");
    }
});
