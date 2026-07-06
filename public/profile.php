<?php
session_start();

require_once __DIR__ . '/../app/controllers/ProfileController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$controller = new ProfileController();
$page = $_GET['page'] ?? 'profile';

switch ($page) {
    case 'history':
        $controller->history();
        break;

    case 'wishlist':
        $controller->wishlist();
        break;

    case 'shoppinglist':
        $controller->shoppinglist();
        break;

    case 'update':
        $controller->update();
        break;

    case 'password':
        $controller->changePassword();
        break;

    default:
        $controller->index();
}
