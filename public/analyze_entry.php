<?php
session_start();

require_once __DIR__ . '/../app/controllers/AnalyzeController.php';

$controller = new AnalyzeController();

// AJAX: image upload → return JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $controller->analyze();
    exit;
}

// Normal page load → show results
$controller->index();
