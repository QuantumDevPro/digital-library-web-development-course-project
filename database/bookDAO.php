<?php
require_once __DIR__ . '/database.php';

class bookDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Get all books
    public function getAllBooks()
    {
        $sql = "SELECT id, title, author, published_year, category, status
                FROM books
                ORDER BY created_at DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single book by ID. for details page, borrow, etc.
    public function getBookById($id)
    {
        $sql = "SELECT id, title, author, published_year, category, status
                FROM books
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchBooks($searchTerm, $category = '')
    {
        $sql = "SELECT id, title, author, published_year, category, status
            FROM books
            WHERE (
                title  LIKE :term_title
                OR author LIKE :term_author
                OR isbn   LIKE :term_isbn
            )";

        if ($category !== '') {
            $sql .= " AND category = :category";
        }

        $stmt = $this->pdo->prepare($sql);

        $like = '%' . $searchTerm . '%';
        $stmt->bindValue(':term_title',  $like, PDO::PARAM_STR);
        $stmt->bindValue(':term_author', $like, PDO::PARAM_STR);
        $stmt->bindValue(':term_isbn',   $like, PDO::PARAM_STR);

        if ($category !== '') {
            $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
