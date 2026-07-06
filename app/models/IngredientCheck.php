<?php
require_once __DIR__ . '/../helpers/Database.php';

class IngredientCheck {

    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    // Search ingredients by name (partial match)
    public function search($query) {
        $stmt = $this->db->prepare("
            SELECT name, safety, notes
            FROM ingredients
            WHERE LOWER(name) LIKE LOWER(?)
            ORDER BY name ASC
        ");
        $stmt->execute(['%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
