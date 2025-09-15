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
    onQueryDep();

});
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
        $("#modal_title").html("Add Department");

        $("#DepName").val("");
        $("#DepNameEN").val("");

        $("#DepName-error").hide();
    }

    $("#create-department").validate({
        rules: {
            DepName: { required: true }
        },
        messages: {
            DepName: { required: "Please enter Department Name" }
        },
        submitHandler: () => {
            if ($("#saveDept").attr("check") == 1) {
                $.ajax({
                    url: "../data/data_department.php?Action=InsertDep",
                    data: new FormData(document.getElementById('create-department')),
                    type: "POST",
                    contentType: false,
                    processData: false,
                    success: (json) => {
                        res = JSON.parse(json);
                        if (res.status == "Success") {
                            toastr.success(res.message, "Info");
                            $("#modalDepartment").modal("hide");
                            $("#tb_department").DataTable().ajax.reload();
                        } else {
                            toastr.error(res.message, "Info");
                        }
                    },
                });
            } else {
                $.ajax({
                    url: "../data/data_department.php?Action=UpdateDep",
                    data: new FormData(document.getElementById('create-department')),
                    type: "POST",
                    contentType: false,
                    processData: false,
                    success: (json) => {
                        res = JSON.parse(json);
                        if (res.status == "Success") {
                            toastr.success(res.message, "Info");
                            $("#modalDepartment").modal("hide");
                            $("#tb_department").DataTable().ajax.reload();
                        } else {
                            toastr.error(res.message, "Info");
                        }
                    },
                });
            }
        },
    });
}
function editDep() {
    let table = $("#tb_department").DataTable();
    let row = getSelectedRow(table);
    if (row) {
        $("#modalDepartment").modal("show");
        $("#modal_title").html("Edit Department");

        $("#DepID").val(row.Dep_ID);
        $("#DepName").val(row.Dep_Name);
        $("#DepNameEN").val(row.Dep_NameEN);

        $("#DepName-error").hide();
        addDep(2);
    }
    else {
        toastr.warning("Please choose row need Edit", "Info");
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
        toastr.warning("Please choose row need Delete", "Info");
    }
}