
$(document).ready(function () {
  loadJobs(); // load lần đầu
  document.getElementById("phone").addEventListener("input", function (e) {
    this.value = this.value.replace(/[^0-9]/g, ""); 
  });
  closeModalJob();
  popularJob();
  categorySelected();
  
  //$('#dep_name').on("keyup",function(e){
    //if(e.key == "Enter"){
     // e.preventDefault();
     // searchDep();
   // }
 // })
});

function showSkeleton(count = 6) {
  let skeletons = '<div class="row g-3 skeleton">';

  for (let i = 0; i < count; i++) {
    skeletons += `
      <div class="col-md-4"> 
      <div class="card-job mb-3 p-4 placeholder-glow h-100">
        <h5 class="placeholder col-6"></h5>
        <p class="placeholder col-9"></p>
        <p class="placeholder col-7"></p>
        <p class="placeholder col-5"></p>
      </div>
      </div>
    `;
  }
  skeletons += '</div>'; 

  $("#job_list").html(skeletons);
}

function categorySelected(){
  $('.dropdown-menu .select-item').on("click", function(e){
    e.preventDefault();

    const category = $(this).data("value");
    const dep_name = $('#dep_name').val().trim();
    const text = $(this).text().trim();

    $(this).closest(".dropdown-menu").find(".select-item").removeClass("active");
    $(this).addClass("active");

    $("#selected_position").html(`<span style="color:var(--green-color); font-weight:bold;">${text}</span>`);

    loadJobs(dep_name, 1, category);
  })
}
function searchDep(){
  const dep_name = $("#dep_name").val().trim();
  const category = $(".dropdown-menu .select-item.active").data("value") || "";
  
   $("#suggestion_list").hide(); 
  loadJobs(dep_name, 1, category);
}

$("#dep_name").on("keydown", function (e) {
  if (e.key === "Enter") {
    e.preventDefault();
    searchDep(); 
  }
});

function loadJobs(dep_name = "", page = 1, category="") {
  const MIN_DELAY = 800; // 0.8s
  const startTime = Date.now();
  showSkeleton();
  const urlParams = new URLSearchParams(window.location.search);
  const langs = urlParams.get("lang") || "vn";
  $.ajax({
      url: "../src/data/data_job.php?Action=loadJobs",
      type: "GET",
      data: { Dep_Name: dep_name, page: page, lang: langs, Category: category },
      success: function (res) {
        const elapsed = Date.now() - startTime;
        const delay = Math.max(0, MIN_DELAY - elapsed);

        setTimeout(() => {
            $("#job_list").html(res);
        }, delay);
      },
      error: function (xhr, status, error) {
          console.error("AJAX Error:", status, error);
      }
  });
}



//gợi ý job
function popularJob(){
  $("#dep_name").on("keyup", function () {
    const keyword = $(this).val().trim();
    if (keyword.length < 1) {
      $("#suggestion_list").html(HOT_SEARCH_HTML); // clear nếu nhập ít hơn 2 ký tự
      return;
    }

    $.ajax({
      url: "../src/data/data_job.php?Action=popularJobs",
      type: "GET",
      data: { q: keyword },
      success: function (res) {
        $("#suggestion_list").html(res).show();
        // mở dropdown
        //$("#dep_name").dropdown("show");
      },
      error: function(){
       $("#suggestion_list").hide();
      },
    });
  });

  // click vào 1 gợi ý search ngay
  $(document).on("click", ".suggest-item", function (e) {
    e.preventDefault();
    const text = $(this).text().trim();
    $("#dep_name").val(text);
    //$("#dep_name").dropdown("hide"); // đóng dropdown
     $("#suggestion_list").hide();
    searchDep(); 
  });
}

function search(e){
  e.preventDefault();
  searchDep();
};

const defaultPositionHTML = $("#selected_position").parent().html();
function clearSearch(event){
  event.preventDefault();
  $('#dep_name').val("");
  $(".dropdown-menu .select-item").removeClass("active");
  $("#suggestion_list").hide();

  $(".location").html(defaultPositionHTML);

  loadJobs();
};

$(document).on("click", ".page-link-ajax", function(e) {
  e.preventDefault();
  const page = $(this).data("page");
  const search = $("#dep_name").val().trim();
  const category = $(".dropdown-menu .select-item.active").data("value") || "";
  loadJobs(search, page, category);

  $('html, body').animate({
      scrollTop: $("#job_list").offset().top - 100
  }, 300);
});



let fileRemoved = false;

function closeModalJob() {
  // reset form khi modal đóng
  document
    .getElementById("apply_now")
    .addEventListener("hidden.bs.modal", function () {
      let form = document.getElementById("apply_now_form");
      form.reset();

      document.getElementById("input_file").value = "";
      $("#apply_now_form").validate().resetForm();
      $(form).find(".error").removeClass("error").css({
        "border-color": "none",
      });
      btnFile();
    });
}

// Lấy giá trị lang từ URL, ví dụ ?lang=en
function getLangFromURL() {
  const params = new URLSearchParams(window.location.search);
  return params.get("lang") || "vn"; // mặc định là vn
}

const lang = getLangFromURL();
const textLang = {
  vn: {
    no_file: "Chưa có tệp nào",
  },
  en: {
    no_file: "No file selected",
  },
};

const inputFile = document.getElementById("input_file");
const fileText = document.getElementById("file_text");
const btnRemove = document.getElementById("btn_remove");

inputFile.addEventListener("change", function () {
  if (this.files.length > 0) {
    fileText.innerText = this.files[0].name;
    btnRemove.style.display = "inline-block";
  } else {
    fileText.innerText = textLang[lang].no_file;
  }
});

function btnFile() {
  inputFile.value = "";
  fileText.innerText = textLang[lang].no_file;
  btnRemove.style.display = "none";
}

btnRemove.addEventListener("click", btnFile);

const dep_name = document.getElementById("dep_name");
const dropdownItems = document.querySelectorAll(".popular");

dropdownItems.forEach((item) => {
  item.addEventListener("click", function (e) {
    e.preventDefault(); 
    dep_name.value = this.textContent.trim(); // lấy text của item gán vào input
  });
});


function applyNow(id, dep_name, lang) {
  $("#job_id").val(id);
  $("#job_name").text(dep_name);
  console.log(id);

  $.ajax({
    type: "POST",
    url: "../src/data/data_home.php?Action=CheckCategory",
    data: { Job_Id: id },
    success: function (response) {
      let res = JSON.parse(response);
    
      if (res && res.Position_Level === "CN") {
        $("#cv_hidden").hide();
        if ($("#apply_now_form").data("validator")) {
          $("#input_file").rules("remove", "required");
        }
      } else if (res && res.Position_Level === "VP") {
        $("#cv_hidden").show();
        if ($("#apply_now_form").data("validator")) {
          $("#input_file").rules("add", { required: true });
        }
      }
      
    }
  });

  $("#apply_now").modal("show");

  const validationMessages = {
    vn: {
      CV: {
        required: "Vui lòng chọn CV",
        formatPDF: "CV Không đúng định dạng PDF",
      },
      Name: { 
        required: "Họ và tên không được để trống",
        lettersonlyVN: "Họ và tên chỉ được nhập chữ cái"
       },
      Birthday: {
        required: "Ngày sinh không được để trống",
        minAge: "Bạn phải đủ 16 tuổi trở lên",
      },
      Phone: {
        required: "Số điện thoại không được để trống",
        phoneVN: "Số điện thoại bắt đầu bằng 0 và có 10 số",
      },
      Email: { email: "Email không đúng định dạng" },
    },
    en: {
      CV: {
        required: "Please select a CV",
        formatPDF: "CV PDF format is incorrect",
      },
      Name: { 
        required: "Full name is required",
        lettersonlyVN: "Full name must contain only letters"
       },
      Birthday: {
        required: "Birthday is required",
        minAge: "You must be at least 16 years old",
      },
      Phone: {
        required: "Phone number is required",
        phoneVN: "Phone number start with 0 and have 10 number",
      },
      Email: { email: "Email is not in correct format" },
    },
  };

  // Custom rule
  $.validator.addMethod(
    "formatPDF",
    function (value, element) {
      if (this.optional(element)) return true; 
      const ext = value.split(".").pop().toLowerCase();
      return ext === "pdf";
    },
    validationMessages[lang].CV && validationMessages[lang].CV.formatPDF
  );
  $.validator.addMethod(
    "lettersonlyVN",
    function (value, element) {
      if (this.optional(element)) return true;
      return /^[A-Za-zÀ-ỹ\s]+$/.test(value.trim());
    },
    validationMessages[lang].Name.lettersonlyVN
  );
  $.validator.addMethod(
    "phoneVN",
    function (value, element) {
      // Cho phép trống nếu không required
      if (this.optional(element)) return true;
      return /^0[0-9]{9}$/.test(value);
    },
    validationMessages[lang].Phone.phoneVN
  );
  $.validator.addMethod(
    "minAge",
    function (value, element, param) {
      if (!value) return false; // nếu rỗng
      const birthDate = new Date(value);
      const today = new Date();
      const age = today.getFullYear() - birthDate.getFullYear();
      const m = today.getMonth() - birthDate.getMonth();
      // Kiểm tra tháng/ngày để chính xác hơn
      const realAge = m < 0 || (m === 0 && today.getDate() < birthDate.getDate()) ? age - 1 : age;
      return realAge >= param;
    },
    validationMessages[lang].Birthday.minAge
  );
  $("#apply_now_form").validate({
    ignore: [], 
    rules: {
      CV: {
        required:{
          depends: function () {
            // nếu block cv đang hiển thị thì mới required
            return $("#cv_hidden").is(":visible");
          }
        },
        formatPDF: true,
      },
      Name: {
        required: true,
        lettersonlyVN: true,
      },
      Birthday: {
        required: true,
        minAge: 16,
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
        error.insertAfter("#file_text"); // chèn lỗi sau span file_text
      } else {
        error.insertAfter(element);
      }
    },
    highlight: function (element) {
      if ($(element).attr("name") === "CV") {
        $(element).closest(".form-control").addClass("border-danger");
      } else {
        $(element).addClass("is-invalid");
      }
    },
    unhighlight: function (element) {
      if ($(element).attr("name") === "CV") {
        $(element).closest(".form-control").removeClass("border-danger");
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
            });
            let jobId = formData.get("Job_Id");
            let name = formData.get("Name");
            let email = formData.get("Email");
            sendMail(jobId, name, email);
            $("#apply_now").modal("hide");
            $("#apply_now_form")[0].reset();
            btnFile();

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
            btnFile();
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

function onDescription(id, dep_name, job_description, request, benefit) {
  $("#job_id_describe").val(id);
  $("#job_name_describe").html(dep_name);
  $("#job_description").html(job_description);
  $("#job_request").html(request);
  $("#job_benefits").html(benefit);

  $("#exampleModal").modal("show");
}
