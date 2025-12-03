<?php
session_start();

require_once __DIR__ . '/../database/bookDAO.php';
require_once __DIR__ . '/../database/borrowingDAO.php';

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_error'] = 'Please log in to borrow books.';
    header('Location: ../login.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];
$bookId = isset($_POST['book_id']) ? (int) $_POST['book_id'] : 0;

// Basic validation
if ($bookId <= 0) {
    $_SESSION['borrow_error'] = 'Invalid book.';
    header('Location: ../books.php');
    exit;
}

try {
    $bookDao      = new bookDAO();
    $borrowingDao = new borrowingDAO();

    $book = $bookDao->getBookById($bookId);

    if (!$book) {
        $_SESSION['borrow_error'] = 'Book not found.';
        header('Location: ../books.php');
        exit;
    }

    if ($book['status'] !== 'available') {
        $_SESSION['borrow_error'] = 'This book is not available for borrowing.';
        header('Location: ../book_details.php?id=' . $bookId);
        exit;
    }

    // Check if user already has this book borrowed
    if ($borrowingDao->userHasActiveBorrowing($userId, $bookId)) {
        $_SESSION['borrow_error'] = 'You already have this book borrowed.';
        header('Location: ../book_details.php?id=' . $bookId);
        exit;
    }

    // Create borrowing
    if ($borrowingDao->createBorrowing($userId, $bookId)) {
        $_SESSION['borrow_success'] = 'Book borrowed successfully.';
    } else {
        $_SESSION['borrow_error'] = 'Failed to borrow the book.';
    }

    header('Location: ../book_details.php?id=' . $bookId);
    exit;

} catch (Exception $e) {
    $_SESSION['borrow_error'] = 'An error occurred while borrowing this book.';
    header('Location: ../book_details.php?id=' . $bookId);
    exit;
}
