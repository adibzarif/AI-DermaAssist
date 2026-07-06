<?php
session_start();
require_once "../app/helpers/Database.php";

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>'login']);
    exit;
}

$db = Database::get();

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;

if(!$product_id){
    echo json_encode(['status'=>'error']);
    exit;
}

$stmt = $db->prepare("SELECT id FROM wishlist WHERE user_id=? AND product_id=?");
$stmt->execute([$user_id, $product_id]);

if($stmt->fetch()){
    $db->prepare("DELETE FROM wishlist WHERE user_id=? AND product_id=?")
       ->execute([$user_id, $product_id]);

    echo json_encode(['status'=>'removed']);
}else{
    $db->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)")
       ->execute([$user_id, $product_id]);

    echo json_encode(['status'=>'added']);
}