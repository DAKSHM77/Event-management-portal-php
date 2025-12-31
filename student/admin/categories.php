<?php
require_once '../app/views/layouts/admin_header.php';
require_once '../app/controllers/AdminController.php';

$admin = new AdminController();

if (isset($_POST['category_name'])) {
    $admin->addCategory($_POST['category_name']);
    echo "<script>window.location.href='categories.php';</script>";
}
if (isset($_GET['delete'])) {
    $admin->deleteCategory($_GET['delete']);
    echo "<script>window.location.href='categories.php';</script>";
}

$categories = $admin->getCategories();
?>

<h2>Categories</h2>
<hr>

<div class="row">
    <div class="col-md-6">
        <form method="post" class="form-inline">
            <div class="form-group">
                <input type="text" name="category_name" class="form-control" placeholder="New Category Name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?php echo $cat['category_id']; ?></td>
                        <td><?php echo htmlspecialchars($cat['category_name']); ?></td>
                        <td>
                            <a href="categories.php?delete=<?php echo $cat['category_id']; ?>" class="btn btn-danger btn-xs"
                                onclick="return confirm('Delete?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../app/views/layouts/admin_footer.php'; ?>