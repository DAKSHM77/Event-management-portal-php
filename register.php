<?php
require_once 'app/controllers/AuthController.php';

$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['role'] === 'organization') {
        $auth->registerOrganization();
    } else {
        $auth->registerStudent();
    }
} else {
    require_once 'app/views/auth/register.php';
}
?>