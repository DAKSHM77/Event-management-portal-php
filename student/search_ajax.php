<?php
require_once '../app/controllers/StudentController.php';

$student = new StudentController();
$events = $student->getUpcomingEvents($_GET);

if (count($events) > 0):
    foreach ($events as $event):
        $bgImg = !empty($event['image_path']) ? $event['image_path'] : 'https://via.placeholder.com/400x200?text=Event';
        if (!empty($event['image_path']) && strpos($event['image_path'], 'http') !== 0) {
            $bgImg = '../' . $event['image_path'];
        }
        ?>
        <div class="col-md-4">
            <a href="event-details.php?id=<?php echo $event['event_id']; ?>" style="text-decoration: none; color: inherit;">
                <div class="event-card">
                    <img src="<?php echo $bgImg; ?>" alt="<?php echo htmlspecialchars($event['title']); ?>"
                        style="width: 100%; height: 220px; object-fit: cover; display: block; border-bottom: 1px solid #eee;">
                    <div class="event-body">
                        <span
                            class="event-price"><?php echo $event['ticket_price'] > 0 ? '$' . $event['ticket_price'] : 'Free'; ?></span>
                        <div class="event-meta">
                            <i class="fa fa-calendar"></i> <?php echo date('M d, Y', strtotime($event['start_date'])); ?>
                            | <i class="fa fa-tag"></i> <?php echo htmlspecialchars($event['category_name']); ?>
                        </div>
                        <div class="event-title"><?php echo htmlspecialchars($event['title']); ?></div>
                        <p style="color: #777;">Organized by: <?php echo htmlspecialchars($event['org_name']); ?></p>
                    </div>
                </div>
            </a>
        </div>
        <?php
    endforeach;
else:
    ?>
    <div class="col-md-12">
        <div class="alert alert-info">No events found matching your criteria.</div>
    </div>
<?php endif; ?>