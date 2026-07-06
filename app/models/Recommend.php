<?php
require_once __DIR__ . '/../helpers/Database.php';

class Recommend {

    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    // 1. Get latest analysis for user
    public function getLatestAnalysis($user_id) {
        $stmt = $this->db->prepare("
            SELECT problem, skintype, skintone, result_json
            FROM analysis_history
            WHERE user_id = ?
            ORDER BY created_at DESC
            LIMIT 1
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Get products by skin problem
    public function getProductsByProblem($problem_name) {

        $problem_name = str_replace(' ', '', strtolower($problem_name));

        $stmt = $this->db->prepare("
            SELECT DISTINCT p.*
            FROM products p
            JOIN product_skinproblems sp ON p.id = sp.product_id
            JOIN skin_problems s ON sp.problem_id = s.id
            WHERE REPLACE(LOWER(s.name), ' ', '') = ?
        ");

        $stmt->execute([$problem_name]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 3. Get products by skin type
    public function getProductsBySkinType($skintype) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT p.*
            FROM products p
            JOIN product_skintypes st ON p.id = st.product_id
            JOIN skin_types s ON st.skintype_id = s.id
            WHERE LOWER(s.name) = ?
        ");
        $stmt->execute([$skintype]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Get products by skin tone
    public function getProductsBySkinTone($skintone) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT p.*
            FROM products p
            JOIN product_skintones st ON p.id = st.product_id
            JOIN skin_tones s ON st.skintone_id = s.id
            WHERE LOWER(s.name) = ?
        ");
        $stmt->execute([$skintone]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Preload minimum prices for all products
    public function getMinPrices() {
        $stmt = $this->db->query("
            SELECT pp.product_id,
                   MIN(pp.price) AS min_price,
                   pp.store_name
            FROM product_prices pp
            INNER JOIN (
                SELECT product_id, MIN(price) AS mp
                FROM product_prices
                GROUP BY product_id
            ) AS cheapest ON pp.product_id = cheapest.product_id
                          AND pp.price      = cheapest.mp
            GROUP BY pp.product_id
        ");

        $min_prices = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $min_prices[$row['product_id']] = [
                'price' => floatval($row['min_price']),
                'store' => $row['store_name'],
            ];
        }
        return $min_prices;
    }

    // 6. Save a shopping list session + items
    public function saveShoppingList($user_id, array $items) {
        $this->db->prepare("INSERT INTO shopping_list_sessions (user_id) VALUES (?)")
                 ->execute([$user_id]);
        $session_id = $this->db->lastInsertId();

        $saved = 0;
        foreach ($items as $item) {
            $product_id = intval($item['id'] ?? 0);
            $store      = trim($item['store'] ?? '');
            $price      = isset($item['price']) && $item['price'] !== '' ? floatval($item['price']) : null;
            if (!$product_id) continue;

            $this->db->prepare("
                INSERT INTO shopping_list_items (session_id, product_id, store_name, price)
                VALUES (?, ?, ?, ?)
            ")->execute([$session_id, $product_id, $store ?: null, $price]);
            $saved++;
        }

        return ['session_id' => $session_id, 'saved' => $saved];
    }
}
