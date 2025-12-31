<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css'); ?>">
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
            width: 44px;
            height: 44px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s;
            float: right;
            margin-top: 5px;
        }

        .theme-btn:hover {
            border-color: #333;
            color: #333;
        }

        /* Form Styling */
        #appointment-form {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            /* Clear floats */
        }

        /* --- DARK THEME --- */
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

        /* Dark Glass Form */
        body.dark-aesthetic #appointment-form {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        body.dark-aesthetic h2,
        body.dark-aesthetic label {
            color: #fff;
        }

        body.dark-aesthetic input.form-control,
        body.dark-aesthetic select.form-control {
            background: #000 !important;
            border: 1px solid #444;
            color: #fff !important;
        }
        
        body.dark-aesthetic input.form-control::placeholder {
            color: #bbbbbb; 
        }

        body.dark-aesthetic .theme-btn {
            border-color: #fff;
            color: #fff;
        }

        body.dark-aesthetic .theme-btn:hover {
            background: #fff;
            color: #000;
        }

        body.dark-aesthetic #appointment-form p {
            color: #ccc;
        }

        body.dark-aesthetic #appointment-form a {
            color: #fff !important;
            text-decoration: underline;
            font-weight: bold;
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
    <section class="preloader">
        <div class="spinner"><span class="spinner-rotate"></span></div>
    </section>

    <!-- MENU -->
    <section class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="../../index.php" class="navbar-brand">
                    <h4 style="color:#a5c422"><b>EVENT PORTAL</b></h4>
                </a>
            </div>
            <button class="theme-btn" onclick="toggleTheme()"><i class="fa fa-adjust"></i></button>
        </div>
    </section>

    <section id="appointment" data-stellar-background-ratio="3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form id="appointment-form" role="form" method="post" action="login.php">
                        <div class="section-title wow fadeInUp" data-wow-delay="0.4s">
                            <h2>Login</h2>
                        </div>

                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">Registration successful! Please login.</div>
                        <?php endif; ?>
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
                        <?php endif; ?>

                        <div class="wow fadeInUp" data-wow-delay="0.8s">
                            <div class="col-md-12">
                                <label for="role">Select Role</label>
                                <select class="form-control" name="role" required>
                                    <option value="student">Student</option>
                                    <option value="organization">Organization</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Your Email" required>
                            </div>

                            <div class="col-md-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="form-control" id="cf-submit" name="submit">LOGIN</button>
                                <p class="text-center" style="margin-top: 20px;">Don't have an account? <a
                                        href="register.php">Register here</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

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