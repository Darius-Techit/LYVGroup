$(document).ready(function () {
  const cardCount = $(".card-item").length; // đếm số card
  if (cardCount < 3) {
    $(".next-btn, .prev-btn").hide(); // ẩn nút (thay id/class nút thật của bạn)
  } else {
    $(".next-btn, .prev-btn").show();
  }

  const newCount = $(".card-new").length;
  if (newCount < 3) {
    $(".next-btn-new, .prev-btn-new").hide(); // ẩn nút (thay id/class nút thật của bạn)
  } else {
    $(".next-btn-new, .prev-btn-new").show();
  }

  closeModal();

});


// carousel job hot
const carousel = document.getElementById("carousel");
const cardItem = document.querySelector(".card-item"); // 1 card mẫu
const nextBtn = document.querySelector(".next-btn");
const prevBtn = document.querySelector(".prev-btn");
const indicatorsContainer = document.getElementById("indicators");

const GAP = 30; // khoảng cách giữa các card (match CSS)
let itemsPerSlide,
  totalSlides,
  slideWidth,
  currentIndex = 0,
  totalItems;
let slideStarts = [];
let isProgrammatic = false; // flag khi ta điều khiển programmatically

function getItemsPerSlide() {
  // khớp breakpoint trong home.css (.hj-carousel .card-item)
  if (window.innerWidth < 576) return 1;
  if (window.innerWidth < 1200) return 2;
  return 3;
}

// start index (item) cho 1 slide; đảm bảo slide cuối ALWAYS có đủ itemsPerSlide
function getSlideStartIndex(slideIndex) {
  let start = slideIndex * itemsPerSlide;
  if (slideIndex === totalSlides - 1 && totalItems % itemsPerSlide !== 0) {
    start = Math.max(totalItems - itemsPerSlide, 0);
  }
  return start;
}

function computeSlideStarts() {
  slideStarts = [];

  const unit = cardItem.offsetWidth + GAP;
  for (let i = 0; i < totalSlides; i++) {
    const startItemIndex = getSlideStartIndex(i);
    slideStarts.push(startItemIndex * unit);
  }
}

function updateIndicators(idx) {
  // selector dùng id #indicators để chính xác
  document.querySelectorAll("#indicators span").forEach((dot, i) => {
    dot.classList.toggle("active", i === idx);
  });
}

function goToSlide(index, smooth = true) {
  if (index < 0) index = 0;
  if (index > totalSlides - 1) index = totalSlides - 1;
  const targetLeft = slideStarts[index] || 0;
  isProgrammatic = true;
  if (smooth) {
    carousel.scrollTo({
      left: targetLeft,
      behavior: "smooth",
    });
    // ước lượng thời gian animation, có thể điều chỉnh (ms)
    setTimeout(() => {
      isProgrammatic = false;
    }, 500);
  } else {
    carousel.scrollLeft = targetLeft;
    // ngay lập tức clear flag (hay vẫn để 1 tick cho an toàn)
    setTimeout(() => {
      isProgrammatic = false;
    }, 10);
  }
  currentIndex = index;
  updateIndicators(currentIndex);
}

function setupCarousel() {
  itemsPerSlide = getItemsPerSlide();
  totalItems = document.querySelectorAll(".card-item").length;
  totalSlides = Math.max(Math.ceil(totalItems / itemsPerSlide), 1);

  const cardItem = document.querySelector(".card-item");
  if (!cardItem) {
    console.log("Không có data");
    return;
  }
  const unit = cardItem.offsetWidth + GAP;
  slideWidth = unit * itemsPerSlide;

  computeSlideStarts();

  // Reset indicators
  indicatorsContainer.innerHTML = "";
  for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement("span");
    if (i === 0) dot.classList.add("active");
    dot.addEventListener("click", () => goToSlide(i));
    indicatorsContainer.appendChild(dot);
  }

  currentIndex = 0;
  // scroll tới vị trí slide 0
  carousel.scrollLeft = slideStarts[0] || 0;
  updateIndicators(currentIndex);
}

// Next / Prev dùng goToSlide
nextBtn.addEventListener("click", () => {
  const next = currentIndex >= totalSlides - 1 ? 0 : currentIndex + 1;
  goToSlide(next);
});
prevBtn.addEventListener("click", () => {
  const prev = currentIndex <= 0 ? totalSlides - 1 : currentIndex - 1;
  goToSlide(prev);
});

// Khi user scroll (kéo), tìm slide gần nhất
carousel.addEventListener("scroll", () => {
  if (isProgrammatic) return; // bỏ qua khi do code gây ra (tùy chọn)
  const left = carousel.scrollLeft;
  // tìm chỉ số slide có start gần nhất với left
  let closestIdx = 0;
  let minDist = Math.abs(left - slideStarts[0]);
  for (let i = 1; i < slideStarts.length; i++) {
    const d = Math.abs(left - slideStarts[i]);
    if (d < minDist) {
      minDist = d;
      closestIdx = i;
    }
  }
  if (closestIdx !== currentIndex) {
    currentIndex = closestIdx;
    updateIndicators(currentIndex);
  }
});

// Init + resize
setupCarousel();
window.addEventListener("resize", () => {
  // small debounce để tránh tính liên tục khi resize
  clearTimeout(window._carousel_resize_timer);
  window._carousel_resize_timer = setTimeout(() => {
    setupCarousel();
  }, 80);
});

//carousel new list
const carousel_new = document.getElementById("carousel_news");
const cards = document.querySelectorAll(".card-new");
const prevBtn_new = document.getElementById("prevBtnNew");
const nextBtn_new = document.getElementById("nextBtnNew");

const gap = 30;
let cardsPerView = getCardsPerView();
const totalCards = cards.length;
let currentIndexNew = 0;

// function isMobile() {
//   return window.innerWidth <= 25;
// }
function getCardsPerView() {
  const width = window.innerWidth;
  if (width >= 1023) return 3; // desktop
  if (width >= 767) return 2;  // tablet
  return 1;                    // mobile
}

// function updateCarousel() {
//   // if (isMobile()) {
//   //   carousel_new.style.transform = "none";
//   // } else {
//     if (!cards || cards.length === 0) return;
//     const cardWidth = cards[0].offsetWidth + gap;
//     carousel_new.style.transform = `translateX(-${currentIndexNew * cardWidth
//       }px)`;
//   // }
// }

function updateCarousel() {
  if (!cards || cards.length === 0) return;

  const effectiveCardsPerView = Math.min(cardsPerView, totalCards);
  const cardWidth = cards[0].offsetWidth + gap;

  // Đảm bảo cuộn đến vị trí đúng
  carousel_new.scrollLeft = currentIndexNew * cardWidth;

  // Kiểm tra và giới hạn index
  if (currentIndexNew < 0) currentIndexNew = 0;
  if (currentIndexNew > totalCards - effectiveCardsPerView) {
    currentIndexNew = totalCards - effectiveCardsPerView;
  }
}
nextBtn_new.addEventListener("click", () => {
  currentIndexNew++;
  // nếu đã đi quá cuối thì quay lại đầu
  if (currentIndexNew > totalCards - cardsPerView) {
    currentIndexNew = 0;
  }
  updateCarousel();
});

prevBtn_new.addEventListener("click", () => {
  currentIndexNew--;
  // nếu lùi quá thì nhảy về cuối
  if (currentIndexNew < 0) {
    currentIndexNew = totalCards - cardsPerView;
  }
  updateCarousel();
});
// init
window.addEventListener("resize", updateCarousel);
updateCarousel();

// const carousel_new = document.getElementById("carousel_news");
// const cards = document.querySelectorAll(".card-new");
// const prevBtn_new = document.getElementById("prevBtnNew");
// const nextBtn_new = document.getElementById("nextBtnNew");

// const gap = 30;
// let cardsPerView = getCardsPerView();
// const totalCards = cards.length;
// let currentIndexNew = 0;

// function getCardsPerView() {
//   const width = window.innerWidth;
//   if (width >= 1023) return 3; // Desktop
//   if (width >= 767) return 2;  // Tablet
//   return 1;                    // Mobile
// }

// function updateCarousel() {
//   if (!cards || cards.length === 0) return;

//   const effectiveCardsPerView = Math.min(cardsPerView, totalCards);
//   const cardWidth = cards[0].offsetWidth + gap;

//   // Đảm bảo cuộn đến vị trí đúng
//   carousel_new.scrollLeft = currentIndexNew * cardWidth;

//   // Kiểm tra và giới hạn index
//   if (currentIndexNew < 0) currentIndexNew = 0;
//   if (currentIndexNew > totalCards - effectiveCardsPerView) {
//     currentIndexNew = totalCards - effectiveCardsPerView;
//   }
// }

// nextBtn_new.addEventListener("click", () => {
//   if (currentIndexNew < totalCards - Math.min(cardsPerView, totalCards)) {
//     currentIndexNew++;
//   } else {
//     currentIndexNew = 0; // Quay lại đầu
//   }
//   updateCarousel();
// });

// prevBtn_new.addEventListener("click", () => {
//   if (currentIndexNew > 0) {
//     currentIndexNew--;
//   } else {
//     currentIndexNew = totalCards - Math.min(cardsPerView, totalCards); // Quay về cuối
//   }
//   updateCarousel();
// });

// // Xử lý resize
// function debounce(func, wait) {
//   let timeout;
//   return function (...args) {
//     clearTimeout(timeout);
//     timeout = setTimeout(() => func.apply(this, args), wait);
//   };
// }

// window.addEventListener(
//   "resize",
//   debounce(() => {
//     cardsPerView = getCardsPerView();
//     updateCarousel();
//   }, 100)
// );

// // Khởi tạo
// updateCarousel();

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


// let fileRemoved = false;
const inputFile = document.getElementById("input_file");
const fileText = document.getElementById("file_text");
const btnRemove = document.getElementById("btn_remove");
// xóa file đã up lên
inputFile.addEventListener("change", function () {
  if (this.files.length > 0) {
    fileText.innerText = this.files[0].name;
    btnRemove.style.display = "inline-block";
  } else {
    fileText.innerText =textLang[lang].no_file;
  }
});
//file ở giao diện
function btnFile() {
  inputFile.value = "";
  fileText.innerText = textLang[lang].no_file;
  btnRemove.style.display = "none";
}

btnRemove.addEventListener("click", btnFile);


function onApply(id, dep_name, lang) {
  $("#job_id").val(id);
  $("#job_name").text(dep_name);
  //check VP, CN
  $.ajax({
    type: "POST",
    url: "./src/data/data_home.php?Action=CheckCategory",
    data: { Job_Id: id },
    success: function (response) {
      let res = JSON.parse(response);

      if (res && res.Position_Level === "CN") {
        $("#cv_block").hide();
        if ($("#apply_form").data("validator")) {
          $("#input_file").rules("remove", "required");
        }
      } else if (res && res.Position_Level === "VP") {
        $("#cv_block").show();
        if ($("#apply_form").data("validator")) {
          $("#input_file").rules("add", { required: true });
        }
      }
    },
  });
  $("#modal_apply").modal("show");
  //validate
  const validationMessages = {
    vn: {
      CV: {
        required: "Vui lòng chọn CV",
        formatPDF: "CV Không đúng định dạng PDF",
      },
      Name: {
        required: "Họ và tên không được để trống",
        lettersonlyVN: "Họ và tên chỉ được nhập chữ cái",
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
        lettersonlyVN: "Full name must contain only letters",
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
      if (this.optional(element)) return true; // bỏ qua nếu không bắt buộc
      const ext = value.split(".").pop().toLowerCase();
      return ext === "pdf";
    },
    validationMessages[lang].CV.formatPDF
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
      const realAge =
        m < 0 || (m === 0 && today.getDate() < birthDate.getDate())
          ? age - 1
          : age;
      return realAge >= param;
    },
    validationMessages[lang].Birthday.minAge
  );
  $("#apply_form").validate({
    ignore: [],
    rules: {
      CV: {
        required: {
          depends: function () {
            return $("#cv_block").is(":visible");
          },
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
      Email: {
        email: true,
      },
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
        url: `./src/data/data_home.php?Action=addApply&lang=${langs}`,
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
              timer: 2000,
              // willClose: () => {
              //     window.location.href = "./index.php";
              // }
            });
            let jobId = formData.get("Job_Id");
            let name = formData.get("Name");
            let email = formData.get("Email");
            sendMail(jobId, name, email);
            $("#apply_form")[0].reset();
            $("#input_file").val("");
            $("#modal_apply").modal("hide");
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
    url: "src/sendmail.php?Action=sendMail",
    type: "POST",
    data: {
      jobId: jobId,
      name: name,
      email: email,
    },
  });
}

function onDescription(id, dep_name, job_description, request, compensation) {
  $("#job_id_describe").val(id);
  $("#job_name_describe").html(dep_name);
  $("#job_description").html(job_description);
  $("#job_request").html(request);
  $("#job_compensation").html(compensation);

  $("#exampleModal").modal("show");
}

function closeModal(){
  $("#modal_apply").on("hidden.bs.modal", function () {
    let form = document.getElementById("apply_form");
    form.reset(); // reset input text, email, number...

    $("#input_file").val("");
    btnFile();

    $("#apply_form").validate().resetForm();
    $(form).find(".error").removeClass("error").css({
      "border-color": "none",
    });

  });
}
 
// animation
document.addEventListener("DOMContentLoaded", function () {
  const titles = document.querySelectorAll(".title-name");
  const items = document.querySelectorAll(".carousel-wrapper");
  const prevs = document.querySelectorAll(".prev-btn");
  const nexts = document.querySelectorAll(".next-btn");
  const jobs = document.querySelectorAll(".card-job");
  const intros = document.querySelectorAll(".intro");
  const news = document.querySelectorAll(".card-new");
  const prev_news = document.querySelectorAll(".prev-btn-new");
  const next_news = document.querySelectorAll(".next-btn-new");
  const applies = document.querySelectorAll(".application");
  const arrows = document.querySelectorAll(".arrow");
  const steps = document.querySelectorAll(".step");
  const footers = document.querySelectorAll(".footer");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.classList.add("show");
        }, index * 150); // tạo hiệu ứng delay lần lượt
        observer.unobserve(entry.target); // chỉ animate 1 lần
      }
    });
  }, { threshold: 0.2 });
  titles.forEach(title => observer.observe(title));
  items.forEach(item => observer.observe(item));
  prevs.forEach(prev => observer.observe(prev));
  nexts.forEach(next => observer.observe(next));
  jobs.forEach(job => observer.observe(job));
  intros.forEach(intro => observer.observe(intro));
  news.forEach(news => observer.observe(news));
  prev_news.forEach(prev_new => observer.observe(prev_new));
  next_news.forEach(next_new => observer.observe(next_new));
  applies.forEach(apply => observer.observe(apply));
  arrows.forEach(arrow => observer.observe(arrow));
  steps.forEach(step => observer.observe(step));
  footers.forEach(footer => observer.observe(footer));
});

