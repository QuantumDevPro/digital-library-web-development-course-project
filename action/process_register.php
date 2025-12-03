<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once __DIR__ . '/../database/userDAO.php';

// checks if a POST field exists. If yes → take it. If not → use an empty string
$name  = isset($_POST['name'])  ? trim($_POST['name'])  : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

$hash = password_hash($password, PASSWORD_DEFAULT);


if ($name === '' || $email === '' || $password === '') {
    $_SESSION['register_error'] = 'All fields are required.';
    header('Location: ../register.php');
    exit;
}

// simple email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = 'Invalid email format.';
    header('Location: ../register.php');
    exit;
}

try {
    $userDAO = new userDAO();
    $ok = $userDAO->addUser($name, $email, $hash);

    if ($ok) {
        $_SESSION['register_success'] = 'user registered successfully.';
    } else {
        $_SESSION['register_error'] = 'failed to register user.';
    }
} catch (Exception $e) {
    // // Log error
    // error_log('rser registration error: '.$e->getMessage());
    // // inform user with error
    // $_SESSION['register_error'] = 'An error occurred while registering. Please try again.';
    die('DEBUG ERROR: ' . $e->getMessage());

    // Redirect back to the form
    header('Location: ../register.php');
    exit;
}
