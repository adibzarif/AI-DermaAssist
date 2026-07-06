<?php
session_start();

require_once __DIR__ . '/../app/controllers/RecommendController.php';

$controller = new RecommendController();

// AJAX: save shopping list
if (isset($_POST['action']) && $_POST['action'] === 'save_list') {
    $controller->saveList();
    exit;
}

// Normal page load
$controller->index();
