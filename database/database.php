<?php
require_once __DIR__.'/../config/database.php';

class Database {
    // Holds the single instance
    private static $instance = null;
    // PDO connection
    private $pdo;

    // Private constructor prevents creating new instances from outside
    private function __construct(){
        try{
            global $pdo_options;
            $this->pdo = new PDO(DB_DSN, DB_USER, DB_PASS, $pdo_options);
        } catch (PDOException $e){
            // Log real error
            error_log("database connecton failed: ".$e->getMessage());
            // hide technical details from user
            throw new Exception("database connection failed");
        }
    }

    // Singleton access point
    public static function getInstance() {
        // self:: refers to the current class, not an object.
        // It’s used to access static properties and static methods
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Return pdo object
    public function getConnection() {
        return $this->pdo;
    }
}