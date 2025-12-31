<?php
require_once 'config/db.php';

echo "<h2>Forcing Password Update...</h2>";

$new_password = 'password123';
$hash = password_hash($new_password, PASSWORD_DEFAULT);

try {
    // Update ALL users to have this password
    $stmt = $pdo->prepare("UPDATE users SET password = ?");
    $stmt->execute([$hash]);

    echo "<h3>SUCCESS: All user passwords updated to '$new_password'</h3>";
    echo "Generated Hash Used: $hash<br>";

    // Configure Admin specifically if needed (already updated by above, but ensuring role)
    $pdo->exec("UPDATE users SET role='admin', status='active', is_verified=1 WHERE email='admin@eventportal.com'");

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>