<?php
require_once __DIR__ . '/../models/IngredientCheck.php';

class IngredientController {

    private $model;

    public function __construct() {
        $this->model = new IngredientCheck();
    }

    // ── Main page (handles both GET and POST) ─────────────
    public function index() {
        // Auth guard (uncomment when ready)
        // if (!isset($_SESSION['user_id'])) {
        //     header("Location: login_signup.php");
        //     exit;
        // }

        $query   = null;
        $results = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ingredient'])) {
            $query   = trim($_POST['ingredient']);
            $results = $this->model->search($query);
        }

        require __DIR__ . '/../views/ingredient.php';
    }
}