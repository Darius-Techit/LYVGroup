<?php
require('../sidebar.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $department ?></h5>
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label"><?= $department_name ?></label>
                                <input type="text" class="form-control" id="sr_DepName">
                            </div>
                            <div class="col-3">
                                <label class="form-label"><?= $department_nameEN ?></label>
                                <input type="text" class="form-control" id="sr_DepNameEN">
                            </div>

                            <div class="col-2" style="align-self: flex-end;">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control" onclick=" onQueryDep()">
                                    <i class="bi bi-search"></i> <?= $search ?></button>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 30px">
                            <div class="col-md-12 col-sm-12 mb-3"
                                style="display: flex; gap: 10px; align-items: center;">

                                <button type="button" class="btn btn-outline-primary"
                                    onclick="addDep(1)"><i class="bi bi-plus-square"></i> <?= $add ?>
                                </button>
                                <button type="button" class="btn btn-outline-warning"
                                    onclick="editDep()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                                </button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="removeDep()"><i class="bi bi-trash"></i> <?= $delete ?>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tb_department" class="table table-striped table-bordered zero-configuration" style="text-align: center;width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $department_name ?></th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $department_nameEN ?></th>
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
<div class="modal fade" id="modalDepartment" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="create-department" enctype="multipart/form-data" role="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" name="DepID" id="DepID">
                        <div class="col-md-6">
                            <label class="form-label"><?= $department_name ?></label>
                            <input type="text" class="form-control" name="DepName" id="DepName">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= $department_nameEN ?></label>
                            <input type="text" class="form-control" name="DepNameEN" id="DepNameEN">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $close ?></button>
                    <button type="submit" class="btn btn-primary" id="saveDept" check="1"><?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Extra Large Modal-->
<script src="../js/department.js"></script>