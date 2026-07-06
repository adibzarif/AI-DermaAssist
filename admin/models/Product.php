<?php
require_once __DIR__ . '/../config/database.php';

class Product {

    // ================= GET ALL =================
    public static function all($limit = 10, $offset = 0, $search = ''){

        $db = Database::connect();

        return $db->query("
            SELECT *
            FROM products

            WHERE
                name LIKE '%$search%'
                OR brand LIKE '%$search%'

            ORDER BY id DESC

            LIMIT $limit OFFSET $offset
        ");
    }

    // ================= COUNT =================
    public static function count($search = ''){

        $db = Database::connect();

        return $db->query("
            SELECT COUNT(*) as total
            FROM products

            WHERE
                name LIKE '%$search%'
                OR brand LIKE '%$search%'
        ")
        ->fetch_assoc()['total'];
    }
}