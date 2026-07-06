<?php
require_once __DIR__ . '/../models/Ingredient.php';

class IngredientController {

public function index() {

    $limit = 9; // berapa row satu page
    $page = $_GET['p'] ?? 1;
    $offset = ($page - 1) * $limit;

    $ingredients = Ingredient::getPaginated($limit, $offset);
    $total = Ingredient::countAll();
    $totalPages = ceil($total / $limit);

    include __DIR__ . '/../views/ingredients.php';
}

    // ================= ADD / EDIT =================
    public function store() {

        if(isset($_POST['name'])) {

            $id = $_POST['id'] ?? null;
            $name = $_POST['name'];
            $safety = $_POST['safety'];
            $notes = $_POST['notes'];

            if($id){
                // ✅ EDIT
                Ingredient::update($id, $name, $safety, $notes);
            } else {
                // ✅ ADD
                Ingredient::create($name, $safety, $notes);
            }
        }

        header("Location: index.php?page=ingredients");
    }


    // ================= DELETE =================
    public function delete(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            Ingredient::delete($id);
        }

        header("Location: index.php?page=ingredients");
    }

}