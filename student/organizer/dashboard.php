<?php
require_once '../app/views/layouts/organizer_header.php';
require_once '../app/controllers/OrganizerController.php';

$org = new OrganizerController();
$status = $org->getApprovalStatus();
$stats = $org->getDashboardStats();
?>

<h2>Dashboard</h2>
<hr>

<?php if ($status == 'pending'): ?>
    <div class="alert alert-warning">
        <strong>Notice:</strong> Your organization account is currently PENDING APPROVAL. You cannot create events until an
        admin approves your profile.
    </div>
<?php elseif ($status == 'rejected'): ?>
    <div class="alert alert-danger">
        <strong>Notice:</strong> Your organization account was REJECTED. Please contact support.
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default text-center">
            <div class="panel-body">
                <h3><?php echo $stats['total_events'] ?? 0; ?></h3>
                <p>Total Events</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-success text-center">
            <div class="panel-body">
                <h3><?php echo $stats['active_events'] ?? 0; ?></h3>
                <p>Active Approved Events</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-info text-center">
            <div class="panel-body">
                <h3>$<?php echo number_format($stats['earnings'] ?? 0, 2); ?></h3>
                <p>Total Earnings</p>
            </div>
        </div>
    </div>
</div>

<?php if ($status == 'approved'): ?>
    <div class="text-center" style="margin-top: 20px;">
        <a href="create-event.php" class="btn btn-primary btn-lg">Create New Event</a>
    </div>
<?php endif; ?>

<?php require_once '../app/views/layouts/organizer_footer.php'; ?>