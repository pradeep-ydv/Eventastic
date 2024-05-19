<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    protected $conn   = null;
    private $host     = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "eventastic";

    function __construct()
    {
        try {
            $this->createConnection();
            // echo "Database connected";
        } catch (PDOException $e) {
            echo "Failed to connect to the database: " . $e->getMessage();
            exit;
        }
        date_default_timezone_set('Asia/Kolkata');
    }

    private function createConnection()
    {
        $this->conn = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function __destruct()
    {
        $this->conn = null;
    }
}
