<?php

require_once __DIR__ . '/../models/ProductSkinProblem.php';

class ProductSkinProblemController {

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

        $model = new ProductSkinProblem;

        // DATA
        $data = $model->getAll(
            $limit,
            $offset,
            $search
        );

        // TOTAL
        $total = $model->countAll($search);

        // TOTAL PAGE
        $totalPages = ceil($total / $limit);

        include __DIR__ . '/../views/product_skin_problem.php';
    }

    // ================= SAVE =================
    public function saveForm(){

        $product_id = $_POST['product_id'] ?? null;

        $problem_ids = $_POST['problem_id'] ?? [];

        if(!$product_id || empty($problem_ids)){
            die("Missing data");
        }

        $model = new ProductSkinProblem;

        foreach($problem_ids as $problem_id){

            $model->insert([

                'product_id' => $product_id,

                'problem_id' => $problem_id
            ]);
        }

        header("Location: index.php?page=productSkinProblem");
        exit;
    }

    // ================= UPDATE =================
    public function update(){

        $product_id = $_POST['product_id'] ?? null;

        $problem_ids = $_POST['problem_id'] ?? [];

        if(!$product_id){
            die("Missing ID");
        }

        $model = new ProductSkinProblem;

        $model->update(
            $product_id,
            $problem_ids
        );

        header("Location: index.php?page=productSkinProblem");
        exit;
    }

    // ================= DELETE ROW =================
    public function deleteRow(){

        $product_id = $_GET['product_id'] ?? null;

        if(!$product_id){
            die("Missing ID");
        }

        (new ProductSkinProblem)->deleteAll(
            $product_id
        );

        header("Location: index.php?page=productSkinProblem");
        exit;
    }
}