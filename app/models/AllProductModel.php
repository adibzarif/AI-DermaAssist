<?php
require_once __DIR__ . '/../helpers/Database.php';

class AllProductModel {

    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    // Filter dropdowns
    public function getProblems() {
        return $this->db->query("SELECT * FROM skin_problems ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTypes() {
        return $this->db->query("SELECT * FROM skin_types ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTones() {
        return $this->db->query("SELECT * FROM skin_tones ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Most loved / recent products
    public function getPopular() {
        return $this->db->query("SELECT * FROM products ORDER BY id DESC LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
    }

    // User wishlist product IDs
    public function getUserWishlist($user_id) {
        $stmt = $this->db->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'product_id');
    }

    // Search by keyword (name, brand, description, ingredient)
    public function searchProducts($keyword) {
        $kw   = "%$keyword%";
        $stmt = $this->db->prepare("
            SELECT DISTINCT p.*
            FROM products p
            LEFT JOIN product_ingredients pi ON p.id = pi.product_id
            LEFT JOIN ingredients i ON pi.ingredient_id = i.id
            WHERE
                LOWER(p.name)        LIKE LOWER(?) OR
                LOWER(p.brand)       LIKE LOWER(?) OR
                LOWER(p.description) LIKE LOWER(?) OR
                LOWER(i.name)        LIKE LOWER(?)
        ");
        $stmt->execute([$kw, $kw, $kw, $kw]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Filter by skin problem
    public function filterByProblem($problem_id) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT p.* FROM products p
            JOIN product_skinproblems sp ON p.id = sp.product_id
            WHERE sp.problem_id = ?
        ");
        $stmt->execute([$problem_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Filter by skin type
    public function filterByType($type_id) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT p.* FROM products p
            JOIN product_skintypes st ON p.id = st.product_id
            WHERE st.skintype_id = ?
        ");
        $stmt->execute([$type_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Filter by skin tone
    public function filterByTone($tone_id) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT p.* FROM products p
            JOIN product_skintones st ON p.id = st.product_id
            WHERE st.skintone_id = ?
        ");
        $stmt->execute([$tone_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Single product detail
    public function getProduct($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ingredients for a product
    public function getIngredients($product_id) {
        $stmt = $this->db->prepare("
            SELECT i.name FROM ingredients i
            JOIN product_ingredients pi ON i.id = pi.ingredient_id
            WHERE pi.product_id = ?
        ");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Buy URL for a product
    public function getProductUrl($product_id) {
        $stmt = $this->db->prepare("SELECT url FROM product_prices WHERE product_id = ? LIMIT 1");
        $stmt->execute([$product_id]);
        return $stmt->fetchColumn();
    }

    // Products grouped by problem (for browse sections)
    public function getProductsByProblem($problem_id) {
        $stmt = $this->db->prepare("
            SELECT p.* FROM products p
            JOIN product_skinproblems sp ON p.id = sp.product_id
            WHERE sp.problem_id = ?
        ");
        $stmt->execute([$problem_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Products grouped by type
    public function getProductsByType($type_id) {
        $stmt = $this->db->prepare("
            SELECT p.* FROM products p
            JOIN product_skintypes st ON p.id = st.product_id
            WHERE st.skintype_id = ?
        ");
        $stmt->execute([$type_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Products grouped by tone
    public function getProductsByTone($tone_id) {
        $stmt = $this->db->prepare("
            SELECT p.* FROM products p
            JOIN product_skintones st ON p.id = st.product_id
            WHERE st.skintone_id = ?
        ");
        $stmt->execute([$tone_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
