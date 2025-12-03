<?php

require_once __DIR__ . '/../database/userDAO.php';

session_start();

// checks if a POST field exists. If yes → take it. If not → use an empty string
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($email === '' || $password === '') {
    $_SESSION['login_error'] = 'email and password are required.';
    header('Location: ../login.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_error'] = 'Invalid email format.';
    header('Location: ../login.php');
    exit;
}

try {
    $userDao = new userDAO();
    $user = $userDao->getUserByEmail($email);


    if (!$user) {
        $_SESSION['login_error'] = 'Invalid email or password.';
        header('Location: ../login.php');
        exit;
    }

    // 2) wrong password (compare plain text with hash from DB)
    if (!password_verify($password, $user['password_hash'])) {
        $_SESSION['login_error'] = 'Invalid email or password.';
        header('Location: ../login.php');
        exit;
    }


    // successful user login
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['login_success'] = 'Login successful.';

    header('Location: ../books.php');
    exit;
} catch (Exception $e) {
    error_log('Login error: ' . $e->getMessage());
    $_SESSION['login_error'] = 'An error occurred. Please try again.';
    header('Location: ../login.php');
    exit;
}
