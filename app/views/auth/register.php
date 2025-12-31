<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/tooplate-style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
    <script>
        function toggleForm() {
            var role = document.getElementById('role').value;
            var orgFields = document.getElementById('org-fields');
            if (role === 'organization') {
                orgFields.style.display = 'block';
            } else {
                orgFields.style.display = 'none';
            }
        }
    </script>
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
        body.dark-aesthetic label,
        body.dark-aesthetic h4 {
            color: #fff;
        }

        body.dark-aesthetic input.form-control,
        body.dark-aesthetic select.form-control,
        body.dark-aesthetic textarea.form-control {
            background: #000 !important;
            border: 1px solid #444;
            color: #fff !important;
        }

        body.dark-aesthetic input.form-control::placeholder,
        body.dark-aesthetic textarea.form-control::placeholder {
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
    <style>
        /* INLINE CSS TO FORCE MOBILE LAYOUT AND BYPASS CACHE */
        @media only screen and (max-width: 767px) {

            body,
            html {
                margin: 0;
                padding: 0;
                width: 100%;
                overflow-x: hidden;
            }

            #appointment {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
            }

            #appointment .container,
            #appointment .row,
            #appointment .col-xs-12 {
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: none !important;
            }

            #appointment-form {
                width: 100% !important;
                min-height: 100vh !important;
                margin: 0 !important;
                padding: 40px 20px !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                /* Allow scroll for register since it is long */
                display: block !important;
            }

            #appointment-form input,
            #appointment-form select,
            #appointment-form button,
            #appointment-form textarea {
                height: 60px !important;
                font-size: 18px !important;
                margin-bottom: 20px !important;
            }

            #appointment-form label {
                font-size: 18px !important;
                margin-bottom: 10px;
            }

            #appointment-form h2 {
                font-size: 32px !important;
                margin-bottom: 30px !important;
                text-align: center;
            }

            .navbar-default {
                display: none !important;
            }
        }
    </style>
</head>

<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
    <section class="preloader">
        <div class="spinner"><span class="spinner-rotate"></span></div>
    </section>

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
                <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                    <form id="appointment-form" role="form" method="post" action="register.php"
                        enctype="multipart/form-data">
                        <div class="section-title wow fadeInUp" data-wow-delay="0.4s">
                            <h2>Register</h2>
                        </div>

                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
                        <?php endif; ?>

                        <div class="wow fadeInUp" data-wow-delay="0.8s">
                            <div class="col-md-12">
                                <label for="role">Register As</label>
                                <select class="form-control" name="role" id="role" onchange="toggleForm()">
                                    <option value="student">Student</option>
                                    <option value="organization">Organization</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                            </div>

                            <div class="col-md-6">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                            </div>

                            <div class="col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                    required>
                            </div>

                            <!-- Organization Fields -->
                            <div id="org-fields" style="display:none; clear:both;">
                                <br>
                                <hr><br>
                                <h4>Organization Details</h4>
                                <div class="col-md-6">
                                    <label>Organization Name</label>
                                    <input type="text" class="form-control" name="org_name">
                                </div>
                                <div class="col-md-6">
                                    <label>Upload Verification Document (PDF/ID)</label>
                                    <input type="file" class="form-control" name="document">
                                </div>
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <br>
                                <button type="submit" class="form-control" id="cf-submit"
                                    name="submit">REGISTER</button>
                                <p class="text-center" style="margin-top: 20px;">Already have an account? <a
                                        href="login.php">Login here</a></p>
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