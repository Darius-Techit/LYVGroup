<?php
require('../sidebar.php');
?>
<style>
    @keyframes infoFadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #info-page .info-card {

        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(21, 33, 92, 0.08);
        overflow: hidden;
        animation: infoFadeInUp 0.35s ease both;
        transition: box-shadow 0.2s ease;
    }

    #info-page .info-card:hover {
        box-shadow: 0 10px 28px rgba(21, 33, 92, 0.12);
    }

    #info-page .info-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 22px 24px 18px;
        border-bottom: 1px solid #eef1fa;
        flex-wrap: wrap;
    }

    #info-page .info-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    #info-page .info-icon {
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

    #info-page .info-header h5 {
        margin: 0;
        font-weight: 700;
        color: #012970;
    }

    #info-page .info-header small {
        color: #8a94b3;
    }

    #info-page .info-stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 12px;
        background: #f8f9ff;
        border: 1px solid #eef1fa;
        min-width: 130px;
    }

    #info-page .info-stat-item i {
        font-size: 18px;
        color: #4154f1;
    }

    #info-page .info-stat-item b {
        display: block;
        font-size: 17px;
        color: #012970;
        line-height: 1;
    }

    #info-page .info-stat-item span {
        display: block;
        font-size: 11.5px;
        color: #8a94b3;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    #info-page .info-filter-bar {
        padding: 20px 24px;
        background: #f8f9ff;
        border-bottom: 1px solid #eef1fa;
    }

    #info-page .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #4b5580;
        margin-bottom: 6px;
    }

    #info-page .info-filter-bar .input-group-text {
        background: #fff;
        color: #6a71a8;
        border-color: #e3e6f5;
    }

    #info-page .info-filter-bar .form-control {
        border-color: #e3e6f5;
    }

    #info-page .info-filter-bar .form-control:focus {
        box-shadow: 0 0 0 3px rgba(65, 84, 241, 0.12);
    }

    #info-page .btn-search,
    #info-page .info-toolbar .btn,
    #modalInfo .modal-footer .btn {

        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.2px;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    #info-page .btn-search {
        padding: 10px 26px;
    }

    #info-page .info-toolbar {
        padding: 16px 24px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    #info-page .info-toolbar .btn {
        padding: 8px 20px;
        font-size: 14px;
    }

    #info-page .btn-search:hover,
    #info-page .info-toolbar .btn:hover,
    #modalInfo .modal-footer .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }

    #info-page .btn-search:active,
    #info-page .info-toolbar .btn:active,
    #modalInfo .modal-footer .btn:active {
        transform: translateY(0);
    }

    #info-page .btn-search,
    #info-page .info-toolbar .btn-primary,
    #modalInfo .modal-footer .btn-primary {
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        box-shadow: 0 6px 16px rgba(65, 84, 241, 0.35);
    }

    #info-page .btn-search:hover,
    #info-page .info-toolbar .btn-primary:hover,
    #modalInfo .modal-footer .btn-primary:hover {
        box-shadow: 0 10px 20px rgba(65, 84, 241, 0.42);
    }

    #info-page .info-toolbar .btn-warning {
        background: linear-gradient(135deg, #f1b949, #fc4a1a);
        color: #fff;
        box-shadow: 0 6px 16px rgba(252, 74, 26, 0.3);
    }

    #info-page .info-toolbar .btn-warning:hover {
        box-shadow: 0 10px 20px rgba(252, 74, 26, 0.4);
    }

    #info-page .info-toolbar .btn-danger {
        background: linear-gradient(135deg, #eb3349, #f45c43);
        box-shadow: 0 6px 16px rgba(235, 51, 73, 0.3);
    }

    #info-page .info-toolbar .btn-danger:hover {
        box-shadow: 0 10px 20px rgba(235, 51, 73, 0.4);
    }

    #modalInfo .modal-footer .btn-secondary {
        background: linear-gradient(135deg, #7b8794, #99a3b0);
        box-shadow: 0 6px 16px rgba(90, 100, 120, 0.25);
    }

    #modalInfo .modal-footer .btn-secondary:hover {
        box-shadow: 0 10px 20px rgba(90, 100, 120, 0.32);
    }

    #info-page .table-responsive {
        padding: 0 24px 24px;
    }

    #tb_info_company {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    #tb_info_company thead th {
        background: linear-gradient(135deg, #2c3ea1, #4154f1) !important;
        color: #fff !important;
        border: none !important;
        text-transform: uppercase;
        font-size: 12.5px;
        letter-spacing: 0.4px;
        padding: 14px 10px !important;
    }

    #tb_info_company tbody td {
        padding: 14px !important;
        vertical-align: middle;
        border-color: #eef1fa !important;
    }

    #tb_info_company tbody tr {
        cursor: pointer;
        transition: background 0.12s ease;
    }

    #tb_info_company .info-img-thumb {
        width: 160px;
        height: 110px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(21, 33, 92, 0.15);
        transition: transform 0.15s ease;
    }

    #tb_info_company .info-img-thumb:hover {
        transform: scale(1.04);
    }

    #modalInfo .modal-content {

        border-radius: 16px;
        overflow: hidden;
    }

    #modalInfo .modal-header {
        background: linear-gradient(135deg, #4154f1, #6a7bfb);
        color: #fff;

        padding: 10px 22px;
    }

    #modalInfo .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    #modalInfo .modal-body {
        padding: 15px;
    }

    #modalInfo .form-label-modal {
        font-weight: 600;
        color: #4b5580;
        display: block;
    }

    #modalInfo label[for="image-info1"] {
        border: 2px dashed #d7dcf5 !important;
        border-radius: 14px;
        background: #f8f9ff;
        transition: border-color 0.15s ease, background 0.15s ease;
    }

    #modalInfo label[for="image-info1"]:hover {
        border-color: #4154f1 !important;
        background: #f0f2ff;
    }

    #modalInfo #image-icon-info1 {
        color: #8a94b3;
    }

    #modalInfo #preview-img-info1 {
        border-radius: 14px !important;
    }

    #modalInfo #close-image-info1 {
        background: #fff;
        border-radius: 50%;
        line-height: 0;
        top: -8px !important;
        right: -8px !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    #modalInfo .modal-footer {

        padding: 10px;
    }

    #modalInfo .modal-footer .btn {
        font-weight: 600;
    }
</style>
<main id="main" class="main">
    <section class="section" id="info-page">
        <div class="row">
            <div class="col-lg-12">
                <div class="card info-card">
                    <div class="info-header">
                        <div class="info-header-left">
                            <div class="info-icon"><i class="bi bi-images"></i></div>
                            <div>
                                <h5 class="card-title"><?= $information ?></h5>
                                <small><?= $information ?></small>
                            </div>
                        </div>
                        <div class="info-stat-item">
                            <i class="bi bi-collection"></i>
                            <div>
                                <b id="info-stat-total">0</b>
                                <span><?= $panel ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="info-filter-bar">
                        <div class="row g-3 align-items-end">
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
                                <button type="submit" class="btn btn-sm btn-primary btn-search px-4" onclick="onQueryInfo()">
                                    <i class="bi bi-search"></i> <?= $search ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="info-toolbar">
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="addInfo(1)"><i class="bi bi-plus-square"></i> <?= $add ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning"
                            onclick="editInfo()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="removeInfo()"><i class="bi bi-trash"></i> <?= $delete ?>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="tb_info_company" class="table table-striped table-hover table-bordered zero-configuration" style="text-align: center;width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;"><?= $panel ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Modal insert/update -->
<div class="modal fade" id="modalInfo" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="create-info" enctype="multipart/form-data" role="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" name="ID_Info_Image" id="ID_Info_Image">
                        <div class="col-md-12">
                            <div>
                                <label class='form-label-modal mt-3'><?= $information_picture ?></label>
                                <div class='col-12 col-sm-6 col-md-4 col-lg-4 position-relative'
                                    style='width: 300px;'>
                                    <label for='image-info1'
                                        class='border d-flex justify-content-center align-items-center'
                                        style='width: 100%; height: 200px; border-style: dotted;'>
                                        <i id='image-icon-info1' class='bi bi-images fs-2 opacity-50'></i>
                                        <img src='' id='preview-img-info1' class='border'
                                            style='width: 100%; height: 200px; display:none; object-fit: cover;' alt=''>
                                    </label>
                                    <span id='close-image-info1' class='close-image position-absolute top-0'
                                        style='right: 5px; display:none; outline: none; cursor: pointer;'>
                                        <i class='bi bi-x-square-fill text-danger' style='font-size: 30px'></i>
                                    </span>
                                    <input type='file' id='image-info1' accept='image/*' hidden>
                                    <input type='text' id='image-info1-hidden' name='Imageinfo1' hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-5 px-4" data-bs-dismiss="modal"><?= $close ?></button>
                    <button type="submit" class="btn btn-sm btn-primary rounded-5 px-4" id="saveInfo" check="1"><i class="bi bi-check2"></i> <?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/information_company.js"></script>