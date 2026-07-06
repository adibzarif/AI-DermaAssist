<?php

require_once __DIR__ . '/../models/ProductSkinType.php';

class ProductSkinTypeController {

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

        $model = new ProductSkinType;

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

        include __DIR__ . '/../views/product_skin_type.php';
    }

    // ================= SAVE =================
    public function saveForm(){

        $product_id = $_POST['product_id'] ?? null;

        $skintype_ids = $_POST['skintype_id'] ?? [];

        if(!$product_id || empty($skintype_ids)){
            die("Missing data");
        }

        $model = new ProductSkinType;

        foreach($skintype_ids as $type_id){

            $model->insert([

                'product_id' => $product_id,

                'skintype_id' => $type_id
            ]);
        }

        header("Location: index.php?page=productSkinType");
        exit;
    }

    // ================= UPDATE =================
public function update(){

    $product_id = $_POST['product_id'] ?? null;

    $skintype_ids = $_POST['skintype_id'] ?? [];

    if(!$product_id){
        die("Missing ID");
    }

    $model = new ProductSkinType;

    $model->update(
        $product_id,
        $skintype_ids
    );

    header("Location: index.php?page=productSkinType");
    exit;
}

    // ================= DELETE =================
    public function deleteRow(){

        $product_id = $_GET['product_id'] ?? null;

        if(!$product_id){
            die("Missing ID");
        }

        (new ProductSkinType)->deleteAll(
            $product_id
        );

        header("Location: index.php?page=productSkinType");
        exit;
    }
}