<?php
session_start();

require_once __DIR__ . '/../app/controllers/ProductListController.php';

$controller = new ProductListController();
$controller->index();
