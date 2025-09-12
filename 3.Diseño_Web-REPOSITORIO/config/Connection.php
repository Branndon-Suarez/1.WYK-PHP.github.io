<?php
namespace config;
use PDO;
use PDOException;

class Connection {
    private static $db;

    private static $dbType = 'mysql';
    private static $host = 'localhost';
    private static $dbName = 'PROYECTO_WYK';
    private static $user = 'root';
    private static $pass = '';

    /* protected $db;
    private $dbType = 'mysql';
    private $host = 'sql306.infinityfree.com';
    private $dbName = 'if0_39799237_proyecto_wyk';
    private $user = 'if0_39799237';
    private $pass = 'Q2Ffn9gQHt7aZrH'; */

    private function __construct() {}
 
    public static function getConnection() {
        // Verifica si la conexión ya ha sido establecida
        if (self::$db === null) {
            try {
                // Crea la conexión si no existe
                self::$db = new PDO(
                    self::$dbType . ':host=' . self::$host . ';dbname=' . self::$dbName,
                    self::$user,
                    self::$pass
                );
                
                // Configura el modo de error para que lance excepciones
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Establece la codificación de caracteres a UTF-8
                self::$db->exec("SET NAMES 'utf8mb4'");
            } catch (PDOException $e) {
                // Si la conexión falla, registra el error y termina la ejecución
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                die("Error de conexión a la base de datos. Por favor, inténtelo de nuevo más tarde.");
            }
        }
        
        // Devuelve la instancia de la conexión
        return self::$db;
    }
}

