<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Ingredient.php';
require_once __DIR__ . '/../models/ProductIngredient.php';

class ProductIngredientController {

    // ================= PAGE =================
    public function index(){

        // PAGE
        $page = $_GET['p'] ?? 1;

        // LIMIT
        $limit = 7;

        // OFFSET
        $offset = ($page - 1) * $limit;

        // SEARCH
        $search = $_GET['search'] ?? '';

        $products = Product::all();

        $ingredients = Ingredient::all();

        // MODEL
        $model = new ProductIngredient;

        // DATA
        $productList = $model->getAllWithIngredients(
            $limit,
            $offset,
            $search
        );

        // TOTAL
        $total = $model->countAll($search);

        // TOTAL PAGE
        $totalPages = ceil($total / $limit);

        include __DIR__ . '/../views/product_ingredients.php';
    }

    // ================= SAVE =================
    public function save(){

        $product_id = $_POST['product_id'] ?? null;

        $ingredient_ids = $_POST['ingredients'] ?? [];

        if(!$product_id){
            die("Product ID missing");
        }

        ProductIngredient::save(
            $product_id,
            $ingredient_ids
        );

        header("Location: index.php?page=productIngredients");
        exit;
    }

    // ================= GET PRODUCT =================
    public function getByProduct(){

        $id = $_GET['product_id'] ?? null;

        if(!$id){
            echo json_encode([]);
            return;
        }

        $data = ProductIngredient::getByProduct($id);

        echo json_encode(
            $data->fetch_all(MYSQLI_ASSOC)
        );
    }

    // ================= DELETE ROW =================
// ================= DELETE ROW =================
    public function delete(){

        $id = $_GET['id'] ?? null;

        if(!$id){
            die("Missing ID");
        }

        ProductIngredient::deleteAll($id);

        header("Location: index.php?page=productIngredients");
        exit;
    }
}