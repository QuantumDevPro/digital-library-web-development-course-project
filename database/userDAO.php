<?php
require_once __DIR__.'/database.php';

class userDAO{
    private $pdo;

    public function __construct(){
        $this->pdo = database::getInstance()->getConnection();
    }

    //get a singel user by ID
    public function getUserById($id){
        $sql = "SELECT id, name, email, password_hash
                FROM users
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    //get a single user by email. for login
    public function getUserByEmail($email){
        $sql = "SELECT id, name, email, password_hash
                FROM users
                WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Insert a new user (status uses DB default: 'active')
    public function addUser($name, $email, $passwordHash)
    {
        $sql = "INSERT INTO users (name, email, password_hash)
                VALUES (:name, :email, :password_hash)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':name',  $name,  PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);

        return $stmt->execute(); // true/false
    }

    // Search users by name or email. for search pages
    public function searchUsers($searchTerm){
        $sql = "SELECT *
                FROM users
                WHERE name like :name_term
                    OR email LIKE :email_term";
        $stmt = $this->pdo->prepare($sql);
        // '%a%' → contains "a" anywhere
        $pattern = '%'.$searchTerm.'%';
        $stmt->bindValue(':name_term',  $pattern, PDO::PARAM_STR);
        $stmt->bindValue(':email_term', $pattern, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}