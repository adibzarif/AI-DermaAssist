<?php
require_once __DIR__ . '/../helpers/Database.php';

class ProductAdmin
{

public static function all()
{
    $db = Database::get();
    return $db->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}

public static function create($name, $brand, $description)
{
    $db = Database::get();
    $stmt = $db->prepare("
        INSERT INTO products (name, brand, description)
        VALUES (?, ?, ?)
    ");
    return $stmt->execute([$name, $brand, $description]);
}

public static function delete($id)
{
    $db = Database::get();
    $stmt = $db->prepare("DELETE FROM products WHERE id=?");
    return $stmt->execute([$id]);
}


    public static function find($id)
    {
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $name, $brand, $description)
    {
        $db = Database::get();
        $stmt = $db->prepare("UPDATE products SET name=?, brand=?, description=? WHERE id=?");
        return $stmt->execute([$name, $brand, $description, $id]);
    }

    // ==========================
    // PRICE CRUD
    // ==========================

    public static function getPrices($product_id)
    {
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM product_prices WHERE product_id=? ORDER BY price ASC");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addPrice($product_id, $store, $price, $url)
    {
        $db = Database::get();
        $stmt = $db->prepare("INSERT INTO product_prices (product_id, store_name, price, url) 
                              VALUES (?, ?, ?, ?)");
        return $stmt->execute([$product_id, $store, $price, $url]);
    }

    public static function deletePrice($price_id)
    {
        $db = Database::get();
        $stmt = $db->prepare("DELETE FROM product_prices WHERE id=?");
        return $stmt->execute([$price_id]);
    }

    // ==========================
    // INGREDIENTS
    // ==========================

    public static function getIngredients($product_id)
    {
        $db = Database::get();
        $sql = "SELECT i.id, i.name 
                FROM ingredients i
                JOIN product_ingredients pi ON pi.ingredient_id=i.id
                WHERE pi.product_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addIngredient($product_id, $ingredient_id)
    {
        $db = Database::get();
        $stmt = $db->prepare("INSERT IGNORE INTO product_ingredients (product_id, ingredient_id) VALUES (?, ?)");
        return $stmt->execute([$product_id, $ingredient_id]);
    }

    public static function removeIngredient($product_id, $ingredient_id)
    {
        $db = Database::get();
        $stmt = $db->prepare("DELETE FROM product_ingredients 
                              WHERE product_id=? AND ingredient_id=?");
        return $stmt->execute([$product_id, $ingredient_id]);
    }

    // ==========================
    // SKIN PROBLEMS
    // ==========================

    public static function getAllProblems()
    {
        $db = Database::get();
        return $db->query("SELECT * FROM skin_problems")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductProblems($product_id)
    {
        $db = Database::get();
        $stmt = $db->prepare("SELECT problem_id FROM product_skinproblems WHERE product_id=?");
        $stmt->execute([$product_id]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'problem_id');
    }

    public static function toggleProblem($product_id, $problem_id)
    {
        $db = Database::get();
        // Check exist
        $stmt = $db->prepare("SELECT * FROM product_skinproblems WHERE product_id=? AND problem_id=?");
        $stmt->execute([$product_id, $problem_id]);

        if ($stmt->fetch()) {
            // Remove
            $del = $db->prepare("DELETE FROM product_skinproblems WHERE product_id=? AND problem_id=?");
            return $del->execute([$product_id, $problem_id]);
        } else {
            // Add
            $add = $db->prepare("INSERT INTO product_skinproblems (product_id, problem_id) VALUES (?, ?)");
            return $add->execute([$product_id, $problem_id]);
        }
    }

    // ==========================
    // SKIN TYPES
    // ==========================

    public static function getAllSkinTypes()
    {
        $db = Database::get();
        return $db->query("SELECT * FROM skin_types")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductSkinTypes($product_id)
    {
        $db = Database::get();
        $stmt = $db->prepare("SELECT skintype_id FROM product_skintypes WHERE product_id=?");
        $stmt->execute([$product_id]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'skintype_id');
    }

    public static function toggleType($product_id, $type_id)
    {
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM product_skintypes WHERE product_id=? AND skintype_id=?");
        $stmt->execute([$product_id, $type_id]);

        if ($stmt->fetch()) {
            $del = $db->prepare("DELETE FROM product_skintypes WHERE product_id=? AND skintype_id=?");
            return $del->execute([$product_id, $type_id]);
        } else {
            $add = $db->prepare("INSERT INTO product_skintypes (product_id, skintype_id) VALUES (?, ?)");
            return $add->execute([$product_id, $type_id]);
        }
    }

    // ==========================
    // SKIN TONES
    // ==========================

    public static function getAllSkinTones()
    {
        $db = Database::get();
        return $db->query("SELECT * FROM skin_tones")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductSkinTones($product_id)
    {
        $db = Database::get();
        $stmt = $db->prepare("SELECT skintone_id FROM product_skintones WHERE product_id=?");
        $stmt->execute([$product_id]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'skintone_id');
    }

    public static function toggleTone($product_id, $tone_id)
    {
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM product_skintones WHERE product_id=? AND skintone_id=?");
        $stmt->execute([$product_id, $tone_id]);

        if ($stmt->fetch()) {
            $del = $db->prepare("DELETE FROM product_skintones WHERE product_id=? AND skintone_id=?");
            return $del->execute([$product_id, $tone_id]);
        } else {
            $add = $db->prepare("INSERT INTO product_skintones (product_id, skintone_id) VALUES (?, ?)");
            return $add->execute([$product_id, $tone_id]);
        }
    }
}
