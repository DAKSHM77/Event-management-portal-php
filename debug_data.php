<?php
require_once 'app/controllers/AdminController.php';

echo "<h2>Debug Data Integrity</h2>";
global $pdo;

echo "<h3>1. All Users</h3>";
$orgUsers = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Verified</th><th>Status</th></tr>";
foreach ($orgUsers as $u) {
    echo "<tr><td>{$u['user_id']}</td><td>{$u['name']}</td><td>{$u['is_verified']}</td><td>{$u['status']}</td></tr>";
}
echo "</table>";

echo "<h3>2. Organizations Table</h3>";
$orgs = $pdo->query("SELECT * FROM organizations")->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'><tr><th>Org ID</th><th>User ID</th><th>Name</th><th>Status</th></tr>";
foreach ($orgs as $o) {
    echo "<tr><td>{$o['org_id']}</td><td>{$o['user_id']}</td><td>{$o['org_name']}</td><td>{$o['approval_status']}</td></tr>";
}
echo "</table>";

echo "<h3>3. Orphan Users (Role Org but no Org Profile)</h3>";
foreach ($orgUsers as $u) {
    $found = false;
    foreach ($orgs as $o) {
        if ($o['user_id'] == $u['user_id'])
            $found = true;
    }
    if (!$found) {
        echo "User ID {$u['user_id']} ({$u['name']}) is missing from organizations table!<br>";
    }
}
?>