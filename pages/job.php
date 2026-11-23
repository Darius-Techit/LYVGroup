<?php
include('../layouts/header.php');
include('../src/conn.php');

?>

<head>
    <!-- <link rel="stylesheet" href="../assets/css/home.css"> -->
    <link rel="stylesheet" href="../assets/css/job.css">
    <!-- thẻ việc làm dùng chung với trang chủ + thanh tìm kiếm/phân trang trang này -->
    <link rel="stylesheet" href="../assets/css/job-list.css?v=<?= @filemtime(__DIR__ . '/../assets/css/job-list.css') ?>">
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
<div style="margin-top: 70px;" class="screen-padding hj-section jobs-page">
    <div>
        <h2 class="hj-heading">
            <span class="hj-heading__icon"><i class="fa-solid fa-briefcase"></i></span>
            <?= $job_opption; ?>
        </h2>
        <div class="jobs-search d-flex justify-content-between align-items-center">
            <form action="" method="GET" class="w-100 d-flex justify-content-between align-items-center position-relative">
                <div class="dropdown">
                    <button
                        class="d-flex justify-content-center align-items-center fw-bold category-list"
                        type="button"
                        name="Category"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-sliders"></i>
                        <span><?= $category; ?></span>
                    </button>

                    <ul class="dropdown-menu rounded-4 mt-3 border-0">
                        <li class="p-1">
                            <a class="dropdown-item select-item" href="#" data-value="CN">
                                <?= $labor; ?>
                            </a>
                        </li>
                        <li class="p-1">
                            <a class="dropdown-item select-item" href="#" data-value="VP">
                                <?= $office; ?>
                            </a>
                        </li>
						<li class="p-1">
                            <a class="dropdown-item select-item" href="#" data-value="QL">
                              <?= $manager; ?>  
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="search-container">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input
                        id="dep_name"
                        name="Dep_Name"
                        class="border-0 input-search dropdown-toggle w-100"
                        placeholder="<?= $search_job; ?>"
                         />
                </div>

                <div>
                    <ul class="custom-dropdown w-100 rounded-4 mt-4 border-0" id="suggestion_list">
                        <p class="fw-bold m-0 px-3 py-2"><?= $keyword; ?></p>
                        <li class="p-2"><a class="dropdown-item popular" href="#"><i class="fa-solid fa-arrow-trend-up me-2"></i> <?= $worker; ?></a></li>
                        <li class="p-2"><a class="dropdown-item popular" href="#"><i class="fa-solid fa-arrow-trend-up me-2"></i> <?= $sewing; ?></a></li>
                        <li class="p-2"><a class="dropdown-item popular" href="#"><i class="fa-solid fa-arrow-trend-up me-2"></i> <?= $product_development_staff; ?></a></li>
                        <li class="p-2"><a class="dropdown-item popular" href="#"><i class="fa-solid fa-arrow-trend-up me-2"></i> <?= $shoe_warehouse_staff; ?></a></li>
                    </ul>
                </div>

                <button class="btn btn-clear" id="btnClear" onclick="clearSearch(event)"
                    aria-label="<?= $lang == 'vn' ? 'Xoá tìm kiếm' : 'Clear search' ?>"><i class="fa-solid fa-xmark"></i></button>
                <button class="btn rounded-5 btn-search" type="submit" onclick="search(event)"
                    aria-label="<?= $search; ?>"><i class="fa-solid fa-magnifying-glass"></i><span><?= $search; ?></span></button>
            </form>
        </div>
		
         <p class="text-dark d-flex gap-1  location">       
          <?= $location ?>
            <span id="selected_position">
                <span style="color:var(--green-color); font-weight:bold;"><?= $all?></span>
            </span>
        </p>


        <div id="job_list"></div>

        <!-- Modal -->
        <div class="modal fade" style="margin-top: 0px;  background: rgb(0, 0, 0, 0.4);" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title fs-5 fw-semibold" id="exampleModalLabel"><?= $descriptions; ?></p>
                        <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-describe">
                        <h5 class="text-center job-name"><span id="job_name_describe"></span></h5>
                        <input type="hidden" id="job_id_describe" name="job_id_describe">
                        <div class="text-dark">
                            <span class="fw-bold"><i class="fa-solid fa-bullhorn text-danger"></i> <?= $descriptions; ?>:</span>
                            <p id="job_description"></p>
                            <br>
                            <span class="fw-bold"><i class="fa-solid fa-bullhorn text-danger"></i> <?= $candidate_requirements; ?>:</span>
                            <p id="job_request"></p>
                            <br>
                            <span class="fw-bold"><i class="fa-solid fa-bullhorn text-danger"></i> <?= $compensation_and_benefits; ?>:</span>
                            <p id="job_benefits"></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- modal apply -->
        <div class="modal fade" style="padding-top: 0px; background: rgb(0, 0, 0, 0.4);" id="apply_now" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 999; ">
                <div class="modal-content">
                    <form id="apply_now_form" enctype="multipart/form-data" method="post" novalidate>
                        <div class="modal-header">
                            <p class="modal-title fs-5 fw-semibold" id="exampleModalLabel" style="color: black;">
                                <?= $apply_for_position; ?> <span style="color: var(--green-color);" id="job_name"></span></p>
                            <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <p style="color: var(--green-color); font-weight: bold; margin:10px 32px 0"> <?= $please_fill_in_all; ?></p>

                        <div class="modal-body ">
                            <div style="border: 1px dashed green; border-radius: 8px; padding:16px; margin:0px 16px;">
                                <input type="hidden" name="Job_Id" id="job_id">
                                
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
                                        <input type="tel" maxlength="10" pattern="^0[0-9]{9}$" class="form-control" id="phone"
                                            name="Phone" placeholder="<?= $enter_phone; ?>">
                                    </div>

                                    <div class="py-2 col-md-6">
                                        <span>Email</span>
                                        <input type="email" class="form-control" id="email" name="Email" placeholder="<?= $enter_email; ?>">
                                    </div>
                                </div>

                                <div id="cv_hidden" class=" pt-2 pb-3" style="display: none;">
                                    <h6 class="text-dark fw-normal"><i class="bi bi-person-rolodex"></i> <?= $select_cv_to_apply; ?> <span style="color: red;">*</span></h6>
                                    <div style="display: flex;">
                                        <div class="d-flex align-items-center form-control p-0 w-100 position-relative">
                                            <label for="input_file" class="btn btn-secondary"
                                                style="border-top-right-radius: 0;border-bottom-right-radius: 0;"><?= $choose_cv; ?></label>
                                            <span id="file_text" class="ms-2"><?= $no_file; ?></span>
                                            <input type="file" id="input_file" name="CV"
                                                accept="application/pdf">
                                            <button type="button" class="btn-file" id="btn_remove" style="display: none;">✕</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="save" 
                                style="width: 80px; height: 40px; font-size: 16px;"><?= $save; ?></button>

                            <button type="button" class="btn btn-default" data-bs-dismiss="modal" 
                                style="width: 80px; height: 40px; font-size: 16px; border-color:var(--green-color)"><?= $close; ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../layouts/footer.php') ?>
<script>
    const HOT_SEARCH_HTML = `
    <p class="fw-bold m-0 px-3 py-2"><?= $hot_search; ?></p>
    <li class="p-2"><a class="dropdown-item popular" href="#">
    <i class="fa-solid fa-arrow-trend-up me-2"></i> <?= $worker; ?>
    </a></li>
    <li class="p-2"><a class="dropdown-item popular" href="#">
    <i class="fa-solid fa-arrow-trend-up me-2"></i> <?= $sewing; ?>
    </a></li>
    <li class="p-2"><a class="dropdown-item popular" href="#">
    <i class="fa-solid fa-arrow-trend-up me-2"></i> <?= $product_development_staff; ?>
    </a></li>
    <li class="p-2"><a class="dropdown-item popular" href="#">
    <i class="fa-solid fa-arrow-trend-up me-2"></i> <?= $shoe_warehouse_staff; ?>
    </a></li>
    `;
</script>

<script src="../assets/js/job.js?v=<?= @filemtime(__DIR__ . '/../assets/js/job.js') ?>"></script>


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
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("dep_name");
        const suggestionList = document.getElementById("suggestion_list");


        // Mở dropdown 
        input.addEventListener("focus", function() {
            suggestionList.classList.add("show");
        });

        // Đóng dropdown khi click ra ngoài
        document.addEventListener("click", function(e) {
            if (!input.contains(e.target) && !suggestionList.contains(e.target)) {
        