<?php
session_start();

require_once __DIR__ . '/../app/controllers/AllProductController.php';

$controller = new AllProductController();
$controller->index();
