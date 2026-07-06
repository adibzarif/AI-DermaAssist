<?php
require_once __DIR__ . '/../config/database.php';

class Ingredient {

    public static function all() {
        $db = Database::connect();
        return $db->query("SELECT * FROM ingredients");
    }

    public static function getPaginated($limit, $offset) {
        $db = Database::connect();
        return $db->query("SELECT * FROM ingredients LIMIT $limit OFFSET $offset");
    }

    public static function countAll() {
        $db = Database::connect();
        return $db->query("SELECT COUNT(*) as total FROM ingredients")
                ->fetch_assoc()['total'];
    }

    public static function create($name, $safety, $notes) {
        $db = Database::connect();

        $name = $db->real_escape_string($name);
        $safety = $db->real_escape_string($safety);
        $notes = $db->real_escape_string($notes);

        $db->query("
            INSERT INTO ingredients (name, safety, notes) 
            VALUES ('$name', '$safety', '$notes')
        ");
    }

    public static function delete($id){
        $db = Database::connect();
        $db->query("DELETE FROM ingredients WHERE id=$id");
    }

    public static function update($id, $name, $safety, $notes){
    $db = Database::connect();

    $name = $db->real_escape_string($name);
    $safety = $db->real_escape_string($safety);
    $notes = $db->real_escape_string($notes);

    $db->query("
        UPDATE ingredients 
        SET name='$name', safety='$safety', notes='$notes'
        WHERE id=$id
    ");
}
}