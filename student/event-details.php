<?php
require_once '../app/views/layouts/student_header.php';
require_once '../app/controllers/StudentController.php';

$student = new StudentController();
$eventId = $_GET['id'] ?? 0;
$event = $student->getEventDetails($eventId);

if (!$event) {
    echo "Event not found.";
    require_once '../app/views/layouts/student_footer.php';
    exit;
}

$isRegistered = $student->isRegistered($eventId);
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $res = $student->registerForEvent($eventId);
    if ($res['status']) {
        echo "<script>alert('{$res['message']}'); window.location.href='my-registrations.php';</script>";
    } else {
        $msg = $res['message'];
    }
}
?>

<style>
    .hero-cover {
        position: relative;
        width: 100%;
        height: 400px;
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        margin-bottom: 30px;
        display: flex;
        align-items: flex-end;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .hero-overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
        width: 100%;
        padding: 40px;
        color: white;
    }

    .hero-title {
        font-size: 36px;
        font-weight: 700;
        margin: 0 0 10px 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        color: #fff;
    }

    .hero-meta {
        font-size: 16px;
        opacity: 0.9;
        color: #eee;
    }

    .hero-meta i {
        margin-right: 8px;
        color: #fff;
        /* Monochrome */
    }

    /* Container Styling to fix Visibility */
    .news-detail-thumb,
    .news-sidebar {
        background: transparent;
        padding: 0;
        border-radius: 0;
        margin-bottom: 30px;
        color: #333;
        /* Default Light Mode Text */
        box-shadow: none;
        border: none;
    }

    /* Important: Ensure the section itself is transparent */
    #news-detail {
        background: transparent !important;
    }

    .news-detail-thumb h3,
    .news-sidebar h4 {
        color: #000;
        margin-top: 0;
    }

    .news-detail-thumb p,
    .news-sidebar p,
    .news-tags li {
        color: #444;
    }

    blockquote {
        background: rgba(0, 0, 0, 0.05);
        /* Very subtle for light mode */
        border-left: 5px solid #333;
        color: #555;
        padding: 20px;
        font-style: italic;
    }

    /* Dark Mode Overrides - strict visibility rules */
    body.dark-aesthetic #news-detail,
    body.dark-aesthetic .news-detail-thumb,
    body.dark-aesthetic .news-sidebar {
        background: transparent !important;
        border: none;
        color: #e0e0e0;
        box-shadow: none;
    }

    body.dark-aesthetic .news-detail-thumb h3,
    body.dark-aesthetic .news-sidebar h4 {
        color: #fff;
    }

    body.dark-aesthetic .news-detail-thumb p,
    body.dark-aesthetic .news-sidebar p,
    body.dark-aesthetic .news-tags li {
        color: #ccc;
    }

    body.dark-aesthetic blockquote {
        background: rgba(255, 255, 255, 0.05);
        /* Subtle for dark mode */
        border-left: 5px solid #fff;
        color: #ccc;
    }

    body.dark-aesthetic .news-sidebar strong {
        color: #fff;
    }

    body.dark-aesthetic .btn-link {
        color: #fff;
    }
</style>

<!-- NEWS DETAIL -->
<section id="news-detail" data-stellar-background-ratio="0.5">
    <div class="row">
        <div class="col-md-8 col-sm-7">
            <!-- NEWS THUMB -->
            <div class="news-detail-thumb">
                <div class="news-image">
                    <?php
                    $heroImg = !empty($event['image_path']) ? $event['image_path'] : 'https://via.placeholder.com/1200x600?text=Event+Cover';
                    if (!empty($event['image_path']) && strpos($event['image_path'], 'http') !== 0) {
                        $heroImg = '../' . $event['image_path'];
                    }
                    ?>
                    <img src="<?php echo $heroImg; ?>" class="img-responsive" alt="Event Image"
                        style="width: 100%; border-radius: 8px;">
                </div>
                <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                <p>
                    <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                </p>
                <blockquote>
                    <i class="fa fa-quote-left"></i>
                    What’s in store?
                    <br>
                    📅 Date: <?php echo date('F d, Y', strtotime($event['start_date'])); ?><br>
                    🕥 Time: <?php echo date('h:i A', strtotime($event['start_time'])); ?><br>
                    📍 Venue: <?php echo htmlspecialchars($event['venue']); ?><br>
                    💸 Price: <?php echo $event['ticket_price'] > 0 ? '$' . $event['ticket_price'] : 'Free'; ?><br>
                    <br>
                    Don't miss out on this amazing experience!
                </blockquote>

                <div class="news-social-share">
                    <h4>Share this event</h4>
                    <a href="#" class="btn btn-primary"><i class="fa fa-facebook"></i>Facebook</a>
                    <a href="#" class="btn btn-success"><i class="fa fa-twitter"></i>Twitter</a>
                    <a href="#" class="btn btn-danger"><i class="fa fa-google-plus"></i>Google+</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-5">
            <div class="news-sidebar">
                <div class="news-author">
                    <h4>Organizer</h4>
                    <p>
                        <strong><?php echo htmlspecialchars($event['org_name']); ?></strong><br>
                        Verified Event Organizer on <?php echo APP_NAME; ?>.
                    </p>
                </div>

                <div class="news-categories">
                    <div class="news-tags">
                        <h4>Ticket Info & Actions</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li><strong>Seats:</strong> <?php echo $event['seat_limit']; ?> Available</li>
                            <li><strong>Deadline:</strong>
                                <?php echo date('M d, Y', strtotime($event['registration_deadline'])); ?>
                            </li>
                        </ul>
                        <br>
                        <?php if ($msg): ?>
                            <div class="alert alert-danger"><?php echo $msg; ?></div>
                        <?php endif; ?>

                        <?php if ($isRegistered): ?>
                            <button class="btn btn-success btn-lg btn-block" disabled>Already Registered</button>
                            <a href="my-registrations.php" class="btn btn-link btn-block">View Ticket</a>
                        <?php else: ?>
                            <form method="post">
                                <button type="submit" name="register" class="btn btn-primary btn-lg btn-block"
                                    onclick="return confirm('Confirm Registration?')">
                                    Register Now
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../app/views/layouts/student_footer.php'; ?>