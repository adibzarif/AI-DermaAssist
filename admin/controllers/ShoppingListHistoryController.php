<?php

require_once __DIR__ . '/../models/ShoppingListHistory.php';

class ShoppingListHistoryController {

    // ================= INDEX (list page) =================
    public function index(){

        $model = new ShoppingListHistory;

        // pagination
        $limit  = 8;
        $page   = $_GET['p'] ?? 1;
        $offset = ($page - 1) * $limit;

        // search
        $search = $_GET['search'] ?? '';

        // data
        $data = $model->getAll($limit, $offset, $search);

        // totals
        $total      = $model->countAll($search);
        $totalPages = ceil($total / $limit);

        include __DIR__ . '/../views/shopping_list_history.php';
    }

    // ================= DELETE SINGLE ENTRY =================
    public function delete(){

        $id = $_GET['id'] ?? 0;

        (new ShoppingListHistory)->delete($id);

        $search = $_GET['search'] ?? '';
        $p      = $_GET['p']      ?? 1;

        header("Location: index.php?page=shoppingListHistory&p=$p&search=$search");
        exit;
    }

    // ================= DELETE ALL ENTRIES FOR A USER =================
    public function deleteByUser(){

        $userId = $_GET['user_id'] ?? 0;

        (new ShoppingListHistory)->deleteByUser($userId);

        header("Location: index.php?page=shoppingListHistory");
        exit;
    }
}
