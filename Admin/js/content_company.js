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
    onQueryContent();
    imageContent(
        `image-content`,
        `preview-img-content`,
        `image-icon-content`,
        `image-content-hidden`,
        `close-image-content`
    );
    $(".close-image").on("click", function () {
        const closeBtn = $(this);

        Swal.fire({
            title: "Do you want to delete this image?",
            font: "16px",
            icon: "question",
            // iconColor: "#ff0000",
            showCancelButton: true,
            confirmButtonColor: "#0d6efd",
            cancelButtonColor: "red",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                const imageId = closeBtn.attr("id")?.split("-")[2];
                const previewImage = $(`#preview-img-${imageId}`);
                const fileInput = $(`#image-${imageId}`);
                const hiddenInput = $(`#image-${imageId}-hidden`);
                const imageIcon = $(`#image-icon-${imageId}`);

                // Xóa hình ảnh và reset các input
                previewImage.attr("src", "").hide();
                fileInput.val("");
                hiddenInput.val("");
                closeBtn.hide(); // Ẩn nút xóa
                imageIcon.show(); // Hiển thị lại icon placeholder
            }
        });
    });
});

let languages = localStorage.getItem("languages");
const translations = {
    en: {
        add_news: "Add News",
        edit_news: "Edit News",
        required_news: "Please enter News Content",
        alert_choose_row: "Please select a row first!",
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: 'Cancel',
        required_title: 'Please enter Title Name',
        required_description: 'Please enter Description Content',
        required_img: 'Please selected Image',
        view_new: 'View content',
        image_uploading: 'Images are still uploading, please wait and save again',
        image_upload_error: 'Could not upload images in the content',
        save_error: 'Save failed, server error',
    },
    vn: {
        add_news: "Thêm Tin Tức",
        edit_news: "Chỉnh sửa Tin Tức",
        required_news: "Vui lòng nhập nội dung tin tức",
        alert_choose_row: "Vui lòng! bạn cần phải chọn 1 dòng trong bảng dữ liệu",
        title: "Bạn có chắc không?",
        text: "Bạn sẽ không thể hoàn tác điều này!",
        confirmButtonText: "Có, xóa!",
        cancelButtonText: 'Hủy bỏ',
        required_title: 'Vui lòng nhập Tên tiêu đề',
        required_description: 'Vui lòng nhập Mô tả nội dung',
        required_img: 'Vui lòng chọn ảnh cho nội dung',
        view_new: 'Xem trước',
        image_uploading: 'Ảnh đang được tải lên, vui lòng đợi rồi lưu lại',
        image_upload_error: 'Không tải được ảnh trong nội dung lên server',
        save_error: 'Lưu thất bại, lỗi từ server',
    }
}

function getTranslation(lang, key) {
    if (translations[lang] && translations[lang][key]) {
        return translations[lang][key];
    }
    return translations.en[key];
}

function debounce(func, wait) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), wait);
  };
}

function getSelectedRow(table) {
    return table.rows(".selected").data()[0];
}

function updateContentStats(json) {
    let total = (json && typeof json.recordsTotal !== "undefined") ? json.recordsTotal : 0;
    $("#cc-stat-total").text(total);
}

function onQueryContent() {
    let User_Date_From = $("#User_Date_From").val();
    let User_Date_To = $("#User_Date_To").val();
    $("#tb_content").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_content_company.php?Action=GetDataContent",
            data: {
                User_Date_From: User_Date_From,
                User_Date_To: User_Date_To
            },
            dataSrc: function (res) {
                return res.data;
            },
        },
        drawCallback: function () {
            updateContentStats(this.api().ajax.json());
        },
        columns: [
            {
                data: "Image_Content",
                render: function (data) {
                    if (!data) return '';

                    return `<img src="${data}" alt="" class="cc-img-thumb" /> `;
                },
            },
            {
                data: "Title_Name",
                render: function (data) {
                    return `<div class="truncate">${data}</div>`
                }
            },
            {
                data: "Description_Content",
                render: function (data) {
                    return `<div class="truncate">${data}</div>`
                }
            },
        ],
        destroy: true,
        select: true,
        searching: false,
        ordering: true,
        info: false,
        serverSide: true,
        processing: true,
        deferRender: true, // Chỉ render các dòng hiển thị trên màn hình
        pageLength: 5,
        scrollX: true,
    });
}
function addContent(check) {
    $("#saveContent").attr("check", check);
    $("#preview-img-content").show();
    $("#close-image-content").show();
    $("#image-icon-content").hide();

    if ($("#saveContent").attr("check") == 1) {
        $("#modalContent").modal("show");
        $("#modal_title").html(getTranslation(languages, "add_news"));

        $("#title_name").val("");
        $("#title_name_en").val("");
        $("#description_content").val("");
        $("#description_content_en").val("");

        $("#check_news").prop("checked") ? 1 : 0;

        window.editors["PostEditor"].setData("");
        window.editors["PostEditorEN"].setData("");

        $("#preview-img-content").hide();
        $("#close-image-content").hide();
        $("#image-icon-content").show();
    }

    $("#create-content").validate({
        ignore: [], // rất quan trọng, để không bỏ qua textarea ẩn
        rules: {
            PostEditor: {
                required: function () {
                    return !window.editors["PostEditor"].getData().trim();
                }
            },
            Image_Content: {
                required: true
            },
            Title_Name: {
                required: true
            },
            Description_Content: {
                required: true
            }
        },
        messages: {
            PostEditor: {
                required: getTranslation(languages, "required_news")
            },
            Image_Content: {
                required: getTranslation(languages, "required_img")
            },
            Title_Name: {
                required: getTranslation(languages, "required_title")
            },
            Description_Content: {
                required: getTranslation(languages, "required_description")
            }
        },
        submitHandler: () => {
            const editorVN = window.editors["PostEditor"];
            const editorEN = window.editors["PostEditorEN"];

            // Ảnh vừa chèn còn đang upload thì chưa có URL, lưu lúc này nội dung sẽ chứa ảnh tạm
            if (editorVN.plugins.get("PendingActions").hasAny || editorEN.plugins.get("PendingActions").hasAny) {
                toastr.warning(getTranslation(languages, "image_uploading"));
                return;
            }

            // Ảnh giống nhau ở bản VN và EN chỉ upload 1 lần
            const uploaded = new Map();
            Promise.all([
                uploadBase64Images(editorVN.getData(), uploaded),
                uploadBase64Images(editorEN.getData(), uploaded)
            ]).then(([content, contentEN]) => {
                let formData = new FormData($("#create-content")[0]);
                // Dùng set, không dùng append: textarea PostEditor/PostEditorEN trong form đã có nội dung,
                // append sẽ gửi nội dung lên 2 lần
                formData.set("PostEditor", content);
                formData.set("PostEditorEN", contentEN);

                let action = ($("#saveContent").attr("check") == 1)
                    ? "InsertContent"
                    : "UpdateContent";

                $.ajax({
                    url: "../data/data_content_company.php?Action=" + action,
                    data: formData,
                    type: "POST",
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: (res) => {
                        if (res.status === "Success") {
                            $("#spinnerContainer").html(`
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            `);
                            toastr.success(res.message);
                            $("#modalContent").modal("hide");
                            $("#tb_content").DataTable().ajax.reload();
                            setTimeout(() => $("#spinnerContainer").empty(), 1000);
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: (xhr) => {
                        // Server trả về lỗi PHP (HTML) thay vì JSON
                        console.error(xhr.responseText);
                        toastr.error(getTranslation(languages, "save_error"));
                    }
                });
            }).catch((err) => {
                console.error(err);
                toastr.error(getTranslation(languages, "image_upload_error") + ": " + err.message);
            });
        }
    });
}

// Đổi ảnh base64 còn trong nội dung (bài lưu trước khi chuyển sang upload ảnh, hoặc ảnh dán từ nơi khác)
// thành ảnh lưu trên server, để nội dung gửi lên không còn base64.
// Chỉ xử lý JPG/PNG vì file-api chỉ nhận 2 loại này.
function uploadBase64Images(html, uploaded) {
    const doc = new DOMParser().parseFromString(html, "text/html");
    const imgs = doc.querySelectorAll('img[src^="data:image/jp"], img[src^="data:image/png"]');
    if (imgs.length === 0) {
        return Promise.resolve(html);
    }
    return Promise.all([...imgs].map((img) => {
        const src = img.getAttribute("src");
        if (!uploaded.has(src)) {
            uploaded.set(src, uploadImage(src));
        }
        return uploaded.get(src).then((url) => img.setAttribute("src", url));
    })).then(() => doc.body.innerHTML);
}

function uploadImage(dataUrl) {
    return fetch(dataUrl)
        .then((res) => res.blob())
        .then((blob) => {
            const formData = new FormData();
            formData.append("upload", blob, "image");
            return fetch("../data/upload_image.php", { method: "POST", body: formData });
        })
        .then((res) => res.json())
        .then((json) => {
            if (!json.url) {
                throw new Error(json.error ? json.error.message : "Upload failed");
            }
            return json.url;
        });
}
function editContent() {
  let table = $("#tb_content").DataTable();
  let row = getSelectedRow(table);
  if (!row) {
    toastr.warning(getTranslation(languages, "alert_choose_row"));
    return;
  }

  $("#modalContent").modal("show");
  $("#modal_title").html(getTranslation(languages, "edit_news"));

  $("#IDNews").val(row.ID_News);
  
  $.ajax({
    url: "../data/data_content_company.php?Action=GetPostContent",
    type: "GET",
    data: { id: row.ID_News },
    dataType: "json",
    success: function (res) {
        if (res.success && res.data) {
            window.editors["PostEditor"].setData(res.data.Post_Content || "");
            window.editors["PostEditorEN"].setData(res.data.Post_ContentEN || "");
            toastr.success("Tải dữ liệu thành công");
        } else {
            toastr.error(res.message || "Không tìm thấy nội dung");
        }
    },
    error: function (xhr, status, error) {
        console.error("Lỗi chi tiết:", error);
        toastr.error("Lỗi gọi API nội dung");
    }
  });
  // window.editors["PostEditor"].setData(row.Post_Content);
  // window.editors["PostEditorEN"].setData(row.Post_ContentEN);

  // $("#PostEditor").val(row.Post_Content);
  // $("#PostEditorEN").val(row.Post_ContentEN);

  $("#title_name").val(row.Title_Name);
  $("#title_name_en").val(row.Title_NameEN);

  $("#description_content").val(row.Description_Content);
  $("#description_content_en").val(row.Description_ContentEN);

  $("#check_news").prop("checked", row.Is_Active == 1);

  const images = row.Image_Content.split("[]");
  if (images[0] !== "") {
    $(`#preview-img-content`).attr("src", images[0]).show();
    $(`#image-icon-content`).hide();
    $(`#image-content-hidden`).val(images[0].trim());
    $(`#close-image-content`).show();
  }

  addContent(2);
}
function removeContent() {
    let table = $("#tb_content").DataTable();
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
                    url: "../data/data_content_company.php?Action=DeleteContent",
                    type: "POST",
                    data: {
                        IDNews: row.ID_News
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
                            $("#tb_content").DataTable().ajax.reload();
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

function imageContent(idImg, previewImg, imgIcon, imgHidden, closeImg) {
    $(`#${idImg}`)
        .off("change")
        .on("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = new Image();
                    img.onload = function () {
                        const canvas = document.createElement("canvas");
                        const ctx = canvas.getContext("2d");

                        const maxWidth = img.width * 0.5;
                        const maxHeight = img.height * 0.5;

                        canvas.width = maxWidth;
                        canvas.height = maxHeight;

                        ctx.drawImage(img, 0, 0, maxWidth, maxHeight);

                        const compressedImage = canvas.toDataURL("image/jpeg", 0.3);
                        $(`#${previewImg}`).attr("src", compressedImage).show();
                        $(`#${imgIcon}`).hide();
                        $(`#${closeImg}`).show();
                        $(`#${imgHidden}`).val(compressedImage);
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
}

function viewContent() {
    let table = $("#tb_content").DataTable();
    let row = getSelectedRow(table);
    if (row) {
        $("#viewContent").modal("show");
        $("#modal_title_view").html(getTranslation(languages, "view_new"));

        let formData = new FormData();
        formData.append("IDNews", row.ID_News);

        $.ajax({
            url: "../data/data_content_company.php?Action=viewNew",
            data: formData,
            type: "POST",
            contentType: false,
            processData: false,
            success: (json) => {
                let res = JSON.parse(json);

                // res lúc này là mảng dữ liệu từ DB
                if (res.length > 0) {
                    let news = res[0];
                    let content = lang == 'vn' ? news.Post_Content : news.Post_ContentEN;
                    // Đổ nội dung vào modal-body
                    $("#viewContent .modal-body").html(`
                      
                <div class="ck-content">${content}</div>
                      
        `);


                } else {
                    toastr.error("Không tìm thấy dữ liệu");
                }
            },
        });


    } else {
        toastr.warning(getTranslation(languages, "alert_choose_row"));
    }
}
