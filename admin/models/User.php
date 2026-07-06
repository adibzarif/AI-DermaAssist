<?php
require_once __DIR__ . '/../config/database.php';

class User {

    public static function all(){
        return Database::connect()->query("SELECT * FROM users");
    }

    public static function count(){
        return Database::connect()
            ->query("SELECT COUNT(*) as total FROM users")
            ->fetch_assoc()['total'];
    }

    public static function delete($id){
        Database::connect()->query("DELETE FROM users WHERE id=$id");
    }
}