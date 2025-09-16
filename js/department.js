toastr.options = {
    closeButton: true,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "600",
    timeOut: "5000",
};
$(function () {
    onQueryDep();

});
let languages = localStorage.getItem("languages");
const translations = {
    en: {
        add_department: "Add Department",
        edit_department: "Edit Department",
        required_depname: "Please enter Department Name",
        alert_choose_row: "Please select a row first!",
    },
    vn: {
        add_department: "Thêm Bộ Phận",
        edit_department: "Chỉnh sửa bộ phận",
        required_depname: "Vui lòng nhập tên bộ phận",
        alert_choose_row: "Vui lòng! bạn cần phải chọn 1 dòng trong bảng dữ liệu",
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
function onQueryDep() {
    let DepName = $("#sr_DepName").val();
    let DepNameEN = $("#sr_DepNameEN").val();
    $("#tb_department").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_department.php?Action=GetDataDep",
            data: {
                DepName: DepName,
                DepNameEN: DepNameEN
            },
            dataSrc: function (res) {
                return res;
            }
        },
        columns: [
            {
                data: "Dep_Name",
            },
            {
                data: "Dep_NameEN",
            }
        ],
        destroy: true,
        select: true,
        searching: false,
        ordering: true,
        info: false,
    });
}

function addDep(check) {
    $("#saveDept").attr("check", check);
    if ($("#saveDept").attr("check") == 1) {
        $("#modalDepartment").modal("show");
        $("#modal_title").html(getTranslation(languages, "add_department"));

        $("#DepName").val("");
        $("#DepNameEN").val("");

        $("#DepName-error").hide();
    }

    $("#create-department").validate({
        rules: {
            DepName: { required: true }
        },
        messages: {
            DepName: { required: getTranslation(languages, "required_depname") }
        },
        submitHandler: () => {
            let action = ($("#saveDept").attr("check") == 1) ? "InsertDep" : "UpdateDep";
            $.ajax({
                url: "../data/data_department.php?Action=" + action,
                data: new FormData(document.getElementById('create-department')),
                type: "POST",
                contentType: false,
                processData: false,
                success: (json) => {
                    res = JSON.parse(json);
                    if (res.status == "Success") {
                        toastr.success(res.message);
                        $("#modalDepartment").modal("hide");
                        $("#tb_department").DataTable().ajax.reload();
                    } else {
                        toastr.error(res.message);
                    }
                },
            });
        },
    });
}
function editDep() {
    let table = $("#tb_department").DataTable();
    let row = getSelectedRow(table);
    if (row) {
        $("#modalDepartment").modal("show");
        $("#modal_title").html(getTranslation(languages, "edit_department"));

        $("#DepID").val(row.Dep_ID);
        $("#DepName").val(row.Dep_Name);
        $("#DepNameEN").val(row.Dep_NameEN);

        $("#DepName-error").hide();
        addDep(2);
    }
    else {
        toastr.warning(getTranslation(languages, "alert_choose_row"));
    }
}
function removeDep() {
    let table = $("#tb_department").DataTable();
    let row = getSelectedRow(table);
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
                    url: "../data/data_department.php?Action=DeleteDep",
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
                            $("#tb_department").DataTable().ajax.reload();
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