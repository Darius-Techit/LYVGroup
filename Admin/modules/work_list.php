<?php
require('../sidebar.php');
?>
<style>
    #modalListApply .table-responsive {
        white-space: nowrap;
        max-height: fit-content;
        overflow-y: auto;
        border: 1px solid #eef1fa;
        border-radius: 14px;
        background: #fff;
        padding: 6px 6px 0;
    }

    #modalListApply .table-responsive::-webkit-scrollbar {
        height: 10px;
        width: 8px;
    }

    #modalListApply .table-responsive::-webkit-scrollbar-track {
        background: #f1f3fb;
        border-radius: 4px;
    }

    #modalListApply .table-responsive::-webkit-scrollbar-thumb {
        background-color: #4154f1;
        border-radius: 4px;
    }

    @keyframes wlFadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #wl-page .wl-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(21, 33, 92, 0.08);
        overflow: hidden;
        animation: wlFadeInUp 0.35s ease both;
        transition: box-shadow 0.2s ease;
    }

    #wl-page .wl-card:hover {
        box-shadow: 0 10px 28px rgba(21, 33, 92, 0.12);
    }

    #wl-page .wl-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 22px 24px 18px;
        border-bottom: 1px solid #eef1fa;
        flex-wrap: wrap;
    }

    #wl-page .wl-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    #wl-page .wl-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        color: #fff;
        font-size: 22px;
        flex-shrink: 0;
    }

    #wl-page .wl-header h5 {
        margin: 0;
        font-weight: 700;
        color: #012970;
    }

    #wl-page .wl-header small {
        color: #8a94b3;
    }

    #wl-page .wl-stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 12px;
        background: #f8f9ff;
        border: 1px solid #eef1fa;
        min-width: 130px;
    }

    #wl-page .wl-stat-item i {
        font-size: 18px;
        color: #4154f1;
    }

    #wl-page .wl-stat-item b {
        display: block;
        font-size: 17px;
        color: #012970;
        line-height: 1;
    }

    #wl-page .wl-stat-item span {
        display: block;
        font-size: 11.5px;
        color: #8a94b3;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    #wl-page .wl-filter-bar {
        border-radius: 10px;
        padding: 20px 24px;
        background: #f8f9ff;
        border-bottom: 1px solid #eef1fa;
    }

    #wl-page .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #4b5580;
        margin-bottom: 6px;
    }

    #wl-page .wl-filter-bar .form-control,
    #wl-page .wl-filter-bar .form-select {
        border-color: #e3e6f5;
    }

    #wl-page .wl-filter-bar .form-control:focus,
    #wl-page .wl-filter-bar .form-select:focus {
        box-shadow: 0 0 0 3px rgba(65, 84, 241, 0.12);
    }

    #wl-page .wl-check-chip,
    #modalWorkList .wl-check-chip {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 50px;
        background: #fff;
        border: 1px solid #e3e6f5;
        height: 42px;
    }

    #wl-page .wl-check-chip input.form-check-input,
    #modalWorkList .wl-check-chip input.form-check-input {
        width: 20px !important;
        height: 20px !important;
        margin: 0 !important;
        cursor: pointer;
    }

    #wl-page .wl-check-chip label.form-check-label,
    #modalWorkList .wl-check-chip label.form-check-label {
        color: #eb3349 !important;
        font-weight: 600;
        font-size: 13.5px;
        margin: 0 !important;
        cursor: pointer;
    }

    #wl-page .btn-search,
    #wl-page .wl-toolbar .btn,
    #modalWorkList .modal-footer .btn,
    #modalListApply .modal-footer .btn,
    #modalPro_Status .modal-footer .btn {
        padding: 8px 20px;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.2px;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    #wl-page .btn-search:hover,
    #wl-page .wl-toolbar .btn:hover,
    #modalWorkList .modal-footer .btn:hover,
    #modalListApply .modal-footer .btn:hover,
    #modalPro_Status .modal-footer .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }

    #wl-page .btn-search:active,
    #wl-page .wl-toolbar .btn:active,
    #modalWorkList .modal-footer .btn:active,
    #modalListApply .modal-footer .btn:active,
    #modalPro_Status .modal-footer .btn:active {
        transform: translateY(0);
    }

    #wl-page .btn-search,
    #wl-page .wl-toolbar .btn-primary,
    #modalWorkList .modal-footer .btn-primary,
    #modalListApply .modal-footer .btn-primary,
    #modalPro_Status .modal-footer .btn-primary {
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        box-shadow: 0 6px 16px rgba(65, 84, 241, 0.35);
    }

    #wl-page .btn-search:hover,
    #wl-page .wl-toolbar .btn-primary:hover,
    #modalWorkList .modal-footer .btn-primary:hover,
    #modalListApply .modal-footer .btn-primary:hover,
    #modalPro_Status .modal-footer .btn-primary:hover {
        box-shadow: 0 10px 20px rgba(65, 84, 241, 0.42);
    }

    #wl-page .wl-toolbar .btn-warning {
        background: linear-gradient(135deg, #f7b733, #fc4a1a);
        color: #fff;
        box-shadow: 0 6px 16px rgba(252, 74, 26, 0.3);
    }

    #wl-page .wl-toolbar .btn-warning:hover {
        box-shadow: 0 10px 20px rgba(252, 74, 26, 0.4);
    }

    #wl-page .wl-toolbar .btn-danger {
        background: linear-gradient(135deg, #eb3349, #f45c43);
        box-shadow: 0 6px 16px rgba(235, 51, 73, 0.3);
    }

    #wl-page .wl-toolbar .btn-danger:hover {
        box-shadow: 0 10px 20px rgba(235, 51, 73, 0.4);
    }

    #wl-page .wl-toolbar .btn-success {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        box-shadow: 0 6px 16px rgba(17, 153, 142, 0.3);
    }

    #wl-page .wl-toolbar .btn-success:hover {
        box-shadow: 0 10px 20px rgba(17, 153, 142, 0.4);
    }

    #modalWorkList .modal-footer .btn-secondary,
    #modalListApply .modal-footer .btn-secondary,
    #modalPro_Status .modal-footer .btn-secondary {
        background: linear-gradient(135deg, #7b8794, #99a3b0);
        box-shadow: 0 6px 16px rgba(90, 100, 120, 0.25);
    }

    #modalWorkList .modal-footer .btn-secondary:hover,
    #modalListApply .modal-footer .btn-secondary:hover,
    #modalPro_Status .modal-footer .btn-secondary:hover {
        box-shadow: 0 10px 20px rgba(90, 100, 120, 0.32);
    }

    #wl-page .wl-toolbar {
        padding: 16px 24px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    #wl-page .table-responsive {
        padding: 0 24px 24px;
    }

    #tb_work_list thead th,
    #tb_list_applicant thead th {
        background: linear-gradient(135deg, #2c3ea1, #4154f1) !important;
        color: #fff !important;
        border: none !important;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.3px;
        padding: 12px 8px !important;
    }

    #tb_work_list tbody td,
    #tb_list_applicant tbody td {
        padding: 10px 8px !important;
        vertical-align: middle;
        border-color: #eef1fa !important;
    }

    #tb_work_list tbody tr {
        cursor: pointer;
        transition: background 0.12s ease;
    }

    #modalWorkList .modal-content,
    #modalListApply .modal-content,
    #modalPro_Status .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    #modalWorkList .modal-header,
    #modalListApply .modal-header,
    #modalPro_Status .modal-header {
        background: linear-gradient(135deg, #4154f1, #6a7bfb) !important;
        color: #fff !important;
        border: none;
        padding: 14px 24px;
    }

    #modalWorkList .modal-header .btn-close,
    #modalListApply .modal-header .btn-close,
    #modalPro_Status .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    /* ---------- Modal List Applicant ---------- */
    #modalListApply .modal-header {
        align-items: center;
        gap: 14px;
    }

    #modalListApply .la-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    #modalListApply .la-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    #modalListApply .modal-title {
        margin: 0;
        font-weight: 700;
        line-height: 1.2;
    }

    #modalListApply .la-subtitle {
        display: block;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.78);
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    #modalListApply .la-header-right {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }

    #modalListApply .la-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 14px;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.18);
        font-size: 12.5px;
        font-weight: 600;
        white-space: nowrap;
    }

    #modalListApply .la-count b {
        font-size: 15px;
    }

    #modalListApply .la-header-right .btn-close {
        margin: 0;
    }

    #modalListApply .modal-body {
        background: #fff;
        padding: 20px 24px 24px;
    }

    #modalListApply .la-filter {
        background: #f8f9ff;
        border: 1px solid #eef1fa;
        border-radius: 14px;
        padding: 16px 18px;
    }

    #modalListApply .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #4b5580;
        margin-bottom: 6px;
    }

    #modalListApply .la-filter .form-select,
    #modalListApply .la-filter .form-control {
        border-color: #e3e6f5;
    }

    #modalListApply .la-filter .form-select:focus,
    #modalListApply .la-filter .form-control:focus {
        box-shadow: 0 0 0 3px rgba(65, 84, 241, 0.12);
    }

    #modalListApply .la-daterange {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #modalListApply .la-daterange .input-group {
        flex: 1 1 0;
        min-width: 0;
    }

    #modalListApply .la-daterange .la-dash {
        color: #8a94b3;
        flex-shrink: 0;
    }

    #modalListApply .la-toolbar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin: 18px 0 12px;
    }

    #modalListApply .la-filter .btn,
    #modalListApply .la-toolbar .btn {
        padding: 8px 20px;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.2px;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    #modalListApply .la-filter .btn:hover,
    #modalListApply .la-toolbar .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }

    #modalListApply .la-filter .btn:active,
    #modalListApply .la-toolbar .btn:active {
        transform: translateY(0);
    }

    #modalListApply .la-filter .btn-primary {
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        box-shadow: 0 6px 16px rgba(65, 84, 241, 0.35);
    }

    #modalListApply .la-toolbar .btn-warning {
        background: linear-gradient(135deg, #f7b733, #fc4a1a);
        color: #fff;
        box-shadow: 0 6px 16px rgba(252, 74, 26, 0.3);
    }

    #modalListApply .la-toolbar .btn-danger {
        background: linear-gradient(135deg, #eb3349, #f45c43);
        box-shadow: 0 6px 16px rgba(235, 51, 73, 0.3);
    }

    #modalListApply .la-hint {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        color: #8a94b3;
    }

    #tb_list_applicant tbody tr {
        cursor: pointer;
        transition: background 0.12s ease;
    }

    #tb_list_applicant tbody tr.selected td {
        background-color: #e3e8ff !important;
        color: #012970 !important;
    }

    #modalWorkList .badge-number {
        border-radius: 50%;
        background: linear-gradient(135deg, #4154f1, #7b8cff) !important;
        width: 22px;
        height: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10.5px;
        padding: 0;
    }

    #modalWorkList .modal-footer,
    #modalListApply .modal-footer,
    #modalPro_Status .modal-footer {
        border: none;
        padding: 12px 24px 18px;
    }
</style>
<main id="main" class="main">
    <section class="section" id="wl-page">
        <div class="row">
            <div class="col-lg-12">
                <div class="card wl-card">
                    <div class="wl-header">
                        <div class="wl-header-left">
                            <div class="wl-icon"><i class="bi bi-briefcase-fill"></i></div>
                            <div>
                                <h5 class="card-title"><?= $worklist ?></h5>
                                <small><?= $worklist ?></small>
                            </div>
                        </div>
                        <div class="wl-stat-item">
                            <i class="bi bi-collection"></i>
                            <div>
                                <b id="wl-stat-total">0</b>
                                <span><?= $worklist ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="wl-filter-bar">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-auto">
                                <label class="form-label"><?= $department_name ?></label>
                                <select class="form-select js-example-basic-single rounded-pill" id="sr_DepName">
                                    <option selected=""></option>
                                    <?php
                                    $sqlDepName = "SELECT Dep_Name FROM CO_DepartmentCompany WHERE ISNULL(Dep_ID,'')<>'' GROUP BY Dep_Name";
                                    $rs_DepName = fetch_to_array($sqlDepName);
                                    foreach ($rs_DepName as $row) {
                                        echo '<option value="' . $row['Dep_Name'] . '">' . $row['Dep_Name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-12 col-md-auto">
                                <label class="form-label"><?= $user_date ?></label>
                                <div class="input-group w-100">
                                    <span class="input-group-text label-date rounded-start-pill"><?= $from ?></span>
                                    <input type="date" class="form-control rounded-end-pill" name="User_Date_From" id="User_Date_From">
                                </div>
                            </div>
                            <div class="col-12 col-md-auto">
                                <!-- <label class="form-label">&nbsp;</label> -->
                                <div class="input-group w-100">
                                    <span class="input-group-text label-date rounded-start-pill"><?= $to ?></span>
                                    <input type="date" class="form-control rounded-end-pill" name="User_Date_To" id="User_Date_To">
                                </div>
                            </div>
                            <div class="col-12 col-md-auto">
                                <label class="form-label"><?= $position_level ?></label>
                                <select class="form-select" id="sr_Position_Level" name="sr_Position_Level">
                                    <option selected=""></option>
                                    <option value="CN">Công nhân</option>
                                    <option value="VP">Văn phòng</option>
                                    <option value="QL">Quản lý</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-auto" style="align-self: flex-end;">
                                <label class="form-label">&nbsp;</label>
                                <div class="wl-check-chip">
                                    <input class="form-check-input" type="checkbox" id="sr_Expire" name="sr_Expire" value="1">
                                    <label class="form-check-label" for="sr_Expire"> <?= $expire ?>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-auto" style="align-self: flex-end;">
                                <label class="form-label">&nbsp;</label>
                                <div class="wl-check-chip">
                                    <input class="form-check-input" type="checkbox" id="sr_Hidden" name="sr_Hidden" value="1">
                                    <label class="form-check-label" for="sr_Hidden"> <?= $hidden_news ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-auto" style="align-self: flex-end;">
                                <label class="form-label">&nbsp;</label>
                                <div class="wl-check-chip">
                                    <input class="form-check-input" type="checkbox" id="sr_Show" name="sr_Show" value="1">
                                    <label class="form-check-label" for="sr_Show"> <?= $show_news ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-auto d-flex align-items-end">
                                <button type="submit" class="btn btn-sm btn-primary btn-search px-4" onclick="onQueryWorkList()">
                                    <i class="bi bi-search"></i> <?= $search ?>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="wl-toolbar">
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="addWorkList(1)"><i class="bi bi-plus-square"></i> <?= $add ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning"
                            onclick="editWorkList()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="removeWorkList()"><i class="bi bi-trash"></i> <?= $delete ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-success"
                            onclick="ExportExcel()"><i class="bi bi-file-earmark-excel-fill"></i> Excel
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="tb_work_list" class="table table-striped table-hover table-bordered zero-configuration" style="text-align: center;width: 100%;">
                            <thead>
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th><?= $department_name ?></th>
                                    <!-- <th>Job Description</th> -->
                                    <!-- <th>Job Description English</th> -->
                                    <!-- <th>Request Work</th> -->
                                    <!-- <th>Request Work English</th> -->
                                    <th><?= $degree ?></th>
                                    <!-- <th>Degree English</th> -->
                                    <th><?= $gender ?></th>
                                    <!-- <th>Gender English</th> -->
                                    <th><?= $age ?></th>
                                    <!-- <th>Age Range English</th> -->
                                    <th><?= $salary ?></th>
                                    <!-- <th>Salary English</th> -->
                                    <th><?= $number_of_vacancies ?></th>
                                    <th><?= $work_experience ?></th>
                                    <!-- <th>Work Experience English</th> -->
                                    <th><?= $working_time ?></th>
                                    <!-- <th>Working Time English</th> -->
                                    <th><?= $application_deadline ?></th>
                                    <th><?= $position_level ?></th>
                                    <th><?= $user_date ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade show" id="modalWorkList" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form id="create-worklist">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 g-3">
                        <input type="hidden" class="form-control" name="ID" id="ID">
                        <div class="col-md-3">
                            <label class="form-label"><?= $department_name ?> <span class="badge bg-primary badge-number">1</span> </label>
                            <select class="js-example-basic-single" id="DepID" name="DepID">
                                <option selected=" "></option>
                                <?php
                                $sqlDepName = "SELECT Dep_ID, Dep_Name  FROM CO_DepartmentCompany WHERE ISNULL(Dep_ID,'')<>'' GROUP BY Dep_ID, Dep_Name";
                                $rs_DepName = fetch_to_array($sqlDepName);
                                foreach ($rs_DepName as $row) {
                                    echo '<option value = "' . $row['Dep_ID'] . '"> ' . $row['Dep_Name'] . ' </option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $number_of_vacancies ?> <span class="badge bg-primary badge-number">2</span></label>
                            <input type="number" class="form-control" name="Number_Vacancies" id="Number_Vacancies" value="1" min="0" max="100">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><?= $degree ?> <span class="badge bg-primary badge-number">3A</span></label>
                            <select class="form-select" name="Degree" id="Degree">
                                <option value="Không yêu cầu">Không yêu cầu</option>
                                <option value="Đại học trở lên">Đại học trở lên</option>
                                <option value="Cao đẳng trở lên">Cao đẳng trở lên</option>
                                <option value="Trung cấp trở lên">Trung cấp trở lên</option>
                                <option value="Sơ cấp trở lên">Sơ cấp trở lên</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $degreeEN ?> <span class="badge bg-primary badge-number">3B</span></label>
                            <select class="form-select" name="DegreeEN" id="DegreeEN">
                                <option value="No requirement">No requirement</option>
                                <option value="University degree or higher">University degree or higher</option>
                                <option value="College degree or higher">College degree or higher</option>
                                <option value="Intermediate diploma or higher">Intermediate diploma or higher</option>
                                <option value="Elementary certificate or higher">Elementary certificate or higher</option>
                            </select>
                        </div>
                        <hr style="border: none; border-top: 2px dashed rgba(0, 0, 0, 0.3); margin: 10px 0px 0px 0px;" />
                        <div class="col-md-3">
                            <label class="form-label"><?= $gender ?> <span class="badge bg-primary badge-number">4A</span></label>
                            <!-- <input type="text" class="form-control" name="Gender" id="Gender"> -->
                            <select class="form-select" name="Gender" id="Gender">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                                <option value="Không yêu cầu">Không yêu cầu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $genderEN ?> <span class="badge bg-primary badge-number">4B</span></label>
                            <!-- <input type="text" class="form-control" name="GenderEN" id="GenderEN"> -->
                            <select class="form-select" name="GenderEN" id="GenderEN">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="No requirement">No requirement</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><?= $age ?> <span class="badge bg-primary badge-number">5A</span></label>
                            <input type="text" class="form-control" name="Age_Range" id="Age_Range">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $ageEN ?> <span class="badge bg-primary badge-number">5B</span></label>
                            <input type="text" class="form-control" name="Age_RangeEN" id="Age_RangeEN">
                        </div>
                        <hr style="border: none; border-top: 2px dashed rgba(41, 35, 35, 0.3); margin: 10px 0px 0px 0px;  " />
                        <div class="col-md-3">
                            <label class="form-label"><?= $salary ?> <span class="badge bg-primary badge-number">6A</span></label>
                            <input type="text" class="form-control" name="Salary" id="Salary" placeholder="Từ 6 - 8 triệu">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $salaryEN ?> <span class="badge bg-primary badge-number">6B</span></label>
                            <input type="text" class="form-control" name="SalaryEN" id="SalaryEN" placeholder="From 6 - 8 millions">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $work_experience ?> <span class="badge bg-primary badge-number">7A</span></label>
                            <select class="form-select" aria-label="Default select example" name="Work_Experience" id="Work_Experience">
                                <option value="Không cần">Không cần</option>
                                <option value="Dưới 1 năm">Dưới 1 năm</option>
                                <option value="Từ 1 năm đến dưới 2 năm">Từ 1 năm đến dưới 2 năm</option>
                                <option value="Từ 2 năm đến dưới 3 năm">Từ 2 năm đến dưới 3 năm</option>
                                <option value="Từ 3 năm đến 5 năm">Từ 3 năm đến 5 năm</option>
                                <option value="Trên 5 năm">Trên 5 năm</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $work_experienceEN ?> <span class="badge bg-primary badge-number">7B</span></label>
                            <!-- <input type="text" class="form-control" name="Work_ExperienceEN" id="Work_ExperienceEN"> -->
                            <select class="form-select" aria-label="Default select example" name="Work_ExperienceEN" id="Work_ExperienceEN">
                                <option value="Not required">Not required</option>
                                <option value="Less than 1 year">Less than 1 year</option>
                                <option value="From 1 year to less than 2 years">From 1 year to less than 2 years</option>
                                <option value="From 2 years to less than 3 years">From 2 years to less than 3 years</option>
                                <option value="From 3 years to 5 years">From 3 years to 5 years</option>
                                <option value="More than 5 years">More than 5 years</option>
                            </select>
                        </div>
                        <hr style="border: none; border-top: 2px dashed rgba(0, 0, 0, 0.3); margin: 10px 0px 0px 0px;  " />
                        <div class="col-md-3">
                            <label class="form-label"><?= $working_time ?> <span class="badge bg-primary badge-number">8A</span></label>
                            <!-- <input type="text" class="form-control" name="Working_Time" id="Working_Time"> -->
                            <select class="form-select" name="Working_Time" id="Working_Time">
                                <option value="Giờ hành chính">Giờ hành chính</option>
                                <option value="Theo ca">Theo ca</option>
                                <option value="Xoay ca">Xoay ca</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $working_timeEN ?> <span class="badge bg-primary badge-number">8B</span></label>
                            <!-- <input type="text" class="form-control" name="Working_TimeEN" id="Working_TimeEN"> -->
                            <select class="form-select" name="Working_TimeEN" id="Working_TimeEN">
                                <option value="Office hours">Office hours</option>
                                <option value="Shift work">Shift work</option>
                                <option value="Rotating shifts">Rotating shifts</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $application_deadline ?> <span class="badge bg-primary badge-number">9</span></label>
                            <input type="date" class="form-control" name="Application_Deadline" id="Application_Deadline">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $position_level ?> <span class="badge bg-primary badge-number">10</span></label>
                            <select class="form-select" name="Position_Level" id="Position_Level">
                                <!-- <option selected="">&nbsp;</option> -->
                                <option value="CN" selected>Công nhân</option>
                                <option value="VP">Nhân viên văn phòng</option>
                                <option value="QL">Quản lý</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="align-self: anchor-center;">
                            <label class="form-label">&nbsp;</label>
                            <div class="wl-check-chip">
                                <input class="form-check-input" type="checkbox" id="Job_Hot" name="Job_Hot" value="1">
                                <label class="form-check-label" for="Job_Hot"> <?= $job_hot ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3" style="align-self: anchor-center;">
                            <label class="form-label">&nbsp;</label>
                            <div class="wl-check-chip">
                                <input class="form-check-input" type="checkbox" id="STATUS" name="STATUS" value="1">
                                <label class="form-check-label" for="STATUS"> <?= $status_hide ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr style="border: none; border-top: 2px dashed rgba(0, 0, 0, 0.3); margin: 10px 0px 10px 0px;  " />
                    <div class="row mb-3 g-3">
                        <div class="col-6">
                            <label class="form-label"><?= $job_description ?> <span class="badge bg-primary badge-number">11</span></label>
                            <div>
                                <div class="quill-editor-default" id="Job_Description">
                                </div>
                                <textarea name="Job_Description_input" id="Job_Description_input" hidden></textarea>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <label class="form-label"><?= $job_descriptionEN ?></label>
                            <div>
                                <div class="quill-editor-default" id="Job_DescriptionEN">
                                </div>
                                <textarea name="Job_DescriptionEN_input" id="Job_DescriptionEN_input" hidden></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label"><?= $request_work ?> <span class="badge bg-primary badge-number">12</span></label>
                            <div>
                                <div class="quill-editor-default" id="Request_Work">
                                </div>
                                <textarea name="Request_Work_input" id="Request_Work_input" hidden></textarea>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <label class="form-label"><?= $request_workEN ?></label>
                            <div>
                                <div class="quill-editor-default" id="Request_WorkEN">
                                </div>
                                <textarea name="Request_WorkEN_input" id="Request_WorkEN_input" hidden></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label"><?= $compensation_benefits ?> <span class="badge bg-primary badge-number">13</span></label>
                            <div>
                                <div class="quill-editor-default" id="Compensation_Benefits">
                                </div>
                                <textarea name="Compensation_Benefits_input" id="Compensation_Benefits_input" hidden></textarea>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <label class="form-label"><?= $compensation_benefitsEN ?></label>
                            <div>
                                <div class="quill-editor-default" id="Compensation_BenefitsEN">
                                </div>
                                <textarea name="Compensation_BenefitsEN_input" id="Compensation_BenefitsEN_input" hidden></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><?= $close ?></button>
                    <button type="submit" class="btn btn-sm btn-primary" id="saveWorkList" check="1"><i class="bi bi-check2"></i> <?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal List Applicant -->
<div class="modal fade" id="modalListApply" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="la-header-left">
                    <div class="la-icon"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <h5 class="modal-title" id="modal_title_ListApply"></h5>
                        <small class="la-subtitle"><?= $worklist ?></small>
                    </div>
                </div>
                <div class="la-header-right">
                    <span class="la-count">
                        <i class="bi bi-person-lines-fill"></i> <b id="la-stat-total">0</b>
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="la-filter">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-lg-4">
                            <label class="form-label" for="SProcessing_Status"><?= $progress_status ?></label>
                            <select class="form-select" id="SProcessing_Status" name="SProcessing_Status">
                                <option selected=""></option>
                                <option value="Tiếp nhận">Tiếp nhận</option>
                                <option value="Không phù hợp">Không phù hợp</option>
                                <option value="Đã liên hệ">Đã liên hệ</option>
                                <option value="Không liên lạc được">Không liên lạc được</option>
                                <option value="Phỏng vấn">Phỏng vấn</option>
                                <option value="Không đến phỏng vấn">Không đến phỏng vấn</option>
                                <option value="Nhận việc">Nhận việc</option>
                                <option value="Từ chối nhận việc">Từ chối nhận việc</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-label"><?= $date_apply ?></label>
                            <div class="la-daterange">
                                <div class="input-group">
                                    <span class="input-group-text rounded-start-pill"><?= $from ?></span>
                                    <input type="date" class="form-control rounded-end-pill" name="Upload_Date_From" id="Upload_Date_From">
                                </div>
                                <span class="la-dash">~</span>
                                <div class="input-group">
                                    <span class="input-group-text rounded-start-pill"><?= $to ?></span>
                                    <input type="date" class="form-control rounded-end-pill" name="Upload_Date_To" id="Upload_Date_To">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <button type="button" class="btn btn-sm btn-primary w-100" onclick="ShowListApply()">
                                <i class="bi bi-search"></i> <?= $search ?>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="la-toolbar">
                    <button type="button" class="btn btn-sm btn-warning"
                        onclick="editListA()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="removeListA()"><i class="bi bi-trash"></i> <?= $delete ?>
                    </button>
                    <span class="la-hint"><i class="bi bi-info-circle"></i> <?= $select_row_hint ?></span>
                </div>
                <div class="table-responsive">
                    <table id="tb_list_applicant" class="table table-striped table-hover table-bordered zero-configuration" style="text-align: center;width: 100%;">
                        <thead>
                            <tr>
                                <th><?= $fullName ?></th>
                                <th><?= $phone ?></th>
                                <th><?= $birthday ?></th>
                                <th>Email</th>
                                <th><?= $progress_status ?></th>
                                <th><?= $file_name ?></th>
                                <th><?= $date_apply ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><?= $close ?></button>
            </div>
        </div>
    </div>
</div>

<!-- modal Processing Status -->
<div class="modal fade show" id="modalPro_Status" tabindex="-1">
    <div class="modal-dialog" style="margin-top: 100px;">
        <div class="modal-content">
            <form id="create-processstatus" enctype="multipart/form-data" role="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-status"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="ID_Status" id="ID_Status">
                    <input type="hidden" class="form-control" name="ID_Dep" id="ID_Dep">

                    <div class="col-md-12">
                        <label class="form-label"><?= $progress_status ?></label>
                        <select class="form-select" aria-label="Default select example" id="Processing_Status" name="Processing_Status">
                            <option selected=""></option>
                            <option value="Tiếp nhận">Tiếp nhận</option>
                            <option value="Không phù hợp">Không phù hợp</option>
                            <option value="Đã liên hệ">Đã liên hệ</option>
                            <option value="Không liên lạc được">Không liên lạc được</option>
                            <option value="Phỏng vấn">Phỏng vấn</option>
                            <option value="Không đến phỏng vấn">Không đến phỏng vấn</option>
                            <option value="Nhận việc">Nhận việc</option>
                            <option value="Từ chối nhận việc">Từ chối nhận việc</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><?= $close ?></button>
                    <button type="submit" class="btn btn-sm btn-primary" id="saveStatus"><i class="bi bi-check2"></i> <?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/work_list.js"></script>