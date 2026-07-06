<?php
require_once __DIR__ . '/../models/AllProductModel.php';

class AllProductController {

    private $model;

    public function __construct() {
        $this->model = new AllProductModel();
    }

    public function index() {
        // Filter dropdowns (always needed for sidebar)
        $problems = $this->model->getProblems();
        $types    = $this->model->getTypes();
        $tones    = $this->model->getTones();

        // Wishlist
        $userWishlist = isset($_SESSION['user_id'])
            ? $this->model->getUserWishlist($_SESSION['user_id'])
            : [];

        // Resolve active filter label for breadcrumb
        $filterName = '';
        $filterType = '';
        if (isset($_GET['problem'])) {
            foreach ($problems as $pb) {
                if ($pb['id'] == $_GET['problem']) {
                    $filterName = $pb['name'];
                    $filterType = 'problem';
                }
            }
        } elseif (isset($_GET['type'])) {
            foreach ($types as $tp) {
                if ($tp['id'] == $_GET['type']) {
                    $filterName = $tp['name'];
                    $filterType = 'type';
                }
            }
        } elseif (isset($_GET['tone'])) {
            foreach ($tones as $tn) {
                if ($tn['id'] == $_GET['tone']) {
                    $filterName = $tn['name'];
                    $filterType = 'tone';
                }
            }
        }

        // Search / filter products
        $search           = $_GET['search'] ?? null;
        $filteredProducts = [];

        if ($search) {
            $filteredProducts = $this->model->searchProducts($search);
        } elseif (isset($_GET['problem'])) {
            $filteredProducts = $this->model->filterByProblem($_GET['problem']);
        } elseif (isset($_GET['type'])) {
            $filteredProducts = $this->model->filterByType($_GET['type']);
        } elseif (isset($_GET['tone'])) {
            $filteredProducts = $this->model->filterByTone($_GET['tone']);
        }

        // Single product detail view
        $viewId      = $_GET['id'] ?? null;
        $viewProduct = null;
        $ingredients = [];
        $productUrl  = null;

        if ($viewId) {
            $viewProduct = $this->model->getProduct($viewId);
            $ingredients = $this->model->getIngredients($viewId);
            $productUrl  = $this->model->getProductUrl($viewId);
        }

        // Popular products (shown when no filter/search)
        $popular = $this->model->getPopular();

        // Products grouped by category (for browse sections)
        $productsByProblem = [];
        foreach ($problems as $pb) {
            $productsByProblem[$pb['id']] = $this->model->getProductsByProblem($pb['id']);
        }

        $productsByType = [];
        foreach ($types as $tp) {
            $productsByType[$tp['id']] = $this->model->getProductsByType($tp['id']);
        }

        $productsByTone = [];
        foreach ($tones as $tn) {
            $productsByTone[$tn['id']] = $this->model->getProductsByTone($tn['id']);
        }

        require __DIR__ . '/../views/all_product.php';
    }
}
