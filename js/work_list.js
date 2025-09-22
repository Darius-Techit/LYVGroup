toastr.options = {
    closeButton: true,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    timeOut: "2000",
};
$(function () {
    onQueryWorkList();
    initQuillEditors();
});
let languages = localStorage.getItem("languages");
const translations = {
    en: {
        add_work_list: "Add Work",
        edit_work_list: "Edit Work",
        required_DepID: "Please Choose Department Name",
        required_number_vacancies: "Please Enter Number Vacancies",
        required_degree: "Please Enter Degree",
        required_gender: "Please Enter Gender",
        required_age_range: "Please Enter Age Requirement",
        required_salary: "Please Enter Salary",
        required_work_experience: "Please Enter Work Experience",
        required_working_time: "Please Enter Working Time",
        list_applicant: "List Applicant",
        edit_status: "Edit Status",
        required_progress_status: "Please Choose progress status",
        alert_choose_row: "Please select a row first!",
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: 'Cancel',
    },
    vn: {
        add_work_list: "Thêm công việc",
        edit_work_list: "Chỉnh sửa công việc",
        required_DepID: "Vui lòng chọn tên bộ phận",
        required_number_vacancies: "Vui lòng nhập số lượng cần tuyển",
        required_degree: "Vui lòng nhập Bằng cấp",
        required_gender: "Vui lòng nhập Giới tính",
        required_age_range: "Vui lòng nhập Độ tuổi",
        required_salary: "Vui lòng nhập Mức lương",
        required_work_experience: "Vui lòng nhập Kinh nghiệm làm việc",
        required_working_time: "Vui lòng nhập Thời gian làm việc",
        list_applicant: "Danh sách người nộp đơn",
        edit_status: "Chỉnh sửa trạng thái",
        required_progress_status: "Vui lòng chọn trạng thái xử lý",
        alert_choose_row: "Vui lòng! bạn cần phải chọn 1 dòng trong bảng dữ liệu",
        title: "Bạn có chắc không?",
        text: "Bạn sẽ không thể hoàn tác điều này!",
        confirmButtonText: "Có, xóa!",
        cancelButtonText: 'Hủy bỏ',
    }
}
function getTranslation(lang, key) {
    if (translations[lang] && translations[lang][key]) {
        return translations[lang][key];
    }
    return translations.en[key];
}
function getSelectedRow(table) {
    return table.rows(".selected").data()[0];
}
function onQueryWorkList() {
    let DepName = $("#sr_DepName").val();
    let User_Date_From = $("#User_Date_From").val();
    let User_Date_To = $("#User_Date_To").val();
    let Position_Level = $("#Position_Level").val();
    $("#tb_work_list").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_work_list.php?Action=GetDataWorkList",
            data: {
                DepName: DepName,
                User_Date_From: User_Date_From,
                User_Date_To: User_Date_To,
                Position_Level: Position_Level
            },
            dataSrc: function (res) {
                return res;
            }
        },
        columns: [
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
                data: "Date_Applications"
            },
            {
                data: "Position_Level",
                render: function (data, type, row) {
                    if (data === "CN") {
                        return "Công nhân";
                    } else {
                        return "Văn phòng";
                    }
                }
            },
            {
                data: null,
                render: function (val, type, row) {
                    if (row.IDListApply == '0') {
                        let html = `
                                <button class="btn btn-light p-0 border-0" onclick="ShowListApply('${row.Dep_ID}','${1}')" title="View Apply List">
                                <i class="bi bi-three-dots-vertical"></i></button>   `;
                        return html;
                    } else {
                        let html = `
                            <div style="position: relative; display: inline-block;">
                                <button class="btn btn-light p-0 border-0" onclick="ShowListApply('${row.Dep_ID}','${1}')" title="View Apply List">
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
        $("#modal_title").html(getTranslation(languages, "add_work_list"));

        unlockSelect("#DepID");

        $("#DepID").prop("disabled", false);
        //Fill data from table to modal
        quills["Job_Description"].setContents([]);
        quills["Request_Work"].setContents([]);
        quills["Job_Description"]?.clipboard.dangerouslyPasteHTML('' || "");
        quills["Job_DescriptionEN"]?.clipboard.dangerouslyPasteHTML('' || "");
        quills["Request_Work"]?.clipboard.dangerouslyPasteHTML('' || "");
        quills["Request_WorkEN"]?.clipboard.dangerouslyPasteHTML('' || "");
        quills["Compensation_Benefits"]?.clipboard.dangerouslyPasteHTML('' || "");
        quills["Compensation_BenefitsEN"]?.clipboard.dangerouslyPasteHTML('' || "");

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
        $("#Application_Deadline").val('');
        // $("#Position_Level").val('');
        $("#Job_Hot").prop("checked", false);

        $("#DepID-error").hide();
        $("#Number_Vacancies-error").hide();
        $("#Degree-error").hide();
        $("#Gender-error").hide();
        $("#Age_Range-error").hide();
        $("#Salary-error").hide();
        $("#Work_Experience-error").hide();
        $("#Working_Time-error").hide();
        $("#Application_Deadline-error").hide();
    }

    $("#create-worklist").validate({
        rules: {
            DepID: { required: true },
            Number_Vacancies: { required: true },
            Degree: { required: true },
            Gender: { required: true },
            Age_Range: { required: true },
            Salary: { required: true },
            Work_Experience: { required: true },
            Working_Time: { required: true },
            Application_Deadline: { required: true }
        },
        messages: {
            DepID: { required: getTranslation(languages, "required_DepID") },
            Number_Vacancies: { required: getTranslation(languages, "required_number_vacancies") },
            Degree: { required: getTranslation(languages, "required_degree") },
            Gender: { required: getTranslation(languages, "required_gender") },
            Age_Range: { required: getTranslation(languages, "required_age_range") },
            Salary: { required: getTranslation(languages, "required_salary") },
            Work_Experience: { required: getTranslation(languages, "required_work_experience") },
            Working_Time: { required: getTranslation(languages, "required_working_time") },
            Application_Deadline: { required: "Vui lòng chọn thời gian nộp hồ sơ" }

        },
        submitHandler: () => {
            $("#Job_Description_input").val(quills['Job_Description']?.root.innerHTML || "");
            $("#Job_DescriptionEN_input").val(quills['Job_DescriptionEN']?.root.innerHTML || "");
            $("#Request_Work_input").val(quills['Request_Work']?.root.innerHTML || "");
            $("#Request_WorkEN_input").val(quills['Request_WorkEN']?.root.innerHTML || "");
            $("#Compensation_Benefits_input").val(quills['Compensation_Benefits']?.root.innerHTML || "");
            $("#Compensation_BenefitsEN_input").val(quills['Compensation_BenefitsEN']?.root.innerHTML || "");

            let action = ($("#saveWorkList").attr("check") == 1) ? "InsertWL" : "UpdateWL";
            $.ajax({
                url: "../data/data_work_list.php?Action=" + action,
                data: new FormData(document.getElementById('create-worklist')),
                type: "POST",
                contentType: false,
                processData: false,
                success: (json) => {
                    res = JSON.parse(json);
                    if (res.status == "Success") {
                        toastr.success(res.message);
                        $("#modalWorkList").modal("hide");
                        $("#tb_work_list").DataTable().ajax.reload();
                    } else {
                        toastr.error(res.message);
                    }
                },
            });
        }
    });
}

function editWorkList() {
    let table = $("#tb_work_list").DataTable();
    let row = getSelectedRow(table);
    makeSelectReadonly("#DepID");

    if (row) {
        $("#modalWorkList").modal("show");
        $("#modal_title").html(getTranslation(languages, "edit_work_list"));

        //Fill data from table to modal
        quills["Job_Description"].setContents([]);
        quills["Request_Work"].setContents([]);
        quills["Job_Description"]?.clipboard.dangerouslyPasteHTML(row.Job_Description || "");
        quills["Job_DescriptionEN"]?.clipboard.dangerouslyPasteHTML(row.Job_DescriptionEN || "");
        quills["Request_Work"]?.clipboard.dangerouslyPasteHTML(row.Request_Work || "");
        quills["Request_WorkEN"]?.clipboard.dangerouslyPasteHTML(row.Request_WorkEN || "");
        quills["Compensation_Benefits"]?.clipboard.dangerouslyPasteHTML(row.Compensation_Benefits || "");
        quills["Compensation_BenefitsEN"]?.clipboard.dangerouslyPasteHTML(row.Compensation_BenefitsEN || "");
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
        $("#Application_Deadline").val(row.Date_Applications);
        $("#Position_Level").val(row.Position_Level);
        $("#Job_Hot").prop("checked", row.Job_Hot == 1);

        $("#DepID-error").hide();
        $("#Number_Vacancies-error").hide();
        $("#Degree-error").hide();
        $("#Gender-error").hide();
        $("#Age_Range-error").hide();
        $("#Salary-error").hide();
        $("#Work_Experience-error").hide();
        $("#Working_Time-error").hide();
        $("#Application_Deadline-error").hide();
        addWorkList(2);
    } else {
        toastr.warning(getTranslation(languages, "alert_choose_row"));
    }
}
function removeWorkList() {
    let table = $("#tb_work_list").DataTable();
    let row = getSelectedRow(table);
    if (row) {
        Swal.fire({
            title: getTranslation(languages, "title"),
            text: getTranslation(languages, "text"),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: getTranslation(languages, "confirmButtonText"),
            cancelButtonText: getTranslation(languages, "cancelButtonText")
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
        toastr.warning(getTranslation(languages, "alert_choose_row"));
    }
}
$('#modalListApply').on('hidden.bs.modal', function () {
    var table = $('#tb_work_list').DataTable();
    table.rows().deselect(); // clear hết selection
});
function ShowListApply(Dep_ID, check) {
    let table = $("#tb_work_list").DataTable();
    let row = getSelectedRow(table);

    if (check == 1) {
        $("#SProcessing_Status").val('');
        $("#Upload_Date_From").val('');
        $("#Upload_Date_To").val('');
    }

    $("#modalListApply").modal("show");
    $("#modal_title_ListApply").html(getTranslation(languages, "list_applicant"));

    let SProcessing_Status = $("#SProcessing_Status").val();
    let Upload_Date_From = $("#Upload_Date_From").val();
    let Upload_Date_To = $("#Upload_Date_To").val();

    $("#tb_list_applicant").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_list_applicant.php?Action=GetDataListApp",
            data: {
                Dep_ID: Dep_ID ? Dep_ID : row.Dep_ID,
                SProcessing_Status: SProcessing_Status,
                Upload_Date_From: Upload_Date_From,
                Upload_Date_To: Upload_Date_To
            },
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
                data: 'Birthday',
            },
            {
                data: "Email",

            },
            {
                // data: "Processing_Status",
                data: function (row) {
                    if (row.Processing_Status == null) {
                        return ''
                    } else {
                        return `<span class="badge bg-info text-dark">${row.Processing_Status}</span>`;
                    }
                }
            },
            {
                // data: "File_name",
                data: function (row) {
                    if (row.File_name == null) {
                        return ''
                    } else {
                        return `<a style="cursor: pointer;color: #007bff; " attr="" onclick="PDF_ListApp('${row.File_name}')" >${row.File_name}</a>`;
                    }
                }
            },
        ],
        destroy: true,
        select: true,
        searching: false,
        ordering: true,
        info: false,
    });
}
function PDF_ListApp(pdf) {
    window.open('../data/show_file_pdf.php?Action=List_Applicant&PDF=' + pdf);
}
function editListA() {
    let table = $("#tb_list_applicant").DataTable();
    let row = getSelectedRow(table);
    if (row) {
        $("#modalPro_Status").modal("show");
        $("#modal-title-status").html(getTranslation(languages, "edit_status"));

        $("#ID_Status").val(row.ID);
        $("#ID_Dep").val(row.Dep_ID);
        $("#Processing_Status").val(row.Processing_Status);

        $("#Processing_Status-error").hide();

        $("#create-processstatus").validate({
            rules: {
                Processing_Status: { required: true }
            },
            messages: {
                Processing_Status: { required: getTranslation(languages, "required_progress_status") }
            },
            submitHandler: () => {
                $.ajax({
                    url: "../data/data_list_applicant.php?Action=UpdateStatus",
                    data: new FormData($("#create-processstatus")[0]),
                    type: "POST",
                    contentType: false,
                    processData: false,
                    success: (json) => {
                        res = JSON.parse(json);
                        if (res.status == "Success") {
                            toastr.success(res.message);
                            $("#modalPro_Status").modal("hide");
                            // $("#modalListApply").modal("hide");
                            $("#tb_list_applicant").DataTable().ajax.reload();
                            $("#tb_work_list").DataTable().ajax.reload();
                        } else {
                            toastr.error(res.message);
                        }
                    }
                });
            }
        })
    } else {
        toastr.warning(getTranslation(languages, "alert_choose_row"));
    }
}
function removeListA() {
    let table = $("#tb_list_applicant").DataTable();
    let row = getSelectedRow(table);
    if (row) {
        Swal.fire({
            title: getTranslation(languages, "title"),
            text: getTranslation(languages, "text"),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: getTranslation(languages, "confirmButtonText"),
            cancelButtonText: getTranslation(languages, "cancelButtonText")
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../data/data_list_applicant.php?Action=DeleteStatus",
                    type: "POST",
                    data: {
                        ID_Status: row.ID,
                        ID_Dep: row.Dep_ID,
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
                            $("#tb_list_applicant").DataTable().ajax.reload();
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
        toastr.warning(getTranslation(languages, "alert_choose_row"));
    }
}