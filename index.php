<?php
require_once 'config/config.php';
// We can include a header partial or just put the HTML here slightly modified from theme
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Event Portal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/animate.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/owl.carousel.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/owl.theme.default.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/tooplate-style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .navbar-brand h4 {
            font-family: 'Tenor Sans', sans-serif;
            letter-spacing: 5px;
            font-size: 24px;
            font-weight: 400;
            margin: 0;
            color: #333;
        }

        /* Toggle Button */
        .theme-btn {
            background: transparent;
            border: 2px solid #555;
            color: #888;
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 30px;
            /* Adjust for navbar alignment */
            margin-left: 10px;
        }

        .theme-btn:hover {
            border-color: #333;
            color: #333;
        }

        /* --- DARK THEME --- */
        /* Dark Aesthetic Mode */
        body.dark-aesthetic {
            background-color: #000;
            color: #e0e0e0;
            background-image:
                radial-gradient(circle at 15% 50%, rgba(255, 255, 255, 0.03), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(255, 255, 255, 0.03), transparent 25%);
        }

        body.dark-aesthetic::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            z-index: -1;
        }

        body.dark-aesthetic .navbar-default {
            background: rgba(20, 20, 20, 0.9);
            border-bottom: 2px solid #fff;
            backdrop-filter: blur(10px);
        }

        body.dark-aesthetic .navbar-brand h4 {
            color: #fff !important;
        }

        body.dark-aesthetic .navbar-nav>li>a {
            color: #ccc;
        }

        body.dark-aesthetic .navbar-nav>li>a:hover {
            color: #fff;
        }

        body.dark-aesthetic .section-title h2 {
            color: #fff;
        }

        body.dark-aesthetic p {
            color: #ccc;
        }

        body.dark-aesthetic h1,
        body.dark-aesthetic h2,
        body.dark-aesthetic h3 {
            color: #fff;
        }

        body.dark-aesthetic .theme-btn {
            border-color: #fff;
            color: #fff;
        }

        body.dark-aesthetic .theme-btn:hover {
            background: #fff;
            color: #000;
        }

        /* Footer */
        body.dark-aesthetic footer {
            background: #000;
            border-top: 2px solid #fff;
        }

        /* Increase Header Height */
        .navbar {
            min-height: 80px;
        }
        
        .navbar-nav > li > a {
            padding-top: 30px;
            padding-bottom: 30px;
        }
        
        .navbar-brand {
            height: 80px;
            padding-top: 30px;
        }
        
        .navbar-toggle {
            margin-top: 23px;
        }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-aesthetic');
            window.addEventListener('DOMContentLoaded', () => {
                document.body.classList.add('dark-aesthetic');
            });
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-aesthetic');
            if (document.body.classList.contains('dark-aesthetic')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        }
    </script>
</head>

<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

    <!-- MENU -->
    <section class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                </button>
                <a href="index.php" class="navbar-brand">
                    <h4 style="color:#a5c422"><b>EVENT PORTAL</b></h4>
                </a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#top" class="smoothScroll">Home</a></li>
                    <li><a href="#about" class="smoothScroll">About Us</a></li>
                    <li><a href="#news" class="smoothScroll">Events</a></li>
                    <li><a href="#google-map" class="smoothScroll">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php
                        $dashboardLink = '#';
                        if ($_SESSION['role'] == 'admin')
                            $dashboardLink = 'admin/dashboard.php';
                        elseif ($_SESSION['role'] == 'organization')
                            $dashboardLink = 'organizer/dashboard.php';
                        else
                            $dashboardLink = 'student/dashboard.php';
                        ?>
                        <li class="appointment-btn"><a href="<?php echo $dashboardLink; ?>">My Dashboard</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="appointment-btn"><a href="login.php">Login / Register</a></li>
                    <?php endif; ?>
                    <li><button class="theme-btn" onclick="toggleTheme()"><i class="fa fa-adjust"></i></button></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- HOME -->
    <section id="home" class="slider" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="owl-carousel owl-theme">
                    <div class="item item-first">
                        <div class="caption">
                            <div class="col-md-offset-1 col-md-10">
                                <h3>All in one event portal</h3>
                                <h1>Welcome to Event Portal</h1>
                                <a href="#news" class="section-btn btn btn-default smoothScroll">Explore Events</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- EVENTS LISTING SAMPLE -->
    <section id="news" data-stellar-background-ratio="2.5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="section-title wow fadeInUp" data-wow-delay="0.1s">
                        <h2>Latest Events</h2>
                    </div>
                </div>
                <!-- Dynamic events would go here usually, but keeping static as landing for now or valid DB check -->
                <div class="col-md-12 text-center">
                    <p>Login to view all available events and register!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer data-stellar-background-ratio="5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>Event Portal &copy; 2025</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?php echo asset('js/jquery.js'); ?>"></script>
    <script src="<?php echo asset('js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo asset('js/jquery.sticky.js'); ?>"></script>
    <script src="<?php echo asset('js/jquery.stellar.min.js'); ?>"></script>
    <script src="<?php echo asset('js/wow.min.js'); ?>"></script>
    <script src="<?php echo asset('js/smoothscroll.js'); ?>"></script>
    <script src="<?php echo asset('js/owl.carousel.min.js'); ?>"></script>
    <script src="<?php echo asset('js/custom.js'); ?>"></script>
</body>

</html>