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
  $("#modalListApply").on("shown.bs.modal", function (e) {
    $("#tb_list_applicant").DataTable().columns.adjust().draw();
  });
  onQueryWorkList();
  initQuillEditors();
  $(".js-example-basic-single").select2();
  $("#DepID")
    .select2({
      dropdownParent: $("#modalWorkList"),
    })
    .on("change.select2", function () {
      if ($("#create-worklist").data("validator")) {
        $("#create-worklist").validate().element($(this));
      }
    });
  $("#sr_Expire, #sr_Hidden, #sr_Show").change(function () {
    onQueryWorkList();
  });
});
let languages = localStorage.getItem("languages");
if (!languages) {
  languages = "en";
  localStorage.setItem("languages", languages);
}

const translations = {
  en: {
    add_work_list: "Add work",
    edit_work_list: "Edit work",
    required_DepID: "Please choose department name",
    required_number_vacancies: "Please enter number vacancies",
    required_degree: "Please enter degree",
    required_degreeEN: "Please enter degree (EN)",
    required_gender: "Please enter gender",
    required_genderEN: "Please enter gender (EN)",
    required_age_range: "Please enter age requirement",
    required_age_rangeEN: "Please enter age requirement (EN)",
    required_salary: "Please enter salary",
    required_salaryEN: "Please enter salary (EN)",
    required_work_experience: "Please enter work experience",
    required_work_experienceEN: "Please enter work experience (EN)",
    required_working_time: "Please enter working time",
    required_working_timeEN: "Please enter working time (EN)",
    required_application_deadline: "Please choose application deadline",
    list_applicant: "List applicant",
    edit_status: "Edit status",
    required_progress_status: "Please choose progress status",
    alert_choose_row: "Please select a row first!",
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "Cancel",
    sEmptyTable: "No data available in table",
  },
  vn: {
    add_work_list: "Thêm công việc",
    edit_work_list: "Chỉnh sửa công việc",
    required_DepID: "Vui lòng chọn tên bộ phận",
    required_number_vacancies: "Vui lòng nhập số lượng cần tuyển",
    required_degree: "Vui lòng nhập bằng cấp",
    required_degreeEN: "Vui lòng nhập bằng cấp (EN)",
    required_gender: "Vui lòng nhập giới tính",
    required_genderEN: "SVui lòng nhập giới tính (EN)",
    required_age_range: "Vui lòng nhập độ tuổi",
    required_age_rangeEN: "Vui lòng nhập độ tuổi (EN)",
    required_salary: "Vui lòng nhập mức lương",
    required_salaryEN: "Vui lòng nhập mức lương (EN)",
    required_work_experience: "Vui lòng nhập Kinh nghiệm làm việc",
    required_work_experienceEN: "Vui lòng nhập Kinh nghiệm làm việc (EN)",
    required_working_time: "Vui lòng nhập Thời gian làm việc",
    required_working_timeEN: "Vui lòng nhập Thời gian làm việc (EN)",
    required_application_deadline: "Vui lòng chọn thời gian nộp hồ sơ",
    list_applicant: "Danh sách người nộp đơn",
    edit_status: "Chỉnh sửa trạng thái",
    required_progress_status: "Vui lòng chọn trạng thái xử lý",
    alert_choose_row: "Vui lòng! bạn cần phải chọn 1 dòng trong bảng dữ liệu",
    title: "Bạn có chắc không?",
    text: "Bạn sẽ không thể hoàn tác điều này!",
    confirmButtonText: "Có, xóa!",
    cancelButtonText: "Hủy bỏ",
    sEmptyTable: "Không có dữ liệu trong bảng",
  },
};
function getTranslation(lang, key) {
  if (translations[lang] && translations[lang][key]) {
    return translations[lang][key];
  }
  return translations.en[key];
}
function getSelectedRow(table) {
  return table.rows(".selected").data()[0];
}
function updateWorkListStats(res) {
  res = Array.isArray(res) ? res : [];
  $("#wl-stat-total").text(res.length);
}
function updateListApplyStats(res) {
  res = Array.isArray(res) ? res : [];
  $("#la-stat-total").text(res.length);
}
function onQueryWorkList() {
  let DepName = $("#sr_DepName").val();
  let User_Date_From = $("#User_Date_From").val();
  let User_Date_To = $("#User_Date_To").val();
  let Position_Level = $("#sr_Position_Level").val();
  let sr_Expire = $("#sr_Expire").is(":checked") ? 1 : 0;
  let sr_Hidden = $("#sr_Hidden").is(":checked") ? 1 : 0;
  let sr_Show = $("#sr_Show").is(":checked") ? 1 : 0;
  $("#tb_work_list").DataTable({
    language: {
      emptyTable: getTranslation(languages, "sEmptyTable"),
    },
    ajax: {
      type: "GET",
      url: "../data/data_work_list.php?Action=GetDataWorkList",
      data: {
        DepName: DepName,
        User_Date_From: User_Date_From,
        User_Date_To: User_Date_To,
        Position_Level: Position_Level,
        sr_Expire: sr_Expire,
        sr_Hidden: sr_Hidden,
        sr_Show: sr_Show,
      },
      dataSrc: function (res) {
        return res;
      },
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
        data: "Date_Applications",
      },
      {
        data: "Position_Level",
        render: function (data, type, row) {
          if (data === "CN") {
            return "Công nhân";
          } else if (data === "VP") {
            return "Nhân viên văn phòng";
          } else {
            return "Quản lý";
          }
        },
      },
      {
        data: "UserDate",
      },
      {
        data: null,
        render: function (val, type, row) {
          if (row.IDListApply == "0") {
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
                                <span class="badge bg-danger" style="position: absolute;top: -5px;right: -8px;font-size: 0.65rem;padding: 2px 5px;line-height: 1;">
                                    ${row.IDListApply}</span>
                            </div>
                    `;
            return html;
          }
        },
      },
    ],
    destroy: true,
    select: true,
    searching: false,
    ordering: true,
    drawCallback: function () {
      updateWorkListStats(this.api().ajax.json());
    },
    initComplete: function (settings, json) {
      const api = this.api();
      const lastColIndex = api.columns().count() - 1;
      api.order([lastColIndex, "asc"]).draw();
    },
    info: false,
    autoWidth: false,
    createdRow: function (row, data, dataIndex) {
      let today = new Date();
      let deadline = new Date(data.Date_Applications);
      let daysDiff = Math.floor((deadline - today) / (1000 * 60 * 60 * 24)) + 1;
      if (daysDiff <= 4) {
        $(row).find("td").css("background-color", "#ffcccc"); // red
      }
    },
  });
}
let quills = {};
function initQuillEditors() {
  $(".quill-editor-default").each(function (index, el) {
    if (!$(el).hasClass("ql-container")) {
      let quill = new Quill(el, { theme: "snow" });
      quills[el.id] = quill; //Get ID Of quill
    }
  });
}

function addWorkList(check) {
  $("#saveWorkList").attr("check", check);
  if ($("#saveWorkList").attr("check") == 1) {
    $("#modalWorkList").modal("show");
    $("#modal_title").html(getTranslation(languages, "add_work_list"));

    let today = new Date();
    let yyyy = today.getFullYear();
    let mm = String(today.getMonth() + 1).padStart(2, "0");
    let dd = String(today.getDate()).padStart(2, "0");
    let currentDate = `${yyyy}-${mm}-${dd}`;

    //Fill data from table to modal
    quills["Job_Description"].setContents([]);
    quills["Request_Work"].setContents([]);
    quills["Job_Description"]?.clipboard.dangerouslyPasteHTML("" || "");
    quills["Job_DescriptionEN"]?.clipboard.dangerouslyPasteHTML("" || "");
    quills["Request_Work"]?.clipboard.dangerouslyPasteHTML("" || "");
    quills["Request_WorkEN"]?.clipboard.dangerouslyPasteHTML("" || "");
    quills["Compensation_Benefits"]?.clipboard.dangerouslyPasteHTML("" || "");
    quills["Compensation_BenefitsEN"]?.clipboard.dangerouslyPasteHTML("" || "");

    $("#DepID").val("").trigger("change").prop("disabled", false);
    $("#Number_Vacancies").val("1");
    // $("#Degree").val([]).trigger("change");
    // $("#DegreeEN").val([]).trigger("change");
    $("#Degree").val("");
    $("#DegreeEN").val("");
    $("#Gender").val("");
    $("#GenderEN").val("");
    $("#Age_Range").val("Trong độ tuổi lao động").prop("readonly", true);
    $("#Age_RangeEN").val("Of working age").prop("readonly", true);
    $("#Salary").val("");
    $("#SalaryEN").val("");
    $("#Work_Experience").val("");
    $("#Work_ExperienceEN").val("");
    $("#Working_Time").val("");
    $("#Working_TimeEN").val("");
    $("#Application_Deadline").val(currentDate);
    // $("#Position_Level").val('');
    $("#Job_Hot").prop("checked", false);
    $("#STATUS").prop("checked", false);

    $("#DepID-error").hide();
    $("#Number_Vacancies-error").hide();
    $("#Degree-error").hide();
    $("#DegreeEN-error").hide();
    $("#Gender-error").hide();
    $("#GenderEN-error").hide();
    $("#Age_Range-error").hide();
    $("#Age_RangeEN-error").hide();
    $("#Salary-error").hide();
    $("#SalaryEN-error").hide();
    $("#Work_Experience-error").hide();
    $("#Work_ExperienceEN-error").hide();
    $("#Working_Time-error").hide();
    $("#Working_TimeEN-error").hide();
    $("#Application_Deadline-error").hide();
  }
  // Custom rule
  jQuery.validator.addMethod(
    "dateGreaterOrEqualToday",
    function (value, element) {
      if (!value) return false;
      let today = new Date();
      today.setHours(0, 0, 0, 0);

      let inputDate = new Date(value);
      return inputDate >= today;
    },
    "Vui lòng chọn ngày lớn hơn hoặc bằng ngày hiện tại",
  );

  $("#create-worklist").validate({
    rules: {
      DepID: { required: true },
      Number_Vacancies: { required: true },
      Degree: { required: true },
      DegreeEN: { required: true },
      Gender: { required: true },
      GenderEN: { required: true },
      Age_Range: { required: true },
      Age_RangeEN: { required: true },
      Salary: { required: true },
      SalaryEN: { required: true },
      Work_Experience: { required: true },
      Work_ExperienceEN: { required: true },
      Working_Time: { required: true },
      Working_TimeEN: { required: true },
      Application_Deadline: {
        required: true,
        dateGreaterOrEqualToday: true,
      },
    },
    messages: {
      DepID: { required: getTranslation(languages, "required_DepID") },
      Number_Vacancies: {
        required: getTranslation(languages, "required_number_vacancies"),
      },
      Degree: { required: getTranslation(languages, "required_degree") },
      DegreeEN: { required: getTranslation(languages, "required_degreeEN") },
      Gender: { required: getTranslation(languages, "required_gender") },
      GenderEN: { required: getTranslation(languages, "required_genderEN") },
      Age_Range: { required: getTranslation(languages, "required_age_range") },
      Age_RangeEN: {
        required: getTranslation(languages, "required_age_rangeEN"),
      },
      Salary: { required: getTranslation(languages, "required_salary") },
      SalaryEN: { required: getTranslation(languages, "required_salaryEN") },
      Work_Experience: {
        required: getTranslation(languages, "required_work_experience"),
      },
      Work_ExperienceEN: {
        required: getTranslation(languages, "required_work_experienceEN"),
      },
      Working_Time: {
        required: getTranslation(languages, "required_working_time"),
      },
      Working_TimeEN: {
        required: getTranslation(languages, "required_working_timeEN"),
      },
      Application_Deadline: {
        required: getTranslation(languages, "required_application_deadline"),
        dateGreaterOrEqualToday:
          "Vui lòng chọn ngày lớn hơn hoặc bằng ngày hiện tại",
      },
    },
    errorPlacement: function (error, element) {
      if (element.hasClass("js-example-basic-single")) {
        error.insertAfter(element.next(".select2"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: () => {
      $("#Job_Description_input").val(
        quills["Job_Description"]?.root.innerHTML || "",
      );
      $("#Job_DescriptionEN_input").val(
        quills["Job_DescriptionEN"]?.root.innerHTML || "",
      );
      $("#Request_Work_input").val(
        quills["Request_Work"]?.root.innerHTML || "",
      );
      $("#Request_WorkEN_input").val(
        quills["Request_WorkEN"]?.root.innerHTML || "",
      );
      $("#Compensation_Benefits_input").val(
        quills["Compensation_Benefits"]?.root.innerHTML || "",
      );
      $("#Compensation_BenefitsEN_input").val(
        quills["Compensation_BenefitsEN"]?.root.innerHTML || "",
      );
      let action =
        $("#saveWorkList").attr("check") == 1 ? "InsertWL" : "UpdateWL";
      $.ajax({
        url: "../data/data_work_list.php?Action=" + action,
        data: new FormData($("#create-worklist")[0]),
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
    },
  });
}

function editWorkList() {
  let table = $("#tb_work_list").DataTable();
  let row = getSelectedRow(table);
  // makeSelectReadonly("#DepID");

  if (row) {
    $("#modalWorkList").modal("show");
    $("#modal_title").html(getTranslation(languages, "edit_work_list"));

    //Fill data from table to modal
    quills["Job_Description"].setContents([]);
    quills["Request_Work"].setContents([]);
    quills["Job_Description"]?.clipboard.dangerouslyPasteHTML(
      row.Job_Description || "",
    );
    quills["Job_DescriptionEN"]?.clipboard.dangerouslyPasteHTML(
      row.Job_DescriptionEN || "",
    );
    quills["Request_Work"]?.clipboard.dangerouslyPasteHTML(
      row.Request_Work || "",
    );
    quills["Request_WorkEN"]?.clipboard.dangerouslyPasteHTML(
      row.Request_WorkEN || "",
    );
    quills["Compensation_Benefits"]?.clipboard.dangerouslyPasteHTML(
      row.Compensation_Benefits || "",
    );
    quills["Compensation_BenefitsEN"]?.clipboard.dangerouslyPasteHTML(
      row.Compensation_BenefitsEN || "",
    );

    $("#ID").val(row.ID);
    $("#DepID").val(row.Dep_ID).trigger("change").prop("disabled", true);
    $("#Number_Vacancies").val(row.Number_Vacancies);
    $("#Degree").val(row.Degree);
    $("#DegreeEN").val(row.DegreeEN);
    $("#Gender").val(row.Gender);
    $("#GenderEN").val(row.GenderEN);
    $("#Age_Range").val(row.Age_Range).prop("readonly", true);
    $("#Age_RangeEN").val(row.Age_RangeEN).prop("readonly", true);
    $("#Salary").val(row.Salary);
    $("#SalaryEN").val(row.SalaryEN);
    $("#Work_Experience").val(row.Work_Experience);
    $("#Work_ExperienceEN").val(row.Work_ExperienceEN);
    $("#Working_Time").val(row.Working_Time);
    $("#Working_TimeEN").val(row.Working_TimeEN);
    $("#Application_Deadline").val(row.Date_Applications);
    $("#Position_Level").val(row.Position_Level);
    $("#Job_Hot").prop("checked", row.Job_Hot == 1);
    $("#STATUS").prop("checked", row.STATUS == 1);

    $("#DepID-error").hide();
    $("#Number_Vacancies-error").hide();
    $("#Degree-error").hide();
    $("#DegreeEN-error").hide();
    $("#Gender-error").hide();
    $("#GenderEN-error").hide();
    $("#Age_Range-error").hide();
    $("#Age_RangeEN-error").hide();
    $("#Salary-error").hide();
    $("#SalaryEN-error").hide();
    $("#Work_Experience-error").hide();
    $("#Work_ExperienceEN-error").hide();
    $("#Working_Time-error").hide();
    $("#Working_TimeEN-error").hide();
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
      cancelButtonText: getTranslation(languages, "cancelButtonText"),
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../data/data_work_list.php?Action=DeleteWL",
          type: "POST",
          data: {
            ID: row.ID,
            Dep_ID: row.Dep_ID,
          },
          success: (json) => {
            let res = JSON.parse(json);
            if (res.status === "Success") {
              Swal.fire({
                icon: "success",
                title: res.message,
                showConfirmButton: false,
                timer: 1000,
              });
              $("#tb_work_list").DataTable().ajax.reload();
            } else {
              Swal.fire({
                title: res.message,
                icon: "error",
                confirmButtonText: "OK",
              });
            }
          },
        });
      }
    });
  } else {
    toastr.warning(getTranslation(languages, "alert_choose_row"));
  }
}
$("#modalListApply").on("hidden.bs.modal", function () {
  var table = $("#tb_work_list").DataTable();
  table.rows().deselect(); // clear hết selection
});

// $('#tb_list_applicant').on('shown.bs.modal', function () {
//     myTable.columns.adjust().draw(); // Tính toán lại và vẽ lại bảng
// });

function ShowListApply(Dep_ID, check) {
  let table = $("#tb_work_list").DataTable();
  let row = getSelectedRow(table);
  if (check == 1) {
    $("#SProcessing_Status").val("");
    $("#Upload_Date_From").val("");
    $("#Upload_Date_To").val("");
  }
  $("#modalListApply").modal("show");
  $("#modal_title_ListApply").html(getTranslation(languages, "list_applicant"));

  let SProcessing_Status = $("#SProcessing_Status").val();
  let Upload_Date_From = $("#Upload_Date_From").val();
  let Upload_Date_To = $("#Upload_Date_To").val();

  $("#tb_list_applicant").DataTable({
    language: {
      emptyTable: getTranslation(languages, "sEmptyTable"),
    },
    ajax: {
      type: "GET",
      url: "../data/data_list_applicant.php?Action=GetDataListApp",
      data: {
        Dep_ID: Dep_ID ? Dep_ID : row.Dep_ID,
        SProcessing_Status: SProcessing_Status,
        Upload_Date_From: Upload_Date_From,
        Upload_Date_To: Upload_Date_To,
      },
      dataSrc: function (res) {
        return res;
      },
    },
    columns: [
      {
        data: function (row) {
          if (!row.FullName) {
            return "-";
          }
          return `
                    <div style="display: flex; align-items: center;">
                      <i class="bi bi-person-circle" style="color: #012970; font-size: 1.3rem; margin-right: 8px;"></i>
                      <span style="font-weight: 500;">${row.FullName}</span>
                    </div>
                  `;
        },
      },
      {
        data: "PhoneNumber",
      },
      {
        data: "Birthday",
      },
      {
        data: "Email",
        data: function (row) {
          if (!row.Email) {
            return "-";
          } else {
            return row.Email;
          }
        },
      },
      {
        data: function (row) {
          if (!row.Processing_Status) {
            return "-";
          }

          let badgeClass = "";
          switch (row.Processing_Status) {
            case "Tiếp nhận":
              badgeClass = "bg-primary";
              break;
            case "Đã liên hệ":
              badgeClass = "bg-info text-dark";
              break;
            case "Phỏng vấn":
              badgeClass = "bg-warning text-dark";
              break;
            case "Nhận việc":
              badgeClass = "bg-success";
              break;
            case "Không phù hợp":
              badgeClass = "bg-secondary";
              break;
            case "Không liên lạc được":
              badgeClass = "bg-dark";
              break;
            case "Không đến phỏng vấn":
            case "Từ chối nhận việc":
              badgeClass = "bg-danger";
              break;
            default:
              badgeClass = "bg-light text-dark";
          }
          return `<span class="badge ${badgeClass}"><span style="font-size: 0.85em; margin-right: 4px; vertical-align: middle;">●</span>${row.Processing_Status}</span>`;
        },
      },
      {
        // data: "File_name",
        data: function (row) {
          if (!row.File_name) {
            return "-";
          } else {
            return `<a style="cursor: pointer;color: #e7c40c;" attr="" onclick="PDF_ListApp('${row.File_name}')" >${row.File_name}</a>`;
            //return `<a style="cursor: pointer;" href="//192.168.0.17/IT_Software2/ERP_Folder/WEB_HR/${row.File_name}" target="_blank">${row.File_name}</a>`;
          }
        },
      },
      {
        data: "CreateDate",
      },
    ],
    destroy: true,
    select: true,
    searching: false,
    ordering: false,
    info: false,
    autoWidth: true,
    drawCallback: function () {
      updateListApplyStats(this.api().ajax.json());
    },
  });
}
function PDF_ListApp(pdf) {
  // Qua file trung gian file_cv.php để giữ đường dẫn của web, không lộ port file-api
  window.open("../data/file_cv.php?name=" + encodeURIComponent(pdf));
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
        Processing_Status: { required: true },
      },
      messages: {
        Processing_Status: {
          required: getTranslation(languages, "required_progress_status"),
        },
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
          },
        });
      },
    });
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
      cancelButtonText: getTranslation(languages, "cancelButtonText"),
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
                timer: 1000,
              });
              $("#tb_list_applicant").DataTable().ajax.reload();
              $("#tb_work_list").DataTable().ajax.reload();
            } else {
              Swal.fire({
                title: res.message,
                icon: "error",
                confirmButtonText: "OK",
                timer: 1000,
              });
            }
          },
        });
      }
    });
  } else {
    toastr.warning(getTranslation(languages, "alert_choose_row"));
  }
}
function ExportExcel() {
  let Date_From = $("#User_Date_From").val();
  let Date_To = $("#User_Date_To").val();
  if (Date_From !== "" || Date_To !== "") {
    window.location.href = `../data/data_excel.php?Action=ExportExcel&Date_From=${Date_From}&Date_To=${Date_To}`;
  } else {
    toastr.warning("Vui lòng chọn khoảng thời gian cần xuất file");
    return;
  }
}
