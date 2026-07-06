<?php
require_once __DIR__ . '/../models/Profile.php';
require_once __DIR__ . '/../models/History.php';
require_once __DIR__ . '/../models/Wishlist.php';
require_once __DIR__ . '/../models/ShoppingList.php';

class ProfileController {

    // 🔹 PROFILE PAGE
    public function index() {
        if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

        $profileModel  = new Profile();
        $historyModel  = new History();
        $wishlistModel = new Wishlist();

        $user     = $profileModel->get($_SESSION['user_id']);
        $history  = $historyModel->get($_SESSION['user_id']);
        $wishlist = $wishlistModel->get($_SESSION['user_id']);

        require __DIR__ . '/../views/profile.php';
    }

    // 🔹 HISTORY PAGE
    public function history() {
        if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

        $profileModel = new Profile();
        $historyModel = new History();

        $user    = $profileModel->get($_SESSION['user_id']);
        $history = $historyModel->get($_SESSION['user_id']);

        require __DIR__ . '/../views/history.php';
    }

    // 🔹 WISHLIST PAGE
    public function wishlist() {
        if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

        $profileModel  = new Profile();
        $wishlistModel = new Wishlist();

        $user     = $profileModel->get($_SESSION['user_id']);
        $wishlist = $wishlistModel->get($_SESSION['user_id']);

        require __DIR__ . '/../views/wishlist.php';
    }

    // 🔹 SHOPPING LIST HISTORY PAGE
    public function shoppinglist() {
        if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

        $profileModel      = new Profile();
        $shoppingListModel = new ShoppingList();

        $user     = $profileModel->get($_SESSION['user_id']);
        $sessions = $shoppingListModel->getSessions($_SESSION['user_id']);

        require __DIR__ . '/../views/shoppinglist.php';
    }

    // 🔹 UPDATE PROFILE
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profileModel = new Profile();
            $name  = $_POST['name'];
            $email = $_POST['email'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format!";
                header("Location: profile.php");
                exit;
            }

            $profileModel->updateProfile($_SESSION['user_id'], $name, $email);
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: profile.php");
            exit;
        }
    }

    // 🔹 CHANGE PASSWORD
    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profileModel = new Profile();
            $password = $_POST['password'];
            $confirm  = $_POST['confirm'];

            if ($password !== $confirm) {
                $_SESSION['error'] = "Password not match!";
                header("Location: profile.php");
                exit;
            }
            if (strlen($password) < 6) {
                $_SESSION['error'] = "Password must be at least 6 characters!";
                header("Location: profile.php");
                exit;
            }

            $profileModel->changePassword($_SESSION['user_id'], $password);
            $_SESSION['success'] = "Password changed successfully!";
            header("Location: profile.php");
            exit;
        }
    }
}
