<?php
require_once __DIR__ . '/../config/database.php';

class UserManagement {

    private $conn;

    public function __construct(){
        $this->conn = Database::connect();
    }

    // ================= GET ALL USERS =================
    public function getAll(){

        return mysqli_query($this->conn, "
            SELECT * FROM users
            ORDER BY created_at DESC
        ");
    }

// ================= SAVE USER =================
    public function save($data){

        $stmt = mysqli_prepare($this->conn,
            "INSERT INTO users(name,email,password_hash)
            VALUES(?,?,?)"
        );

        $password = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $data['name'],
            $data['email'],
            $password
        );

        return mysqli_stmt_execute($stmt);
    }

    // ================= UPDATE USER =================
    public function update($data){

        $stmt = mysqli_prepare($this->conn,
            "UPDATE users
             SET name=?, email=?
             WHERE id=?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $data['name'],
            $data['email'],
            $data['id']
        );

        return mysqli_stmt_execute($stmt);
    }

    // ================= DELETE USER =================
    public function delete($id){

        mysqli_query($this->conn,
            "DELETE FROM users WHERE id=$id"
        );
    }
}