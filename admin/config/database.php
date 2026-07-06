<?php
class Database {
    public static function connect() {
        $host = getenv('DB_HOST') ?: "localhost";
        $user = getenv('DB_USER') ?: "root";
        $pass = getenv('DB_PASS') ?: "";
        $name = getenv('DB_NAME') ?: "skin_fyp";
        $port = getenv('DB_PORT') ?: "3306";

        $conn = new mysqli($host, $user, $pass, $name, $port);

        if ($conn->connect_error) {
            die("DB Error: " . $conn->connect_error);
        }

        return $conn;
    }
}