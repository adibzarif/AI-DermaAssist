<?php
require_once __DIR__ . '/../helpers/Database.php';

class CheckProducts {

    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    // ── 1. Resolve skin type ID ────────────────────────────
    public function getSkinTypeId($skin_type) {
        $stmt = $this->db->prepare("SELECT id FROM skin_types WHERE name = ?");
        $stmt->execute([$skin_type]);
        return $stmt->fetchColumn();
    }

    // ── 2. Resolve problem IDs → [id => name] ─────────────
    public function getProblemIds(array $skin_problem) {
        $problemRows = [];
        foreach ($skin_problem as $p) {
            $stmt = $this->db->prepare("SELECT id, name FROM skin_problems WHERE name = ?");
            $stmt->execute([$p]);
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $problemRows[$row['id']] = $row['name'];
            }
        }
        return $problemRows;
    }

    // ── 3. Check a DB product by ID ───────────────────────
    public function checkDbProduct(int $pid, $skinTypeId, $skin_type, array $problemRows) {
        $stmt = $this->db->prepare("SELECT name, brand, image_url FROM products WHERE id = ?");
        $stmt->execute([$pid]);
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$productData) return [];

        $stmt = $this->db->prepare("
            SELECT i.id, i.name
            FROM product_ingredients pi
            JOIN ingredients i ON pi.ingredient_id = i.id
            WHERE pi.product_id = ?
        ");
        $stmt->execute([$pid]);
        $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $results = [];
        foreach ($ingredients as $ing) {
            $results[] = $this->evaluateIngredient(
                $ing,
                $productData['name'],
                $productData['brand'],
                $productData['image_url'],
                $skinTypeId,
                $skin_type,
                $problemRows
            );
        }
        return $results;
    }

    // ── 4. Check a custom product (JSON-encoded) ──────────
    public function checkCustomProduct($cp, $skinTypeId, $skin_type, array $problemRows) {
        $cp          = json_decode($cp, true);
        $productName = $cp['name'];
        $ingredients = $cp['ingredients'];

        $results = [];
        foreach ($ingredients as $ingName) {
            $stmt = $this->db->prepare("SELECT id, name FROM ingredients WHERE name LIKE ?");
            $stmt->execute(["%$ingName%"]);
            $ing = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$ing) {
                $results[] = [
                    'type'       => 'neutral',
                    'product'    => $productName,
                    'brand'      => 'Unknown Brand',
                    'image'      => '',
                    'ingredient' => $ingName,
                    'result'     => 'Not found in database',
                ];
                continue;
            }

            $results[] = $this->evaluateIngredient(
                $ing,
                $productName,
                'Unknown Brand',
                '',
                $skinTypeId,
                $skin_type,
                $problemRows
            );
        }
        return $results;
    }

    // ── 5. Core ingredient evaluation (shared logic) ──────
    private function evaluateIngredient(
        array  $ing,
        string $productName,
        string $brand,
        string $image,
        $skinTypeId,
        string $skin_type,
        array  $problemRows
    ) {
        $finalType = null;
        $message   = '';

        // Skin type check
        $stmt = $this->db->prepare("
            SELECT suitability
            FROM ingredient_skintypes
            WHERE ingredient_id = ? AND skintype_id = ?
        ");
        $stmt->execute([$ing['id'], $skinTypeId]);
        $type = $stmt->fetchColumn();

        if ($type === 'bad') {
            $finalType = 'danger';
            $message   = "Not suitable for {$skin_type} skin";
        } elseif ($type === 'good' && !$finalType) {
            $finalType = 'good';
            $message   = "Good for your {$skin_type} skin";
        }

        // Skin problem checks
        foreach ($problemRows as $probId => $problemName) {
            $stmt = $this->db->prepare("
                SELECT suitability
                FROM ingredient_skinproblems
                WHERE ingredient_id = ? AND problem_id = ?
            ");
            $stmt->execute([$ing['id'], $probId]);
            $prob = $stmt->fetchColumn();

            if ($prob === 'avoid') {
                $finalType = 'danger';
                $message   = "May worsen {$problemName}";
            } elseif ($prob === 'treats' && !$finalType) {
                $finalType = 'good';
                $message   = "Helps your {$problemName}";
            }
        }

        return [
            'type'       => $finalType ?? 'neutral',
            'product'    => $productName,
            'brand'      => $brand,
            'image'      => $image,
            'ingredient' => $ing['name'],
            'result'     => $message ?: 'No data available',
        ];
    }
}
