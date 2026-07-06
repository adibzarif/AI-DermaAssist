<?php
require_once __DIR__ . '/../config/database.php';

class ProductSkinProblem {

    private $conn;

    public function __construct(){

        $this->conn = Database::connect();
    }

    // ================= GET ALL =================
    public function getAll(
        $limit = 10,
        $offset = 0,
        $search = ''
    ){

        return mysqli_query($this->conn, "

            SELECT 
                p.id as product_id,
                p.name as product,

                GROUP_CONCAT(
                    sp.name SEPARATOR ','
                ) as problems,

                GROUP_CONCAT(
                    sp.id
                ) as problem_ids

            FROM product_skinproblems psp

            JOIN products p
                ON p.id = psp.product_id

            JOIN skin_problems sp
                ON sp.id = psp.problem_id

            WHERE
                p.name LIKE '%$search%'
                OR sp.name LIKE '%$search%'

            GROUP BY p.id

            ORDER BY p.id DESC

            LIMIT $limit OFFSET $offset
        ");
    }

    // ================= COUNT =================
    public function countAll($search = ''){

        $result = mysqli_query($this->conn, "

            SELECT COUNT(DISTINCT p.id) as total

            FROM product_skinproblems psp

            JOIN products p
                ON p.id = psp.product_id

            JOIN skin_problems sp
                ON sp.id = psp.problem_id

            WHERE
                p.name LIKE '%$search%'
                OR sp.name LIKE '%$search%'
        ");

        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }

    // ================= INSERT =================
    public function insert($data){

        $product_id = $data['product_id'];

        $problem_id = $data['problem_id'];

        // CHECK EXIST
        $check = mysqli_query($this->conn, "

            SELECT *

            FROM product_skinproblems

            WHERE product_id = '$product_id'

            AND problem_id = '$problem_id'
        ");

        // INSERT IF NOT EXIST
        if(mysqli_num_rows($check) == 0){

            mysqli_query($this->conn, "

                INSERT INTO product_skinproblems
                (product_id, problem_id)

                VALUES (
                    '$product_id',
                    '$problem_id'
                )
            ");
        }
    }

    // ================= UPDATE =================
    public function update($product_id, $problem_ids){

        // DELETE OLD
        mysqli_query($this->conn, "

            DELETE FROM product_skinproblems

            WHERE product_id = '$product_id'
        ");

        // INSERT NEW
        foreach($problem_ids as $problem_id){

            mysqli_query($this->conn, "

                INSERT INTO product_skinproblems
                (product_id, problem_id)

                VALUES (
                    '$product_id',
                    '$problem_id'
                )
            ");
        }
    }

    // ================= DELETE ROW =================
    public function deleteAll($product_id){

        mysqli_query($this->conn, "

            DELETE FROM product_skinproblems

            WHERE product_id = '$product_id'
        ");
    }
}