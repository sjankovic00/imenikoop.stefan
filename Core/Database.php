<?php
namespace Core;
use PDO;

class Database{
    public $stmt;
    public $connection;
    public function __construct($config){
        $dsn="mysql:host={$config['database']['host']};dbname={$config['database']['dbname']};port={$config['database']['port']};charset={$config['database']['charset']}";

        $this->connection = new PDO(
            $dsn,
            $config['database']['username'],
            $config['database']['password'],
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    }
    public function query($query,$params = []){
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->execute($params);
        return $this->stmt;
    }
    public function fetch() {
        return $this->stmt->fetch();
    }

    public function fetchAll() {
        return $this->stmt->fetchAll();
    }
}