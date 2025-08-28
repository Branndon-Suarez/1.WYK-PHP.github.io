<?php
namespace config;
use PDO;
use PDOException;

class Connection {
    protected $db;
    private $dbType = 'mysql';
    private $host = 'localhost';
    private $dbName = 'PROYECTO_WYK';
    private $user = 'root';
    private $pass = '';

    public function __construct() {
        try {
            $this->db = new PDO(
                "{$this->dbType}:host={$this->host};dbname={$this->dbName}",
                $this->user,
                $this->pass
            );

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->db;
        } catch (PDOException $exception) {
            echo "Error de conexión a la base de datos: " . $exception->getMessage();
            exit;
        }
    }
}
