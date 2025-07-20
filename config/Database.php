<?php

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private string $servername;
    private string $username;
    private string $password;
    private string $dbname;

    private function __construct()
    {

        $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = 'Prakash@123$';
        $this->dbname = 'quickplate';

        $data = "mysql:host={$this->servername};dbname={$this->dbname};charset=utf8mb4";

        try {
            $this->connection = new PDO($data, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception("Unable to connect to the database: " . $e->getMessage());
        }
    }


    //singleton pattern to ensure only one instance of database in made and prevent multiple instance
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
