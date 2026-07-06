<?php
session_start();

require_once __DIR__ . '/../app/controllers/CheckProductsController.php';

$controller = new CheckProductsController();
$controller->check();
