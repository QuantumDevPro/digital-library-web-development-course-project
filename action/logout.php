<?php
session_start();

// Remove all session data
$_SESSION = [];
session_destroy();

// remove session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to home
header('Location: ../index.php');
exit;
