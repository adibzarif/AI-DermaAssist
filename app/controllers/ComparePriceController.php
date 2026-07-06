<?php
require_once __DIR__ . '/../models/ComparePrice.php';
require_once __DIR__ . '/../views/partials/compare_price_helpers.php';

class ComparePriceController {

    private $model;

    // Store brand colours (used in view)
    public static array $storeColors = [
        'Watsons'  => '#0066cc',
        'Guardian' => '#00a651',
        'Shopee'   => '#ee4d2d',
        'Lazada'   => '#0f146d',
    ];

    // Store emoji icons (used in view)
    public static array $storeIcons = [
        'Watsons'  => '💙',
        'Guardian' => '💚',
        'Shopee'   => '🟠',
        'Lazada'   => '🟣',
    ];

    public function __construct() {
        $this->model = new ComparePrice();
    }

    // ── Main page ──────────────────────────────────────────
    public function index() {
        $product_id = (int) ($_GET['product_id'] ?? 0);
        if (!$product_id) {
            header("Location: index.php");
            exit;
        }

        $product = $this->model->getProduct($product_id);
        if (!$product) {
            header("Location: index.php");
            exit;
        }

        // Prices + savings calc
        $prices     = $this->model->getPrices($product_id);
        $bestPrice  = !empty($prices) ? (float) $prices[0]['price']      : null;
        $worstPrice = !empty($prices) ? (float) end($prices)['price']    : null;
        $savings    = ($bestPrice && $worstPrice) ? round($worstPrice - $bestPrice, 2) : 0;

        // Ingredients + skin tags
        $ingredients = $this->model->getIngredients($product_id);
        $concerns    = $this->model->getConcerns($product_id);
        $skinTypes   = $this->model->getSkinTypes($product_id);
        $skinTones   = $this->model->getSkinTones($product_id);

        // Similar products
        $similar = $this->model->getSimilar($product_id, $concerns);

        // Wishlist
        $userId       = $_SESSION['user_id'] ?? null;
        $isWishlisted = $userId ? $this->model->isWishlisted($userId, $product_id) : false;

        // Back link
        $source = $_GET['source'] ?? '';
        [$back, $back_label] = $this->resolveBack($source);

        // Store maps passed to view
        $storeIcons  = self::$storeIcons;
        $storeColors = self::$storeColors;

        require __DIR__ . '/../views/compare_price.php';
    }

    // ── AJAX: wishlist toggle ──────────────────────────────
    public function toggleWish() {
        header('Content-Type: application/json');

        $userId    = $_SESSION['user_id'] ?? null;
        $productId = (int) ($_GET['wish'] ?? 0);

        if (!$userId || !$productId) {
            echo json_encode(['error' => 'unauthorized']);
            exit;
        }

        $saved = $this->model->toggleWishlist($userId, $productId);
        echo json_encode(['saved' => $saved]);
    }

    // ── Resolve back link ──────────────────────────────────
    private function resolveBack(string $source): array {
        return match ($source) {
            'recommend' => ['recommend_entry.php',          '← Back to Recommendations'],
            'list'      => ['productlist_compare.php',      '← Back to Product List'],
            'similar'   => ['javascript:history.back()',    '← Back'],
            default     => ['index.php',                    '← Home'],
        };
    }
}