<?php
require_once __DIR__ . '/../helpers/Database.php';

class Wishlist {
    public function get($user_id){
        $db = Database::get();
        $stmt = $db->prepare("
            SELECT p.*
            FROM wishlist w
            JOIN products p ON w.product_id=p.id
            WHERE w.user_id=?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}