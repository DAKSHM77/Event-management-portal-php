<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('organization');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Organizer Panel - <?php echo APP_NAME; ?></title>
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

        .org-header {
            background: #fff;
            padding: 0;
            padding-bottom: 90px;
            /* MATCH DARK MODE HEIGHT */
            border-bottom: 4px solid #a5c422;
            width: 100%;
            overflow: hidden;
        }

        .org-brand {
            font-family: 'Tenor Sans', sans-serif;
            font-size: 32px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 4px;
            padding: 20px 0;
            display: inline-block;
        }

        .org-brand span {
            font-weight: 700;
        }

        .org-nav {
            padding: 25px 0;
            text-align: right;
        }

        .org-nav a {
            margin-left: 20px;
            color: #777;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .org-nav a:hover,
        .org-nav a.active {
            color: #a5c422;
        }

        .main-content {
            padding: 40px 0;
            min-height: 600px;
            background: #f8f9fa;
        }

        /* CARD STYLES */
        .card,
        .panel {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        /* --- DARK THEME --- */
        /* Light Mode (Default) Variables */
        :root {
            --bg-color: #f8f9fa;
            --text-color: #333;
        }

        /* Dark Aesthetic Mode Variables - STRICT B&W */
        body.dark-aesthetic {
            --bg-color: #000000;
            --text-color: #e0e0e0;
            background-color: var(--bg-color);
            background-image:
                radial-gradient(circle at 15% 50%, rgba(255, 255, 255, 0.03), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(255, 255, 255, 0.03), transparent 25%);
            color: var(--text-color);
        }

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

        body.dark-aesthetic .org-header {
            background: #000;
            border-bottom: 2px solid #fff;
            padding-bottom: 90px;
            /* Increased to 90px */
            overflow: hidden;
            /* Ensure floats are cleared */
        }

        body.dark-aesthetic .org-brand {
            color: #fff;
        }

        body.dark-aesthetic .org-nav a {
            color: #ccc;
        }

        body.dark-aesthetic .org-nav a:hover {
            color: #fff;
        }

        body.dark-aesthetic .main-content {
            background: transparent;
        }

        /* Glassmorphism Enforcer for Org */
        body.dark-aesthetic .stat-card,
        body.dark-aesthetic .panel,
        body.dark-aesthetic .card,
        body.dark-aesthetic .well,
        body.dark-aesthetic .table-responsive,
        body.dark-aesthetic input.form-control,
        body.dark-aesthetic textarea.form-control,
        body.dark-aesthetic select.form-control {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5) !important;
            color: #fff !important;
            border-radius: 25px !important;
        }

        body.dark-aesthetic h1,
        body.dark-aesthetic h2,
        body.dark-aesthetic h3,
        body.dark-aesthetic h4,
        body.dark-aesthetic h5,
        body.dark-aesthetic h6,
        body.dark-aesthetic strong,
        body.dark-aesthetic label {
            color: #fff !important;
        }

        body.dark-aesthetic .table {
            color: #ccc !important;
        }

        body.dark-aesthetic .table thead th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        body.dark-aesthetic .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }

        body.dark-aesthetic .table td {
            border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        /* Toggle Button */
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
            margin-left: 15px;
            vertical-align: middle;
        }

        body.dark-aesthetic .theme-btn {
            border-color: #fff;
            color: #fff;
        }

        body.dark-aesthetic .theme-btn:hover {
            background: #fff;
            color: #000;
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

<body>
    <header class="org-header navbar navbar-default navbar-static-top"
        style="border: 0; border-bottom: 4px solid #a5c422; padding-bottom: 0;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#org-navbar-collapse" aria-expanded="false" style="border: 1px solid #888;">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar" style="background-color: #888;"></span>
                    <span class="icon-bar" style="background-color: #888;"></span>
                    <span class="icon-bar" style="background-color: #888;"></span>
                </button>
                <a href="dashboard.php" class="navbar-brand" style="padding: 15px;">
                    <div class="org-brand" style="padding: 0; font-size: 24px; line-height: 20px;">Organizer
                        <span>Panel</span></div>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="org-navbar-collapse" style="border-top: none; box-shadow: none;">
                <ul class="nav navbar-nav navbar-right org-nav" style="margin: 0;">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="create-event.php">Create Event</a></li>
                    <li><a href="my-events.php">My Events</a></li>
                    <li><a href="earnings.php">Earnings</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                    <li><button class="theme-btn" onclick="toggleTheme()" style="margin-top: 10px;"><i
                                class="fa fa-adjust"></i></button></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="main-content">
        <div class="container">