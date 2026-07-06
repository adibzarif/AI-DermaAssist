<?php
require_once __DIR__ . '/../helpers/Database.php';

class ShoppingList {

    public function getSessions($user_id) {
        $db = Database::get();

        // Get all sessions for this user, newest first
        $stmt = $db->prepare("
            SELECT s.id, s.created_at,
                   COUNT(i.id) AS item_count,
                   SUM(i.price) AS total
            FROM shopping_list_sessions s
            LEFT JOIN shopping_list_items i ON i.session_id = s.id
            WHERE s.user_id = ?
            GROUP BY s.id
            ORDER BY s.created_at DESC
        ");
        $stmt->execute([$user_id]);
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // For each session, fetch its products
        foreach ($sessions as &$session) {
            $items = $db->prepare("
                SELECT i.store_name, i.price,
                       p.name, p.brand, p.image_url
                FROM shopping_list_items i
                JOIN products p ON p.id = i.product_id
                WHERE i.session_id = ?
            ");
            $items->execute([$session['id']]);
            $session['items'] = $items->fetchAll(PDO::FETCH_ASSOC);
        }

        return $sessions;
    }
}
