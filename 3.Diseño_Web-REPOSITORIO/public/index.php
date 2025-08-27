<?php
echo "<!-- Iniciando index.php -->";

echo "Ruta actual: " . __DIR__ . "<br>";
echo "Buscando autoload en: " . __DIR__ . '/../app/autoload.php' . "<br>";
$autoloadPath = __DIR__ . '/../app/autoload.php';
// Verificar si el archivo existe
if (file_exists($autoloadPath)) {
    echo "<!-- autoload.php ENCONTRADO -->";
    require_once $autoloadPath;
    echo "<!-- autoload.php CARGADO -->";
} else {
    echo "<!-- ERROR: autoload.php NO ENCONTRADO -->";
    // Listar archivos en el directorio para debug
    $files = scandir(__DIR__ . '/../');
    echo "<!-- Archivos en app/: " . implode(', ', $files) . " -->";
    die("Error: No se puede encontrar autoload.php");
}