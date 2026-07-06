<?php
session_start();

require_once __DIR__ . '/../app/helpers/Database.php';

header("Content-Type: application/json");

try {

    $raw = file_get_contents("php://input");

    if (!$raw) {
        throw new Exception("No JSON received");
    }

    $data = json_decode($raw, true);

    if (!$data) {
        throw new Exception("Invalid JSON");
    }

    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');

    if (!$email || !$password) {
        throw new Exception("Email and password required");
    }

    $db = Database::get();

    $stmt = $db->prepare("
        SELECT *
        FROM users
        WHERE email = ?
        LIMIT 1
    ");

    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if (!$user) {
        throw new Exception("User not found");
    }

    if (!password_verify($password, $user['password_hash'])) {
        throw new Exception("Invalid password");
    }

    // ====================================
    // LOGIN SESSION
    // ====================================
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['role'] = $user['role']; // ← ADD THIS

    // ====================================
    // ADMIN REDIRECT                       ← ADD THIS BLOCK
    // ====================================
    if ($user['role'] === 'admin') {
        echo json_encode([
            "success"  => true,
            "redirect" => "../admin/index.php"
        ]);
        exit;
    }

    // default redirect
    $redirect = "index.php";

    // ====================================
    // CHECK PENDING SCAN
    // ====================================
    if (isset($_SESSION['pending_scan'])) {

        $pending = $_SESSION['pending_scan'];

        // save into database
        $stmt = $db->prepare("
            INSERT INTO analysis_history
            (
                user_id,
                problem,
                skintype,
                skintone,
                result_json,
                created_at
            )
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $_SESSION['user_id'],
            $pending['problem'],
            $pending['skintype'],
            $pending['skintone'],
            json_encode($pending['result_json'])
        ]);

        // ====================================
        // RESTORE RESULT SESSION
        // ====================================
        $_SESSION['latest_analysis'] = $pending['result_json'];

        if (isset($pending['image'])) {
            $_SESSION['latest_image'] = $pending['image'];
        }

        // optional latest inserted ID
        $_SESSION['latest_analysis_id'] = $db->lastInsertId();

        // clear pending scan
        unset($_SESSION['pending_scan']);

        // redirect to analyze page
        $redirect = "analyze_entry.php";
    }

    echo json_encode([
        "success" => true,
        "redirect" => $redirect
    ]);

    exit;

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);

    exit;
}