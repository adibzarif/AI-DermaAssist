<?php
require_once __DIR__ . '/../models/ProductListModel.php';

class ProductListController {

    private $model;

    public function __construct() {
        $this->model = new ProductListModel();
    }

    public function index() {
        $search = $_GET['q'] ?? '';
        $rows   = [];

        if ($search !== '') {
            $rows = $this->model->search($search);
        }

        require __DIR__ . '/../views/productlist_compare.php';
    }
}
