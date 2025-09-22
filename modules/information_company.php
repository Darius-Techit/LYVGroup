<?php
require('../sidebar.php');
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $information ?></h5>
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"><?= $user_date ?></label>
                                <div class="d-flex align-items-center">
                                    <div class="input-group w-40">
                                        <span class="input-group-text"><?= $from ?></span>
                                        <input type="date" class="form-control" name="User_Date_From" id="User_Date_From">
                                    </div>
                                    <span class="mx-2">~</span>
                                    <div class="input-group w-40">
                                        <span class="input-group-text"><?= $to ?></span>
                                        <input type="date" class="form-control" name="User_Date_To" id="User_Date_To">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2" style="align-self: flex-end;">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control" onclick="onQueryInfo()">
                                    <i class="bi bi-search"></i> <?= $search ?></button>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 30px">
                            <div class="col-md-12 col-sm-12 mb-3"
                                style="display: flex; gap: 10px; align-items: center;">

                                <button type="button" class="btn btn-outline-primary"
                                    onclick="addInfo(1)"><i class="bi bi-plus-square"></i> <?= $add ?>
                                </button>
                                <button type="button" class="btn btn-outline-warning"
                                    onclick="editInfo()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                                </button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="removeInfo()"><i class="bi bi-trash"></i> <?= $delete ?>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tb_info_company" class="table table-striped table-bordered zero-configuration" style="text-align: center;width: 100%;">
                                <thead>
                                    <tr>
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">ID</th> -->
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $panel ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Modal insert/update -->
<div class="modal fade" id="modalInfo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="create-info" enctype="multipart/form-data" role="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" name="ID_Info_Image" id="ID_Info_Image">
                        <!-- <div class="col-md-6">
                            <label class="form-label">Image Type</label>
                            <select class="form-select" aria-label="Default select example" id="img_type" name="img_type">
                                <option value="" selected></option>
                                <option value="home">Panel Home</option>
                                <option value="news">Panel News</option>
                            </select>
                        </div> -->

                        <div class="col-md-12">
                            <!-- <label class="form-label">Information Picture</label> -->
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $close ?></button>
                    <button type="submit" class="btn btn-primary" id="saveInfo" check="1"><?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/information_company.js"></script>