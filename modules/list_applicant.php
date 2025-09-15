<?php
require('../sidebar.php');
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">List Applicants</h5>
                        <div class="row mb-2">
                            <div class="col-2">
                                <label for="inputNanme4" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="inputNanme4">
                            </div>
                            <div class="col-2">
                                <label for="inputNanme4" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="inputNanme4">
                            </div>
                            <div class="col-2" style="align-self: flex-end;">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary" onclick="onQueryApplicant()">
                                    <i class="bi bi-search"></i> Search</button>
                            </div>
                        </div>
                        <!-- <div class="row" style="margin-top: 30px">
                            <div class="col-md-12 col-sm-12 mb-3"
                                style="display: flex; gap: 10px; align-items: center;">

                                <button type="button" class="btn btn-outline-primary"
                                    onclick="addApplicant(1)"><i class="bi bi-plus-square"></i> Add
                                </button>
                                <button type="button" class="btn btn-outline-warning"
                                    onclick="ediApplicant()"><i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="removeApplicant()"><i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div> -->
                        <div class="table-responsive">
                            <table id="tb_list_applicant" class="table table-striped table-bordered zero-configuration" style="text-align: center;width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">ID</th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">FullName</th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">Phone</th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">Email</th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;">File Name</th>
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