<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar">
    <div class="nav-left">
        <a href="/web-project/books.php">Home</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/web-project/my_borrowings.php">My Borrowings</a>
        <?php endif; ?>
    </div>

    <div class="nav-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="welcome-text">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="/web-project/action/logout.php">Logout</a>
        <?php else: ?>
            <a href="/web-project/login.php">Login</a>
            <a href="/web-project/register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>
