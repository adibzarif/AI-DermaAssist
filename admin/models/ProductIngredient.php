<?php
require_once __DIR__ . '/../config/database.php';

class ProductIngredient {

    // ================= GET BY PRODUCT =================
    public static function getByProduct($product_id){

        $db = Database::connect();

        return $db->query("

            SELECT ingredient_id

            FROM product_ingredients

            WHERE product_id = $product_id
        ");
    }

    // ================= SAVE =================
    public static function save(
        $product_id,
        $ingredient_ids
    ){

        $db = Database::connect();

        // DELETE OLD
        $db->query("

            DELETE FROM product_ingredients

            WHERE product_id = $product_id
        ");

        // INSERT NEW
        foreach($ingredient_ids as $id){

            if(!$id) continue;

            // AVOID DUPLICATE
            $check = $db->query("

                SELECT *

                FROM product_ingredients

                WHERE product_id = $product_id

                AND ingredient_id = $id
            ");

            if($check->num_rows == 0){

                $db->query("

                    INSERT INTO product_ingredients
                    (product_id, ingredient_id)

                    VALUES ($product_id, $id)
                ");
            }
        }
    }

    // ================= TABLE =================
    public function getAllWithIngredients(
        $limit = 10,
        $offset = 0,
        $search = ''
    ){

        $db = Database::connect();

        return $db->query("

            SELECT
                p.id,
                p.name,

                GROUP_CONCAT(
                    i.name SEPARATOR ','
                ) as ingredients,

                GROUP_CONCAT(
                    i.id
                ) as ingredient_ids

            FROM product_ingredients pi

            JOIN products p
                ON p.id = pi.product_id

            JOIN ingredients i
                ON pi.ingredient_id = i.id

            WHERE
                p.name LIKE '%$search%'
                OR i.name LIKE '%$search%'

            GROUP BY p.id

            ORDER BY p.id DESC

            LIMIT $limit OFFSET $offset
        ");
    }

    // ================= COUNT =================
    public function countAll($search = ''){

        $db = Database::connect();

        $result = $db->query("

            SELECT COUNT(DISTINCT p.id) as total

            FROM product_ingredients pi

            JOIN products p
                ON p.id = pi.product_id

            JOIN ingredients i
                ON pi.ingredient_id = i.id

            WHERE
                p.name LIKE '%$search%'
                OR i.name LIKE '%$search%'
        ");

        $row = $result->fetch_assoc();

        return $row['total'];
    }

    // ================= DELETE ALL =================
    public static function deleteAll($product_id){

        $db = Database::connect();

        $db->query("

            DELETE FROM product_ingredients

            WHERE product_id = '$product_id'
        ");
    }
}