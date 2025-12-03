<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_error'] = 'Please log in to view your borrowings.';
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/database/borrowingDAO.php';

$borrowingDao = new borrowingDAO();
$borrowings   = $borrowingDao->getBorrowingsByUser($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Borrowings - Digital Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <?php require __DIR__ . '/partials/navbar.php'; ?>
    </header>


<section class="content">
    <h2>My Borrowings</h2>

    <?php if (isset($_SESSION['return_error'])): ?>
        <div class="alert error"><?= htmlspecialchars($_SESSION['return_error']); ?></div>
        <?php unset($_SESSION['return_error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['return_success'])): ?>
        <div class="alert success"><?= htmlspecialchars($_SESSION['return_success']); ?></div>
        <?php unset($_SESSION['return_success']); ?>
    <?php endif; ?>

    <?php if (empty($borrowings)): ?>
        <p>You have no borrowings.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Author</th>
                    <th>Borrowed At</th>
                    <th>Returned At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowings as $borrowing): ?>
                    <tr>
                        <td><?= htmlspecialchars($borrowing['title']) ?></td>
                        <td><?= htmlspecialchars($borrowing['author']) ?></td>
                        <td><?= htmlspecialchars($borrowing['borrowed_at']) ?></td>
                        <td>
                            <?= $borrowing['returned_at']
                                ? htmlspecialchars($borrowing['returned_at'])
                                : '<em>Not returned</em>' ?>
                        </td>
                        <td>
                            <?php if ($borrowing['returned_at'] === null): ?>
                                <form action="action/return_book.php" method="post" style="display:inline;">
                                    <input type="hidden" name="borrowing_id"
                                           value="<?= (int)$borrowing['id'] ?>">
                                    <button type="submit">Return</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

</body>
</html>
