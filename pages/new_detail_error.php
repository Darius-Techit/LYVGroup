<?php //include('../layouts/header.php') ?>

<head>
    <link rel="stylesheet" href="../assets/css/new.css">
    <link href="../assets/vendor/ckeditor5/ckeditor5.css" rel="stylesheet">

</head>
<style>
    .empty-news {
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #1b7f5c;
    }

    .empty-news__icon {
        width: 150px;
        height: 150px;
        background: #e6f5ef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .empty-news__icon i {
        font-size: 52px;
        color: #ee0707ff;
    }

    .empty-news h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .empty-news p {
        font-size: 16px;
        color: #555;
        max-width: 420px;
        margin-bottom: 20px;
    }
</style>

<div style="margin-top: 50px;" class="screen-padding">
    <div class="empty-news">
        <div class="empty-news__icon">
            <i class="fa-regular fa-newspaper"></i>
        </div>
        <h2>Tin tức không tồn tại</h2>
        <p>Nội dung bạn đang tìm kiếm không có hoặc đã bị gỡ bỏ.</p>

    </div>

</div>


<?php include('../layouts/footer.php') ?>