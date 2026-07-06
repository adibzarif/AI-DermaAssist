<?php
require_once __DIR__ . '/../models/CheckProducts.php';

class CheckProductsController {

    private $model;

    public function __construct() {
        $this->model = new CheckProducts();
    }

    public function check() {
        header('Content-Type: application/json');

        $skin_type       = $_POST['skin_type']       ?? null;
        $skin_problem    = $_POST['skin_problem']    ?? [];
        $products        = $_POST['products']        ?? [];
        $custom_products = $_POST['custom_products'] ?? [];

        // ── Validation ────────────────────────────────────
        if (!$skin_type) {
            echo json_encode([['type' => 'error', 'text' => '❌ Please select your skin type']]);
            exit;
        }

        if (empty($products) && empty($custom_products)) {
            echo json_encode([['type' => 'error', 'text' => '❌ Please select at least one product']]);
            exit;
        }

        // ── Resolve skin type & problem IDs ───────────────
        $skinTypeId   = $this->model->getSkinTypeId($skin_type);
        $problemRows  = $this->model->getProblemIds($skin_problem);  // [id => name]

        // ── Run checks ────────────────────────────────────
        $results = [];

        foreach ($products as $pid) {
            $rows = $this->model->checkDbProduct((int) $pid, $skinTypeId, $skin_type, $problemRows);
            $results = array_merge($results, $rows);
        }

        foreach ($custom_products as $cp) {
            $rows = $this->model->checkCustomProduct($cp, $skinTypeId, $skin_type, $problemRows);
            $results = array_merge($results, $rows);
        }

        echo json_encode($results);
        exit;
    }
}
