<?php
require('../sidebar.php');
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Management</h5>
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label">Department Name</label>
                                <input type="text" class="form-control" id="sr_DepName">
                            </div>
                            <div class="col-3">
                                <label class="form-label">Department Name English</label>
                                <input type="text" class="form-control" id="sr_DepNameEN">
                            </div>

                            <div class="col-2" style="align-self: flex-end;">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control" onclick="onQueryUser()">
                                    <i class="bi bi-search"></i> Search</button>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 30px">
                            <div class="col-md-12 col-sm-12 mb-3"
                                style="display: flex; gap: 10px; align-items: center;">

                                <button type="button" class="btn btn-outline-primary"
                                    onclick="addUser(1)"><i class="bi bi-plus-square"></i> Add
                                </button>
                                <button type="button" class="btn btn-outline-warning"
                                    onclick="editUser()"><i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="removeUser()"><i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tb_user_management" class="table table-striped table-bordered zero-configuration" style="text-align: center;width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">ID User</th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">User Name</th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">Permission</th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">User ID</th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">User Date</th>
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
                            <input type="text" class="form-control" name="IDUser" id="IDUser">
                            <input name="IDHidden" id="IDHidden" hidden>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Password <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="Password" id="Password">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">User Name <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="UserName" id="UserName">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Permission <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="Permission" id="Permission" class="form-select">
                                <option selected="">&nbsp;</option>
                                <option value="Administrator">Administrator</option>
                                <option value="HR">HR</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveUserM" check="1">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>