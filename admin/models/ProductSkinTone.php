<?php
require_once __DIR__ . '/../config/database.php';

class ProductSkinTone {

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
                    st.name SEPARATOR ','
                ) as tones,

                GROUP_CONCAT(
                    st.id
                ) as tone_ids

            FROM product_skintones pst

            JOIN products p
                ON p.id = pst.product_id

            JOIN skin_tones st
                ON st.id = pst.skintone_id

            WHERE
                p.name LIKE '%$search%'
                OR st.name LIKE '%$search%'

            GROUP BY p.id

            ORDER BY p.id DESC

            LIMIT $limit OFFSET $offset
        ");
    }

    // ================= COUNT =================
    public function countAll($search = ''){

        $result = mysqli_query($this->conn, "

            SELECT COUNT(DISTINCT p.id) as total

            FROM product_skintones pst

            JOIN products p
                ON p.id = pst.product_id

            JOIN skin_tones st
                ON st.id = pst.skintone_id

            WHERE
                p.name LIKE '%$search%'
                OR st.name LIKE '%$search%'
        ");

        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }

    // ================= INSERT =================
    public function insert($data){

        $product_id = $data['product_id'];

        $skintone_id = $data['skintone_id'];

        $check = mysqli_query($this->conn, "

            SELECT *

            FROM product_skintones

            WHERE product_id = '$product_id'

            AND skintone_id = '$skintone_id'
        ");

        if(mysqli_num_rows($check) == 0){

            mysqli_query($this->conn, "

                INSERT INTO product_skintones
                (product_id, skintone_id)

                VALUES (
                    '$product_id',
                    '$skintone_id'
                )
            ");
        }
    }

    // ================= UPDATE =================
    public function update($product_id, $skintone_ids){

        mysqli_query($this->conn, "

            DELETE FROM product_skintones

            WHERE product_id = '$product_id'
        ");

        foreach($skintone_ids as $tone_id){

            mysqli_query($this->conn, "

                INSERT INTO product_skintones
                (product_id, skintone_id)

                VALUES (
                    '$product_id',
                    '$tone_id'
                )
            ");
        }
    }

    // ================= DELETE ROW =================
    public function deleteAll($product_id){

        mysqli_query($this->conn, "

            DELETE FROM product_skintones

            WHERE product_id = '$product_id'
        ");
    }
}