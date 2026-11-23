<?php
require('../sidebar.php');
?>
<style>
    @keyframes umFadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #um-page .um-card {

        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(21, 33, 92, 0.08);
        overflow: hidden;
        animation: umFadeInUp 0.35s ease both;
        transition: box-shadow 0.2s ease;
    }

    #um-page .um-card:hover {
        box-shadow: 0 10px 28px rgba(21, 33, 92, 0.12);
    }

    #um-page .um-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 22px 24px 18px;
        border-bottom: 1px solid #eef1fa;
        flex-wrap: wrap;
    }

    #um-page .um-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    #um-page .um-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    #um-page .um-stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 12px;
        background: #f8f9ff;
        border: 1px solid #eef1fa;
        min-width: 110px;
    }

    #um-page .um-stat-item i {
        font-size: 18px;
    }

    #um-page .um-stat-item.stat-total i {
        color: #4154f1;
    }

    #um-page .um-stat-item.stat-admin i {
        color: #e6357b;
    }

    #um-page .um-stat-item.stat-hr i {
        color: #12b76a;
    }

    #um-page .um-stat-item b {
        display: block;
        font-size: 17px;
        color: #012970;
        line-height: 1;
    }

    #um-page .um-stat-item span {
        display: block;
        font-size: 11.5px;
        color: #8a94b3;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    #um-page .um-header .um-icon {
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

    #um-page .um-header h5 {
        margin: 0;
        font-weight: 700;
        color: #012970;
    }

    #um-page .um-header small {
        color: #8a94b3;
    }

    #um-page .um-filter-bar {
        padding: 20px 24px;
        background: #f8f9ff;
        border-bottom: 1px solid #eef1fa;
    }

    #um-page .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #4b5580;
        margin-bottom: 6px;
    }

    #um-page .input-group-text {
        background: #fff;
        border-right: none;
        color: #6a71a8;
    }

    #um-page .input-group .form-control {
        border-left: none;
    }

    #um-page .input-group:focus-within {
        box-shadow: 0 0 0 3px rgba(65, 84, 241, 0.12);
        border-radius: 50px;
    }

    #um-page .form-control,
    #um-page .input-group-text {
        border-radius: 50px !important;
        border-color: #e3e6f5;
    }

    #um-page .input-group .form-control {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    #um-page .input-group .input-group-text {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    #um-page .btn-search,
    #um-page .um-toolbar .btn,
    #modalUserManagement .modal-footer .btn {

        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.2px;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    #um-page .btn-search {
        padding: 10px 26px;
    }

    #um-page .um-toolbar {
        padding: 16px 24px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    #um-page .um-toolbar .btn {
        padding: 8px 20px;
        font-size: 14px;
    }

    #um-page .btn-search:hover,
    #um-page .um-toolbar .btn:hover,
    #modalUserManagement .modal-footer .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }

    #um-page .btn-search:active,
    #um-page .um-toolbar .btn:active,
    #modalUserManagement .modal-footer .btn:active {
        transform: translateY(0);
    }

    #um-page .btn-search,
    #um-page .um-toolbar .btn-primary,
    #modalUserManagement .modal-footer .btn-primary {
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        box-shadow: 0 6px 16px rgba(65, 84, 241, 0.35);
    }

    #um-page .btn-search:hover,
    #um-page .um-toolbar .btn-primary:hover,
    #modalUserManagement .modal-footer .btn-primary:hover {
        box-shadow: 0 10px 20px rgba(65, 84, 241, 0.42);
    }

    #um-page .um-toolbar .btn-warning {
        background: linear-gradient(135deg, #f7b733, #fc4a1a);
        color: #fff;
        box-shadow: 0 6px 16px rgba(252, 74, 26, 0.3);
    }

    #um-page .um-toolbar .btn-warning:hover {
        box-shadow: 0 10px 20px rgba(252, 74, 26, 0.4);
    }

    #um-page .um-toolbar .btn-danger {
        background: linear-gradient(135deg, #eb3349, #f45c43);
        box-shadow: 0 6px 16px rgba(235, 51, 73, 0.3);
    }

    #um-page .um-toolbar .btn-danger:hover {
        box-shadow: 0 10px 20px rgba(235, 51, 73, 0.4);
    }

    #modalUserManagement .modal-footer .btn-secondary {
        background: linear-gradient(135deg, #7b8794, #99a3b0);
        box-shadow: 0 6px 16px rgba(90, 100, 120, 0.25);
    }

    #modalUserManagement .modal-footer .btn-secondary:hover {
        box-shadow: 0 10px 20px rgba(90, 100, 120, 0.32);
    }

    #um-page .table-responsive {
        padding: 0 24px 24px;
    }

    #tb_user_management {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    #tb_user_management thead th {
        background: linear-gradient(135deg, #2c3ea1, #4154f1) !important;
        color: #fff !important;
        border: none !important;
        text-transform: uppercase;
        font-size: 12.5px;
        letter-spacing: 0.4px;
        padding: 14px 10px !important;
    }

    #tb_user_management tbody td {
        padding: 12px 10px !important;
        vertical-align: middle;
        border-color: #eef1fa !important;
    }

    #tb_user_management tbody tr {
        cursor: pointer;
        transition: background 0.12s ease;
    }

    #tb_user_management .um-user-cell {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    #tb_user_management .um-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    #tb_user_management .um-badge {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    #tb_user_management .um-badge-admin {
        background: rgba(230, 53, 123, 0.12);
        color: #e6357b;
    }

    #tb_user_management .um-badge-hr {
        background: rgba(18, 183, 106, 0.12);
        color: #12b76a;
    }

    #tb_user_management thead th:empty {
        min-width: 0;
    }

    #modalUserManagement .modal-content {

        border-radius: 16px;
        overflow: hidden;
    }

    #modalUserManagement .modal-header {
        background: linear-gradient(135deg, #4154f1, #6a7bfb);
        color: #fff;

        padding: 18px 24px;
    }

    #modalUserManagement .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    #modalUserManagement .modal-body {
        padding: 26px 24px;
    }

    #modalUserManagement .form-label {
        font-weight: 600;
        color: #4b5580;
    }

    #modalUserManagement .form-control,
    #modalUserManagement .form-select,
    #modalUserManagement .input-group-text {
        border-radius: 10px;
        border-color: #e3e6f5;
    }

    #modalUserManagement .input-group .form-control {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    #modalUserManagement .input-group .input-group-text {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        background: #f4f6ff;
        color: #4154f1;
    }

    #modalUserManagement .modal-footer {

        padding: 16px 24px 22px;
    }

    #modalUserManagement .modal-footer .btn {
        border-radius: 50px;
        padding: 8px 22px;
        font-weight: 600;
    }
</style>
<main id="main" class="main">
    <section class="section" id="um-page">
        <div class="row">
            <div class="col-lg-12">
                <div class="card um-card">
                    <div class="um-header">
                        <div class="um-header-left">
                            <div class="um-icon"><i class="bi bi-people-fill"></i></div>
                            <div>
                                <h5 class="card-title"><?= $usermanagement ?></h5>
                                <small><?= $usermanagement ?></small>
                            </div>
                        </div>
                        <div class="um-stats">
                            <div class="um-stat-item stat-total">
                                <i class="bi bi-people"></i>
                                <div>
                                    <b id="um-stat-total">0</b>
                                    <span>Total</span>
                                </div>
                            </div>
                            <div class="um-stat-item stat-admin">
                                <i class="bi bi-shield-lock"></i>
                                <div>
                                    <b id="um-stat-admin">0</b>
                                    <span>Admin</span>
                                </div>
                            </div>
                            <div class="um-stat-item stat-hr">
                                <i class="bi bi-person-badge"></i>
                                <div>
                                    <b id="um-stat-hr">0</b>
                                    <span>HR</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="um-filter-bar">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-2">
                                <label class="form-label">ID User</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="id_user" id="id_user">
                                </div>
                            </div>
                            <div class="col-12 col-md-auto">
                                <label class="form-label"><?= $user_date ?></label>
                                <div class="input-group">
                                    <span class="input-group-text"><?= $from ?></span>
                                    <input type="date" class="form-control" name="User_Date_From" id="User_Date_From">
                                </div>
                            </div>
                            <div class="col-12 col-md-auto">
                                <label class="form-label d-none d-md-block">&nbsp;</label>
                                <div class="input-group">
                                    <span class="input-group-text"><?= $to ?></span>
                                    <input type="date" class="form-control" name="User_Date_To" id="User_Date_To">
                                </div>
                            </div>
                            <div class="col-12 col-md-auto">
                                <button type="submit" class="btn btn-primary btn-search w-100" onclick="onQueryUser()">
                                    <i class="bi bi-search"></i> <?= $search ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="um-toolbar">
                        <button type="button" class="btn btn-primary"
                            onclick="addUser(1)"><i class="bi bi-plus-square"></i> <?= $add ?>
                        </button>
                        <button type="button" class="btn btn-warning"
                            onclick="editUser()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                        </button>
                        <button type="button" class="btn btn-danger"
                            onclick="removeUser()"><i class="bi bi-trash"></i> <?= $delete ?>
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="tb_user_management" class="table table-striped table-hover table-bordered zero-configuration" style="text-align: center;width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">ID User</th>
                                    <th style="text-align: center;">User Name</th>
                                    <th style="text-align: center;">Permission</th>
                                    <th style="text-align: center;">User ID</th>
                                    <th style="text-align: center;">User Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade show" id="modalUserManagement" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="create-user-management" enctype="multipart/form-data" role="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">ID User <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="IDUser" id="IDUser">
                            </div>
                            <input name="IDHidden" id="IDHidden" hidden>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Password <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" name="Password" id="Password">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">User Name <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" class="form-control" name="UserName" id="UserName">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Permission <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                <select name="Permission" id="Permission" class="form-select">
                                    <option selected="">&nbsp;</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="HR">HR</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $close ?></button>
                    <button type="submit" class="btn btn-primary" id="saveUserM" check="1"><i class="bi bi-check2"></i> <?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/user_management.js"></script>