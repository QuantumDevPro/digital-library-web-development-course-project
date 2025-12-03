<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Digital Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <?php require __DIR__ . '/partials/navbar.php'; ?>
    </header>


    <section class="form-container">
        <h2>Login</h2>

        <form action="action/process-login.php" method="post">
            <label for="user_email">Email:</label>
            <input type="email" id="user_email" name="email" required>

            <label for="user_pass">Password:</label>
            <input type="password" id="user_pass" name="password" required>

            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert error"><?= htmlspecialchars($_SESSION['login_error']); ?></div>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['login_success'])): ?>
                <div class="alert success"><?= htmlspecialchars($_SESSION['login_success']); ?></div>
                <?php unset($_SESSION['login_success']); ?>
            <?php endif; ?>

            <button type="submit">Login</button>

        </form>
        
    </section>

</body>

</html>