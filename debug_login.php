<?php
require_once 'config/db.php';

$email = 'john@test.com';
$password = 'password123';
$role = 'student';

echo "<h2>Login Debugger</h2>";

// 1. Check DB Connection
if ($pdo)
    echo "Database Connected.<br>";

// 2. Fetch User
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    echo "User Found: " . $user['email'] . "<br>";
    echo "Role in DB: " . $user['role'] . " (Expected: $role)<br>";
    echo "Stored Hash: " . $user['password'] . "<br>";

    // 3. Verify Password
    if (password_verify($password, $user['password'])) {
        echo "<h3 style='color:green'>Password Verify PASSED</h3>";
    } else {
        echo "<h3 style='color:red'>Password Verify FAILED</h3>";
        echo "Generating new hash for 'password123': " . password_hash($password, PASSWORD_DEFAULT) . "<br>";
    }

    // 4. Role Check
    if ($user['role'] == $role) {
        echo "Role Match: YES<br>";
    } else {
        echo "Role Match: NO<br>";
    }

} else {
    echo "<h3 style='color:red'>User '$email' NOT FOUND in database.</h3>";
}
?>