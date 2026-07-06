<?php
session_start();
require_once __DIR__ . '/../app/helpers/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $pass  = $_POST["password"];

    if (empty($name) || empty($email) || empty($pass)) {
        header("Location: login_signup.php?error=register_failed&reg_email=" . urlencode($email) . "&name=" . urlencode($name));
        exit;
    }

    $db = Database::get();

    $check = $db->prepare("SELECT id FROM users WHERE email=?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        header("Location: login_signup.php?error=email_taken&reg_email=" . urlencode($email) . "&name=" . urlencode($name));
        exit;
    }

    $stmt = $db->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT)]);

    header("Location: login_signup.php?registered=1");
    exit;
}

// Direct access with no POST — go back to login page
header("Location: login_signup.php");
exit;
?>