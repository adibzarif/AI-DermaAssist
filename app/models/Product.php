<?php
require_once __DIR__ . '/../helpers/Database.php';

class ProductModel {

    // Get all products
    public static function all() {
        $db = Database::get();
        $sql = "
            SELECT 
                p.*,
                MIN(pp.price) AS price,
                MIN(pp.url) AS url
            FROM products p
            LEFT JOIN product_prices pp ON p.id = pp.product_id
            GROUP BY p.id
            ORDER BY p.id DESC
        ";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find product by ID
    public static function find($id) {
        $db = Database::get();
        $stmt = $db->prepare("
            SELECT 
                p.*,
                MIN(pp.price) AS price,
                MIN(pp.url) AS url
            FROM products p
            LEFT JOIN product_prices pp ON p.id = pp.product_id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ⭐ MAIN FUNCTION: AI-BASED Recommendation
    public static function recommend($problem, $type, $tone) {
        $db = Database::get();

        $sql = "
            SELECT DISTINCT p.*, 
                MIN(pp.price) AS price,
                MIN(pp.url) AS url
            FROM products p

            LEFT JOIN product_skinproblems sp ON sp.product_id = p.id
            LEFT JOIN skin_problems prob ON prob.id = sp.problem_id

            LEFT JOIN product_skintypes st ON st.product_id = p.id
            LEFT JOIN skin_types t ON t.id = st.skintype_id

            LEFT JOIN product_skintones sn ON sn.product_id = p.id
            LEFT JOIN skin_tones tn ON tn.id = sn.skintone_id

            LEFT JOIN product_prices pp ON pp.product_id = p.id

            WHERE prob.name = :problem
               OR t.name = :type
               OR tn.name = :tone

            GROUP BY p.id
            ORDER BY price ASC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':problem' => $problem,
            ':type'    => $type,
            ':tone'    => $tone
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
