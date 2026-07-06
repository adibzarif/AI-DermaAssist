<?php
require_once __DIR__ . '/../helpers/Database.php';
class UserModel {
    public static function create($name,$email,$password){
        $pdo = Database::get();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name,email,password_hash) VALUES (?,?,?)');
        $stmt->execute([$name,$email,$hash]);
        return $pdo->lastInsertId();
    }
    public static function all(){ return Database::get()->query('SELECT id,name,email,role,created_at FROM users')->fetchAll(); }
}
?>