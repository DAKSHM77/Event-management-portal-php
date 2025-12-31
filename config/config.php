<?php
// General Configuration
define('BASE_URL', 'http://localhost/2098_health/');
define('APP_NAME', 'Event Portal');

// Helper function for asset URLs
function asset($path)
{
    return BASE_URL . 'assets/' . ltrim($path, '/');
}

// Helper function for redirect
function redirect($url)
{
    header("Location: " . BASE_URL . ltrim($url, '/'));
    exit;
}

// Helper to check if logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Helper to get current user role
function getRole()
{
    return $_SESSION['role'] ?? null;
}
?>