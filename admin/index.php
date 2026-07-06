<?php


session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/login_signup.php');
    exit;
}


require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/IngredientController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/ProductIngredientController.php';
require_once __DIR__ . '/controllers/ProductSkinProblemController.php';
require_once __DIR__ . '/controllers/ProductSkinTypeController.php';
require_once __DIR__ . '/controllers/ProductSkinToneController.php';
require_once __DIR__ . '/controllers/UserManagementController.php';
require_once __DIR__ . '/controllers/UserHistoryController.php';
require_once __DIR__ . '/controllers/ProductPriceController.php';
require_once __DIR__ . '/controllers/ShoppingListHistoryController.php';

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? null;


// ================= 🔥 ACTION (WAJIB ATAS) =================
if($action == 'getStores'){
    (new StoreController)->index();
    exit;
}

if($action == 'addStore'){
    (new StoreController)->store();
    exit;
}

if($action == 'saveIngredients'){
    (new ProductController)->saveIngredients();
    exit;
}

if($action == 'addIngredient'){
    (new IngredientController)->store();
    exit;
}

if($action == 'deleteIngredient'){
    (new IngredientController)->delete();
    exit;
}

if($action == 'safe' || $action == 'unsafe'){
    (new IngredientController)->updateSafety();
    exit;
}

if($action == 'saveProduct'){
    (new ProductController)->saveProduct();
    exit;
}

if($action == 'deleteProduct'){
    (new ProductController)->delete();
    exit;
}

if($action == 'saveProductIngredients'){
    (new ProductIngredientController)->save();
    exit;
}

if($action == 'deleteProductIngredients'){
    (new ProductIngredientController)->delete();
    exit;
}

if($action == 'getProductIngredients'){
    (new ProductIngredientController)->getByProduct();
    exit;
}

if($action == 'deletePSP'){
    (new ProductSkinProblemController)->delete();
    exit;
}

if($action == 'deletePST'){
    (new ProductSkinTypeController)->delete();
    exit;
}

if($action == 'deletePSTone'){
    (new ProductSkinToneController)->delete();
    exit;
}

if($action == 'updatePSTone'){
    (new ProductSkinToneController)->update();
    exit;
}

if($action == 'deletePSToneRow'){
    (new ProductSkinToneController)->deleteRow();
    exit;
}

if($action == 'savePSPForm'){
    (new ProductSkinProblemController)->saveForm();
    exit;
}

if($action == 'updatePSP'){
    (new ProductSkinProblemController)->update();
    exit;
}

if($action == 'deletePSPRow'){
    (new ProductSkinProblemController)->deleteRow();
    exit;
}

if($action == 'savePSTForm'){
    (new ProductSkinTypeController)->saveForm();
    exit;
}

if($action == 'updatePST'){
    (new ProductSkinTypeController)->update();
    exit;
}

if($action == 'deletePSTRow'){
    (new ProductSkinTypeController)->deleteRow();
    exit;
}

if($action == 'savePSToneForm'){
    (new ProductSkinToneController)->saveForm();
    exit;
}

if($action == 'deleteHistory'){
    (new UserHistoryController)->delete();
    exit;
}

if($action == 'saveUser'){
    (new UserManagementController)->save();
    exit;
}

if($action == 'updateUser'){
    (new UserManagementController)->update();
    exit;
}

if($action == 'deleteUser'){
    (new UserManagementController)->delete();
    exit;
}

if($action == 'savePrice'){
    (new ProductPriceController)->save();
    exit;
}

if($action == 'updatePrice'){
    (new ProductPriceController)->update();
    exit;
}

if($action == 'deletePrice'){
    (new ProductPriceController)->delete();
    exit;
}

if($action == 'updateIngredient'){
    (new IngredientController)->update();
    exit;
}

if($action == 'deleteShoppingHistory'){
    (new ShoppingListHistoryController)->delete();
    exit;
}
 
if($action == 'deleteShoppingHistoryByUser'){
    (new ShoppingListHistoryController)->deleteByUser();
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<?php include __DIR__ . '/views/layout/sidebar.php'; ?>

<?php

// ================= PAGE =================
switch($page){

    case 'products':
        (new ProductController)->index();
        break;

    case 'ingredients':
        (new IngredientController)->index();
        break;

    case 'productIngredients':
    (new ProductIngredientController)->index();
        break;

    case 'productSkinProblem':
        (new ProductSkinProblemController)->index();
        break;

    case 'productSkinType':
        (new ProductSkinTypeController)->index();
        break;

    case 'productSkinTone':
        (new ProductSkinToneController)->index();
        break;

    case 'userManagement':
        (new UserManagementController)->index();
        break;

    case 'userHistory':
        (new UserHistoryController)->index();
        break;

    case 'productPrice':
        (new ProductPriceController)->index();
        break;

    case 'shoppingListHistory':
    (new ShoppingListHistoryController)->index();
        break;

    default:
        (new DashboardController)->index();
        break;
}

?>

    <div class="logout">
        <a href="logout.php">
            <i class="fa fa-sign-out-alt"></i>
            Logout
        </a>
    </div>

<script src="scriptsfyp.js"></script>

</body>
</html>