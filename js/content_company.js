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
                return res;
            },
        },
        columns: [
            {
                data: "Image_Content",
                render: function (data) {
                    if (!data) return;

                    return `<img src="${data}" alt="" style="width:200px; height:100px" /> `;
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
            {
                data: "Post_Content",
                render: function (data) {
                    return `<div class="truncate">${data}</div>`
                }
            },
            {
                data: "Title_NameEN",
                render: function (data) {
                    return `<div class="truncate">${data}</div>`
                }
            },
            {
                data: "Description_ContentEN",
                render: function (data) {
                    return `<div class="truncate">${data}</div>`
                }
            },
            {
                data: "Post_ContentEN",
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
        scrollX: true,
    });
}
function base64ToFile(base64, filename) {
    let arr = base64.split(",");
    let mime = arr[0].match(/:(.*?);/)[1];
    let bstr = atob(arr[1]);
    let n = bstr.length;
    let u8arr = new Uint8Array(n);
    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, { type: mime });
}

function processEditorImages(editorData) {
    return new Promise((resolve) => {
        let parser = new DOMParser();
        let doc = parser.parseFromString(editorData, "text/html");
        let imgs = doc.querySelectorAll("img");

        let promises = [];

        imgs.forEach((img) => {
            if (img.src.startsWith("data:image/")) {
                let ext = img.src.substring(
                    "data:image/".length,
                    img.src.indexOf(";base64")
                );
                let file = base64ToFile(img.src, Date.now() + "." + ext);

                let formData = new FormData();
                formData.append("file", file);

                let p = fetch("../data/upload_image.php", {
                    method: "POST",
                    body: formData,
                })
                    .then((res) => res.json())
                    .then((json) => {
                        if (json.status === "Success") {
                            img.src = json.url; // thay src base64 bằng link server
                        }
                    });

                promises.push(p);
            }
        });

        Promise.all(promises).then(() => {
            resolve(doc.body.innerHTML);
        });
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
            console.log(window.editors["PostEditor"].getData());
            Promise.all([
                processEditorImages(window.editors["PostEditor"].getData()),
                processEditorImages(window.editors["PostEditorEN"].getData())
            ]).then(([content, contentEN]) => {
                let formData = new FormData($("#create-content")[0]);
                formData.append("Post_Content", content);
                formData.append("Post_ContentEN", contentEN);


                let action = ($("#saveContent").attr("check") == 1)
                    ? "InsertContent"
                    : "UpdateContent";

                $.ajax({
                    url: "../data/data_content_company.php?Action=" + action,
                    data: formData,
                    type: "POST",
                    contentType: false,
                    processData: false,
                    success: (json) => {
                        let res = JSON.parse(json);
                        if (res.status === "Success") {
                            toastr.success(res.message);
                            $("#modalContent").modal("hide");
                            $("#tb_content").DataTable().ajax.reload();

                        } else {
                            toastr.error(res.message);
                        }
                    }
                });
            });
        }
    });
}
function editContent() {
    let table = $("#tb_content").DataTable();
    let row = getSelectedRow(table);
    if (row) {
        $("#modalContent").modal("show");
        $("#modal_title").html(getTranslation(languages, "edit_news"));

        $("#IDNews").val(row.ID_News);

        window.editors["PostEditor"].setData(row.Post_Content);
        window.editors["PostEditorEN"].setData(row.Post_ContentEN);


        $("#title_name").val(row.Title_Name);
        $("#title_name_en").val(row.Title_NameEN);

        $("#description_content").val(row.Description_Content);
        $("#description_content_en").val(row.Description_ContentEN);

        const images = row.Image_Content.split("[]");
        if (images[0] !== "") {
            $(`#preview-img-content`).attr("src", images[0]).show();
            $(`#image-icon-content`).hide();
            $(`#image-content-hidden`).val(images[0].trim());
            $(`#close-image-content`).show();
        }

        addContent(2);
    }
    else {
        toastr.warning(getTranslation(languages, "alert_choose_row"));
    }
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

                        const compressedImage = canvas.toDataURL("image/jpeg", 0.7);
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