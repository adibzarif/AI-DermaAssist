<?php
require_once __DIR__ . '/../helpers/Database.php';

class History {

    public function get($user_id){
        $db = Database::get();

        $stmt = $db->prepare("
            SELECT *
            FROM analysis_history
            WHERE user_id=?
            ORDER BY created_at DESC
        ");

        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}