<?php include('../layouts/header.php') ?>
<?php
include('../src/conn.php');

if (isset($_GET['job'])) {
    $id = $_GET['job'];
	if (!preg_match('/^[A-Za-z0-9]{1,19}$/', $id)) {
        echo "<script>
            alert('$delete');
            window.location.href ='../index.php'
        </script>";
    exit();
    }
    //$sql = "SELECT * FROM CO_WorkList as w 
      //      LEFT JOIN CO_DepartmentCompany as d
      //    ON d.Dep_ID = w.Dep_ID 
      //   WHERE w.Dep_ID = '$id' AND w.Date_Applications >= CAST(GETDATE() AS DATE)";
	$sql ="EXEC dbo.LYV_CO_WorkList '$id'";
    $rs_sql = fetch_to_array($sql);

    if (empty($rs_sql)) {
        echo "<script>
                alert('$job_delete');
                window.location.href ='../index.php'
            </script>";
        exit();
    }
} else {
    echo "<script>
            alert('$job_delete');
            window.location.href ='../index.php'
        </script>";
    exit();
}
?>

<link rel="stylesheet" href="../assets/css/job.css">
<!-- <link rel="stylesheet" href="../assets/css/footer.css"> -->
<style>
    .job-detail p {
        margin: 0;
    }

    label.error {
        /* color: #ff0000;
        font-size: 14px;
        margin-top: 5px; */
        display: none !important;
    }

    input.error {
        border-color: red;
        color: red !important;
    }

    input.error::placeholder {
        color: red !important;
    }
</style>
<div style="margin-top: 70px;" class="screen-padding">
    <?php
    foreach ($rs_sql as $row) {
        $dep_name = ($lang == 'vn') ? $row['Dep_Name'] : $row['Dep_NameEN'];
        $job_description = ($lang == 'vn') ? $row['Job_Description'] : $row['Job_DescriptionEN'];
        $request_work = ($lang == 'vn') ? $row['Request_Work'] : $row['Request_WorkEN'];
        $degree =  ($lang == 'vn') ? $row['Degree'] : $row['DegreeEN'];
        $gender = ($lang == 'vn') ? $row['Gender'] : $row['GenderEN'];
        $age = ($lang == 'vn') ? $row['Age_Range'] : $row['Age_RangeEN'];
        $salary = ($lang == 'vn') ? $row['Salary'] : $row['SalaryEN'];
        $number = $row['Number_Vacancies'];
        $exp =  ($lang == 'vn') ?  $row['Work_Experience'] : $row['Work_ExperienceEN'];
        $time = ($lang == 'vn') ? $row['Working_Time'] :  $row['Working_TimeEN'];
        $date = $row['UserDate'];
        $compensation = ($lang == 'vn') ? $row['Compensation_Benefits'] : $row['Compensation_BenefitsEN'];
        $apply_date = $row['Date_Applications'];
        $now = new DateTime();                   // ngày hiện tại
        $applyDate = new DateTime($apply_date);  // ngày lấy từ DB

        $diff = $now->diff($applyDate);
    }
    ?>
    <div class="d-flex justify-content-between job-detail">

        <div class="job-detail-left">
            <div class="rounded-3 border border-2 d-flex align-items-center job-title">
                <img src="../assets/images/logo/LAI_logo.png" alt="" class="detail-icon">
                <div class="custom-border border-2 p-3 w-100 border-start">
                    <h3 class="text-center fw-bold font-16"><?php echo $dep_name; ?></h3>
                    <div class="d-flex flex-wrap flex-xl-nowrap justify-content-between gap-3 mt-3">

                        <div class="d-flex align-items-center">
                            <img src="../assets/images/address.png" alt="" style="width: 40px;height: 35px;">
                            <span class="d-inline-block detail-address"><?= $company_address ?></span>
                        </div>
                        <div>
                            <img src="../assets//images//time.png" alt="" style="width: 40px;height: 35px;">
                            <span><?php echo $time; ?></span>
                        </div>
                        <div>
                            <img src="../assets//images//agree.png" alt="" style="width: 40px;height: 35px;">
                            <span><?php echo $salary; ?></span>
                        </div>
                    </div>

                    <div class="text-center d-flex justify-content-start mt-2 text-danger font-14">
                        <div class="me-3"><i class="bi bi-clock"></i> <?= $deadline  ?> <?= date("d/m/Y", strtotime($apply_date)); ?></div>

                        <?php if ($lang == 'vn') {
                            echo "
                                <div style='white-space: nowrap'> $remain  $diff->days $day</div>
                            ";
                        } else {
                            echo "
                                <div style='white-space: nowrap'> $diff->days $day $remain</div>
                            ";
                        } ?>
                    </div>
                </div>
            </div>
            <div class="rounded-3 border border-2 mt-4 p-3">
                <h3>◆ <?= $descriptions; ?></h3>
                <div class="text-dark">
                    <span>
                        <?php echo $job_description; ?>
                    </span>
                </div>
                <br />
                <h3>◆ <?= $candidate_requirements; ?></h3>
                <div class="text-dark">
                    <span>
                        <?php echo $request_work; ?>
                    </span>
                </div>
            </div>
            <div class="rounded-3 border border-2 mt-4 p-3  p-md-3">
                <h3>◆ <?= $compensation_and_benefits; ?></h3>
                <div class="text-dark">
                    <span>
                        <?php echo $compensation ?>
                    </span>
                </div>

            </div>
        </div>
        <div class="job-detail-right">
            <div class="rounded-3 border border-2">
                <h3 class="border-bottom text-center p-3 m-0  p-md-3" style="white-space: nowrap;"><?= $general_request; ?></h3>
                <div class="p-3 request">
                    <div class="d-flex justify-content-start align-items-center text-dark mb-3">
                        <img src="../assets//images//degree.png" alt="" class="icon-size">
                        <div class="ms-4">
                            <p class="fw-bold m-0"><?= $qualification; ?></p>
                            <span><?php echo $degree ?></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center text-dark mb-3">
                        <img src="../assets//images//sex.png" alt="" class="icon-size">
                        <div class="ms-4">
                            <p class="fw-bold m-0"><?= $genders; ?></p>
                            <span><?php echo $gender ?></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center text-dark mb-3">
                        <img src="../assets//images//age.png" alt="" class="icon-size">
                        <div class="ms-4">
                            <p class="fw-bold m-0"><?= $ages; ?></p>
                            <span><?php echo $age ?></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center text-dark mb-3">
                        <img src="../assets//images//money.png" alt="" class="icon-size">
                        <div class="ms-4">
                            <p class="fw-bold m-0"><?= $salarys; ?></p>
                            <span><?php echo $salary ?></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center text-dark mb-3">
                        <img src="../assets//images//quantity.png" alt="" class="icon-size">
                        <div class="ms-4">
                            <p class="fw-bold m-0"><?= $apply_number; ?></p>
                            <span><?php echo $number ?></span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start align-items-center text-dark mb-3">
                        <img src="../assets//images//exp.png" alt="" class="icon-size">
                        <div class="ms-4">
                            <p class="fw-bold m-0"><?= $experience; ?></p>
                            <span><?php echo $exp ?></span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start align-items-center text-dark">
                        <img src="../assets//images//time.png" alt="" class="icon-size">
                        <div class="ms-4">
                            <p class="fw-bold m-0"><?= $working_time; ?></p>
                            <span><?php echo $time ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-3 border mt-4" style="background: var(--green-color);">
                <h3 class="text-white py-3 text-center border-bottom border-2 m-0"><?= $register_apply; ?></h3>
                <form id="apply_now_form" enctype="multipart/form-data" method="post" novalidate>
                    <input type="hidden" name="Job_Id" id="job_id" value="<?php echo $id; ?>">
                    <div class="m-3 row text-white">
                        <div class="col-md-6 mb-3">
                            <span><?= $full_name ?></span>
                            <input type="text" id="name" name="Name" placeholder="<?= $enter_full_name; ?>" 
                                class="form-control custom-placeholder" required >
                        </div>
                        <div class="col-md-6 mb-3">
                            <span><?= $birth; ?></span>
                            <!-- <input type="date" id="birthday" name="Birthday" lang="vi" 
                                class="form-control custom-placeholder" required title="Tuổi lớn hơn 16 và nhỏ hơn 60"> -->
                                <input type="text" class="form-control" id="birthday" name="Birthday"
                                placeholder="yyyy/mm/dd" onfocus="this.type='date'" onblur="if(!this.value)this.type='text'">
                        </div>
                        <div class="col-md-12 mb-3">
                            <span><?= $phone_number; ?></span>
                            <input type="tel" maxlength="10" pattern="^0[0-9]{9}$" 
                                class="form-control custom-placeholder" id="phone_detail"
                                name="Phone" placeholder="<?= $enter_phone; ?>" required >
                        </div>

                        <div class="col-md-12 mb-3">
                            <span>Email</span>
                            <input type="text" name="Email" placeholder="<?= $enter_email; ?>" class="form-control custom-placeholder">
                        </div>

                        <div id="cv_detail" class="custom mb-3 col-md-12">
                            <span><?= $select_cv_to_apply; ?></span>
                            <div class="d-flex position-relative">
                                <input type="text" class="form-control custom-placeholder" id="blah" readonly
                                    value="<?php echo $attach_cv_here; ?>">
                                <input type="file" name="CV" class="custom-file" id="input_file" accept=".pdf">
                                <button type="button" class="btn-cv" id="btn_cv" style="display: none;">✕</button>
                                
                            </div>

                        </div>

                        <div class="text-center">
                            <button type="submit" class="p-2 rounded-3 bg-danger text-white border-0 fw-bold" onclick="applyNow('<?= $lang ?>')">
                                <i class="bi bi-send"></i> <?= $submit_apply; ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.getElementById("input_file");
        const textInput = document.getElementById("blah");

        fileInput.addEventListener("change", function() {
            if (this.files && this.files.length > 0) {
                textInput.value = this.files[0].name;
            } else {
                textInput.value = "";
            }
        });
    });
</script>
<?php include('../layouts/footer.php') ?>
<script src="../assets/js/job_detail.js"></script>

<script>
    const nameInput = document.getElementById("name");

    // Chỉ cho nhập chữ cái (có dấu) và khoảng trắng
    nameInput.addEventListener("input", function() {
        this.value = this.value.replace(/[^A-Za-zÀ-ỹ\s]/g, "");
    });


    const birthdayInput = document.getElementById("birthday");
    const today = new Date();

    // >16
    const maxDate = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate());

    // <60
    const minDate = new Date(today.getFullYear() - 60, today.getMonth(), today.getDate());

    birthdayInput.max = maxDate.toISOString().split("T")[0];
    birthdayInput.min = minDate.toISOString().split("T")[0];
</script>

