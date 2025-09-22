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
    onQueryInfo();
    imageInfo(
        `image-info1`,
        `preview-img-info1`,
        `image-icon-info1`,
        `image-info1-hidden`,
        `close-image-info1`
    );

    $("#action-modal").on("hidden.bs.modal", function () {
        $(`#preview-img-info1`).attr("src", "").hide();
        $(`#image-icon-info1`).show();
        $(`#image-info1-hidden`).val("");
        $(`#close-image-info1`).hide();
        $(`#image-info1`).val(""); // reset file input
    });

    $(".close-image").on("click", function () {
        const closeBtn = $(this);

        Swal.fire({
            title: "Do you want to delete this image?",
            icon: "question",
            // iconColor: "#ff0000",
            showCancelButton: true,
            confirmButtonColor: "#000",
            cancelButtonColor: "#847e7c",
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
function imageInfo(idImg, previewImg, imgIcon, imgHidden, closeImg) {
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
let languages = localStorage.getItem("languages");
const translations = {
    en: {
        add_information: "Add Information",
        edit_information: "Edit Information",
        required_img: "Please upload an image",
        alert_choose_row: "Please select a row first!",
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: 'Cancel',
    },
    vn: {
        add_information: "Thêm Thông Tin",
        edit_information: "Chỉnh Sửa Thông Tin",
        required_img: "Vui lòng tải lên một hình ảnh",
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
function onQueryInfo() {
    let User_Date_From = $("#User_Date_From").val();
    let User_Date_To = $("#User_Date_To").val();
    $("#tb_info_company").DataTable({
        ajax: {
            type: "GET",
            url: "../data/data_information_company.php?Action=GetDataInfo",
            data: {
                User_Date_From: User_Date_From,
                User_Date_To: User_Date_To
            },
            dataSrc: function (res) {
                return res;
            }
        },
        columns: [
            // {
            //     data: "ID_Info_Image",
            // },
            {
                data: "Info_Image",
                render: function (val, type, row) {
                    if (!val) return "";

                    const images = val.split("[]");
                    let html = "<div style='display:flex; gap:4px; flex-wrap:wrap;'>";

                    images.forEach(src => {
                        if (src) {
                            html += `<img src="${src}" 
                     style="max-width:540px; max-height:500px; height:auto; width:auto; border-radius:4px;" />`;
                        }
                    });
                    html += "</div>";
                    return html;
                }
            },

        ],
        destroy: true,
        // select: true,
        select: {
            style: "single",
        },
        searching: false,
        ordering: true,
        info: false,
    });
}
function addInfo(check) {
    $("#saveInfo").attr("check", check);
    if ($("#saveInfo").attr("check") == 1) {
        $("#modalInfo").modal("show");
        $("#modal_title").html(getTranslation(languages, "add_information"));
        $("#image-info1-hidden-error").hide();

        // let imgArr = [1];
        // for (let i = 0; i < imgArr.length; i++) {
        //     $(`#preview-imginfo-${i + 1}`).hide();
        //     $(`#imageinfo-icon-${i + 1}`).show();
        //     $(`#imageinfo-${i + 1}-hidden`).val("");
        //     $(`#close-imageinfo-${i + 1}`).hide();
        // }
        $(`#preview-img-info1`).hide();
        $(`#image-icon-info1`).show();
        $(`#image-info1-hidden`).val("");
        $(`#close-image-info1`).hide();


    }
    $("#create-info").validate({
        ignore: [],
        rules: {
            Imageinfo1: {
                required: true
            }
        },
        messages: {
            Imageinfo1: {
                required: getTranslation(languages, "required_img")
            }
        },
        submitHandler: () => {
            let action = ($("#saveInfo").attr("check") == 1) ? "InsertInfo" : "UpdateInfo";
            $.ajax({
                url: "../data/data_information_company.php?Action=" + action,
                type: "POST",
                data: new FormData($("#create-info")[0]),
                contentType: false,
                processData: false,
                success: (json) => {
                    let res = JSON.parse(json);
                    if (res.status === "Success") {
                        toastr.success(res.message);
                        $("#modalInfo").modal("hide");
                        $("#tb_info_company").DataTable().ajax.reload();
                    } else {
                        toastr.error(res.message);
                    }
                },
            });
        }
    });
}
function editInfo() {
    let table = $("#tb_info_company").DataTable();
    let row = getSelectedRow(table);
    if (row) {

        $("#ID_Info_Image").val(row.ID_Info_Image);
        const images = row.Info_Image.split("[]");
        if (images[0] !== "") {
            $(`#preview-img-info1`).attr("src", images[0]).show();
            $(`#image-icon-info1`).hide();
            $(`#image-info1-hidden`).val(images[0].trim());
            $(`#close-image-info1`).show();
        }
        $("#modalInfo").modal("show");
        $("#modal_title").html(getTranslation(languages, "edit_information"));

        $("#image-info1-hidden-error").hide();
        addInfo(2);
    } else {
        toastr.warning(getTranslation(languages, "alert_choose_row"));
    }

}
function removeInfo() {
    let table = $("#tb_info_company").DataTable();
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
            cancelButtonText: getTranslation(languages, "cancelButtonText"),
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../data/data_information_company.php?Action=DeleteInfo",
                    type: "POST",
                    data: {
                        ID_Info_Image: row.ID_Info_Image
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
                            $("#tb_info_company").DataTable().ajax.reload();
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