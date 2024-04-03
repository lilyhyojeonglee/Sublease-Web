<?php
class Database {
    private $dbConnector;

    public function __contruct(){

        $host = Config::$db["host"];
        $user = Config::$db["local"]; //change to user when deploy server maybe
        $database = Config::$db["database"];
        $password = Config::$db["password"];
        $port = Config::$db["port"];

        $this->dbConnector = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");
        if (!$this->dbConnector) {
            error_log('Database connection failed');
            throw new Exception('Database connection failed');
        }
        $this->createTables();
    }

    public function createTables(){
        $createQuery = "
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            phone VARCHAR(255) UNIQUE,
            password VARCHAR(255)
        );
    ";
    $result = pg_query($this->dbConnector, $createQuery);
    if (!$result) {
        error_log('Failed to create tables: ' . pg_last_error($this->dbConnector));
        throw new Exception('Failed to create tables');
    }

    }
    public function getDbConnector() {
        return $this->dbConnector;
    }



}