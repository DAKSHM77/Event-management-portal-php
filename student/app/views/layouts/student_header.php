<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('student');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Panel - <?php echo APP_NAME; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/tooplate-style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .student-header {
            background: #252525;
            padding: 0;
            border-bottom: 4px solid #a5c422;
            width: 100%;
            height: auto;
            position: relative;
        }

        /* Clearfix */
        .student-header:after {
            content: "";
            display: table;
            clear: both;
        }

        .navbar-brand {
            color: #fff !important;
            font-family: 'Tenor Sans', sans-serif;
            /* Elegant Font */
            font-weight: 400;
            /* Regular weight for chic look */
            font-size: 38px;
            padding: 24px 15px;
            text-transform: uppercase;
            float: left;
            line-height: 1;
            letter-spacing: 5px;
            /* Audrey-style wide spacing */
            text-shadow: none;
            white-space: nowrap;
        }

        .navbar-brand span {
            color: #fff !important;
            font-size: inherit;
            font-family: inherit;
            font-weight: inherit;
            letter-spacing: inherit;
        }

        .student-nav {
            padding: 38px 0;
            float: right;
        }

        .student-nav a {
            margin-left: 30px;
            color: #ccc;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .student-nav a:hover,
        .student-nav a.active {
            color: #a5c422;
        }

        .main-content {
            padding: 40px 0;
            min-height: 600px;
            background: #f8f9fa;
        }

        /* Global Footer Styles Override */
        footer h4 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800 !important;
            font-size: 22px !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Card Modernization */
        .event-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            /* Soft premium shadow */
            transition: all 0.3s ease;
            border: none;
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .event-img {
            height: 220px;
            background-size: cover;
            background-position: center;
        }

        .event-body {
            padding: 25px;
        }

        .event-meta {
            font-size: 12px;
            color: #888;
            margin-bottom: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .event-title {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 12px;
            color: #222;
            line-height: 1.3;
        }

        .event-price {
            color: #a5c422;
            font-weight: 900;
            font-size: 18px;
            float: right;
        }

        <style>

        /* Light Mode (Default) Variables */
        :root {
            --bg-color: #f8f9fa;
            --text-color: #333;
            --card-bg: #ffffff;
            --card-shadow: rgba(0, 0, 0, 0.05);
            --border-color: #e0e0e0;
            --accent-color: #a5c422;
        }

        /* Dark Aesthetic Mode Variables - STRICT B&W */
        body.dark-aesthetic {
            --bg-color: #000000;
            --text-color: #e0e0e0;
            --card-bg: #0a0a0a;
            --card-shadow: rgba(255, 255, 255, 0.1);
            --border-color: #333;
            --accent-color: #ffffff;
        }

        body.dark-aesthetic {
            background-color: var(--bg-color);
            background-image:
                radial-gradient(circle at 15% 50%, rgba(255, 255, 255, 0.03), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(255, 255, 255, 0.03), transparent 25%);
            color: var(--text-color);
        }

        body.dark-aesthetic .student-header {
            background: #000;
            border-bottom: 2px solid #fff;
        }

        body.dark-aesthetic .navbar-brand {
            color: #fff !important;
            text-shadow: none;
        }

        body.dark-aesthetic .navbar-brand span {
            color: #fff;
        }

        body.dark-aesthetic .main-content {
            background: transparent;
        }

        body.dark-aesthetic .event-card {
            background: var(--card-bg);
            border: 1px solid #222;
            color: var(--text-color);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.05);
        }

        body.dark-aesthetic .event-card:hover {
            border-color: #fff;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        body.dark-aesthetic .event-title {
            color: #fff;
        }

        body.dark-aesthetic .event-meta {
            color: #999;
        }

        body.dark-aesthetic .event-price {
            color: #fff;
            text-shadow: none;
            font-weight: 900;
        }

        body.dark-aesthetic h2,
        body.dark-aesthetic h3 {
            color: #fff;
        }

        /* Footer Dark Mode Overrides - Monochrome */
        body.dark-aesthetic footer {
            background: #000 !important;
            border-top: 2px solid #fff !important;
            color: #ccc !important;
        }

        body.dark-aesthetic footer h4 {
            color: #fff !important;
            text-shadow: none;
        }

        body.dark-aesthetic footer a {
            color: #ccc !important;
        }

        body.dark-aesthetic footer a:hover {
            color: #fff !important;
            text-decoration: underline;
        }

        body.dark-aesthetic .footer-social .btn-social {
            background: transparent !important;
            border: 1px solid #fff !important;
            color: #fff !important;
        }

        body.dark-aesthetic .footer-social .btn-social:hover {
            background: #fff !important;
            color: #000 !important;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
        }

        /* --- GLOBAL DARK MODE ENFORCER --- */
        body.dark-aesthetic .panel,
        body.dark-aesthetic .panel-default,
        body.dark-aesthetic .well,
        body.dark-aesthetic .card,
        body.dark-aesthetic .event-card,
        body.dark-aesthetic .glass-search {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5) !important;
            color: #e0e0e0 !important;
            border-radius: 25px !important;
            /* MORE CURVED */
        }

        body.dark-aesthetic .panel-heading,
        body.dark-aesthetic .panel-footer {
            background: rgba(255, 255, 255, 0.05) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }

        body.dark-aesthetic .panel-body {
            background: transparent !important;
        }

        body.dark-aesthetic h1,
        body.dark-aesthetic h2,
        body.dark-aesthetic h3,
        body.dark-aesthetic h4,
        body.dark-aesthetic h5,
        body.dark-aesthetic h6,
        body.dark-aesthetic strong,
        body.dark-aesthetic b {
            color: #fff !important;
        }

        body.dark-aesthetic p,
        body.dark-aesthetic span,
        body.dark-aesthetic div {
            color: #ccc;
        }

        /* Specific overrides for text that must be white */
        body.dark-aesthetic .text-white,
        body.dark-aesthetic .navbar-brand {
            color: #fff !important;
        }

        body.dark-aesthetic hr {
            border-top: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        body.dark-aesthetic code,
        body.dark-aesthetic pre {
            background: rgba(0, 0, 0, 0.5) !important;
            color: #fff !important;
            border: 1px solid #333 !important;
        }

        body.dark-aesthetic .table {
            color: #ccc !important;
        }

        body.dark-aesthetic .table thead th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        body.dark-aesthetic .table td,
        body.dark-aesthetic .table th {
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        body.dark-aesthetic .alert-info {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        /* --------------------------------- */

        /* Grid Pattern overlay for aesthetic */
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

        /* Toggle Button Style */
        /* Toggle Button Style */
        .theme-btn {
            background: transparent;
            border: 2px solid #555;
            color: #888;
            width: 44px;
            /* Fixed Width */
            height: 44px;
            /* Fixed Height */
            padding: 0;
            /* Reset padding */
            display: inline-flex;
            /* Use flex for centering */
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            /* Circle */
            font-size: 20px;
            /* Large Icon */
            cursor: pointer;
            transition: all 0.3s;
            margin-right: 15px;
            vertical-align: middle;
            /* Align with text */
        }

        .theme-btn:hover {
            border-color: #fff;
            color: #fff;
        }

        body.dark-aesthetic .theme-btn {
            border-color: #fff;
            color: #fff;
            box-shadow: none;
        }
    </style>
    <script>
        // Check local storage on load
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-aesthetic'); // Pre-add to html to avoid flash
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

<body>
    <header class="student-header">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <a href="dashboard.php" class="navbar-brand">Event <span>Portal</span></a>
                </div>
                <div class="col-md-8 col-xs-12 text-right student-nav">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="events.php">Browse Events</a>
                    <a href="my-registrations.php">My Tickets</a>
                    <a href="../logout.php"
                        style="border: 2px solid #fff; padding: 10px 20px; border-radius: 50px; color: #fff; font-weight: 700;">Logout</a>
                    <button class="theme-btn" onclick="toggleTheme()" title="Toggle Theme"><i
                            class="fa fa-adjust"></i></button>
                </div>
            </div>
        </div>
    </header>
    <div class="main-content">
        <div class="container">