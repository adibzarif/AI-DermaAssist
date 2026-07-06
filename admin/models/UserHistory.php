<?php
require_once __DIR__ . '/../config/database.php';

class UserHistory {

    private $conn;

    public function __construct(){
        $this->conn = Database::connect();
    }

    public function getAll($limit = 10, $offset = 0, $search = ''){

    return mysqli_query($this->conn, "
        SELECT 
            ah.*,
            u.name
        FROM analysis_history ah
        JOIN users u 
            ON u.id = ah.user_id

        WHERE 
            u.name LIKE '%$search%'
            OR ah.skintype LIKE '%$search%'
            OR ah.skintone LIKE '%$search%'

        ORDER BY ah.created_at DESC

        LIMIT $limit OFFSET $offset
    ");
}

   public function countAll($search = ''){

    $result = mysqli_query($this->conn, "
        SELECT COUNT(*) as total

        FROM analysis_history ah

        JOIN users u
            ON u.id = ah.user_id

        WHERE 
            u.name LIKE '%$search%'
            OR ah.skintype LIKE '%$search%'
            OR ah.skintone LIKE '%$search%'
    ");

    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}

    
    public function delete($id){

        $stmt = mysqli_prepare($this->conn,
            "DELETE FROM analysis_history WHERE id=?"
        );

        mysqli_stmt_bind_param($stmt, "i", $id);

        return mysqli_stmt_execute($stmt);
    }

}