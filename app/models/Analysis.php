<?php
require_once __DIR__ . '/../helpers/Database.php';

class Analysis {

    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    // 1. Save a new analysis record
    public function saveAnalysis($user_id, $problem, $skintype, $skintone, array $result) {
        $stmt = $this->db->prepare("
            INSERT INTO analysis_history (user_id, problem, skintype, skintone, result_json)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $user_id,
            $problem,
            $skintype,
            $skintone,
            json_encode($result),
        ]);
        return $this->db->lastInsertId();
    }

    // 2. Get all products (id + name) for the product-search modal
    public function getAllProducts() {
        $stmt = $this->db->query("SELECT id, name FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
