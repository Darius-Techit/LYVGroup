<?php
require('../sidebar.php');
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $worklist ?></h5>
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"><?= $department_name ?></label>
                                <select class="form-select" aria-label="Default select example" id="sr_DepName">
                                    <option selected=""></option>
                                    <?php
                                    $sqlDepName = "SELECT Dep_Name FROM CO_DepartmentCompany WHERE ISNULL(Dep_ID,'')<>'' GROUP BY Dep_Name";
                                    $rs_DepName = fetch_to_array($sqlDepName);
                                    foreach ($rs_DepName as $row) {
                                        echo '<option value = "' . $row['Dep_Name'] . '"> ' . $row['Dep_Name'] . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2" style="align-self: flex-end;">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary" onclick="onQueryWorkList()">
                                    <i class="bi bi-search"></i> <?= $search ?></button>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 30px">
                            <div class="col-md-12 col-sm-12 mb-3"
                                style="display: flex; gap: 10px; align-items: center;">

                                <button type="button" class="btn btn-outline-primary"
                                    onclick="addWorkList(1)"><i class="bi bi-plus-square"></i> <?= $add ?>
                                </button>
                                <button type="button" class="btn btn-outline-warning"
                                    onclick="editWorkList()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                                </button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="removeWorkList()"><i class="bi bi-trash"></i> <?= $delete ?>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tb_work_list" class="table table-striped table-bordered zero-configuration" style="text-align: center;width: 100%;">
                                <thead>
                                    <tr>
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">ID</th> -->
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $department_name ?></th>
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Job Description</th> -->
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Job Description English</th> -->
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Request Work</th> -->
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Request Work English</th> -->
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $degree ?></th>
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Degree English</th> -->
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $gender ?></th>
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Gender English</th> -->
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $age ?></th>
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Age Range English</th> -->
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $salary ?></th>
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Salary English</th> -->
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $number_of_vacancies ?></th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $work_experience ?></th>
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Work Experience English</th> -->
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $working_time ?></th>
                                        <!-- <th style="background-color: #337ab7; color: #fff; text-align: center;">Working Time English</th> -->
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"></th>
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
<div class="modal fade show" id="modalWorkList" tabindex="-1" aria-modal="true" role="dialog">
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
                            <select class="form-select" aria-label="Default select example" id="DepID" name="DepID">
                                <option selected=""></option>
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
                            <input type="text" class="form-control" name="Number_Vacancies" id="Number_Vacancies">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><?= $degree ?> <span class="badge bg-primary badge-number">3A</span></label>
                            <input type="text" class="form-control" name="Degree" id="Degree">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $degreeEN ?> <span class="badge bg-primary badge-number">3B</span></label>
                            <input type="text" class="form-control" name="DegreeEN" id="DegreeEN">
                        </div>
                        <hr style="border: none; border-top: 2px dashed rgba(0, 0, 0, 0.3); margin: 10px 0px 0px 0px;" />
                        <div class="col-md-3">
                            <label class="form-label"><?= $gender ?> <span class="badge bg-primary badge-number">4A</span></label>
                            <input type="text" class="form-control" name="Gender" id="Gender">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $genderEN ?> <span class="badge bg-primary badge-number">4B</span></label>
                            <input type="text" class="form-control" name="GenderEN" id="GenderEN">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><?= $age ?> <span class="badge bg-primary badge-number">5A</span></label>
                            <input type="text" class="form-control" name="Age_Range" id="Age_Range">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $ageEN ?> <span class="badge bg-primary badge-number">5B</span></label>
                            <input type="text" class="form-control" name="Age_RangeEN" id="Age_RangeEN">
                        </div>
                        <hr style="border: none; border-top: 2px dashed rgba(0, 0, 0, 0.3); margin: 10px 0px 0px 0px;  " />
                        <div class="col-md-3">
                            <label class="form-label"><?= $salary ?> <span class="badge bg-primary badge-number">6A</span></label>
                            <input type="text" class="form-control" name="Salary" id="Salary">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $salaryEN ?> <span class="badge bg-primary badge-number">6B</span></label>
                            <input type="text" class="form-control" name="SalaryEN" id="SalaryEN">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $work_experience ?> <span class="badge bg-primary badge-number">7A</span></label>
                            <input type="text" class="form-control" name="Work_Experience" id="Work_Experience">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $work_experienceEN ?> <span class="badge bg-primary badge-number">7B</span></label>
                            <input type="text" class="form-control" name="Work_ExperienceEN" id="Work_ExperienceEN">
                        </div>
                        <hr style="border: none; border-top: 2px dashed rgba(0, 0, 0, 0.3); margin: 10px 0px 0px 0px;  " />
                        <div class="col-md-3">
                            <label class="form-label"><?= $working_time ?> <span class="badge bg-primary badge-number">8A</span></label>
                            <input type="text" class="form-control" name="Working_Time" id="Working_Time">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= $working_timeEN ?> <span class="badge bg-primary badge-number">8B</span></label>
                            <input type="text" class="form-control" name="Working_TimeEN" id="Working_TimeEN">
                        </div>
                        <div class="col-md-3" style="align-self: anchor-center;">
                            <label class="form-label">&nbsp;</label>
                            <input class="form-check-input" type="checkbox" id="Job_Hot" name="Job_Hot" value="1">
                            <label class="form-check-label" for="Job_Hot" style="color: red;"> Job Hot
                            </label>
                        </div>
                    </div>
                    <div class="row mb-3 g-3">
                        <div class="col-6">
                            <label class="form-label">Job Description</label>
                            <div>
                                <div class="quill-editor-default" id="Job_Description">
                                </div>
                                <textarea name="Job_Description_input" id="Job_Description_input" hidden></textarea>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <label class="form-label">Job Description English</label>
                            <div>
                                <div class="quill-editor-default" id="Job_DescriptionEN">
                                </div>
                                <textarea name="Job_DescriptionEN_input" id="Job_DescriptionEN_input" hidden></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Request Work</label>
                            <div>
                                <div class="quill-editor-default" id="Request_Work">
                                </div>
                                <textarea name="Request_Work_input" id="Request_Work_input" hidden></textarea>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <label class="form-label">Request Work English</label>
                            <div>
                                <div class="quill-editor-default" id="Request_WorkEN">
                                </div>
                                <textarea name="Request_WorkEN_input" id="Request_WorkEN_input" hidden></textarea>
                            </div>
                        </div>
                        <!-- <div class="col-6">
                            <label class="form-label">Request Work</label>
                            <div>
                                <div class="quill-editor-default" id="Request_Work">
                                </div>
                                <textarea name="Request_Work_input" id="Request_Work_input" hidden></textarea>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <label class="form-label">Request Work English</label>
                            <div>
                                <div class="quill-editor-default" id="Request_WorkEN">
                                </div>
                                <textarea name="Request_WorkEN_input" id="Request_WorkEN_input" hidden></textarea>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $close ?></button>
                    <button type="submit" class="btn btn-primary" id="saveWorkList" check="1"><?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal List Applicant -->
<div class="modal fade" id="modalListApply" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="create-content" enctype="multipart/form-data" role="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title_ListApply"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tb_list_applicant" class="table table-striped table-bordered zero-configuration" style="text-align: center;width: 100%;">
                            <thead>
                                <tr>
                                    <th style="background-color: #337ab7; color: #fff; text-align: center;">FullName</th>
                                    <th style="background-color: #337ab7; color: #fff; text-align: center;">Phone</th>
                                    <th style="background-color: #337ab7; color: #fff; text-align: center;">Email</th>
                                    <th style="background-color: #337ab7; color: #fff; text-align: center;">File Name</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>