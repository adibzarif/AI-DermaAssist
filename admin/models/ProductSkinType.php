<?php
require_once __DIR__ . '/../config/database.php';

class ProductSkinType {

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
                ) as types,

                GROUP_CONCAT(
                    st.id
                ) as type_ids

            FROM product_skintypes pst

            JOIN products p
                ON p.id = pst.product_id

            JOIN skin_types st
                ON st.id = pst.skintype_id

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

            FROM product_skintypes pst

            JOIN products p
                ON p.id = pst.product_id

            JOIN skin_types st
                ON st.id = pst.skintype_id

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

    $skintype_id = $data['skintype_id'];

    // CHECK EXIST
    $check = mysqli_query($this->conn, "

        SELECT *

        FROM product_skintypes

        WHERE product_id = '$product_id'

        AND skintype_id = '$skintype_id'
    ");

    // INSERT IF NOT EXIST
    if(mysqli_num_rows($check) == 0){

        mysqli_query($this->conn, "

            INSERT INTO product_skintypes
            (product_id, skintype_id)

            VALUES (
                '$product_id',
                '$skintype_id'
            )
        ");
    }
}


// ================= UPDATE =================
public function update($product_id, $skintype_ids){

    // DELETE OLD
    mysqli_query($this->conn, "

        DELETE FROM product_skintypes

        WHERE product_id = '$product_id'
    ");

    // INSERT NEW
    foreach($skintype_ids as $type_id){

        mysqli_query($this->conn, "

            INSERT INTO product_skintypes
            (product_id, skintype_id)

            VALUES (
                '$product_id',
                '$type_id'
            )
        ");
    }
}

    // ================= DELETE =================
    public function deleteAll($product_id){

        mysqli_query($this->conn, "

            DELETE FROM product_skintypes

            WHERE product_id = '$product_id'
        ");
    }
}