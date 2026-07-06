<?php
require_once __DIR__ . '/Database.php';

class Auth {

    public static function attempt($email, $password) {
        $pdo = Database::get();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $u = $stmt->fetch();

        if ($u && password_verify($password, $u['password_hash'])) {

            // 🔥 SIMPAN ANALYSIS SEBELUM SESSION DIGANTI
            $prev_analysis = $_SESSION['analysis'] ?? null;

            // regenerate session ID
            session_regenerate_id(true);

            // 🔥 PULANGKAN BALIK ANALYSIS
            if ($prev_analysis) {
                $_SESSION['analysis'] = $prev_analysis;
            }

            // login info
            $_SESSION['user'] = [
                'id'    => $u['id'],
                'email' => $u['email'],
                'name'  => $u['name'],
                'role'  => $u['role']
            ];

            return true;
        }

        return false;
    }

    public static function check() { return isset($_SESSION['user']); }
    public static function user() { return $_SESSION['user'] ?? null; }
    public static function logout() {
        unset($_SESSION['user']);
        session_destroy();
    }
}
?>
