<?php
require_once 'Config.php';
require_once 'Database.php';

class Database {
    private $dbConnector;

    public function __construct(){

        $host = Config::$db["host"];
        $user = Config::$db["user"]; //change to user when deploy server maybe
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
        $this->createUsersTable();
        $this->createSubleaseTable();
    }

    private function createUsersTable(){
        $createQuery = "
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            phone BIGINT UNIQUE,
            password VARCHAR(255)
        );
    ";
    $result = pg_query($this->dbConnector, $createQuery);
    if (!$result) {
        error_log('Failed to create tables: ' . pg_last_error($this->dbConnector));
        throw new Exception('Failed to create tables');
    }
    }

    private function createSubleaseTable(){
        $createQuery = "
            CREATE TABLE IF NOT EXISTS subleases (
                house_id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL,
                area VARCHAR(255),
                description TEXT,
                location VARCHAR(255),
                address VARCHAR(255),
                gender VARCHAR(50),
                furnished BOOLEAN,
                subleaseFee INTEGER,
                pet BOOLEAN,
                image VARCHAR(255),
                CONSTRAINT fk_user
                    FOREIGN KEY(user_id) 
                        REFERENCES users(id)
                        ON DELETE CASCADE
            );
        ";
        $result = pg_query($this->dbConnector, $createQuery);
        if (!$result) {
            error_log('Failed to create subleases table: ' . pg_last_error($this->dbConnector));
            throw new Exception('Failed to create subleases table');
        }
    }

    
    public function getDbConnector() {
        return $this->dbConnector;
    }



}