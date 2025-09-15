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
    <style>
        table.dataTable tbody>tr.selected,
        table.dataTable tbody>tr>.selected {
            background-color: #86b0d3;
            color: #fff;
            cursor: pointer;
        }

        label.error {
            color: red;
            margin-top: 2px;
            font-size: 12px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }

        .alert {
            padding: unset;
            border-radius: 4px 4px 0 0;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .icon-box {
            color: #fff;
            width: 80px;
            height: 80px;
            border: 5px solid rgb(221, 51, 51);
            border-radius: 50%;
            line-height: 70px;
            display: block;
            margin: auto;
            position: absolute;
            top: -18%;
            left: 50%;
            transform: translate(-50%);
            background: rgb(221, 51, 51);
            text-align: center;
        }

        .icon-box span {
            font-size: 35px;
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
    </style>
</head>

<body>
    <main>
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 d-flex flex-column align-items-center justify-content-center">
                        <div class="card">
                            <div class="card-body pt-5">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <img src="assets/img/company.jpg" alt="help" style="width: 100%; height: 100%" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="pt-4 pb-2">
                                            <h6 class="card-title text-center pb-0 fs-4">
                                                Welcome to Company Admin
                                            </h6>
                                            <p class="text-center small">Enter your username & password to login</p>
                                        </div>
                                        <form class="row g-3" id='login_form' enctype="multipart/form-data" role="form">
                                            <div class="col-12 px-4">
                                                <label class="form-label">User ID</label>
                                                <input type="text" name="userid" class="form-control" id="userid">
                                            </div>
                                            <div class="col-12 px-4">
                                                <label class="form-label">Password</label>
                                                <input type="password" name="password" class="form-control" id="password">
                                            </div>
                                            <div class="col-12 px-4">
                                                <button class="btn btn-primary w-100" type="submit" onclick="Login()">Login</button>
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

</body>

</html>