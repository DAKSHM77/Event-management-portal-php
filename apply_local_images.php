<?php
require_once 'config/db.php';

echo "<h2>Applying Local Images...</h2>";

$mapping = [
    'Tech Summit 2025' => 'uploads/banners/techsummit.jpg',
    'Rock Concert Live' => 'uploads/banners/rock consert.jpg',
    'Startup Bootcamp' => 'uploads/banners/startup.jpg',
    'Gaming Championship' => 'uploads/banners/gaming.jpg',
    'City Marathon 2025' => 'uploads/banners/marathon.jpg'
];

foreach ($mapping as $title => $path) {
    // Check if file exists relative to root
    if (file_exists($path)) {
        // Find Event
        $stmt = $pdo->prepare("SELECT event_id FROM events WHERE title = ?");
        $stmt->execute([$title]);
        $event = $stmt->fetch();

        if ($event) {
            $eventId = $event['event_id'];

            // Delete old image
            $pdo->prepare("DELETE FROM event_images WHERE event_id = ?")->execute([$eventId]);

            // Insert new local image
            $pdo->prepare("INSERT INTO event_images (event_id, image_path) VALUES (?, ?)")
                ->execute([$eventId, $path]);

            echo "<div style='color:green'>Updated '$title' with '$path'</div>";
        } else {
            echo "<div style='color:red'>Event '$title' not found.</div>";
        }
    } else {
        echo "<div style='color:orange'>File '$path' not found. Skipping.</div>";
    }
}
?>