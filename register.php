<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Digital Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <?php require __DIR__ . '/partials/navbar.php'; ?>
    </header>


    <section class="form-container">
        <h2>Create Account</h2>


        <form action="action/process_register.php" method="post">
            <label for="user_name">Full Name:</label>
            <input type="text" id="user_name" name="name" required>

            <label for="user_email">Email:</label>
            <input type="email" id="user_email" name="email" required>

            <label for="user_pass">Password:</label>
            <input type="password" id="user_pass" name="password" required>

            <?php if (isset($_SESSION['register_error'])): ?>
                <div class="alert error"><?= htmlspecialchars($_SESSION['register_error']); ?></div>
                <?php unset($_SESSION['register_error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['register_success'])): ?>
                <div class="alert success"><?= htmlspecialchars($_SESSION['register_success']); ?></div>
                <?php unset($_SESSION['register_success']); ?>
            <?php endif; ?>

            <button type="submit">Register</button>
        </form>


    </section>

</body>

</html>