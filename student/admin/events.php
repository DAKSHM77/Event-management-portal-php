<?php
require_once '../app/views/layouts/admin_header.php';
require_once '../app/controllers/AdminController.php';

$admin = new AdminController();

if (isset($_GET['approve'])) {
    $admin->approveEvent($_GET['approve']);
    echo "<script>window.location.href='events.php';</script>";
}
if (isset($_POST['reject_id'])) {
    $reason = $_POST['reason'];
    $id = $_POST['reject_id'];
    $admin->rejectEvent($id, $reason);
    echo "<script>window.location.href='events.php';</script>";
}

$pendingEvents = $admin->getPendingEvents();
$allEvents = $admin->getAllEvents();
?>

<h2>Manage Events</h2>
<hr>

<!-- Pending Events -->
<div class="panel panel-warning" style="margin-bottom: 30px;">
    <div class="panel-heading">Pending Approvals</div>
    <div class="panel-body">
        <?php if (count($pendingEvents) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Organizer</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendingEvents as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['title']); ?></td>
                            <td><?php echo htmlspecialchars($event['org_name']); ?></td>
                            <td><?php echo htmlspecialchars($event['category_name']); ?></td>
                            <td><?php echo $event['start_date']; ?></td>
                            <td><?php echo $event['ticket_price'] > 0 ? '$' . $event['ticket_price'] : 'Free'; ?></td>
                            <td>
                                <a href="events.php?approve=<?php echo $event['event_id']; ?>" class="btn btn-success btn-xs"
                                    onclick="return confirm('Approve event?');">Approve</a>
                                <button class="btn btn-danger btn-xs"
                                    onclick="document.getElementById('reject-<?php echo $event['event_id']; ?>').style.display='block'">Reject</button>

                                <form method="post" id="reject-<?php echo $event['event_id']; ?>"
                                    style="display:none; margin-top:5px;">
                                    <input type="hidden" name="reject_id" value="<?php echo $event['event_id']; ?>">
                                    <input type="text" name="reason" placeholder="Reason" required class="form-control input-sm"
                                        style="display:inline-block; width:150px;">
                                    <button type="submit" class="btn btn-xs btn-primary">Confirm</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pending events.</p>
        <?php endif; ?>
    </div>
</div>

<!-- All Events List -->
<h3>All Events Log</h3>
<table class="table table-condensed table-hover">
    <thead>
        <tr>
            <th>Event</th>
            <th>Organizer</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allEvents as $event): ?>
            <tr>
                <td><?php echo htmlspecialchars($event['title']); ?></td>
                <td><?php echo htmlspecialchars($event['org_name']); ?></td>
                <td>
                    <span
                        class="label label-<?php echo $event['status'] == 'approved' ? 'success' : ($event['status'] == 'rejected' ? 'danger' : 'default'); ?>">
                        <?php echo ucfirst($event['status']); ?>
                    </span>
                </td>
                <td><?php echo $event['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../app/views/layouts/admin_footer.php'; ?>