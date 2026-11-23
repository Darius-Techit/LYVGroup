<?php
session_start();
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'vn';
if ($lang == 'vn') {
    $lang = 'vn';
} else if ($lang == 'en') {
    $lang = 'en';
} else {
    $lang = 'tw';
}
// include 'languages/' . $lang . '.php';
include __DIR__ . '/../languages/' . $lang . '.php';

function buildLangUrl($newLang)
{
    // Lấy toàn bộ query string hiện tại
    $params = $_GET;

    // Thay lang = newLang
    $params['lang'] = $newLang;

    // Gắn lại query string
    $queryString = http_build_query($params);

    // Trả về URL đầy đủ
    return basename($_SERVER['PHP_SELF']) . '?' . $queryString;
}
?>
<!DOCTYPE html>
<?php
// SEO: trang nào cần tiêu đề/mô tả riêng thì đặt $seo_page = '<tên file không có .php>' trước khi include header,
// rồi khai báo $seo['<tên file>'] = ['title' => ..., 'description' => ...] trong languages/vn.php và en.php
$site_url = 'https://www.lacty.com.vn/LYVGroup';
$seo_meta = (isset($seo_page) && isset($seo[$seo_page])) ? $seo[$seo_page] : null;
?>
<html lang="<?= $lang == 'en' ? 'en' : 'vi' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($seo_meta) { ?>
        <title><?= htmlspecialchars($seo_meta['title']) ?></title>
        <meta name="description" content="<?= htmlspecialchars($seo_meta['description']) ?>">
        <link rel="canonical" href="<?= $site_url ?>/pages/<?= $seo_page ?>.php?lang=<?= $lang == 'en' ? 'en' : 'vn' ?>">
        <link rel="alternate" hreflang="vi" href="<?= $site_url ?>/pages/<?= $seo_page ?>.php?lang=vn">
        <link rel="alternate" hreflang="en" href="<?= $site_url ?>/pages/<?= $seo_page ?>.php?lang=en">
    <?php } else { ?>
        <title>CÔNG TY TNHH LẠC TỶ</title>
    <?php } ?>
    <link href="/LYVGroup/assets/images/logo/LAI_logo.png" rel="icon">

    <link rel="stylesheet" href="/LYVGroup/assets/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <script src="/LYVGroup/assets/vendor/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/LYVGroup/assets/vendor/icons/fontawesome-free-7.0.0-web/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link href="https://fonts.cdnfonts.com/css/woodsen-signature" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Hurricane&family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/LYVGroup/assets/vendor/jquery-ui-1.11.4/jquery-ui.css">
    <script src="/LYVGroup/assets/vendor/jquery/jquery-1.11.3.min.js"></script>
    <script src="/LYVGroup/assets/vendor/jquery-ui-1.11.4/jquery-ui.js"></script>

    <script src="/LYVGroup/assets/vendor/validation/jquery.validate.min.js"></script>
    <script src="/LYVGroup/assets/vendor/validation/jquery.validate-init.js"></script>

    <link href="/LYVGroup/assets/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="/LYVGroup/assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>


    <link rel="stylesheet" href="/LYVGroup/assets/css/header.css?v=<?= @filemtime(__DIR__ . '/../assets/css/header.css') ?>">

</head>
<style>
    .navbar {
        z-index: 999;
        position: fixed;
        top: 0;
        background: white;
        width: 100%;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: "Montserrat", sans-serif;
        font-optical-sizing: auto;
        font-style: normal;
        color: var(--green-color);
        /* các trang đã chừa sẵn 70px cho tầng trên, phần này bù thêm cho thanh menu xanh */
        padding-top: 46px;
    }

    @media (max-width: 768px) {
        body {
            padding-top: 0;
        }
    }

    h2 {
        font-weight: bold;
    }

    .modal-backdrop {
        z-index: 1 !important;
    }

    .dropdown {
        list-style: none;
    }
</style>

<body>

    <nav class="navbar site-header p-0">
        <!-- Tầng trên: logo + ngôn ngữ -->
        <div class="header-top">
            <div class="container-fluid px-4 h-100 d-flex align-items-center justify-content-between">
                <div class="navbar-brand d-flex align-items-center m-0 p-0">
                    <div class="toggler me-2">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                    <a class="logo-box" href="/LYVGroup/index.php?lang=<?= $lang; ?>">
                        <img src="/LYVGroup/assets/images/logo/LAI_logo.png" alt="Logo">
                    </a>
                    <a class="title-company" href="/LYVGroup/index.php?lang=<?= $lang; ?>">
                        <span class="company-name"><?= $company ?></span>
                        <span class="company-sub">LYV<?= $lang == 'en' ? '' : ' · LAC TY COMPANY LIMITED' ?></span>
                    </a>
                </div>

                <div class="header-actions">
                    <div class="lang-switch">
                        <a class="lang-pill <?= $lang == 'vn' ? 'active' : '' ?>" href="<?= buildLangUrl('vn') ?>">VI</a>
                        <a class="lang-pill <?= $lang == 'en' ? 'active' : '' ?>" href="<?= buildLangUrl('en') ?>">EN</a>
                    </div>
                    <a class="btn-apply-now" href="/LYVGroup/pages/job.php?lang=<?= $lang ?>" title="<?= $apply_now_btn; ?>" aria-label="<?= $apply_now_btn; ?>">
                        <span class="btn-apply-text"><?= $apply_now_btn; ?></span>
                        <i class="fa-solid fa-arrow-right"></i>
                        <i class="fa-solid fa-briefcase"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tầng dưới: menu xanh -->
        <div class="header-menu">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center">
                    <?php
                    $current_page = basename($_SERVER['PHP_SELF']);
                    ?>
                    <div class="menu-overlay"></div>
                    <ul class="navbar-header align-items-center">
                        <div class="nav-item toggle-close justify-content-between">
                            <a href="/LYVGroup/index.php">
                                <img src="/LYVGroup/assets/images/logo/LAI_logo.png" alt="Logo"
                                    style="width: 70px; height:40px;">
                            </a>
                            <span class="btn-close toggler-btn "></span>
                        </div>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'home.php' || $current_page == 'index.php') ? 'active' : '' ?>"
                                href="/LYVGroup/index.php?lang=<?= $lang ?>"><?= $home; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'intro.php') ? 'active' : '' ?>"
                                href="/LYVGroup/pages/intro.php?lang=<?= $lang ?>"><?= $intro ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'new.php' || $current_page == 'new_detail.php') ? 'active' : '' ?>"
                                href="<?php
                                        if ($current_page == 'new_detail.php' && isset($_GET['news'])) {

                                            echo "/LYVGroup/pages/new.php?lang=" . $lang;
                                        } else {
                                            echo "/LYVGroup/pages/new.php?lang=" . $lang;
                                        }
                                        ?>">
                                <?= $news ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'job.php' || $current_page == 'job_detail.php') ? 'active' : '' ?>"
                                href="<?php
                                        if ($current_page == 'job_detail.php' && isset($_GET['job'])) {

                                            echo "/LYVGroup/pages/job.php?lang=" . $lang;
                                        } else {
                                            echo "/LYVGroup/pages/job.php?lang=" . $lang;
                                        }
                                        ?>">
                                <?= $jobs ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'environment.php') ? 'active' : '' ?>"
                                href="/LYVGroup/pages/environment.php?lang=<?= $lang ?>"><?= $environment ?></a>
                        </li>
                        <div class="mt-3 fw-normal toggle-close justify-content-center">© 2025 by Lac Ty Company Limited</div>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <?php
    // ===== Hiệu ứng mùa (cấu hình trong Admin › Hiệu ứng mùa) =====
    require_once __DIR__ . '/../src/season_effect.php';
    $se_cfg = season_effect_load();
    $se_season = season_effect_current($se_cfg);
    $se_page = basename($_SERVER['PHP_SELF']);
    $se_show = $se_cfg['enabled'] && $se_season
        && ($se_cfg['pages'] === 'all' || $se_page === 'index.php' || $se_page === 'home.php');
    if ($se_show) {
        $se_run = $se_cfg['seasons'][$se_season];
    ?>
        <canvas id="season-fx" aria-hidden="true"
            style="position:fixed;inset:0;pointer-events:none;z-index:<?= $se_cfg['layer'] === 'over' ? 998 : -1 ?>"></canvas>
        <script src="/LYVGroup/assets/js/season-effect.js?v=<?= @filemtime(__DIR__ . '/../assets/js/season-effect.js') ?>" defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var mobile = <?= json_encode($se_cfg['mobile']) ?>;
                var small = window.innerWidth <= 768;
                var cv = document.getElementById('season-fx');
                if (!window.SeasonEffect || !cv || (small && mobile === 'off')) {
                    if (cv) cv.remove();
                    return;
                }
                SeasonEffect.create(cv, {
                    fullscreen: true,
                    respectReducedMotion: true,
                    qtyScale: (small && mobile === 'reduce') ? 0.5 : 1
                }).setConfig(<?= json_encode($se_run, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>);
            });
        </script>
    <?php } ?>

    <div class="floating-buttons">
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center on-top">
            <i class="bi bi-arrow-up-short fs-3"></i>
        </a>
        <button class="btn btn-float phone" data-bs-toggle="modal" data-bs-target="#modalContact">
            <i class="fas fa-phone"></i>
        </button>
        <div class="modal fade modal-contact" id="modalContact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 100 !important;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="contact-head">
                        <button type="button" class="btn-close btn-close-white contact-close" data-bs-dismiss="modal" aria-label="<?= $close; ?>"></button>
                        <div class="contact-head-icon"><i class="fas fa-headset"></i></div>
                        <h1 class="contact-title" id="exampleModalLabel"><?= $contact_phone; ?></h1>
                        <p class="contact-subtitle"><?= $with_24h; ?></p>
                    </div>

                    <div class="contact-body">
                        <a class="contact-item" href="tel:02838762443">
                            <span class="contact-icon"><i class="fas fa-phone-alt"></i></span>
                            <span class="contact-info">
                                <span class="contact-label"><?= $contact_number; ?></span>
                                <span class="contact-value">(028) 38 762 443</span>
                                <span class="contact-note"><i class="far fa-clock"></i> 7:30 - 16:30</span>
                            </span>
                        </a>

                        <div class="contact-item">
                            <span class="contact-icon"><i class="fas fa-mobile-alt"></i></span>
                            <span class="contact-info">
                                <span class="contact-label"><?= $hotline; ?></span>
                                <span class="contact-value">
                                    <a href="tel:0902590113">0902 590 113</a>
                                    <span class="contact-sep">·</span>
                                    <a href="tel:0932097116">0932 097 116</a>
                                </span>
                            </span>
                        </div>

                        <a class="contact-item" href="mailto:tuyendung@lacty.com.vn">
                            <span class="contact-icon"><i class="fas fa-envelope"></i></span>
                            <span class="contact-info">
                                <span class="contact-label">Email</span>
                                <span class="contact-value">tuyendung@lacty.com.vn</span>
                            </span>
                        </a>
                    </div>

                    <div class="contact-foot">
                        <button type="button" class="btn contact-btn-close" data-bs-dismiss="modal"><?= $close; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <a href=" https://www.facebook.com/HRLYV" target="_blank" class="btn-float messenger">
            <i class="fab fa-facebook-messenger"></i>
        </a>
    </div>

    <div class="modal fade" style="margin-top: 70px;" id="modal_login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="login_form" enctype="multipart/form-data" method="POST" novalidate>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="m-0">Đăng nhập</h4>
                        <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h5 class="text-dark">
                            Đăng nhập với Google
                        </h5>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>


</html>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    const overlay = document.querySelector(".menu-overlay");
    const openBtn = document.querySelector(".toggler");
    const closeBtn = document.querySelector(".toggler-btn");
    const menu = document.querySelector('.navbar-header');

    function openMenu() {
        menu.classList.add("show");
        overlay.classList.add("show");
        document.body.classList.add("menu-open");
    }

    function closeMenu() {
        menu.classList.remove("show");
        overlay.classList.remove("show");
        document.body.classList.remove("menu-open");
    }
    openBtn.addEventListener("click", openMenu);
    closeBtn.addEventListener("click", closeMenu);
    overlay.addEventListener("click", closeMenu);
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") closeMenu();
    });
    // xoay ngang / phóng to màn hình lên desktop thì tự đóng ngăn kéo
    window.addEventListener("resize", function() {
        if (window.innerWidth > 768) closeMenu();
    });
    // click chọn nav 

    menu.addEventListener('click', function(e) {
        const link = e.target.closest('.nav-link');
        if (!link) return;
        // Bỏ active ở tất cả link
        menu.querySelectorAll('.nav-link.active').forEach(a => a.classList.remove('active'));
        // Gán active cho link vừa bấm
        link.classList.add('active');
    });
</script>
<?php
// include __DIR__ . '/maintenance.php';
?>