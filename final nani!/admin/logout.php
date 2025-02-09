<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Explicitly expire the session cookie by setting the cookie with a past expiration time
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000, 
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Redirect to login page or homepage
header('Location: ../index.html');
exit(); // Always use exit after a redirect
?>
