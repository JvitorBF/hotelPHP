<?php
class Database
{
    private $host = "localhost";
    private $db_name = "hotel";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function runQuery($sql, $data = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $exception) {
            echo "Query error: " . $exception->getMessage();
        }
        return $stmt;
    }

    public function getRowCount($stmt)
    {
        return $stmt->rowCount();
    }

    public function closeConnection()
    {
        $this->conn = null;
    }
}
