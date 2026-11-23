<?php
session_start();
require_once('connect.php');
if (!isset($_SESSION["displayName"])) {
    header('Location: ../login.php');
}
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
$permission = isset($_SESSION['permission']) ? $_SESSION['permission'] : '';
$displayName = isset($_SESSION['displayName']) ? $_SESSION['displayName'] : '';
$avatarLetter = mb_strtoupper(mb_substr(trim($displayName), 0, 1, 'UTF-8'), 'UTF-8');
include_once("languages/languages.php");

// Breadcrumb: [nhóm, trang hiện tại] theo file đang mở
$currentPage = basename($_SERVER['PHP_SELF']);
$breadcrumbMap = [
    'information_company.php' => [$system, $information],
    'department.php'          => [$system, $department],
    'work_list.php'           => [$system, $worklist],
    'content_company.php'     => [$system, $news],
    'season_effect.php'       => [$system, $season_effect],
    'help_center.php'         => [$system, $helper_center],
    'user_management.php'     => [$administrator, $usermanagement],
];
$breadcrumb = isset($breadcrumbMap[$currentPage]) ? $breadcrumbMap[$currentPage] : [$system, ''];
$currentLang = isset($_SESSION['language']) ? $_SESSION['language'] : 'en';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LYV Company Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/LAI_logo.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <!-- <link href="https://fonts.gstatic.com" rel="preconnect"> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> -->


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
    <link href="../assets/css/style.css?v=<?= @filemtime(__DIR__ . '/assets/css/style.css') ?>" rel="stylesheet">
    <link href="../plugins/toastr/css/toastr.min.css" rel="stylesheet">
    <link href="../plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="../ckeditor5/ckeditor5.css" rel="stylesheet">
    <link href="../assets/css/select2.min.css" rel="stylesheet" />

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

        /* #tb_data>tbody>tr>td {
            font-size: 11px;
            padding: 0px !important;
        } */

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
            border-radius: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        /* CSS để bo tròn góc cho toàn bộ table */
        table.dataTable {
            border-radius: 10px;
            overflow: hidden;
        }

        /* Ghi đè style bo tròn góc của từng ô header từ plugin datatables */
        table.dataTable thead th {
            border-radius: 0 !important;
        }

        table.dataTable thead th,
        table.dataTable thead td,
        table.dataTable.no-footer {
            border-bottom: 1px solid #ddd !important;
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            box-shadow: 0 10px 22px -8px rgba(99, 102, 241, .55);
        }

        .sidebar .nav-link.active i {
            color: #fff;
            background: rgba(255, 255, 255, .16);
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


        /* .select2-dropdown {
            z-index: 9999 !important;
        } */
    </style>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <!-- Logo: cùng bề rộng với sidebar -->
        <a href="../index.php" class="logo hd-brand">
            <img src="../assets/img/LAI_logo.png" alt="Logo">
            <span class="hd-brand-text">
                <span class="hd-brand-title">Company Admin</span>
                <span class="hd-brand-sub">LYV GROUP</span>
            </span>
        </a>

        <div class="hd-bar">
            <div class="hd-left">
                <button type="button" class="toggle-sidebar-btn" aria-label="Toggle menu">
                    <i class="bi bi-text-left"></i>
                </button>
                <nav aria-label="breadcrumb" class="hd-breadcrumb">
                    <span class="hd-crumb"><?= htmlspecialchars($breadcrumb[0]) ?></span>
                    <?php if ($breadcrumb[1] !== '') { ?>
                        <i class="bi bi-chevron-right hd-crumb-sep"></i>
                        <span class="hd-crumb hd-crumb-current" aria-current="page"><?= htmlspecialchars(trim($breadcrumb[1])) ?></span>
                    <?php } ?>
                </nav>
            </div>

            <div class="header-nav hd-right">
                <!-- Đồng hồ -->
                <div id="clock-wrapper" class="hd-clock">
                    <span id="clock-icon-bg" class="hd-clock-icon"><i id="clock-icon" class="bi"></i></span>
                    <span class="hd-clock-text">
                        <span id="realtime-clock" class="hd-clock-time"></span>
                        <span id="realtime-date" class="hd-clock-date"></span>
                    </span>
                </div>

                <!-- Ngôn ngữ -->
                <div class="hd-lang" role="group" aria-label="<?= htmlspecialchars($language) ?>">
                    <a class="cursor-pointer <?= $currentLang == 'vn' ? 'active' : '' ?>" onclick="chooseLanguage('vn')" title="<?= htmlspecialchars($language_vn) ?>">VI</a>
                    <a class="cursor-pointer <?= $currentLang == 'en' ? 'active' : '' ?>" onclick="chooseLanguage('en')" title="<?= htmlspecialchars($language_en) ?>">EN</a>
                </div>

                <span class="hd-divider"></span>

                <!-- User profile dropdown -->
                <div class="nav-item dropdown">
                <a class="nav-link nav-profile hd-user" href="#" data-bs-toggle="dropdown">
                    <span class="avatar-chip"><?= htmlspecialchars($avatarLetter) ?></span>
                    <span class="hd-user-meta">
                        <span class="hd-user-name"><?php echo htmlspecialchars($displayName); ?></span>
                        <span class="hd-user-role"><?= htmlspecialchars($permission) ?></span>
                    </span>
                    <i class="bi bi-chevron-down hd-user-caret"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header d-flex align-items-center gap-2">
                        <span class="avatar-chip avatar-chip-lg"><?= htmlspecialchars($avatarLetter) ?></span>
                        <span class="profile-meta">
                            <span class="profile-name"><?php echo htmlspecialchars($displayName); ?></span>
                            <span class="profile-role"><?= htmlspecialchars($permission) ?></span>
                        </span>
                    </li>
                    <hr class="dropdown-divider">
                    <li>
                        <a class="dropdown-item d-flex align-items-center cursor-pointer" href="../logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span><?= $logout ?></span>
                        </a>
                    </li>
                </ul>
                </div>
            </div>
        </div>

    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-heading" style="font-weight: 700;font-size: 12px;"><?= $system ?></li>
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
            <li class="nav-item">
                <a class="nav-link collapsed" href="season_effect.php">
                    <i class="bi bi-snow2"></i>
                    <span><?= $season_effect ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="help_center.php">
                    <i class="bx bxs-help-circle"></i>
                    <span><?= $helper_center ?></span>
                </a>
            </li>
            <?php if ($permission == 'Administrator') { ?>
                <li class="nav-heading" style="font-weight: 700;font-size: 12px;"><?= $administrator ?> </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="user_management.php">
                        <i class="bi bi-people-fill"></i>
                        <span><?= $usermanagement ?></span>
                    </a>
                <?php }  ?>
        </ul>

        <div class="sidebar-footer-card">
            <i class="bi bi-shield-check"></i>
            <span>LYV Group Admin</span>
        </div>

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


    <!-- <script src="../js/list_applicant.js"></script> -->
    <script type="importmap">
        {
			"imports": {
				"ckeditor5": "../ckeditor5/ckeditor5.js",
				"ckeditor5/": "../ckeditor5/"
			}
		}
    </script>

    <script src="../assets/js/select2.min.js"></script>
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

        const HEADER_LANG = <?= json_encode($currentLang) ?>;

        $(function() {
            function updateClock() {
                const now = new Date();

                // Lấy ngày, tháng, năm
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const year = now.getFullYear();

                // Lấy giờ, phút, giây
                let hours = now.getHours();
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');

                // Xác định AM hay PM
                const ampm = hours >= 12 ? 'PM' : 'AM';

                // Icon ngày / đêm
                const isDay = hours >= 6 && hours < 18;
                $('#clock-wrapper').toggleClass('is-day', isDay);
                $('#clock-icon').attr('class', isDay ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill');

                // Chuyển đổi định dạng 24h sang 12h
                hours = hours % 12;
                hours = hours ? hours : 12;
                const strHours = String(hours).padStart(2, '0');

                const weekday = HEADER_LANG === 'vn' ?
                    (now.getDay() === 0 ? 'Chủ nhật' : 'Thứ ' + (now.getDay() + 1)) :
                    ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][now.getDay()];

                $('#realtime-clock').text(`${strHours}:${minutes}:${seconds} ${ampm}`);
                $('#realtime-date').text(`${weekday}, ${day}/${month}/${year}`);
            }

            updateClock();
            setInterval(updateClock, 1000);
        });
    </script>
</body>

</html>