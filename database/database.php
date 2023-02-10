<?php
class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct($host, $db_name, $username, $password)
    {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
    }

    public function getConnection()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            throw new Exception("Error connecting to the database: " . $exception->getMessage());
        }
        return $this->conn;
    }

    public function runQuery($sql, $data = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $exception) {
            throw new Exception("Error running query: " . $exception->getMessage());
        }
        return $stmt;
    }

    public function getRowCount($stmt)
    {
        return $stmt->rowCount();
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}
