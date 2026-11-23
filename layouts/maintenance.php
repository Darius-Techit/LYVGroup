<?php
// Chế độ bảo trì: true = đóng toàn bộ trang (giữ header/footer), false = hoạt động bình thường
$maintenance = true;

if ($maintenance) {
    if ($lang == 'vn') {
        $mt_title = 'HỆ THỐNG ĐANG BẢO TRÌ';
        $mt_desc  = 'Chúng tôi đang nâng cấp hệ thống để phục vụ bạn tốt hơn. Vui lòng quay lại sau.';
        $mt_sorry = 'Xin lỗi vì sự bất tiện này!';
    } else {
        $mt_title = 'SYSTEM UNDER MAINTENANCE';
        $mt_desc  = 'We are upgrading our system to serve you better. Please come back later.';
        $mt_sorry = 'Sorry for the inconvenience!';
    }
?>
    <style>
        .maintenance {
            position: relative;
            overflow: hidden;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #eaf7f1 0%, #ffffff 50%, #fff6e0 100%);
        }

        /* Đốm màu mờ trôi nhẹ phía sau */
        .maintenance-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: .45;
            animation: mt-float 12s ease-in-out infinite;
        }

        .maintenance-blob.blob-1 {
            width: 320px;
            height: 320px;
            top: -80px;
            left: -80px;
            background: var(--green-color);
        }

        .maintenance-blob.blob-2 {
            width: 260px;
            height: 260px;
            bottom: -60px;
            right: -60px;
            background: var(--yellow-color);
            animation-delay: -6s;
        }

        .maintenance-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 620px;
            padding: 48px 40px;
            text-align: center;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(8px);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(17, 136, 92, .15);
            animation: mt-fade-up .6s ease-out both;
        }

        /* Các phần trong card hiện lần lượt */
        .maintenance-card > * {
            animation: mt-fade-up .7s ease-out both;
        }

        .maintenance-card > *:nth-child(2) { animation-delay: .15s; }
        .maintenance-card > *:nth-child(3) { animation-delay: .3s; }
        .maintenance-card > *:nth-child(4) { animation-delay: .45s; }
        .maintenance-card > *:nth-child(5) { animation-delay: .6s; }
        .maintenance-card > *:nth-child(6) { animation-delay: .75s; }

        /* Hai bánh răng quay ngược chiều nhau */
        .maintenance-gears {
            position: relative;
            width: 140px;
            height: 100px;
            margin: 0 auto 24px;
        }

        .maintenance-gears i {
            position: absolute;
            line-height: 1;
        }

        .maintenance-gears .gear-big {
            left: 0;
            top: 12px;
            font-size: 84px;
            color: var(--green-color);
            animation: mt-spin 6s linear infinite;
        }

        .maintenance-gears .gear-small {
            right: 4px;
            top: 0;
            font-size: 52px;
            color: var(--yellow-color);
            animation: mt-spin 4s linear infinite reverse;
        }

        .maintenance-title {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--green-color);
            margin-bottom: 16px;
        }

        .maintenance-title .dots span {
            animation: mt-blink 1.4s infinite both;
        }

        .maintenance-title .dots span:nth-child(2) { animation-delay: .2s; }
        .maintenance-title .dots span:nth-child(3) { animation-delay: .4s; }

        .maintenance-text {
            font-size: 17px;
            color: #555;
            margin-bottom: 6px;
        }

        .maintenance-progress {
            max-width: 360px;
            height: 8px;
            margin: 28px auto 24px;
            border-radius: 99px;
            background: #e9ecef;
            overflow: hidden;
        }

        .maintenance-progress span {
            display: block;
            width: 40%;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--green-color), var(--yellow-color));
            animation: mt-loading 1.8s ease-in-out infinite;
        }

        .maintenance-contact {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px 24px;
            font-size: 15px;
        }

        .maintenance-contact a {
            color: #333;
            text-decoration: none;
            transition: color .2s;
        }

        .maintenance-contact a:hover {
            color: var(--green-color);
        }

        .maintenance-contact i {
            color: var(--green-color);
            margin-right: 6px;
        }

        @keyframes mt-spin {
            to { transform: rotate(360deg); }
        }

        @keyframes mt-fade-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: none; }
        }

        @keyframes mt-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, 30px) scale(1.1); }
        }

        @keyframes mt-blink {
            0%, 80%, 100% { opacity: 0; }
            40% { opacity: 1; }
        }

        @keyframes mt-loading {
            from { transform: translateX(-100%); }
            to { transform: translateX(250%); }
        }

        @media (max-width: 576px) {
            .maintenance {
                padding: 40px 16px;
            }

            .maintenance-card {
                padding: 36px 20px;
                border-radius: 18px;
            }

            .maintenance-title {
                font-size: 22px;
            }

            .maintenance-text {
                font-size: 15px;
            }
        }

        /* Tắt hiệu ứng nếu người dùng bật giảm chuyển động */
        @media (prefers-reduced-motion: reduce) {
            .maintenance,
            .maintenance * {
                animation: none !important;
            }
        }
    </style>

    <div class="maintenance">
        <span class="maintenance-blob blob-1"></span>
        <span class="maintenance-blob blob-2"></span>

        <div class="maintenance-card">
            <div class="maintenance-gears">
                <i class="fa-solid fa-gear gear-big"></i>
                <i class="fa-solid fa-gear gear-small"></i>
            </div>
            <h2 class="maintenance-title">
                <?= $mt_title ?><span class="dots"><span>.</span><span>.</span><span>.</span></span>
            </h2>
            <p class="maintenance-text"><?= $mt_desc ?></p>
            <p class="maintenance-text"><?= $mt_sorry ?></p>
            <div class="maintenance-progress"><span></span></div>
            <div class="maintenance-contact">
                <a href="tel:0902590113"><i class="fa-solid fa-phone"></i><?= $hotline ?>: 0902 590 113</a>
                <a href="mailto:tuyendung@lacty.com.vn"><i class="fa-solid fa-envelope"></i>tuyendung@lacty.com.vn</a>
            </div>
        </div>
    </div>
<?php
    include __DIR__ . '/footer.php';
    exit;
}
