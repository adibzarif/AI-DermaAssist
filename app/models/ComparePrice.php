<?php
require_once __DIR__ . '/../helpers/Database.php';

class ComparePrice {

    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    // 1. Get single product by ID
    public function getProduct(int $product_id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute([$product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Get all prices for a product, cheapest first
    public function getPrices(int $product_id): array {
        $stmt = $this->db->prepare("
            SELECT * FROM product_prices
            WHERE product_id = ?
            ORDER BY price ASC
        ");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Get ingredients with safety + suitability info
    public function getIngredients(int $product_id): array {
        $stmt = $this->db->prepare("
            SELECT i.id, i.name, i.safety, i.notes,
                   GROUP_CONCAT(DISTINCT sp.name ORDER BY sp.name SEPARATOR ', ') AS treats,
                   GROUP_CONCAT(DISTINCT
                       CASE WHEN isp.suitability = 'avoid' THEN sp.name END
                       ORDER BY sp.name SEPARATOR ', '
                   ) AS avoids
            FROM   ingredients i
            JOIN   product_ingredients pi ON pi.ingredient_id = i.id
            LEFT JOIN ingredient_skinproblems isp ON isp.ingredient_id = i.id
            LEFT JOIN skin_problems sp             ON sp.id = isp.problem_id
            WHERE  pi.product_id = ?
            GROUP BY i.id, i.name, i.safety, i.notes
        ");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Get skin concerns for a product
    public function getConcerns(int $product_id): array {
        $stmt = $this->db->prepare("
            SELECT sp.name FROM skin_problems sp
            JOIN product_skinproblems psp ON psp.problem_id = sp.id
            WHERE psp.product_id = ?
        ");
        $stmt->execute([$product_id]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'name');
    }

    // 5. Get skin types for a product
    public function getSkinTypes(int $product_id): array {
        $stmt = $this->db->prepare("
            SELECT st.name FROM skin_types st
            JOIN product_skintypes pst ON pst.skintype_id = st.id
            WHERE pst.product_id = ?
        ");
        $stmt->execute([$product_id]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'name');
    }

    // 6. Get skin tones for a product
    public function getSkinTones(int $product_id): array {
        $stmt = $this->db->prepare("
            SELECT stn.name FROM skin_tones stn
            JOIN product_skintones pstn ON pstn.skintone_id = stn.id
            WHERE pstn.product_id = ?
        ");
        $stmt->execute([$product_id]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'name');
    }

    // 7. Get similar products by shared skin concern
    public function getSimilar(int $product_id, array $concerns): array {
        if (empty($concerns)) return [];

        $placeholders = implode(',', array_fill(0, count($concerns), '?'));
        $stmt = $this->db->prepare("
            SELECT DISTINCT p.id, p.name, p.brand, p.image_url,
                   MIN(pp.price) AS price_min,
                   COUNT(DISTINCT pp.store_name) AS store_count
            FROM   products p
            JOIN   product_skinproblems psp ON psp.product_id = p.id
            JOIN   skin_problems sp         ON sp.id = psp.problem_id
            LEFT JOIN product_prices pp     ON pp.product_id = p.id
            WHERE  sp.name IN ($placeholders)
              AND  p.id != ?
            GROUP BY p.id, p.name, p.brand, p.image_url
            ORDER BY price_min ASC
            LIMIT 4
        ");
        $stmt->execute([...$concerns, $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 8. Check if product is wishlisted by user
    public function isWishlisted(int $user_id, int $product_id): bool {
        $stmt = $this->db->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        return (bool) $stmt->fetch();
    }

    // 9. Toggle wishlist (add / remove)
    public function toggleWishlist(int $user_id, int $product_id): bool {
        if ($this->isWishlisted($user_id, $product_id)) {
            $this->db->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?")
                     ->execute([$user_id, $product_id]);
            return false; // removed
        } else {
            $this->db->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)")
                     ->execute([$user_id, $product_id]);
            return true;  // added
        }
    }
}

// ── Helpers ──────────────────────────────────────────────