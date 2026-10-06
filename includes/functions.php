<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}


function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: auth/login.php?error=unauthorized");
        exit();
    }
}
