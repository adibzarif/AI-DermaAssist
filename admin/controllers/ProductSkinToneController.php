<?php

require_once __DIR__ . '/../models/ProductSkinTone.php';

class ProductSkinToneController {

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

        $model = new ProductSkinTone;

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

        include __DIR__ . '/../views/product_skin_tone.php';
    }

    // ================= SAVE =================
    public function saveForm(){

        $product_id = $_POST['product_id'] ?? null;

        $skintone_ids = $_POST['skintone_id'] ?? [];

        if(!$product_id || empty($skintone_ids)){
            die("Missing data");
        }

        $model = new ProductSkinTone;

        foreach($skintone_ids as $tone_id){

            $model->insert([

                'product_id' => $product_id,

                'skintone_id' => $tone_id
            ]);
        }

        header("Location: index.php?page=productSkinTone");
        exit;
    }

    // ================= UPDATE =================
    public function update(){

        $product_id = $_POST['product_id'] ?? null;

        $skintone_ids = $_POST['skintone_id'] ?? [];

        if(!$product_id){
            die("Missing ID");
        }

        $model = new ProductSkinTone;

        $model->update(
            $product_id,
            $skintone_ids
        );

        header("Location: index.php?page=productSkinTone");
        exit;
    }

    // ================= DELETE ROW =================
    public function deleteRow(){

        $product_id = $_GET['product_id'] ?? null;

        if(!$product_id){
            die("Missing ID");
        }

        (new ProductSkinTone)->deleteAll(
            $product_id
        );

        header("Location: index.php?page=productSkinTone");
        exit;
    }
}