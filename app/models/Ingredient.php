<?php
require_once __DIR__ . '/../helpers/Database.php';
class IngredientModel {
    public static function search($term){
        $pdo = Database::get();
        $stmt = $pdo->prepare('SELECT * FROM ingredients WHERE name LIKE ? LIMIT 100');
        $stmt->execute(['%'.$term.'%']);
        return $stmt->fetchAll();
    }
    public static function all(){ return Database::get()->query('SELECT * FROM ingredients ORDER BY id DESC')->fetchAll(); }
    public static function create($name,$safety,$notes){ $pdo = Database::get(); $stmt = $pdo->prepare('INSERT INTO ingredients (name,safety,notes) VALUES (?,?,?)'); $stmt->execute([$name,$safety,$notes]); return $pdo->lastInsertId(); }
}
?>