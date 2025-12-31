<?php
require_once 'app/controllers/AuthController.php';

$auth = new AuthController();
$auth->login();

// If not POST (handled by login method), show view
require_once 'app/views/auth/login.php';
?>