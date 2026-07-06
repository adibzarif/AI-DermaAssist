<?php

require_once __DIR__ . '/../models/UserHistory.php';

class UserHistoryController {

   public function index(){

    // current page
    $page = $_GET['p'] ?? 1;

    // limit
    $limit = 5;

    // offset
    $offset = ($page - 1) * $limit;

    // search
    $search = $_GET['search'] ?? '';

    $model = new UserHistory;

    // get data
    $data = $model->getAll(
        $limit,
        $offset,
        $search
    );

    // total rows
    $total = $model->countAll($search);

    // total pages
    $totalPages = ceil($total / $limit);

    include __DIR__ . '/../views/user_history.php';
}

    public function delete(){

        $id = $_GET['id'] ?? 0;

        (new UserHistory)->delete($id);

        header("Location: index.php?page=userHistory");
    }
}