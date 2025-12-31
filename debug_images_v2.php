<?php
require_once 'config/db.php';

echo "<h2>Image Debugger</h2>";

try {
    // 1. Check Event Images Table
    $stmt = $pdo->query("SELECT COUNT(*) FROM event_images");
    $count = $stmt->fetchColumn();
    echo "Total Images in DB: " . $count . "<br>";

    // 2. Check Join
    $sql = "SELECT e.event_id, e.title, i.image_path 
            FROM events e 
            LEFT JOIN event_images i ON e.event_id = i.event_id";
    $events = $pdo->query($sql)->fetchAll();

    echo "<table border='1'><tr><th>Event ID</th><th>Title</th><th>Image Path</th></tr>";
    foreach ($events as $evt) {
        echo "<tr>";
        echo "<td>" . $evt['event_id'] . "</td>";
        echo "<td>" . htmlspecialchars($evt['title']) . "</td>";
        echo "<td>" . ($evt['image_path'] ? htmlspecialchars($evt['image_path']) : 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>