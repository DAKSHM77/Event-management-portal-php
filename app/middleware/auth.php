<?php
function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php?error=access_denied');
    }
}

function requireRole($role)
{
    requireLogin();
    if ($_SESSION['role'] !== $role) {
        redirect('login.php?error=unauthorized');
    }
}
?>