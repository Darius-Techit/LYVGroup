<?php
session_start();
require_once('connect.php');
if (!isset($_SESSION["displayName"])) {
    header('Location: ../login.php');
}
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
$permission = isset($_SESSION['permission']) ? $_SESSION['permission'] : '';
include_once("languages/languages.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>LYV Company Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/LAI_logo.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <!-- <link href="https://fonts.gstatic.com" rel="preconnect"> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> -->

    <!--  -->


    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <!-- <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->

    <link href="../plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../plugins/tables/css/datatable/select.dataTables.min.css" rel="stylesheet">
    <link href="../plugins/tables/css/datatable/fixedColumns.dataTables.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../plugins/toastr/css/toastr.min.css" rel="stylesheet">
    <link href="../plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="../ckeditor5/ckeditor5.css" rel="stylesheet">
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

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
            display: inline;
            border: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            border: none;
        }

        #tb_data>tbody>tr>td {
            font-size: 11px;
            padding: 0px !important;
        }

        .pagination>li>a:hover,
        .pagination>li>span:hover,
        .pagination>li>a:focus,
        .pagination>li>span:focus {
            outline: none;
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

        table.dataTable thead th,
        table.dataTable thead td,
        table.dataTable.no-footer {
            border-bottom: 1px solid #ddd !important;
        }

        .sidebar .nav-link.active {
            background: #f6f9ff;
            color: #4154f1;
        }

        .sidebar .nav-link.active i {
            color: #4154f1;
        }

        /* #tb_work_list th:nth-child(3),
        #tb_work_list td:nth-child(3),
        #tb_work_list th:nth-child(4),
        #tb_work_list td:nth-child(4),
        #tb_work_list th:nth-child(5),
        #tb_work_list td:nth-child(5),
        #tb_work_list th:nth-child(6),
        #tb_work_list td:nth-child(6) {
            min-width: 400px !important;
            max-width: 400px !important;
            white-space: normal !important;
            word-wrap: break-word;
        } */

        .select-readonly {
            background-color: #e9ecef;
            color: #6c757d;
            pointer-events: none;
        }

        .ck.ck-balloon-panel,
        .ck.ck-dropdown__panel {
            z-index: 2000 !important;
            /* cao hơn modal (1050) */
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="../index.php" class="logo d-flex align-items-center">
                <img src="../assets/img/LAI_logo.png" alt="">
                <span class="d-none d-lg-block">Company Admin</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <nav class="header-nav ms-auto d-flex align-items-center">
            <!-- Language dropdown -->
            <div class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <!-- <img src="../assets/img/<?php echo $langDisplay[$lang]['flag']; ?>.png" alt="Language" style="width:30px; object-fit: contain; margin-right:10px">
                    <?php echo $langDisplay[$lang]['text']; ?> -->
                    <i class="bi bi-globe me-2"></i>
                    <?= $language ?>
                    <i class="bi bi-caret-right-fill ms-2 dropdown-caret "></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li>
                        <a class="nav-link dropdown-item d-flex align-items-center cursor-pointer <?php echo (@$_SESSION['language'] == 'en') ? 'active' : ''; ?>" onclick="chooseLanguage('en')">
                            <img src=" ../assets/img/en.png" style="width:30px; object-fit: contain; margin-right:10px" /> <?= $language_en ?>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link dropdown-item d-flex align-items-center cursor-pointer <?php echo (@$_SESSION['language'] == 'vn') ? 'active' : ''; ?>" onclick="chooseLanguage('vn')">
                            <img src="../assets/img/vn.png" style="width:30px; object-fit: contain; margin-right:10px" />
                            <?= $language_vn ?>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User profile dropdown -->
            <div class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-2"></i>
                    <?php echo $_SESSION['displayName']; ?>
                    <i class="bi bi-caret-right-fill ms-2 dropdown-caret"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <hr class="dropdown-divider">
                    <li>
                        <a class="dropdown-item d-flex align-items-center cursor-pointer" href="../logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-heading" style="font-weight: 700;font-size: 14px;"><?= $system ?></li>
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-info-circle"></i><span>Information</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link collapsed" href="information_company.php">
                            <i class="bi bi-circle"></i>
                            <span>Information</span>
                        </a>
                    </li>
                    <li>
                        <a class=" nav-link collapsed" href="department.php">
                            <i class="bi bi-circle"></i>
                            <span>Department</span>
                        </a>
                    </li>
                </ul>
            </li> -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="information_company.php">
                    <i class="bi bi-info-circle"></i>
                    <span><?= $information ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="department.php">
                    <i class="bi bi-file-earmark-person"></i>
                    <span><?= $department ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="work_list.php">
                    <i class="bi bi-menu-button-wide"></i>
                    <span><?= $worklist ?></span>
                </a>
            </li>


            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="list_applicant.php">
                    <i class="bi bi-card-checklist"></i>
                    <span>List Applicant</span>
                </a>
            </li> -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="content_company.php">
                    <i class="bi bi-newspaper"></i>
                    <span><?= $news ?></span>
                </a>
            </li>
            <?php if ($permission == 'Administrator') { ?>
                <li class="nav-heading" style="font-weight: 700;font-size: 14px;"><?= $administrator ?> </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="user_management.php">
                        <i class="bi bi-people-fill"></i>
                        <span><?= $usermanagement ?></span>
                    </a>
                <?php }  ?>
        </ul>

    </aside>
    <!-- End Sidebar-->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.min.js"></script>
    <!-- <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script> -->
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>


    <!-- Template Main JS File -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        document.addEventListener('focusin', (event) => {
            if (
                document.querySelector('.modal.show') &&
                event.target.closest('.ck') // Nếu element thuộc CKEditor
            ) {
                event.stopImmediatePropagation();
            }
        });
    </script>
    <script src="../plugins/toastr/js/toastr.init.js"></script>
    <script src="../plugins/toastr/js/toastr.min.js"></script>
    <script src="../plugins/sweetalert2/dist/sweetalert2.min.js"></script>
    <!-- DataTable -->
    <script src="../plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/tables/js/datatable/dataTables.select.min.js"></script>
    <script src="../plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    <!-- Validate -->
    <script src="../plugins/validation/jquery.validate.min.js"></script>
    <script src="../plugins/validation/jquery.validate-init.js"></script>

    <script src="../js/department.js"></script>
    <script src="../js/information_company.js"></script>
    <script src="../js/work_list.js"></script>
    <!-- <script src="../js/list_applicant.js"></script> -->
    <script src="../js/content_company.js"></script>
    <script src="../js/user_management.js"></script>
    <script type="importmap">
        {
			"imports": {
				"ckeditor5": "../ckeditor5/ckeditor5.js",
				"ckeditor5/": "../ckeditor5/"
			}
		}
    </script>
    <script>
        function chooseLanguage(language) {
            $.ajax({
                url: "../data/data_languages.php",
                method: "GET",
                data: {
                    language: language
                },
                success: function(res) {
                    localStorage.setItem("languages", res);
                    location.reload(true);
                }
            })
        }
    </script>
</body>

</html>