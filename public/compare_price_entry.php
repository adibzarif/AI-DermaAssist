<?php
session_start();

require_once __DIR__ . '/../app/controllers/ComparePriceController.php';

$controller = new ComparePriceController();

// AJAX: wishlist toggle
if (isset($_GET['wish'])) {
    $controller->toggleWish();
    exit;
}

// Normal page load
$controller->index();