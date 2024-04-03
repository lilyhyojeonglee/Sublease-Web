<?php
class Database {
    private $dbConnector;

    public function __contruct(){

        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["password"];
        $port = Config::$db["port"];

        $this->dbConnector = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");
        $this->createDatabases();
    }

    public function createDatebases(){

    }



}