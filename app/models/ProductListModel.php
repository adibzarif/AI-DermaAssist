<?php
require_once __DIR__ . '/../helpers/Database.php';

class ProductListModel {

    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    // Search products by name or brand
    public function search($keyword) {
        $kw   = "%$keyword%";
        $stmt = $this->db->prepare("
            SELECT DISTINCT p.id, p.name, p.brand, p.description, p.image_url
            FROM products p
            WHERE p.name  LIKE ?
               OR p.brand LIKE ?
            ORDER BY p.name
        ");
        $stmt->execute([$kw, $kw]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
