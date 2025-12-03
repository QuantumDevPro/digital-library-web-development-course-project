<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_error'] = 'Please log in first.';
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../database/borrowingDAO.php';

$userId       = (int) $_SESSION['user_id'];
$borrowingId  = isset($_POST['borrowing_id']) ? (int) $_POST['borrowing_id'] : 0;

if ($borrowingId <= 0) {
    $_SESSION['return_error'] = 'Invalid borrowing.';
    header('Location: ../my_borrowings.php');
    exit;
}

try {
    $borrowingDao = new borrowingDAO();

    $ok = $borrowingDao->returnBorrowing($borrowingId, $userId);

    if ($ok) {
        $_SESSION['return_success'] = 'Book returned successfully.';
    } else {
        $_SESSION['return_error'] = 'Unable to return this book.';
    }

    header('Location: ../my_borrowings.php');
    exit;

} catch (Exception $e) {
    $_SESSION['return_error'] = 'An error occurred while returning the book.';
    header('Location: ../my_borrowings.php');
    exit;
}
