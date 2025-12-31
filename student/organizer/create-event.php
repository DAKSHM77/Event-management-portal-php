<?php
require_once '../app/views/layouts/organizer_header.php';
require_once '../app/controllers/OrganizerController.php';

$org = new OrganizerController();
if ($org->getApprovalStatus() != 'approved') {
    echo "<div class='alert alert-danger'>Account not approved. <a href='dashboard.php'>Go Back</a></div>";
    require_once '../app/views/layouts/organizer_footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($org->createEvent($_POST, $_FILES)) {
        echo "<script>alert('Event Submitted for Approval!'); window.location.href='my-events.php';</script>";
    } else {
        $error = "Failed to create event.";
    }
}

$categories = $org->getCategories();
?>

<h2>Create New Event</h2>
<hr>

<form method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Event Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['category_id']; ?>">
                            <?php echo htmlspecialchars($cat['category_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="5" required></textarea>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Venue / Online Link</label>
                <input type="text" name="venue" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Ticket Price ($) (0 for Free)</label>
                <input type="number" name="ticket_price" class="form-control" min="0" step="0.01" value="0">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Start Time</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>End Time</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Seat Limit</label>
                <input type="number" name="seat_limit" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Registration Deadline</label>
                <input type="datetime-local" name="registration_deadline" class="form-control" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Event Banner Image</label>
        <input type="file" name="banner" class="form-control" accept="image/*" required>
    </div>

    <button type="submit" class="btn btn-success">Submit Event</button>
</form>

<?php require_once '../app/views/layouts/organizer_footer.php'; ?>