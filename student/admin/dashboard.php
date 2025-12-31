<?php
require_once '../app/views/layouts/admin_header.php';
require_once '../app/controllers/AdminController.php';

$admin = new AdminController();
$stats = $admin->getDashboardStats();
?>

<h2>Dashboard</h2>
<hr>

<div class="row">
    <div class="col-md-3">
        <div class="stat-card">
            <h3><?php echo $stats['users']; ?></h3>
            <p>Total Users</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3><?php echo $stats['organizations']; ?></h3>
            <p>Organizations</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3><?php echo $stats['events']; ?></h3>
            <p>Total Events</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>$<?php echo number_format($stats['revenue'], 2); ?></h3>
            <p>Total Revenue</p>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 30px;">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Recent Operations</div>
            <div class="panel-body">
                <p>System operational. Check notifications for pending approvals.</p>
                <a href="organizations.php" class="btn btn-primary btn-sm">Manage Organizations</a>
                <a href="events.php" class="btn btn-warning btn-sm">Manage Events</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/admin_footer.php'; ?>