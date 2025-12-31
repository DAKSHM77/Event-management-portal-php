<?php
require_once 'config/db.php';

$password = password_hash('admin123', PASSWORD_DEFAULT);
$email = 'admin@eventportal.com';
$name = 'Super Admin';
$role = 'admin';
$status = 'active';
$is_verified = 1;

try {
    // Check if admin exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo "Admin user already exists.<br>";
        echo "Email: $email<br>";
        echo "Password: admin123<br>";
    } else {
        $sql = "INSERT INTO users (name, email, phone, password, role, is_verified, status) VALUES (?, ?, '0000000000', ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $password, $role, $is_verified, $status]);
        echo "Admin user created successfully!<br>";
        echo "Email: $email<br>";
        echo "Password: admin123<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>