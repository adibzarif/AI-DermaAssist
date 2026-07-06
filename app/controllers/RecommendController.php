<?php
require_once __DIR__ . '/../models/Recommend.php';

class RecommendController {

    private $model;

    public function __construct() {
        $this->model = new Recommend();
    }

    // ── Main page ──────────────────────────────────────────
    public function index() {
        // Auth guards
        if (!isset($_SESSION['user_id'])) {
            header("Location: login_signup.php");
            exit;
        }
        if (!isset($_SESSION['latest_analysis'])) {
            header("Location: skin_analysis.php");
            exit;
        }

        $user_id = $_SESSION['user_id'];

        // Fetch latest analysis
        $data = $this->model->getLatestAnalysis($user_id);
        if (!$data) {
            echo "<p>No analysis found. <a href='index.php'>Analyze first</a></p>";
            exit;
        }

        // Normalize scores
        $json = json_decode($data['result_json'], true);
        $raw  = $json['problem_scores'];
        $max  = max($raw);

        $scaled = [];
        foreach ($raw as $k => $v) {
            $scaled[strtolower($k)] = round(($v / $max) * 100);
        }

        // Filter problems scoring >= 20
        $selected_problems = [];
        foreach ($scaled as $problem_name => $score) {
            if ($score >= 20) {
                $selected_problems[$problem_name] = $score;
            }
        }

        $skintype  = strtolower($data['skintype']);
        $skintone  = strtolower($data['skintone']);
        $min_prices = $this->model->getMinPrices();

        // Fetch products for each section
        $products_by_problem = [];
        foreach ($selected_problems as $problem_name => $score) {
            $products_by_problem[$problem_name] = $this->model->getProductsByProblem($problem_name);
        }

        $products_by_type = $this->model->getProductsBySkinType($skintype);
        $products_by_tone = $this->model->getProductsBySkinTone($skintone);

        require __DIR__ . '/../views/recommend.php';
    }

    // ── AJAX: save shopping list ───────────────────────────
    public function saveList() {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
            exit;
        }

        $items = json_decode($_POST['items'] ?? '[]', true);
        if (!$items || !is_array($items)) {
            echo json_encode(['success' => false, 'message' => 'No items']);
            exit;
        }

        $result = $this->model->saveShoppingList($_SESSION['user_id'], $items);
        echo json_encode(['success' => true] + $result);
        exit;
    }
}
