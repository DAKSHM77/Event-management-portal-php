<?php
require_once '../app/views/layouts/admin_header.php';
require_once '../app/controllers/AdminController.php';

$admin = new AdminController();

if (isset($_GET['block'])) {
    $admin->toggleUserStatus($_GET['block'], 'blocked');
    echo "<script>window.location.href='users.php';</script>";
}
if (isset($_GET['activate'])) {
    $admin->toggleUserStatus($_GET['activate'], 'active');
    echo "<script>window.location.href='users.php';</script>";
}

$users = $admin->getAllUsers();
?>

<h2>Users Management</h2>
<hr>

<div class="panel">
    <div class="panel-body table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Verified</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo ucfirst($user['role']); ?></td>
                        <td>
                            <span class="label label-<?php echo $user['status'] == 'active' ? 'success' : 'danger'; ?>">
                                <?php echo ucfirst($user['status']); ?>
                            </span>
                        </td>
                        <td><?php echo $user['is_verified'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($user['created_at'])); ?></td>
                        <td>
                            <?php if ($user['status'] == 'active'): ?>
                                <a href="users.php?block=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-xs"
                                    onclick="return confirm('Block this user?');">Block</a>
                            <?php else: ?>
                                <a href="users.php?activate=<?php echo $user['user_id']; ?>"
                                    class="btn btn-success btn-xs">Unblock</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../app/views/layouts/admin_footer.php'; ?>