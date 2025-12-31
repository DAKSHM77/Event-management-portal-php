<?php
require_once '../app/views/layouts/organizer_header.php';
require_once '../app/controllers/OrganizerController.php';

$org = new OrganizerController();
$eventId = $_GET['event_id'] ?? 0;

// Ideally move logic to Controller
// Checking if event belongs to org
$pdo = $GLOBALS['pdo']; // Quick access or use controller method
$registrations = $pdo->query("SELECT r.*, u.name, u.email, u.phone, p.payment_status FROM registrations r 
                                JOIN users u ON r.user_id = u.user_id 
                                LEFT JOIN payments p ON r.registration_id = p.registration_id
                                WHERE r.event_id = $eventId")->fetchAll();
?>

<h2>Participants</h2>
<a href="my-events.php" class="btn btn-default btn-xs">&larr; Back to Events</a>
<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Registered At</th>
            <th>Payment Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($registrations as $reg): ?>
            <tr>
                <td><?php echo htmlspecialchars($reg['name']); ?></td>
                <td><?php echo htmlspecialchars($reg['email']); ?></td>
                <td><?php echo htmlspecialchars($reg['phone']); ?></td>
                <td><?php echo $reg['registered_at']; ?></td>
                <td><?php echo ucfirst($reg['payment_status'] ?? 'N/A'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../app/views/layouts/organizer_footer.php'; ?>