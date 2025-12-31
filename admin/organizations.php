<?php
require_once '../app/views/layouts/admin_header.php';
require_once '../app/controllers/AdminController.php';

$admin = new AdminController();

if (isset($_GET['approve'])) {
    $admin->approveOrganization($_GET['approve']);
    echo "<script>window.location.href='organizations.php';</script>";
}
if (isset($_GET['reject'])) {
    $admin->rejectOrganization($_GET['reject']);
    echo "<script>window.location.href='organizations.php';</script>";
}

$pendingOrgs = $admin->getPendingOrganizations();
?>

<h2>Manage Organizations</h2>
<hr>

<div class="panel panel-info">
    <div class="panel-heading">Pending Approvals</div>
    <div class="panel-body">
        <?php if (count($pendingOrgs) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Org Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Document</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingOrgs as $org): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($org['org_name']); ?></td>
                                <td><?php echo htmlspecialchars($org['name']); ?></td>
                                <td><?php echo htmlspecialchars($org['email']); ?></td>
                                <td>
                                    <?php if ($org['document_path']): ?>
                                        <a href="<?php echo '../' . $org['document_path']; ?>" target="_blank"
                                            class="btn btn-xs btn-default">View Doc</a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($org['description']); ?></td>
                                <td>
                                    <a href="organizations.php?approve=<?php echo $org['org_id']; ?>"
                                        class="btn btn-success btn-xs"
                                        onclick="return confirm('Approve this organization?');">Approve</a>
                                    <a href="organizations.php?reject=<?php echo $org['org_id']; ?>"
                                        class="btn btn-danger btn-xs"
                                        onclick="return confirm('Reject this organization?');">Reject</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No pending organizations.</p>
        <?php endif; ?>
    </div>
</div>

<?php
$allOrgs = $admin->getAllOrganizations();
?>

<h3>All Organizations Log</h3>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Org Name</th>
                <th>Owner</th>
                <th>Email</th>
                <th>Status</th>
                <th>Joined At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allOrgs as $org): ?>
                <tr>
                    <td><?php echo htmlspecialchars($org['org_name']); ?></td>
                    <td><?php echo htmlspecialchars($org['name']); ?></td>
                    <td><?php echo htmlspecialchars($org['email']); ?></td>
                    <td>
                        <span
                            class="label label-<?php echo $org['approval_status'] == 'approved' ? 'success' : ($org['approval_status'] == 'rejected' ? 'danger' : 'warning'); ?>">
                            <?php echo ucfirst($org['approval_status']); ?>
                        </span>
                    </td>
                    <td><?php echo $org['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../app/views/layouts/admin_footer.php'; ?>