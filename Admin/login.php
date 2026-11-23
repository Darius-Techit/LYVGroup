<?php
session_start();
if (isset($_SESSION['displayName'])) {
    header('Location: modules/department.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - Company Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/LAI_logo.png" rel="icon">
    <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
    <!-- <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> -->

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="plugins/toastr/css/toastr.min.css" rel="stylesheet">
    <link href="plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <style>
        table.dataTable tbody>tr.selected,
        table.dataTable tbody>tr>.selected {
            background-color: #86b0d3;
            color: #fff;
            cursor: pointer;
        }

        label.error {
            color: #ff6b6b;
            margin-top: 4px;
            font-size: 12px;
            display: block;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }

        .select2-container--default .select2-selection--single {
            height: 33px;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        :root {
            --brand-1: #012970;
            --brand-2: #4154f1;
            --brand-3: #7b2ff7;
        }

        html, body {
            height: 100%;
        }

        body {
            overflow-x: hidden;
        }

        .login-page {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg, #050b2b 0%, var(--brand-1) 45%, var(--brand-2) 75%, var(--brand-3) 100%);
            overflow: hidden;
        }

        .login-page::before,
        .login-page::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: .55;
            z-index: 0;
            animation: float-blob 14s ease-in-out infinite;
        }

        .login-page::before {
            width: 480px;
            height: 480px;
            top: -160px;
            left: -140px;
            background: radial-gradient(circle at 30% 30%, #7b2ff7, transparent 70%);
        }

        .login-page::after {
            width: 520px;
            height: 520px;
            bottom: -200px;
            right: -160px;
            background: radial-gradient(circle at 70% 70%, #00d4ff, transparent 70%);
            animation-delay: -7s;
        }

        @keyframes float-blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, -30px) scale(1.08); }
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 25px 60px -15px rgba(1, 6, 40, 0.5);
            animation: card-in .6s ease;
        }

        @keyframes card-in {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-visual {
            position: relative;
            background: linear-gradient(160deg, var(--brand-1), var(--brand-2) 60%, var(--brand-3));
            min-height: 560px;
        }

        .login-visual::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.12) 1px, transparent 1px);
            background-size: 22px 22px;
            opacity: .5;
        }

        .login-visual-caption {
            position: relative;
            z-index: 1;
            color: #fff;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
        }

        .login-visual-caption h3 {
            font-weight: 700;
            letter-spacing: .3px;
        }

        .login-visual-caption p {
            color: rgba(255, 255, 255, 0.8);
        }

        #lottie-container {
            width: 100%;
            height: 100%;
            min-height: 340px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
        }

        #lottie-container svg {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
            filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.25));
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 16px;
            background: #fff;
            padding: 8px;
            box-shadow: 0 8px 20px rgba(1, 41, 112, 0.18);
        }

        .login-title {
            color: var(--brand-1);
            font-weight: 700;
        }

        .input-icon-group {
            position: relative;
        }

        .input-icon-group .bi:not(.toggle-password) {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #8b93b0;
            font-size: 1.05rem;
            transition: color .2s ease;
            pointer-events: none;
        }

        .input-icon-group .form-control {
            padding-left: 42px;
            height: 48px;
            border-radius: 10px;
            border: 1px solid #e2e5f1;
            background: #f8f9ff;
            transition: all .2s ease;
        }

        .input-icon-group .form-control:focus {
            border-color: var(--brand-2);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(65, 84, 241, 0.12);
        }

        .input-icon-group .form-control:focus ~ .bi:not(.toggle-password) {
            color: var(--brand-2);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #8b93b0;
            cursor: pointer;
            font-size: 1.05rem;
            z-index: 2;
        }

        .toggle-password:hover {
            color: var(--brand-2);
        }

        .btn-login {
            height: 48px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: .3px;
            background: linear-gradient(135deg, var(--brand-2), var(--brand-3));
            box-shadow: 0 12px 24px -6px rgba(65, 84, 241, 0.55);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 30px -6px rgba(65, 84, 241, 0.65);
        }

        .btn-login:active {
            transform: translateY(0);
        }
    </style>
</head>

<body>
    <main>
        <section class="section register login-page min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-md-11">
                        <div class="card login-card border-0 rounded-4 overflow-hidden">
                            <div class="row g-0">
                                <div class="col-md-6 d-none d-md-block p-0 login-visual">
                                    <div class="d-flex flex-column h-100 p-4">
                                        <div id="lottie-container"></div>
                                        <div class="login-visual-caption text-center mt-2">
                                            <h3 class="mb-1">Company Admin</h3>
                                            <p class="mb-0 small">Manage your workspace, effortlessly.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="card-body p-4 p-lg-5 d-flex flex-column justify-content-center h-100">

                                        <div class="text-center mb-4">
                                            <img src="assets/img/LAI_logo.png" class="brand-logo mb-2" alt="Logo"/>
                                            <h4 class="card-title pb-0 login-title">
                                                Welcome Back
                                            </h4>
                                            <p class="text-muted small mb-0">Enter your username & password to login</p>
                                        </div>

                                        <form class="row g-3" id="login_form" enctype="multipart/form-data" role="form">
                                            <div class="col-12">
                                                <label for="userid" class="form-label fw-semibold">User ID</label>
                                                <div class="input-icon-group">
                                                    <i class="bi bi-person-fill"></i>
                                                    <input type="text" name="userid" class="form-control" id="userid" placeholder="Enter your user ID" required>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label for="password" class="form-label fw-semibold">Password</label>
                                                <div class="input-icon-group">
                                                    <i class="bi bi-lock-fill"></i>
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                                                    <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-4">
                                                <button class="btn btn-login btn-primary w-100 py-2 fs-5 text-white" type="submit" onclick="Login()">
                                                    Login
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="plugins/sweetalert2/dist/sweetalert2.min.js"></script>
    <!-- Validate -->
    <script src="plugins/validation/jquery.validate.min.js"></script>
    <script src="plugins/validation/jquery.validate-init.js"></script>


    <script src="js/login.js"></script>

    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie-container'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: './assets/js/factory.json'
        });
        animation.setSpeed(1.5);

        document.getElementById('togglePassword').addEventListener('click', function () {
            const pwd = document.getElementById('password');
            const isHidden = pwd.type === 'password';
            pwd.type = isHidden ? 'text' : 'password';
            this.classList.toggle('bi-eye-slash', !isHidden);
            this.classList.toggle('bi-eye', isHidden);
        });
    </script>

</body>

</html>