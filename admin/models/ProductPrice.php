<?php

require_once __DIR__ . '/../config/database.php';

class ProductPrice {

    private $conn;

    public function __construct(){

        $this->conn = Database::connect();
    }

    // ================= GET ALL =================
    public function getAll(
        $search = '',
        $limit = 10,
        $offset = 0
    ){

        $search = mysqli_real_escape_string(
            $this->conn,
            $search
        );

        return mysqli_query($this->conn, "

            SELECT
                pp.*,
                p.name as product_name

            FROM product_prices pp

            JOIN products p
                ON p.id = pp.product_id

            WHERE
                p.name LIKE '%$search%'
                OR pp.store_name LIKE '%$search%'

            ORDER BY pp.id DESC

            LIMIT $limit OFFSET $offset
        ");
    }

    // ================= COUNT =================
    public function countAll($search = ''){

        $search = mysqli_real_escape_string(
            $this->conn,
            $search
        );

        $result = mysqli_query($this->conn, "

            SELECT COUNT(*) as total

            FROM product_prices pp

            JOIN products p
                ON p.id = pp.product_id

            WHERE
                p.name LIKE '%$search%'
                OR pp.store_name LIKE '%$search%'
        ");

        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }

    // ================= GET PRODUCTS =================
    public function getProducts(){

        return mysqli_query($this->conn, "
            SELECT * FROM products
            ORDER BY name ASC
        ");
    }

    // ================= SAVE =================
    public function save($data){

        $stmt = mysqli_prepare($this->conn,
            "INSERT INTO product_prices
            (product_id, store_name, price, url)
            VALUES(?,?,?,?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "isds",
            $data['product_id'],
            $data['store_name'],
            $data['price'],
            $data['url']
        );

        return mysqli_stmt_execute($stmt);
    }

    // ================= UPDATE =================
    public function update($data){

        $stmt = mysqli_prepare($this->conn,
            "UPDATE product_prices
            SET product_id=?, store_name=?, price=?, url=?
            WHERE id=?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "isdsi",
            $data['product_id'],
            $data['store_name'],
            $data['price'],
            $data['url'],
            $data['id']
        );

        return mysqli_stmt_execute($stmt);
    }

    // ================= DELETE =================
    public function delete($id){

        mysqli_query($this->conn,
            "DELETE FROM product_prices
             WHERE id=$id"
        );
    }
}