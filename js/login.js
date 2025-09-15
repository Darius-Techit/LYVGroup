$(function () {
    Login();
    sessionStorage.clear();
});

// const Toast = Swal.mixin({
//     toast: true,
//     position: "top-end",
//     showConfirmButton: false,
//     timer: 3000,
//     timerProgressBar: true,
//     didOpen: (toast) => {
//         toast.onmouseenter = Swal.stopTimer;
//         toast.onmouseleave = Swal.resumeTimer;
//     }
// });

function Login() {
    $("#login_form").validate({
        rules: {
            userid: {
                required: true,
                // maxlength: 15,
            },
            password: {
                required: true,
                // minlength: 3,
            },
        },
        messages: {
            userid: {
                required: "Please Enter Your UserID",
                // maxlength: "Enter no more than 15 characters!",
            },
            password: {
                required: "Please Enter Your Password",
                // minlength: "Enter at least 3 characters!",
            },
        },
        submitHandler: function () {
            $.ajax({
                url: "data/data_login.php?Action=Login",
                data: $("#login_form").serialize(),
                type: "POST",
                success: (json) => {
                    let res = JSON.parse(json);
                    if (res.status === 'success') {
                        sessionStorage.setItem("userid", res?.userid);
                        Swal.fire({
                            timer: 1000,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                            willClose: () => {
                                window.location.href = "modules/department.php";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: res.message,
                            icon: "error",
                            confirmButtonText: 'OK',
                        });
                        $("#password").val("");
                    }
                },
            });
        },
    });
}
