<?php
session_start();

require_once __DIR__ . '/../app/controllers/IngredientController.php';

$controller = new IngredientController();

// Normal page load (GET or POST)
$controller->index();
