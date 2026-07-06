<?php

require_once __DIR__ . '/../models/UserManagement.php';

class UserManagementController {

    public function index(){

    $model = new UserManagement;

    // ================= PAGINATION =================
    $limit = 9;

    $page = $_GET['p'] ?? 1;

    $start = ($page - 1) * $limit;

    // ================= SEARCH =================
    $search = $_GET['search'] ?? '';

    // ================= TOTAL =================
    $totalQuery = mysqli_query(
        Database::connect(),
        "SELECT COUNT(*) as total
         FROM users
         WHERE name LIKE '%$search%'
         OR email LIKE '%$search%'"
    );

    $totalData = mysqli_fetch_assoc($totalQuery);

    $totalRows = $totalData['total'];

    $totalPages = ceil($totalRows / $limit);

    // ================= DATA =================
    $data = mysqli_query(
        Database::connect(),
        "SELECT *
         FROM users
         WHERE name LIKE '%$search%'
         OR email LIKE '%$search%'
         ORDER BY created_at DESC
         LIMIT $start, $limit"
    );

    include __DIR__ . '/../views/user_management.php';
}

    // ================= SAVE USER =================
    public function save(){

        (new UserManagement)->save($_POST);

        header("Location: index.php?page=userManagement");
        exit;
    }

    // ================= UPDATE USER =================
    public function update(){

        (new UserManagement)->update($_POST);

        header("Location: index.php?page=userManagement");
        exit;
    }

    // ================= DELETE USER =================
    public function delete(){

        $id = $_GET['id'] ?? null;

        if(!$id){
            die("Missing ID");
        }

        (new UserManagement)->delete($id);

        header("Location: index.php?page=userManagement");
        exit;
    }
    
}