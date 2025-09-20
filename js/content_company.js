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
    $("#tb_content").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_content_company.php?Action=GetDataContent",
            dataSrc: function (res) {
                return res;
            }
        },
        columns: [
            {
                data: "Post_Content",
                render: function (val, type, row) {
                    if (!val) return "";
                    const temp = document.createElement("div");
                    temp.innerHTML = val;

                    temp.querySelectorAll("img").forEach(img => {
                        img.style.maxWidth = "120px";   // resize ngang
                        img.style.maxHeight = "80px";  // resize dọc
                        img.style.height = "auto";
                        img.style.width = "auto";
                        img.style.borderRadius = "4px";
                        img.style.objectFit = "cover";
                        img.style.margin = "2px";
                    });
                    return temp.innerHTML;
                }
            },
            {
                data: "Post_ContentEN",
                render: function (val, type, row) {
                    if (!val) return "";
                    const temp = document.createElement("div");
                    temp.innerHTML = val;

                    temp.querySelectorAll("img").forEach(img => {
                        img.style.maxWidth = "120px";   // resize ngang
                        img.style.maxHeight = "80px";  // resize dọc
                        img.style.height = "auto";
                        img.style.width = "auto";
                        img.style.borderRadius = "4px";
                        img.style.objectFit = "cover";
                        img.style.margin = "2px";
                    });
                    return temp.innerHTML;
                }
            }
        ],
        destroy: true,
        select: true,
        searching: false,
        ordering: true,
        info: false,
    });
}
function base64ToFile(base64, filename) {
    let arr = base64.split(',');
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

        imgs.forEach(img => {
            if (img.src.startsWith("data:image/")) {
                let ext = img.src.substring("data:image/".length, img.src.indexOf(";base64"));
                let file = base64ToFile(img.src, Date.now() + "." + ext);

                let formData = new FormData();
                formData.append("file", file);

                let p = fetch("../data/upload_image.php", {
                    method: "POST",
                    body: formData
                }).then(res => res.json()).then(json => {
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
    if ($("#saveContent").attr("check") == 1) {
        $("#modalContent").modal("show");
        $("#modal_title").html(getTranslation(languages, "add_news"));

        window.editors["PostEditor"].setData('');
        window.editors["PostEditorEN"].setData('');
    }

    $("#create-content").validate({
        ignore: [], // rất quan trọng, để không bỏ qua textarea ẩn
        rules: {
            PostEditor: {
                required: function () {
                    return !window.editors["PostEditor"].getData().trim();
                }
            },
        },
        messages: {
            PostEditor: {
                required: getTranslation(languages, "required_news")
            },
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