<?php
require_once __DIR__ . '/../helpers/Database.php';

class Profile {

    public function get($id){
        $db = Database::get();

        $stmt = $db->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $name, $email){
    $db = Database::get();

    $stmt = $db->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    return $stmt->execute([$name, $email, $id]);
}

public function changePassword($id, $password){
    $db = Database::get();

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("UPDATE users SET password=? WHERE id=?");
    return $stmt->execute([$hashed, $id]);
}
}