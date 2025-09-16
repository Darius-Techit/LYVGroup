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
    onQueryUser();
});
function getSelectedRow(table) {
    return table.rows(".selected").data()[0];
}
function onQueryUser() {
    $("#tb_user_management").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_user_management.php?Action=GetDataUser",
            dataSrc: function (res) {
                return res;
            }
        },
        columns: [
            {
                data: "IDUser",
            },
            {
                data: "UserName",
            },
            {
                data: "Permission",
            },
            {
                data: "UserID",
            },
            {
                data: "UserDate",
            }
        ],
        destroy: true,
        select: true,
        searching: false,
        ordering: true,
        info: false,
    })
}
function addUser(check) {
    $("#saveUserM").attr("check", check);
    if ($("#saveUserM").attr("check") == 1) {
        $("#modalUserManagement").modal("show");
        $("#modal_title").html("Add User Management");
        $("#IDUser").prop("disabled", false);
        $("#IDUser").val("");
        $("#Password").val("");
        $("#UserName").val("");
        $("#Permission").val("");

        $("#IDUser-error").hide();
        $("#Password-error").hide();
        $("#UserName-error").hide();
        $("#Permission-error").hide();
    }
    $("#create-user-management").validate({
        rules: {
            IDUser: {
                required: true,
            },
            Password: {
                required: true,
            },
            UserName: {
                required: true,
            },
            Permission: {
                required: true,
            }
        },
        messages: {
            IDUser: {
                required: "Please enter ID User",
            },
            Password: {
                required: "Please enter Password",
            },
            UserName: {
                required: "Please enter User Name",
            },
            Permission: {
                required: "Please select Permission",
            }
        },
        submitHandler: () => {
            let action = ($("#saveUserM").attr("check") == 1)
                ? "InsertUser" : "UpdateUser";
            $.ajax({
                url: "../data/data_user_management.php?Action=" + action,
                data: new FormData($("#create-user-management")[0]),
                type: "POST",
                contentType: false,
                processData: false,
                success: (json) => {
                    let res = JSON.parse(json);
                    if (res.status == "Success") {
                        toastr.success(res.message, "Success");
                        $("#modalUserManagement").modal("hide");
                        $("#tb_user_management").DataTable().ajax.reload();
                    } else {
                        toastr.error(res.message, "Info");
                    }
                }
            });
        }
    })
}
function editUser() {
    let table = $("#tb_user_management").DataTable();
    let row = getSelectedRow(table);
    if (row) {
        $("#modalUserManagement").modal("show");
        $("#modal_title").html("Edit User Management");

        $("#IDUser").prop("disabled", true);
        $("#IDHidden").val(row.IDUser);
        $("#IDUser").val(row.IDUser);
        $("#Password").val(row.Password);
        $("#UserName").val(row.UserName);
        $("#Permission").val(row.Permission);

        $("#IDUser-error").hide();
        $("#Password-error").hide();
        $("#UserName-error").hide();
        $("#Permission-error").hide();

        addUser(2);
    } else {
        toastr.warning("Please choose row need Edit", "Info");
    }
}
function removeUser() {
    let table = $("#tb_user_management").DataTable();
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
                    url: "../data/data_user_management.php?Action=DeleteUser",
                    type: "POST",
                    data: {
                        IDUser: row.IDUser
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
                            $("#tb_user_management").DataTable().ajax.reload();
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
        toastr.warning("Please choose row need Delete", "Info")
    }
}