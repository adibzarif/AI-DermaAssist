<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Ingredient.php';
require_once __DIR__ . '/../config/database.php';

class ProductController {

    // ================= PRODUCTS =================
    public function index() {

        // PAGE
        $page = $_GET['p'] ?? 1;

        // LIMIT
        $limit = 5;

        // OFFSET
        $offset = ($page - 1) * $limit;

        // SEARCH
        $search = $_GET['search'] ?? '';

        // PRODUCTS
        $products = Product::all(
            $limit,
            $offset,
            $search
        );

        // TOTAL
        $totalProducts = Product::count($search);

        // TOTAL PAGE
        $totalPages = ceil($totalProducts / $limit);

        // INGREDIENT
        $ingredients = Ingredient::all();

        include __DIR__ . '/../views/products.php';
    }

    // ================= SAVE PRODUCT =================
    public function saveProduct(){

        $db = Database::connect();

        $id = $_POST['id'];

        if($id){

            $db->query("
                UPDATE products SET

                name='{$_POST['name']}',
                brand='{$_POST['brand']}',
                description='{$_POST['description']}',
                image_url='{$_POST['image_url']}'

                WHERE id=$id
            ");

        }else{

            $db->query("
                INSERT INTO products
                (name,brand,description,image_url)

                VALUES(
                    '{$_POST['name']}',
                    '{$_POST['brand']}',
                    '{$_POST['description']}',
                    '{$_POST['image_url']}'
                )
            ");
        }

        header("Location: index.php?page=products");
    }

    // ================= DELETE =================
    public function delete(){

        $id = $_GET['id'];

        Database::connect()
        ->query("DELETE FROM products WHERE id=$id");

        header("Location: index.php?page=products");
    }

    // ================= INGREDIENT =================
    public function saveIngredients() {

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        Product::setIngredients(
            $data['product_id'],
            $data['ingredients']
        );

        echo "Saved successfully!";
    }
}