<?php
require_once __DIR__ . '/database.php';

class borrowingDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Check if user already has this book borrowed (not returned yet)
    public function userHasActiveBorrowing($userId, $bookId) {
        $sql = "SELECT COUNT(*) 
                FROM borrowings
                WHERE user_id = :uid
                  AND book_id = :bid
                  AND returned_at IS NULL";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':bid', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    // Create a new borrowing
    public function createBorrowing($userId, $bookId) {
        $sql = "INSERT INTO borrowings (user_id, book_id, borrowed_at)
                VALUES (:uid, :bid, NOW())";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':bid', $bookId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // List borrowings of a user
    public function getBorrowingsByUser($userId) {
        $sql = "SELECT br.id, br.borrowed_at, br.returned_at,
                       b.title, b.author
                FROM borrowings br
                JOIN books b ON br.book_id = b.id
                WHERE br.user_id = :uid
                ORDER BY br.borrowed_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mark borrowing as returned
    public function returnBorrowing($borrowingId, $userId) {
        $sql = "UPDATE borrowings
                SET returned_at = NOW()
                WHERE id = :id
                  AND user_id = :uid
                  AND returned_at IS NULL";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id',  $borrowingId, PDO::PARAM_INT);
        $stmt->bindValue(':uid', $userId,      PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0; // true if something was updated
    }
}
