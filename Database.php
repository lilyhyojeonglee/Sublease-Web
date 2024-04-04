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

    public function convertDataToJson() {
        // SQL query to fetch all listings
        $query = "SELECT * FROM subleases";
        $result = pg_query($this->dbConnector, $query);

        if (!$result) {
            error_log('Query failed: ' . pg_last_error($this->dbConnector));
            throw new Exception('Query failed');
        }

        $listings = [];

        while ($row = pg_fetch_assoc($result)) {
            $listing = [
                "house_id" => $row['house_id'],
                "propertyDetails" => [
                    "name" => $row['name'], 
                    "description" => $row['description'],
                    "location" => $row['location'], //maybe need modification, since we will get longtitude and latitude using api
                    "address" => $row['address'],
                    "image" => $row['image']
                ],
                "rentalTerms" => [
                    "gender" => $row['gender'],
                    "furnished" => (bool) $row['furnished'], // Cast to boolean for JSON
                    "subleasefee" => $row['subleasefee'],
                    "pet" => (bool) $row['pet'] // Cast to boolean for JSON
                ]
            ];

            $listings[] = $listing;
        }

        // Convert the $listings array to JSON
        $jsonData = json_encode($listings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($jsonData === false) {
            error_log('JSON encode failed: ' . json_last_error_msg());
            throw new Exception('JSON encode failed');
        }

        // Write JSON data to file
        $filePath = 'data/data.json';
        if (file_put_contents($filePath, $jsonData) === false) {
            error_log('Failed to write JSON data to file');
            throw new Exception('Failed to write JSON data to file');
        }

        echo "Data successfully written to {$filePath}";
    }

}


