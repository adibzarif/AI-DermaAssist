<?php

require_once __DIR__ . '/../models/ProductPrice.php';

class ProductPriceController {

    // ================= PAGE =================
    public function index(){

        $page = $_GET['p'] ?? 1;

        $limit = 7;

        $offset = ($page - 1) * $limit;

        $search = $_GET['search'] ?? '';

        $model = new ProductPrice;

        $data = $model->getAll(
            $search,
            $limit,
            $offset
        );

        $products = $model->getProducts();

        $total = $model->countAll($search);

        $totalPages = ceil($total / $limit);

        include __DIR__ . '/../views/product_price.php';
    }

    // ================= SAVE =================
    public function save(){

        (new ProductPrice)->save($_POST);

        header("Location: index.php?page=productPrice");
        exit;
    }

    // ================= UPDATE =================
    public function update(){

        (new ProductPrice)->update($_POST);

        header("Location: index.php?page=productPrice");
        exit;
    }

    // ================= DELETE =================
    public function delete(){

        $id = $_GET['id'] ?? 0;

        (new ProductPrice)->delete($id);

        header("Location: index.php?page=productPrice");
        exit;
    }
}