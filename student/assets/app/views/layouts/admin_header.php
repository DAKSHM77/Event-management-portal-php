<?php
// Admin Header Part
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel - <?php echo APP_NAME; ?></title>
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

        .admin-sidebar {
            background: #252525;
            color: #fff;
            position: fixed;
            /* Fixed Sidebar */
            top: 0;
            bottom: 0;
            left: 0;
            width: 16.666667%;
            /* approx col-md-2 width */
            padding-top: 20px;
            border-right: 4px solid #a5c422;
            z-index: 1000;
            overflow-y: auto;
        }

        .main-content {
            padding: 30px;
            margin-left: 16.666667%;
            /* Offset for fixed sidebar */
        }

        .admin-sidebar h4 {
            font-family: 'Tenor Sans', sans-serif;
            letter-spacing: 3px;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .admin-sidebar a {
            color: #ccc;
            display: block;
            padding: 15px 20px;
            text-decoration: none;
            border-bottom: 1px solid #444;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .admin-sidebar a:hover,
        .admin-sidebar a.active {
            background: #a5c422;
            color: #fff;
            padding-left: 25px;
        }

        .main-content {
            padding: 30px;
        }

        .stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            border-left: 5px solid #a5c422;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .stat-card h3 {
            margin: 0;
            font-size: 36px;
            font-weight: 800;
        }

        .stat-card p {
            margin: 10px 0 0;
            color: #777;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            font-weight: 700;
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

        body.dark-aesthetic .admin-sidebar {
            background: rgba(20, 20, 20, 0.8);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
        }

        body.dark-aesthetic .admin-sidebar a {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        body.dark-aesthetic .admin-sidebar a:hover,
        body.dark-aesthetic .admin-sidebar a.active {
            background: #fff;
            color: #000;
        }

        /* Glassmorphism Enforcer for Admin */
        body.dark-aesthetic .stat-card,
        body.dark-aesthetic .panel,
        body.dark-aesthetic .card,
        body.dark-aesthetic .well,
        body.dark-aesthetic .table-responsive {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5) !important;
            color: #e0e0e0 !important;
            border-radius: 25px !important;
        }

        body.dark-aesthetic h1,
        body.dark-aesthetic h2,
        body.dark-aesthetic h3,
        body.dark-aesthetic h4,
        body.dark-aesthetic h5,
        body.dark-aesthetic h6 {
            color: #fff !important;
        }

        body.dark-aesthetic .table {
            color: #ccc !important;
        }

        body.dark-aesthetic .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }

        body.dark-aesthetic .table thead th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        body.dark-aesthetic .table td {
            border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        /* Toggle Button */
        /* Toggle Button */
        .theme-btn {
            background: transparent;
            border: 2px solid #555;
            color: #888;
            padding: 12px 20px;
            /* Larger padding */
            border-radius: 30px;
            font-size: 16px;
            /* Larger text */
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin: 20px 15px;
            width: calc(100% - 30px);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 admin-sidebar">
                <h4 class="text-center">ADMIN PANEL</h4>
                <hr>
                <a href="dashboard.php">Dashboard</a>
                <a href="organizations.php">Organizations</a>
                <a href="events.php">Events</a>
                <a href="users.php">Users</a>
                <a href="categories.php">Categories</a>
                <a href="../logout.php">Logout</a>

                <button class="theme-btn" onclick="toggleTheme()"><i class="fa fa-adjust"></i> Toggle Theme</button>
            </div>
            <div class="col-md-10 main-content">