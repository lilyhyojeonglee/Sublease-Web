<?php
class Config{
    public static $db=[
        "host" => "db",
        "port" => "5432",
        "user" => "localuser",
        "password" => "cs4640LocalUser!",
        "database" => "example"
    ];
}
    // Note that these are for the local Docker container
   

    // $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    // if ($dbHandle) {
    //     echo "Success connecting to database";
    // } else {
    //     echo "An error occurred connecting to the database";
    // }
    