<?php
// book_details.php
session_start();
require_once __DIR__ . '/database/bookDAO.php';

$bookDao = new bookDAO();

// Read and validate id
$bookId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($bookId <= 0) {
    $error = 'Invalid book ID.';
    $book = null;
} else {
    $book = $bookDao->getBookById($bookId);
    if (!$book) {
        $error = 'Book not found.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book Details - Digital Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
<nav class="navbar">
    <a href="index.php">Home</a>
    <a href="books.php">Books</a>
    <a href="my_borrowings.php">My Borrowings</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
</nav>
</header>

    <section class="content">

        <?php if (isset($_SESSION['borrow_error'])): ?>
            <div class="alert error"><?= htmlspecialchars($_SESSION['borrow_error']); ?></div>
            <?php unset($_SESSION['borrow_error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['borrow_success'])): ?>
            <div class="alert success"><?= htmlspecialchars($_SESSION['borrow_success']); ?></div>
            <?php unset($_SESSION['borrow_success']); ?>
        <?php endif; ?>


        <?php if (!empty($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php else: ?>
            <h2><?= htmlspecialchars($book['title']) ?></h2>
            <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>

            <?php if (!empty($book['published_year'])): ?>
                <p><strong>Year:</strong> <?= (int)$book['published_year'] ?></p>
            <?php endif; ?>

            <p><strong>Category:</strong> <?= htmlspecialchars($book['category']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($book['status']) ?></p>

            <p><a href="books.php">← Back to books</a></p>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($book['status'] === 'available'): ?>
                    <!-- Borrow form – we’ll implement borrow_book.php next -->
                    <form action="action/borrow_book.php" method="post">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        <button type="submit">Borrow this book</button>
                    </form>
                <?php else: ?>
                    <p><em>This book is not available for borrowing.</em></p>
                <?php endif; ?>
            <?php else: ?>
                <p><em><a href="login.php">Log in</a> to borrow this book.</em></p>
            <?php endif; ?>
        <?php endif; ?>
    </section>

</body>

</html>