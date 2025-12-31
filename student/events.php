<?php
require_once '../app/views/layouts/student_header.php';
require_once '../app/controllers/StudentController.php';

$student = new StudentController();
$categories = $student->getCategories();
$events = $student->getUpcomingEvents($_GET);
?>

<h2>Browse Events</h2>
<hr>

<style>
    /* Liquid Background Blobs - Monochrome Smoke Effect */
    .liquid-background {
        position: absolute;
        top: -30%;
        left: -10%;
        width: 120%;
        height: 160%;
        overflow: hidden;
        z-index: 0;
        pointer-events: none;
    }

    .blob {
        position: absolute;
        filter: blur(80px);
        opacity: 0.5;
        animation: moveBlob 20s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 0;
    }

    .blob-1 {
        top: 10%;
        left: 20%;
        width: 350px;
        height: 350px;
        /* White/Grey Smoke Blob */
        background: radial-gradient(circle, #ffffff 0%, rgba(100, 100, 100, 0) 70%);
        border-radius: 40% 50% 70% 30% / 40% 50% 60% 50%;
    }

    .blob-2 {
        top: 20%;
        right: 20%;
        width: 400px;
        height: 400px;
        /* Darker Grey Blob */
        background: radial-gradient(circle, #888888 0%, rgba(50, 50, 50, 0) 70%);
        border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        animation-duration: 25s;
        animation-direction: alternate-reverse;
    }

    @keyframes moveBlob {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }

        100% {
            transform: translate(60px, 80px) rotate(20deg);
        }
    }

    /* Matte Glassmorphism */
    .glass-search {
        position: relative;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(50px) saturate(0%);
        /* Desaturated */
        -webkit-backdrop-filter: blur(50px) saturate(0%);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-top: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        padding: 50px;
        margin-bottom: 60px;
        overflow: hidden;
        z-index: 1;
    }

    body.dark-aesthetic .glass-search {
        background: rgba(20, 20, 20, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
    }

    .glass-search input.form-control,
    .glass-search select.form-control {
        background: rgba(255, 255, 255, 0.2) !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        color: #333;
        backdrop-filter: blur(0px);
        border-radius: 12px;
        height: 55px;
        font-weight: 500;
        font-size: 16px;
    }

    .glass-search input.form-control::placeholder {
        color: rgba(0, 0, 0, 0.6);
    }

    /* Dark Mode Inputs - Pure B&W */
    body.dark-aesthetic .glass-search input.form-control,
    body.dark-aesthetic .glass-search select.form-control {
        color: #fff !important;
        background: rgba(255, 255, 255, 0.1) !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
    }

    body.dark-aesthetic .glass-search input.form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .glass-search select.form-control option {
        background: #fff;
        color: #333;
    }

    body.dark-aesthetic .glass-search select.form-control option {
        background: #000;
        color: #fff;
    }

    /* Focus States - White Borders, No Neon */
    .glass-search input.form-control:focus,
    .glass-search select.form-control:focus {
        background: rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
        border-color: #333 !important;
    }

    body.dark-aesthetic .glass-search input.form-control:focus,
    body.dark-aesthetic .glass-search select.form-control:focus {
        background: rgba(255, 255, 255, 0.15) !important;
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
        border-color: #fff !important;
    }

    /* Filter Button - Monochrome */
    .glass-search .btn-primary {
        height: 55px;
        border-radius: 12px;
        background: #333;
        color: #fff;
        border: none;
        font-weight: 800;
        font-size: 16px;
        letter-spacing: 1px;
        text-transform: uppercase;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
    }

    .glass-search .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        background: #000;
    }

    /* Dark Mode Button - White with Black Text */
    body.dark-aesthetic .glass-search .btn-primary {
        background: #fff;
        color: #000;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }

    body.dark-aesthetic .glass-search .btn-primary:hover {
        background: #f0f0f0;
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
    }
</style>

<div style="position:relative; margin-bottom: 50px;">
    <div class="liquid-background">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <form method="get" class="glass-search" onsubmit="return false;">
        <div class="row">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search events..." id="searchInput"
                    autocomplete="off" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </div>
            <div class="col-md-5">
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['category_id']; ?>" <?php if (isset($_GET['category']) && $_GET['category'] == $cat['category_id'])
                               echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat['category_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </div>
    </form>
</div>

<div class="row" id="events-container">
    <?php if (count($events) > 0): ?>
        <?php foreach ($events as $event): ?>
            <div class="col-md-4">
                <a href="event-details.php?id=<?php echo $event['event_id']; ?>" style="text-decoration: none; color: inherit;">
                    <div class="event-card">
                        <?php
                        $bgImg = !empty($event['image_path']) ? $event['image_path'] : 'https://via.placeholder.com/400x200?text=Event';
                        if (!empty($event['image_path']) && strpos($event['image_path'], 'http') !== 0) {
                            $bgImg = '../' . $event['image_path'];
                        }
                        ?>
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
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-info">No events found matching your criteria.</div>
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('input[name="search"]');
        const categorySelect = document.querySelector('select[name="category"]');
        const resultsContainer = document.getElementById('events-container');

        function fetchEvents() {
            const search = searchInput.value;
            const category = categorySelect.value;

            // Create query string
            const params = new URLSearchParams();
            params.append('search', search);
            if (category) params.append('category', category);

            fetch('search_ajax.php?' + params.toString())
                .then(response => response.text())
                .then(html => {
                    resultsContainer.innerHTML = html;
                })
                .catch(err => console.error('Error fetching events:', err));
        }

        searchInput.addEventListener('keyup', fetchEvents);
        categorySelect.addEventListener('change', fetchEvents);

        // Optional: prevent form submit on enter
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();
            fetchEvents();
        });
    });
</script>

<?php require_once '../app/views/layouts/student_footer.php'; ?>