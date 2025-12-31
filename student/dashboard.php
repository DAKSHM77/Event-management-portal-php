<?php
require_once '../app/views/layouts/student_header.php';
require_once '../app/controllers/StudentController.php';

$student = new StudentController();
$upcoming = $student->getUpcomingEvents();
?>

<h2>Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
<hr>

<div class="row">
    <div class="col-md-12">
        <h3>Featured Upcoming Events</h3>
        <br>
    </div>

    <?php
    $count = 0;
    foreach ($upcoming as $event):
        if ($count >= 3)
            break;
        $count++;
        // Quick image check
        $img = '../images/default_event.jpg';
        // Logic to fetch image from db (not implemented in getUpcomingEvents fully, but lets assume)
        // For now use a placeholder or check table
        ?>
        <div class="col-md-4 col-sm-6">
            <a href="event-details.php?id=<?php echo $event['event_id']; ?>" style="text-decoration: none; color: inherit;">
                <div class="event-card">
                    <?php
                    $bgImg = !empty($event['image_path']) ? $event['image_path'] : 'https://via.placeholder.com/400x200?text=Event';
                    if (!empty($event['image_path']) && strpos($event['image_path'], 'http') !== 0) {
                        $bgImg = '../' . $event['image_path'];
                    }
                    ?>
                    <div class="event-img" style="background-image: url('<?php echo $bgImg; ?>');">
                    </div>
                    <div class="event-body">
                        <span
                            class="event-price"><?php echo $event['ticket_price'] > 0 ? '$' . $event['ticket_price'] : 'Free'; ?></span>
                        <div class="event-meta">
                            <i class="fa fa-calendar"></i> <?php echo date('M d, Y', strtotime($event['start_date'])); ?>
                            | <i class="fa fa-tag"></i> <?php echo htmlspecialchars($event['category_name']); ?>
                        </div>
                        <div class="event-title"><?php echo htmlspecialchars($event['title']); ?></div>
                        <p style="color: #777;"><?php echo substr(htmlspecialchars($event['description']), 0, 80); ?>...</p>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<div class="text-center">
    <a href="events.php" class="btn btn-primary">Browse All Events</a>
</div>

<?php require_once '../app/views/layouts/student_footer.php'; ?>