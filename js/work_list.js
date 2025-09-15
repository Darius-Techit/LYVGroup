$(function () {
    onQueryWorkList();
    initQuillEditors();
});
function onQueryWorkList() {
    let DepName = $("#sr_DepName").val();
    $("#tb_work_list").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_work_list.php?Action=GetDataWorkList",
            data: {
                DepName: DepName
            },
            dataSrc: function (res) {
                return res;
            }
        },
        columns: [
            // {
            //     data: "ID",
            // },
            {
                data: "Dep_Name",
            },
            // {
            //     data: "Job_Description"
            // },

            // {
            //     data: "Job_DescriptionEN",
            // },
            // {
            //     data: "Request_Work",
            // },
            // {
            //     data: "Request_WorkEN",
            // },
            {
                data: "Degree",
            },
            // {
            //     data: "DegreeEN",
            // },
            {
                data: "Gender",
            },
            // {
            //     data: "GenderEN",
            // },
            {
                data: "Age_Range",
            },
            // {
            //     data: "Age_RangeEN",
            // },
            {
                data: "Salary",
            },
            // {
            //     data: "SalaryEN",
            // },
            {
                data: "Number_Vacancies",
            },
            {
                data: "Work_Experience",

            },
            // {
            //     data: "Work_ExperienceEN",

            // },
            {
                data: "Working_Time",

            },
            // {
            //     data: "Working_TimeEN",

            // }
            {
                data: null,
                render: function (val, type, row) {
                    if (row.IDListApply == '0') {
                        let html = `
                                <button class="btn btn-light p-0 border-0" onclick="ShowListApply('${row.Dep_ID}')" title="View Apply List">
                                <i class="bi bi-three-dots-vertical"></i></button>   `;
                        return html;
                    } else {
                        let html = `
                            <div style="position: relative; display: inline-block;">
                                <button class="btn btn-light p-0 border-0" onclick="ShowListApply('${row.Dep_ID}')" title="View Apply List">
                                <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <span class="badge bg-danger" style="position: absolute;top: -5px;right: -10px;font-size: 0.65rem;padding: 2px 5px;line-height: 1;">
                                    ${row.IDListApply}</span>
                            </div>
                    `;
                        return html;
                    }

                }
            }
        ],
        destroy: true,
        select: true,
        searching: false,
        ordering: true,
        info: false,
        autoWidth: false,
    });
}
let quills = {};
function initQuillEditors() {
    $('.quill-editor-default').each(function (index, el) {
        if (!$(el).hasClass('ql-container')) {
            let quill = new Quill(el, { theme: 'snow' });
            quills[el.id] = quill; //Get ID Of quill
        }
    });
}

function makeSelectReadonly(selector) {
    $(selector)
        .on("mousedown keydown", function (e) {
            e.preventDefault();
        })
        .addClass("select-readonly");
}


function unlockSelect(selector) {
    $(selector)
        .off("mousedown keydown")
        .removeClass("select-readonly");
}
function addWorkList(check) {
    $("#saveWorkList").attr("check", check);
    if ($("#saveWorkList").attr("check") == 1) {
        $("#modalWorkList").modal("show");
        $("#modal_title").html("Add Work");
        unlockSelect("#DepID");

        $("#DepID").prop("disabled", false);
        //Fill data from table to modal
        quills["Job_Description"].setContents([]);
        quills["Request_Work"].setContents([]);
        quills["Job_Description"]?.clipboard.dangerouslyPasteHTML('' || "");
        quills["Job_DescriptionEN"]?.clipboard.dangerouslyPasteHTML('' || "");
        quills["Request_Work"]?.clipboard.dangerouslyPasteHTML('' || "");
        quills["Request_WorkEN"]?.clipboard.dangerouslyPasteHTML('' || "");
        $("#DepID").val('');
        $("#Number_Vacancies").val('');
        $("#Degree").val('');
        $("#DegreeEN").val('');
        $("#Gender").val('');
        $("#GenderEN").val('');
        $("#Age_Range").val('');
        $("#Age_RangeEN").val('');
        $("#Salary").val('');
        $("#SalaryEN").val('');
        $("#Work_Experience").val('');
        $("#Work_ExperienceEN").val('');
        $("#Working_Time").val('');
        $("#Working_TimeEN").val('');
        $("#Job_Hot").prop("checked", false);

        $("#DepID-error").hide();
        $("#Number_Vacancies-error").hide();
        $("#Degree-error").hide();
        $("#Gender-error").hide();
        $("#Age_Range-error").hide();
        $("#Salary-error").hide();
        $("#Work_Experience-error").hide();
        $("#Working_Time-error").hide();
    }




    $("#create-worklist").validate({
        rules: {
            DepID: { required: true },
            // Number_Vacancies: { required: true },
            // Degree: { required: true },
            // Gender: { required: true },
            // Age_Range: { required: true },
            // Salary: { required: true },
            // Work_Experience: { required: true },
            // Working_Time: { required: true }
        },
        messages: {
            DepID: { required: "Please choose Department Name" },
            // Number_Vacancies: { required: "Please Enter Number Vacancies" },
            // Degree: { required: "Please Enter Degree" },
            // Gender: { required: "Please Enter Gender" },
            // Age_Range: { required: "Please Enter Age Range" },
            // Salary: { required: "Please Enter Salary" },
            // Work_Experience: { required: "Please Enter Work Experience" },
            // Working_Time: { required: "Please Enter Working Time" }

        },
        submitHandler: () => {
            $("#Job_Description_input").val(quills['Job_Description']?.root.innerHTML || "");
            $("#Job_DescriptionEN_input").val(quills['Job_DescriptionEN']?.root.innerHTML || "");
            $("#Request_Work_input").val(quills['Request_Work']?.root.innerHTML || "");
            $("#Request_WorkEN_input").val(quills['Request_WorkEN']?.root.innerHTML || "");
            if ($("#saveWorkList").attr("check") == 1) {
                $.ajax({
                    url: "../data/data_work_list.php?Action=InsertWL",
                    data: new FormData(document.getElementById('create-worklist')),
                    type: "POST",
                    contentType: false,
                    processData: false,
                    success: (json) => {
                        res = JSON.parse(json);
                        if (res.status == "Success") {
                            toastr.success(res.message, "Info");
                            $("#modalWorkList").modal("hide");
                            $("#tb_work_list").DataTable().ajax.reload();
                        } else {
                            toastr.error(res.message, "Info");
                        }
                    },
                });
            } else {
                $.ajax({
                    url: "../data/data_work_list.php?Action=UpdateWL",
                    data: new FormData(document.getElementById('create-worklist')),
                    type: "POST",
                    contentType: false,
                    processData: false,
                    success: (json) => {
                        res = JSON.parse(json);
                        if (res.status == "Success") {
                            toastr.success(res.message, "Info");
                            $("#modalWorkList").modal("hide");
                            $("#tb_work_list").DataTable().ajax.reload();
                        } else {
                            toastr.error(res.message, "Info");
                        }
                    },
                });
            }

        }
    });
}

function editWorkList() {
    let table = $("#tb_work_list").DataTable();
    let row = getSelectedRow(table);
    makeSelectReadonly("#DepID");


    if (row) {
        $("#modalWorkList").modal("show");
        $("#modal_title").html("Edit Work");

        //Fill data from table to modal
        quills["Job_Description"].setContents([]);
        quills["Request_Work"].setContents([]);
        quills["Job_Description"]?.clipboard.dangerouslyPasteHTML(row.Job_Description || "");
        quills["Job_DescriptionEN"]?.clipboard.dangerouslyPasteHTML(row.Job_DescriptionEN || "");
        quills["Request_Work"]?.clipboard.dangerouslyPasteHTML(row.Request_Work || "");
        quills["Request_WorkEN"]?.clipboard.dangerouslyPasteHTML(row.Request_WorkEN || "");
        $("#ID").val(row.ID);
        $("#DepID").val(row.Dep_ID);
        $("#Number_Vacancies").val(row.Number_Vacancies);
        $("#Degree").val(row.Degree);
        $("#DegreeEN").val(row.DegreeEN);
        $("#Gender").val(row.Gender);
        $("#GenderEN").val(row.GenderEN);
        $("#Age_Range").val(row.Age_Range);
        $("#Age_RangeEN").val(row.Age_RangeEN);
        $("#Salary").val(row.Salary);
        $("#SalaryEN").val(row.SalaryEN);
        $("#Work_Experience").val(row.Work_Experience);
        $("#Work_ExperienceEN").val(row.Work_ExperienceEN);
        $("#Working_Time").val(row.Working_Time);
        $("#Working_TimeEN").val(row.Working_TimeEN);
        $("#Job_Hot").prop("checked", row.Job_Hot == 1);

        $("#DepID-error").hide();
        $("#Number_Vacancies-error").hide();
        $("#Degree-error").hide();
        $("#Gender-error").hide();
        $("#Age_Range-error").hide();
        $("#Salary-error").hide();
        $("#Work_Experience-error").hide();
        $("#Working_Time-error").hide();
        addWorkList(2);
    } else {
        toastr.warning("Please choose row need Edit", "Info");
    }
}
function removeWorkList() {
    let table = $("#tb_work_list").DataTable();
    let row = getSelectedRow(table);
    console.log(row);
    if (row) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../data/data_work_list.php?Action=DeleteWL",
                    type: "POST",
                    data: {
                        ID: row.ID,
                        Dep_ID: row.Dep_ID
                    },
                    success: (json) => {
                        let res = JSON.parse(json);
                        if (res.status === "Success") {
                            Swal.fire({
                                icon: "success",
                                title: res.message,
                                showConfirmButton: false,
                                timer: 1000
                            });
                            $("#tb_work_list").DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: res.message,
                                icon: "error",
                                confirmButtonText: 'OK',
                                timer: 1000
                            });
                        }
                    }
                });

            }
        });
    } else {
        toastr.warning("Please choose row need Delete", "Info");
    }
}
function ShowListApply(Dep_ID) {
    console.log(Dep_ID);
    $("#modalListApply").modal("show");
    $("#modal_title_ListApply").html("List Apply");

    $("#tb_list_applicant").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_list_applicant.php?Action=GetDataListApp",
            data: { Dep_ID: Dep_ID },
            dataSrc: function (res) {
                return res;
            }
        },
        columns: [
            {
                data: "FullName",
            },
            {
                data: "PhoneNumber",
            },
            {
                data: "Email",

            },
            {
                data: "File_name",
            },
        ],
        destroy: true,
        select: false,
        searching: false,
        ordering: true,
        info: false,
    });
}