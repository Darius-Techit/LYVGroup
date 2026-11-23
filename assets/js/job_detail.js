$(document).ready(function () {
    document.getElementById("phone_detail").addEventListener("input", function (e) {
      this.value = this.value.replace(/[^0-9]/g, ""); 
    });

    const urlParams = new URLSearchParams(window.location.search);
    const job = urlParams.get("job");

    $.ajax({
      type: "POST",
      url: "../src/data/data_home.php?Action=CheckCategory",
      data: { Job_Id: job },
      success: function (response) {
        let res = JSON.parse(response);
      
        if (res && res.Position_Level === "CN") {
          $("#cv_detail").hide();
          if ($("#apply_now_form").data("validator")) {
            $("#input_file").rules("remove", "required");
          }
        } else if(res && res.Position_Level === "VP") {
          $("#cv_detail").show();
          if ($("#apply_now_form").data("validator")) {
            $("#input_file").rules("add", { required: true });
          }
        }
      }
    });
  });

  // Lấy giá trị lang từ URL, ví dụ ?lang=en
function getLangFromURL() {
  const params = new URLSearchParams(window.location.search);
  return params.get("lang") || "vn"; // mặc định là vn
}

const lang = getLangFromURL();
const textLang = {
  vn: {
    no_file: "Đính kèm CV tại đây!",
  },
  en: {
    no_file: "No file selected",
  },
};
const inputFile = document.getElementById("input_file");
const fileText = document.getElementById("blah");
const btnRemove = document.getElementById("btn_cv");

inputFile.addEventListener("change", function () {
  if (this.files.length > 0) {
    fileText.value = this.files[0].name;
    btnRemove.style.display = "inline-block";
  } else {
    fileText.value = textLang[lang].no_file;
  }
});

function btnFile() {
  inputFile.value = "";
  fileText.value = textLang[lang].no_file;
  btnRemove.style.display = "none";
}

btnRemove.addEventListener("click", btnFile);
  
  
  function applyNow(lang) {
    
    const validationMessages = {
      vn: {
        CV: { required: "Vui lòng chọn CV" },
        Name: { required: "Họ và tên không được để trống" },
        Birthday: { required: "Ngày sinh không được để trống" },
        Phone: {
          required: "Số điện thoại không được để trống",
          phoneVN: "Số điện thoại phải bắt đầu bằng 0 và có đúng 10 số",
        },
        Email: { email: "Email không đúng định dạng" },
      },
      en: {
        CV: { required: "Please select a CV" },
        Name: { required: "Full name is required" },
        Birthday: { required: "Birthday is required" },
        Phone: {
          required: "Phone number is required",
          phoneVN: "Phone number must start with 0 and have exactly 10 digits",
        },
        Email: { email: "Email is not in correct format" },
      },
    };
    $.validator.addMethod(
      "phoneVN",
      function (value, element) {
        // Cho phép trống nếu không required
        if (this.optional(element)) return true;
        return /^0[0-9]{9}$/.test(value);
      },
      validationMessages[lang].Phone.phoneVN
    );
   
    $("#apply_now_form").validate({
      ignore: [],
      rules: {
        CV: {
          required:{
            depends: function () {
              return $("#cv_detail").is(":visible");
            }
          }
        },
        Name: {
          required: true,
        },
        Birthday: {
          required: true,
        },
        Phone: {
          required: true,
          phoneVN: true,
        },
      Email:{
        email: true,
      }
    },
    messages: validationMessages[lang],
    errorPlacement: function (error, element) {
      if (element.attr("name") === "CV") {
        error.insertAfter("#blah"); // hiển thị lỗi ngay dưới ô text
      } else {
        error.insertAfter(element);
      }
    },
    highlight: function (element) {
      if ($(element).attr("name") === "CV") {
        $("#blah").addClass("border-danger"); // tô viền đỏ cho ô text
      } else {
        $(element).addClass("is-invalid");
      }
    },
    unhighlight: function (element) {
      if ($(element).attr("name") === "CV") {
        $("#blah").removeClass("border-danger");
      } else {
        $(element).removeClass("is-invalid");
      }
    },
    
    
    submitHandler: function (form) {
      let formData = new FormData(form);
      const urlParams = new URLSearchParams(window.location.search);
      const langs = urlParams.get("lang") || "vn";
  
        $.ajax({
          type: "POST",
          url: `../src/data/data_home.php?Action=addApply&lang=${langs}`,
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            let res = JSON.parse(response);
            if (res.status === true) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: res.Info,
                showConfirmButton: false,
                timer: 1500,
                // willClose: () => {
                //     window.location.href = "./pages/job.php";
                // }
              }).then(() => {
                location.reload(); 
              });
            let jobId = formData.get("Job_Id");
            let name = formData.get("Name");
            let email = formData.get("Email");
            sendMail(jobId, name, email);
            } else {
              Swal.fire({
                title: res.Info,
                icon: "error",
                confirmButtonText: "OK",
                customClass: {
                  confirmButton: "btn btn-success",
                },
                buttonsStyling: false,
              });
            }
          },
        });
      },
    });
  }
  
  function sendMail(jobId, name, email) {
  $.ajax({
    url: "/LYVGroup/src/sendmail.php?Action=sendMail",
    type: "POST",
    data: {
      jobId: jobId,
      name: name,
      email: email,
    },
  });
}
  
  
  
  