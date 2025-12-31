<?php
require_once '../app/views/layouts/organizer_header.php';
require_once '../app/controllers/OrganizerController.php';

$org = new OrganizerController();
$events = $org->getMyEvents();
?>

<h2>My Events</h2>
<hr>

<div class="panel">
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Dates</th>
                    <th>Price</th>
                    <th>Seats</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                        <td><?php echo $event['start_date'] . ' to ' . $event['end_date']; ?></td>
                        <td><?php echo $event['ticket_price'] > 0 ? '$' . $event['ticket_price'] : 'Free'; ?></td>
                        <td><?php echo $event['seat_limit']; ?></td>
                        <td>
                            <?php
                            $label = 'default';
                            if ($event['status'] == 'approved')
                                $label = 'success';
                            elseif ($event['status'] == 'rejected')
                                $label = 'danger';
                            elseif ($event['status'] == 'pending')
                                $label = 'warning';
                            ?>
                            <span class="label label-<?php echo $label; ?>">
                                <?php echo ucfirst($event['status']); ?>
                            </span>
                            <?php if ($event['status'] == 'rejected'): ?>
                                <br><small
                                    class="text-danger"><?php echo htmlspecialchars($event['rejection_reason']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="participants.php?event_id=<?php echo $event['event_id']; ?>"
                                class="btn btn-info btn-xs">Participants</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../app/views/layouts/organizer_footer.php'; ?>