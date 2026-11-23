<?php
require('../sidebar.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
?>
<style>
    @keyframes depFadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #dep-page .dep-card {
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(21, 33, 92, 0.08);
        overflow: hidden;
        animation: depFadeInUp 0.35s ease both;
        transition: box-shadow 0.2s ease;
    }

    #dep-page .dep-card:hover {
        box-shadow: 0 10px 28px rgba(21, 33, 92, 0.12);
    }

    #dep-page .dep-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 22px 24px 18px;
        border-bottom: 1px solid #eef1fa;
        flex-wrap: wrap;
    }

    #dep-page .dep-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    #dep-page .dep-icon {
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

    #dep-page .dep-header h5 {
        margin: 0;
        font-weight: 700;
        color: #012970;
    }

    #dep-page .dep-header small {
        color: #8a94b3;
    }

    #dep-page .dep-stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 12px;
        background: #f8f9ff;
        border: 1px solid #eef1fa;
        min-width: 130px;
    }

    #dep-page .dep-stat-item i {
        font-size: 18px;
        color: #4154f1;
    }

    #dep-page .dep-stat-item b {
        display: block;
        font-size: 17px;
        color: #012970;
        line-height: 1;
    }

    #dep-page .dep-stat-item span {
        display: block;
        font-size: 11.5px;
        color: #8a94b3;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    #dep-page .dep-filter-bar {
        padding: 20px 24px;
        background: #f8f9ff;
        border-bottom: 1px solid #eef1fa;
    }

    #dep-page .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #4b5580;
        margin-bottom: 6px;
    }

    #dep-page .dep-filter-bar .form-control {
        border-radius: 50px !important;
        border-color: #e3e6f5;
    }

    #dep-page .dep-filter-bar .form-control:focus {
        box-shadow: 0 0 0 3px rgba(65, 84, 241, 0.12);
    }

    #dep-page .btn-search,
    #dep-page .dep-toolbar .btn,
    #modalDepartment .modal-footer .btn {
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.2px;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    #dep-page .btn-search {
        padding: 10px 26px;
    }

    #dep-page .dep-toolbar {
        padding: 16px 24px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    #dep-page .dep-toolbar .btn {
        padding: 8px 20px;
        font-size: 14px;
    }

    #dep-page .btn-search:hover,
    #dep-page .dep-toolbar .btn:hover,
    #modalDepartment .modal-footer .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }

    #dep-page .btn-search:active,
    #dep-page .dep-toolbar .btn:active,
    #modalDepartment .modal-footer .btn:active {
        transform: translateY(0);
    }

    #dep-page .btn-search,
    #dep-page .dep-toolbar .btn-primary,
    #modalDepartment .modal-footer .btn-primary {
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        box-shadow: 0 6px 16px rgba(65, 84, 241, 0.35);
    }

    #dep-page .btn-search:hover,
    #dep-page .dep-toolbar .btn-primary:hover,
    #modalDepartment .modal-footer .btn-primary:hover {
        box-shadow: 0 10px 20px rgba(65, 84, 241, 0.42);
    }

    #dep-page .dep-toolbar .btn-warning {
        background: linear-gradient(135deg, #f7b733, #fc4a1a);
        color: #fff;
        box-shadow: 0 6px 16px rgba(252, 74, 26, 0.3);
    }

    #dep-page .dep-toolbar .btn-warning:hover {
        box-shadow: 0 10px 20px rgba(252, 74, 26, 0.4);
    }

    #dep-page .dep-toolbar .btn-danger {
        background: linear-gradient(135deg, #eb3349, #f45c43);
        box-shadow: 0 6px 16px rgba(235, 51, 73, 0.3);
    }

    #dep-page .dep-toolbar .btn-danger:hover {
        box-shadow: 0 10px 20px rgba(235, 51, 73, 0.4);
    }

    #modalDepartment .modal-footer .btn-secondary {
        background: linear-gradient(135deg, #7b8794, #99a3b0);
        box-shadow: 0 6px 16px rgba(90, 100, 120, 0.25);
    }

    #modalDepartment .modal-footer .btn-secondary:hover {
        box-shadow: 0 10px 20px rgba(90, 100, 120, 0.32);
    }

    #dep-page .table-responsive {
        padding: 0 24px 24px;
    }

    #tb_department {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    #tb_department thead th {
        background: linear-gradient(135deg, #2c3ea1, #4154f1) !important;
        color: #fff !important;
        border: none !important;
        text-transform: uppercase;
        font-size: 12.5px;
        letter-spacing: 0.4px;
        padding: 14px 10px !important;
    }

    #tb_department thead th:first-child {
        width: 60px;
    }

    #tb_department tbody td {
        padding: 12px 10px !important;
        vertical-align: middle;
        border-color: #eef1fa !important;
    }

    #tb_department tbody tr {
        cursor: pointer;
        transition: background 0.12s ease;
    }

    #modalDepartment .modal-content {
        border-radius: 16px;
        overflow: hidden;
    }

    #modalDepartment .modal-header {
        background: linear-gradient(135deg, #4154f1, #6a7bfb);
        color: #fff;
        padding: 10px 22px;
    }

    #modalDepartment .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    #modalDepartment .modal-body {
        padding: 15px;
    }

    #modalDepartment .form-label {
        font-weight: 600;
        color: #4b5580;
    }

    #modalDepartment .form-control {
        border-radius: 10px;
        border-color: #e3e6f5;
    }

    #modalDepartment .modal-footer {
        padding: 10px;
    }
</style>
<main id="main" class="main">
    <section class="section" id="dep-page">
        <div class="row">
            <div class="col-lg-12">
                <div class="card dep-card">
                    <div class="dep-header">
                        <div class="dep-header-left">
                            <div class="dep-icon"><i class="bi bi-diagram-3-fill"></i></div>
                            <div>
                                <h5 class="card-title"><?= $department ?></h5>
                                <small><?= $department ?></small>
                            </div>
                        </div>
                        <div class="dep-stat-item">
                            <i class="bi bi-building"></i>
                            <div>
                                <b id="dep-stat-total">0</b>
                                <span><?= $department ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="dep-filter-bar">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label"><?= $department_name ?></label>
                                <input type="text" class="form-control" id="sr_DepName">
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label"><?= $department_nameEN ?></label>
                                <input type="text" class="form-control" id="sr_DepNameEN">
                            </div>

                            <div class="col-12 col-md-6 col-lg-1">
                                <button type="submit" class="btn btn-sm btn-primary btn-search px-4" onclick=" onQueryDep()">
                                    <i class="bi bi-search"></i> <?= $search ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="dep-toolbar">
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="addDep(1)"><i class="bi bi-plus-square"></i> <?= $add ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning"
                            onclick="editDep()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="removeDep()"><i class="bi bi-trash"></i> <?= $delete ?>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="tb_department" class="table table-striped table-hover table-bordered zero-configuration" style="text-align: center;width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;"></th>
                                    <th style="text-align: center;"><?= $department_name ?></th>
                                    <th style="text-align: center;"><?= $department_nameEN ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade" id="modalDepartment" tabindex="-1">
    <div class="modal-dialog modal-xs modal-dialog-centered">
        <div class="modal-content">
            <form id="create-department" enctype="multipart/form-data" role="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <input type="hidden" class="form-control " name="DepID" id="DepID">
                        <div class="col-12">
                            <label class="form-label"><?= $department_name ?></label>
                            <input type="text" class="form-control" name="DepName" id="DepName">
                        </div>
                        <div class="col-12">
                            <label class="form-label"><?= $department_nameEN ?></label>
                            <input type="text" class="form-control" name="DepNameEN" id="DepNameEN">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-5 px-4" data-bs-dismiss="modal"><?= $close ?></button>
                    <button type="submit" class="btn btn-sm btn-primary rounded-5 px-4" id="saveDept" check="1"><i class="bi bi-check2"></i> <?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Extra Large Modal-->
<script src="../js/department.js"></script>