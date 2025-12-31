<?php
require_once '../app/views/layouts/student_header.php';
require_once '../app/controllers/StudentController.php';

$student = new StudentController();
$registrations = $student->getMyRegistrations();
?>

<h2>My Registrations</h2>
<hr>

<?php if (count($registrations) > 0): ?>
    <div class="row">
        <?php foreach ($registrations as $reg): ?>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><?php echo htmlspecialchars($reg['title']); ?></h4>
                        <p><i class="fa fa-clock-o"></i> <?php echo $reg['start_date'] . ' ' . $reg['start_time']; ?></p>
                        <p><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($reg['venue']); ?></p>
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>Ticket Code:</strong><br>
                                <code><?php echo $reg['ticket_code'] ?? 'PENDING'; ?></code>
                            </div>
                            <div class="col-xs-6 text-right">
                                <a href="ticket.php?id=<?php echo $reg['registration_id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-qrcode"></i> View Ticket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">You haven't registered for any events yet.</div>
    <a href="events.php" class="btn btn-primary">Browse Events</a>
<?php endif; ?>

<?php require_once '../app/views/layouts/student_footer.php'; ?>