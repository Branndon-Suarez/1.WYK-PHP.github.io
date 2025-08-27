<?php
spl_autoload_register(function ($className) {
    $baseDirectory = __DIR__.'/';

    $className = str_replace('App\\', '', $className);
    $file = $baseDirectory . str_replace('\\', '/', $className) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});
