<?php
session_start();
require_once __DIR__ . '/database/bookDAO.php';

$bookDao = new bookDAO();

// Read filters from GET
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
$category   = isset($_GET['category']) ? trim($_GET['category']) : '';

// Decide what to load
if ($searchTerm === '' && $category === '') {
    $books = $bookDao->getAllBooks();
} else {
    $books = $bookDao->searchBooks($searchTerm, $category);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Books - Digital Library</title>
<link rel="stylesheet" href="css/style.css">
<style>
    #book-search-form{
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f9fafb;
    border-radius: 6px;
}
</style>
</head>
<body>

    <header>
        <?php require __DIR__ . '/partials/navbar.php'; ?>
    </header>


<section class="content">
    <h2>Available Books</h2>

    <!-- Search / filter form -->
    <form action="books.php" method="get" id="book-search-form">
        <label for="q">Search (title, author, ISBN):</label><br>
        <input type="text" id="q" name="q"
               value="<?= htmlspecialchars($searchTerm) ?>">

        <label for="category">Category:</label><br>
        <select id="category" name="category">
            <option value="">-- Any Category --</option>
            <option value="Programming" <?= $category === 'Programming' ? 'selected' : '' ?>>Programming</option>
            <option value="Classic Literature" <?= $category === 'Classic Literature' ? 'selected' : '' ?>>Classic Literature</option>
            <option value="Dystopian" <?= $category === 'Dystopian' ? 'selected' : '' ?>>Dystopian</option>
            <option value="Self-Improvement" <?= $category === 'Self-Improvement' ? 'selected' : '' ?>>Self-Improvement</option>
        </select>

        <button type="submit">Search</button>
        <a href="books.php">Reset</a>
    </form>

    <hr>

    <?php if (empty($books)): ?>
        <p>No books found.</p>
    <?php else: ?>
        <div class="books-grid">
            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <h3><?= htmlspecialchars($book['title']) ?></h3>
                    <p>Author: <?= htmlspecialchars($book['author']) ?></p>

                    <?php if (!empty($book['published_year'])): ?>
                        <p>Year: <?= (int)$book['published_year'] ?></p>
                    <?php endif; ?>

                    <p>Category: <?= htmlspecialchars($book['category']) ?></p>
                    <p>Status: <?= htmlspecialchars($book['status']) ?></p>

                    <!-- details/borrow link -->
                    <a href="book_details.php?id=<?= $book['id'] ?>">View details</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</section>

</body>
</html>

