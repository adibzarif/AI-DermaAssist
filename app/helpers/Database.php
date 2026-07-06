<?php
class Database {
    private static $pdo = null;
    public static function get() {
        if (self::$pdo === null) {
            $cfg = include __DIR__ . '/../config/config.php';
            $db = $cfg['db'];
            $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset=utf8mb4";
            self::$pdo = new PDO($dsn, $db['user'], $db['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        return self::$pdo;
    }
}
?>