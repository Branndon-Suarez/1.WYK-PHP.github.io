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

    /*private static $db;

    private static $dbType = 'mysql';
    private static $host = 'sql306.infinityfree.com';
    private static $dbName = 'if0_39799237_proyecto_wyk';
    private static $user = 'if0_39799237';
    private static $pass = 'Q2Ffn9gQHt7aZrH'; */

    /* Nota: El constructor es privado para evitar instanciaciones directas */
    private function __construct() {}
 
    public static function getConnection() {
        if (self::$db === null) {
            try {
                self::$db = new PDO(
                    self::$dbType . ':host=' . self::$host . ';dbname=' . self::$dbName,
                    self::$user,
                    self::$pass
                );

                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                self::$db->exec("SET NAMES 'utf8mb4'");
            } catch (PDOException $e) {
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                die("Error de conexión a la base de datos. Por favor, inténtelo de nuevo más tarde.");
            }
        }
        return self::$db;
    }
}

