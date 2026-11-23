<?php
// include('./layouts/header.php');
include('./src/conn.php');
$sql = "SELECT *, d.Dep_Name FROM CO_WorkList AS w
   LEFT JOIN CO_DepartmentCompany AS d
   ON d.Dep_ID = w.Dep_ID
   WHERE w.Date_Applications >= CAST(GETDATE() AS DATE)
   AND w.STATUS = '1'
   ORDER BY w.ID DESC";

$rs_sql = fetch_to_array($sql);

$sql_job_hot = "SELECT *, d.Dep_Name FROM CO_WorkList AS w
   LEFT JOIN CO_DepartmentCompany AS d
   ON d.Dep_ID = w.Dep_ID
   WHERE Job_Hot = 1 AND w.Date_Applications >= CAST(GETDATE() AS DATE)
   AND w.STATUS = '1'
   ORDER BY w.ID DESC";

$rs_hot = fetch_to_array($sql_job_hot);

// Không lấy Post_Content/Post_ContentEN: chứa ảnh base64, rất nặng (vượt memory_limit)
$sql_new = "SELECT TOP 10 ID_News, Title_Name, Title_NameEN, Description_Content, Description_ContentEN, Image_Content
		FROM CO_ContentCompany 
        WHERE Is_Active = 1
        ORDER BY CreateDate DESC";
$rs_news = fetch_to_array($sql_new);


//banner: chỉ hiện 1 ảnh mới nhất.
// Không lấy cột Info_Image (base64 ~1MB/ảnh): ảnh được trả qua src/data/banner_image.php
$sql_banner = "SELECT TOP 1 ID_Info_Image, CONVERT(VARCHAR(19), UserDate, 120) AS UserDate
               FROM CO_InformationCompany
               WHERE Image_Status = '1' AND Info_Image LIKE 'data:image/%'
               ORDER BY CreateDate DESC";
$rs_banner = fetch_to_array($sql_banner);
?>

<head>
    <link rel="stylesheet" href="./assets/css/home.css?v=<?= @filemtime(__DIR__ . '/../assets/css/home.css') ?>">
    <link rel="stylesheet" href="./assets/css/job.css">
    <link rel="stylesheet" href="./assets/css/intro.css">
    <link rel="stylesheet" href="./assets/css/new.css">
    <!-- thẻ việc làm dùng chung với trang Việc làm -->
    <link rel="stylesheet" href="./assets/css/job-list.css?v=<?= @filemtime(__DIR__ . '/../assets/css/job-list.css') ?>">

    <link href="./assets/vendor/ckeditor5/ckeditor5.css" rel="stylesheet">

</head>

<style>
    #input_file {
        display: none;
    }

    .modal-describe p {
        margin: 0;
    }

    label.error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }

    input.error {
        border-color: red;
    }

    #input_file-error {
        position: absolute;
        top: 100%;
    }
</style>


<section class="home-banner" style="margin-top: 70px;">
    <?php
    if (!empty($rs_banner)) {
        // v = thời điểm sửa ảnh: Admin đổi ảnh thì link đổi => trình duyệt tải ảnh mới, không dùng ảnh cũ trong cache
        $banner_src = './src/data/banner_image.php?id=' . urlencode($rs_banner[0]['ID_Info_Image'])
            . '&v=' . urlencode(strtotime($rs_banner[0]['UserDate']));
    ?>
        <div class="home-banner__frame">
            <img src="<?= htmlspecialchars($banner_src) ?>" alt="<?= htmlspecialchars($company) ?>"
                class="home-banner__img" fetchpriority="high">
        </div>
        <!-- 
        <a href="#home-content" class="home-banner__scroll" aria-label="<?= $lang == 'vn' ? 'Xem tiếp' : 'Scroll down' ?>">
            <i class="fa-solid fa-chevron-down"></i>
        </a> -->
    <?php } ?>
</section>

<div id="home-content">

    <!-- ===== Việc làm hot (carousel) =====
         Luôn in đủ khung carousel vì assets/js/home.js cần #carousel, .card-item, .prev-btn, .next-btn, #indicators;
         không có việc làm hot thì ẩn cả khu (hidden) -->
    <section class="hj-section screen-padding" <?= empty($rs_hot) ? 'hidden' : '' ?>>
        <h2 class="title-name hj-heading">
            <span class="hj-heading__icon hj-heading__icon--hot"><i class="fa-solid fa-fire"></i></span>
            <?= $hot_work ?>
        </h2>

        <div class="hj-carousel">
            <button type="button" id="prevBtn" class="prev-btn hj-nav hj-nav--prev"
                aria-label="<?= $lang == 'vn' ? 'Trước' : 'Previous' ?>">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <div class="carousel-container">
                <div class="carousel-wrapper" id="carousel">
                    <?php
                    foreach ($rs_hot as $row) {
                        $dep_name = ($lang == 'vn') ? $row['Dep_Name'] : $row['Dep_NameEN'];
                        $working_time = ($lang == 'vn') ? $row['Working_Time'] : $row['Working_TimeEN'];
                        $salary = ($lang == 'vn') ? $row['Salary'] : $row['SalaryEN'];
                        $id = $row['Dep_ID'];
                    ?>
                        <article class="card-item hj-card hj-card--hot">
                            <span class="hj-badge"><i class="fa-solid fa-fire"></i> HOT</span>
                            <a class="hj-card__link" href="./pages/job_detail.php?job=<?= $id ?>&lang=<?= $lang ?>" target="_blank">
                                <div class="hj-card__head">
                                    <span class="hj-logo"><img src="./assets/images/logo/LAI_logo.png" alt="Logo"></span>
                                    <div class="hj-card__titles">
                                        <span class="hj-card__company"><?= $company ?></span>
                                        <h3 class="hj-card__title"><?= $dep_name ?></h3>
                                    </div>
                                </div>

                                <ul class="hj-meta">
                                    <li><i class="fa-regular fa-clock"></i><span><?= $working_time ?></span></li>
                                    <li class="hj-meta__salary"><i class="fa-solid fa-sack-dollar"></i><span><?= $salary ?></span></li>
                                </ul>
                            </a>

                            <div class="hj-card__foot">
                                <button type="button" class="hj-btn hj-btn--primary"
                                    onclick="onApply('<?= $id ?>', '<?= htmlspecialchars($dep_name) ?>','<?= $lang ?>')">
                                    <?= $apply ?> <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            </div>

            <button type="button" id="nextBtn" class="next-btn hj-nav hj-nav--next"
                aria-label="<?= $lang == 'vn' ? 'Tiếp' : 'Next' ?>">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <!-- Chấm chỉ mục: home.js tự tạo theo số trang của carousel -->
        <div id="indicators" class="indicators"></div>
    </section>


    <!-- ===== Danh sách việc làm mới nhất (lưới thẻ) ===== -->
    <section class="hj-section home-job-list screen-padding">
        <h2 class="title-name hj-heading">
            <span class="hj-heading__icon"><i class="fa-solid fa-briefcase"></i></span>
            <?= $job_list ?>
        </h2>

        <?php if (empty($rs_sql)) { ?>
            <div class="hj-empty">
                <i class="fa-regular fa-folder-open"></i>
                <?= $lang == 'vn' ? 'Hiện chưa có vị trí đang tuyển, bạn quay lại sau nhé!' : 'There are no open positions right now, please check back later!' ?>
            </div>
        <?php } ?>

        <div class="hj-grid">
            <?php
            // Trang chủ chỉ hiện 6 việc làm mới nhất (xem đủ ở trang Việc làm)
            foreach (array_slice($rs_sql, 0, 6) as $row) {
                $id = $row['Dep_ID'];
                $dep_name = ($lang == 'vn') ? $row['Dep_Name'] : $row['Dep_NameEN'];
                $working_time = ($lang == 'vn') ?  $row['Working_Time'] :  $row['Working_TimeEN'];
                $salary =  ($lang == 'vn') ?   $row['Salary'] : $row['SalaryEN'];
                $job_description = ($lang == 'vn') ? $row['Job_Description'] : $row['Job_DescriptionEN'];
                $request =  ($lang == 'vn') ? $row['Request_Work'] : $row['Request_WorkEN'];
                $compensation = ($lang == 'vn') ? $row['Compensation_Benefits'] : $row['Compensation_BenefitsEN'];
            ?>
                <article class="hj-card card-job">
                    <a class="hj-card__link" href="./pages/job_detail.php?job=<?= $id ?>&lang=<?= $lang ?>" target="_blank">
                        <div class="hj-card__head">
                            <span class="hj-logo"><img src="./assets/images/logo/LAI_logo.png" alt="Logo"></span>
                            <div class="hj-card__titles">
                                <span class="hj-card__company"><?= $company ?></span>
                                <h3 class="hj-card__title"><?= $dep_name ?></h3>
                            </div>
                        </div>

                        <ul class="hj-meta">
                            <li class="hj-meta__address" title="<?= htmlspecialchars($company_address) ?>">
                                <i class="fa-solid fa-location-dot"></i><span><?= $company_address ?></span>
                            </li>
                            <li><i class="fa-regular fa-clock"></i><span><?= $working_time ?></span></li>
                            <li class="hj-meta__salary"><i class="fa-solid fa-sack-dollar"></i><span><?= $salary ?></span></li>
                        </ul>
                    </a>

                    <div class="hj-card__foot">
                        <button type="button" class="hj-btn hj-btn--primary"
                            onclick="onApply('<?= $id ?>', '<?= htmlspecialchars($dep_name) ?>','<?= $lang ?>')">
                            <?= $apply ?> <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        <button type="button" class="hj-btn hj-btn--soft"
                            onclick="onDescription(
                                '<?= $id ?>',
                                '<?= htmlentities($dep_name) ?>',
                                '<?= htmlentities($job_description) ?>',
                                '<?= htmlentities($request) ?>',
                                '<?= htmlentities($compensation) ?>'
                            )">
                            <i class="fa-regular fa-file-lines"></i> <?= $describe ?>
                        </button>
                    </div>
                </article>
            <?php } ?>
        </div>

        <?php if (!empty($rs_sql) && count($rs_sql) > 3) { ?>
            <div class="hj-more-wrap">
                <a href="./pages/job.php" class="hj-more"><?= $see_more ?> <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        <?php } ?>
    </section>
</div>


<div class="intro">
    <div class="intro-selection">
        <h1><?= $intro; ?></h1>
        <h2 style="font-weight: bold;"><?= $lacty; ?></h2>
    </div>
    <p style="font-size: 18px;"><?= $intro_detail; ?>
    </p>

    <div class="intro-selection">
        <h1><?= $why; ?></h1>
        <h2 style="font-weight: bold;"><?= $choose; ?></h2>
    </div>
    <p style="font-size: 18px;">
        <?= $intro_about; ?>
    </p>
</div>

<div class="screen-padding">
    <div style="margin-bottom:40px">
        <?php if (!empty($rs_news)) {
            echo '<h2 style="color:var(--yellow-color); text-align: center;" class="title-name">
                    <img src="./assets/images/news.png" alt="" style="width: 24px;"> ' . $general_news . ' <img src="./assets/images/news.png" alt="" style="width: 24px;">
                </h2>
                <div class ="d-flex justify-content-end">
                    <a href="./pages/new.php" class="d-block text-end news m-0">' . $see_all . ' >>></a> 
                </div>
            ';
        }
        ?>

        <div class="position-relative ">
            <button id="prevBtnNew" class="prev-btn-new position-absolute top-50 start-0 translate-middle-y">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="carousel-wrapper-news">
                <div class="d-flex carousel-news" id="carousel_news">
                    <?php
                    foreach ($rs_news as $row) {
                        $id_content = $row['ID_News'];
                        $title  = ($lang == 'vn') ? $row['Title_Name'] : $row['Title_NameEN'];
                        $description = ($lang == 'vn') ? $row['Description_Content'] : $row['Description_ContentEN'];
                        $image = $row['Image_Content'];
                    ?>

                        <div class="p-3 card-new new-item" style="width: 100%;height:100%;">
                            <a href="./pages/new_detail.php?news=<?php echo $id_content ?>&lang=<?= $lang; ?>" class="text-decoration-none">
                                <div class="new-text">
                                    <img src="<?= $image; ?>" alt="">
                                    <h3><?= $title ?></h3>
                                    <p><?= $description ?></p>
                                </div>
                            </a>
                        </div>

                    <?php }; ?>
                </div>
            </div>

            <button id="nextBtnNew" class="next-btn-new position-absolute top-50 end-0 translate-middle-y">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
    <div class="border border-1 rounded-4 p-4 application">
        <h2 class="text-center mb-4 fw-bold apply-title font-20"><?= $application_process; ?></h2>
        <div class="d-flex align-items-start justify-content-center application-process">
            <div class="step">
                <img src="./assets/images/apply1.png" alt="" class="apply-img">
                <p class="fw-bold fs-5 m-0 step-title"><?= $submit_application; ?></p>
                <div class="desc"><?= $application_process_detail; ?>
                </div>
            </div>
            <div class="arrow"></div>
            <div class="step">
                <img src="./assets/images/apply2.png" alt="" class="apply-img">
                <p class="fw-bold fs-5 m-0 step-title"><?= $interview; ?></p>
                <div class="desc"><?= $interview_detail; ?></div>
            </div>
            <div class="arrow"></div>
            <div class="step">
                <img src="./assets/images/apply3.png" alt="" class="apply-img">
                <p class="fw-bold fs-5 m-0 step-title"><?= $get_job; ?></p>
                <div class="desc"><?= $get_job_detail; ?></div>
            </div>
            <div class="arrow"></div>
            <div class="step">
                <img src="./assets/images/apply4.png" alt="" class="apply-img">
                <p class="fw-bold fs-5 m-0 step-title"><?= $training; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade " style="margin-top: 0px; background: rgb(0, 0, 0, 0.4);" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-semibold" id="exampleModalLabel"><?= $descriptions; ?></h1>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body  modal-describe">
                <h5 class="text-center job-name"><span id="job_name_describe"></span></h5>
                <input type="hidden" name="job_id_describe" id="job_id_describe">
                <div class="text-dark">
                    <span class="fw-bold"><i class="fa-solid fa-bullhorn text-danger"></i> <?= $descriptions; ?>:</span>
                    <p id="job_description"></p>
                    <br>
                    <span class="fw-bold"><i class="fa-solid fa-bullhorn text-danger"></i> <?= $candidate_requirements; ?>:</span>
                    <p id="job_request"></p>
                    <br>
                    <span class="fw-bold"><i class="fa-solid fa-bullhorn text-danger"></i> <?= $compensation_and_benefits; ?>:</span>
                    <p id="job_compensation"></p>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- modal apply -->
<div class="modal fade" style="padding-top: 0px;background: rgb(0, 0, 0, 0.4);" id="modal_apply" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="apply_form" enctype="multipart/form-data" method="POST" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-semibold" id="exampleModalLabel" style="color:black;">
                        <?= $apply_for_position; ?> <span style="color: var(--green-color);" id="job_name"></span></p>
                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p style="color: var(--green-color); font-weight: bold; margin:10px 32px 0"> <?= $please_fill_in_all; ?></p>
                <div class="modal-body ">
                    <div style="border: 1px dashed green; border-radius: 8px; padding:16px; margin:0px 16px;">
                        <input type="hidden" name="Job_Id" id="job_id">
                        <!-- <input type="hidden" id="position_level" name="Position_Level" value=""> -->

                        <div class="text-dark row">
                            <div class="py-2 col-md-6">
                                <span><?= $full_name; ?> <span style="color: red;">*</span></span>
                                <input type="text" class="form-control" id="name" name="Name" placeholder="<?= $enter_full_name; ?>">
                            </div>
                            <div class="py-2 col-md-6">
                                <span><?= $birth; ?> <span style="color: red;">*</span></span>
                                <!-- <input type="date" class="form-control" id="birthday" name="Birthday" placeholder=""> -->
                                <input type="text" class="form-control" id="birthday" name="Birthday"
                                    placeholder="yyyy/mm/dd" onfocus="this.type='date'" onblur="if(!this.value)this.type='text'">

                            </div>
                            <div class="py-2 col-md-6">
                                <span><?= $phone_number; ?> <span style="color: red;">*</span></span>
                                <input type="tel" maxlength="10"
                                    pattern="^0[0-9]{9}$" class="form-control"
                                    id="phone" name="Phone" placeholder="<?= $enter_phone; ?>">
                            </div>

                            <div class="py-2 col-md-6">
                                <span>Email</span>
                                <input type="email" class="form-control" id="email" name="Email" placeholder="<?= $enter_email; ?>">
                            </div>
                        </div>
                        <div id="cv_block" class=" pt-2 pb-3 ">
                            <h6 class="text-dark fw-normal"><i class="bi bi-person-rolodex"></i> <?= $select_cv_to_apply; ?><span style="color: red;"> *</span></h6>
                            <div style="display: flex;">
                                <div class="d-flex align-items-center form-control p-0 w-100 position-relative">
                                    <label for="input_file" class="btn btn-secondary"
                                        style="border-top-right-radius: 0;border-bottom-right-radius: 0;
                                    border-top-left-radius:3px;border-bottom-left-radius:3px;"><?= $choose_cv; ?></label>
                                    <span id="file_text" class="ms-2"><?= $no_file; ?></span>
                                    <input type="file" id="input_file" name="CV" accept=".pdf">
                                    <button type="button" class="btn-file" id="btn_remove" style="display: none;">✕</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <!-- <button type="submit" class="btn btn-success" id="save" onclick="saveApply('<?= $lang; ?>')"
                        style="width: 80px; height: 40px; font-size: 16px;"><?= $save; ?></button> -->

                    <input type="submit" class="btn btn-success" id="save"
                        style="width: 80px; height: 40px; font-size: 16px;" value="<?= $save; ?>">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal"
                        style="width: 80px; height: 40px; font-size: 16px; border-color:var(--green-color)"><?= $close; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- <script src="./src/js/home.js"></script> -->
<script src="./assets/js/home.js?v=<?= @filemtime(__DIR__ . '/../assets/js/home.js') ?>"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

<script>
    const nameInput = document.getElementById("name");

    // Chỉ cho nhập chữ cái (có dấu) và khoảng trắng
    nameInput.addEventListener("input", function() {
        this.value = this.value.replace(/[^A-Za-zÀ-ỹ\s]/g, "");
    });

    const birthdayInput = document.getElementById("birthday");
    const today = new Date();
    const minDate = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate());
    birthdayInput.max = minDate.toISOString().split("T")[0];

    // Nút mũi tên dưới banner: cuộn mượt xuống phần nội dung
    const bannerScroll = document.querySelector(".home-banner__scroll");
    if (bannerScroll) {
        bannerScroll.addEventListener("click", function(