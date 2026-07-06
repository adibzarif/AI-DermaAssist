<?php
require_once __DIR__ . '/../models/Analysis.php';
require_once __DIR__ . '/../helpers/Database.php';

class SkinAnalysisController {

    private $model;

    public function __construct() {
        $this->model = new Analysis();
    }

    // ── GET: render skin analysis landing + modal page ─────
    public function index() {
        $config   = include __DIR__ . '/../config/config.php';
        $loggedIn = isset($_SESSION['user_id']);
        $products = $this->model->getAllProducts();

        require __DIR__ . '/../views/skin_analysis.php';
    }
}
