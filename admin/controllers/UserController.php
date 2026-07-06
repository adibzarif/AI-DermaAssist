<?php
require_once __DIR__ . '/../models/User.php';

class UserController {

    public function index(){
        $users = User::all();
        include __DIR__ . '/../views/users.php';
    }

    public function delete(){
        User::delete($_GET['id']);
        header("Location: index.php?page=users");
    }
}