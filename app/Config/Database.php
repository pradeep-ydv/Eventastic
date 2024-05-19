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
        $this->conn = $this->connectDB();
        if ($this->conn) {
            echo "Database connected";
        }
        date_default_timezone_set('Asia/Kolkata');
    }

    private function connectDB()
    {
        try {
            $conn = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Failed to connect to the database: " . $e->getMessage();
            exit();
        }
    }

    function __destruct()
    {
        $this->conn = null;
    }
}
