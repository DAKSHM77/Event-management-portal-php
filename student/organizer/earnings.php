<?php
require_once '../app/views/layouts/organizer_header.php';
require_once '../app/controllers/OrganizerController.php';

$org = new OrganizerController();
$stats = $org->getDashboardStats();

// Fetch detailed earnings history if needed, for now just summary
?>

<h2>Earnings</h2>
<hr>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Total Wallet Balance</div>
            <div class="panel-body">
                <h1>$<?php echo number_format($stats['earnings'] ?? 0, 2); ?></h1>
                <p class="text-muted">Available for payout</p>
                <button class="btn btn-success" disabled>Request Payout (Coming Soon)</button>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/organizer_footer.php'; ?>