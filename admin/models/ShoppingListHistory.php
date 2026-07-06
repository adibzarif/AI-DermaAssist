<?php
require_once __DIR__ . '/../config/database.php';

class ShoppingListHistory {

    private $conn;

    public function __construct(){
        $this->conn = Database::connect();
    }

    // ================= GET ALL =================
    public function getAll($limit = 10, $offset = 0, $search = ''){

        return mysqli_query($this->conn, "
            SELECT
                sli.id,
                sli.session_id,
                sli.product_id,
                sli.store_name,
                sli.price,
                sli.created_at,
                sls.user_id,
                u.name  AS user_name,
                u.email,
                p.name  AS product_name
            FROM shopping_list_items sli
            JOIN shopping_list_sessions sls ON sls.id  = sli.session_id
            JOIN users                  u   ON u.id    = sls.user_id
            LEFT JOIN products          p   ON p.id    = sli.product_id
            WHERE
                u.name        LIKE '%$search%'
                OR u.email    LIKE '%$search%'
                OR p.name     LIKE '%$search%'
                OR sli.store_name LIKE '%$search%'
            ORDER BY sli.created_at DESC
            LIMIT $limit OFFSET $offset
        ");
    }

    // ================= COUNT ALL =================
    public function countAll($search = ''){

        $result = mysqli_query($this->conn, "
            SELECT COUNT(*) AS total
            FROM shopping_list_items sli
            JOIN shopping_list_sessions sls ON sls.id = sli.session_id
            JOIN users                  u   ON u.id   = sls.user_id
            LEFT JOIN products          p   ON p.id   = sli.product_id
            WHERE
                u.name        LIKE '%$search%'
                OR u.email    LIKE '%$search%'
                OR p.name     LIKE '%$search%'
                OR sli.store_name LIKE '%$search%'
        ");

        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    // ================= DELETE SINGLE ITEM =================
    public function delete($id){

        $stmt = mysqli_prepare($this->conn,
            "DELETE FROM shopping_list_items WHERE id = ?"
        );
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }

    // ================= DELETE ALL ITEMS FOR A USER =================
    // Deletes all sessions (cascades to items via FK)
    public function deleteByUser($userId){

        $stmt = mysqli_prepare($this->conn,
            "DELETE FROM shopping_list_sessions WHERE user_id = ?"
        );
        mysqli_stmt_bind_param($stmt, "i", $userId);
        return mysqli_stmt_execute($stmt);
    }
}