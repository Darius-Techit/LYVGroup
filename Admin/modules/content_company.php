<?php
require('../sidebar.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');


if (!isset($_SESSION['language']) || empty($_SESSION['language'])) {
    $_SESSION['language'] = 'en';
}
$languages = $_SESSION['language'];

switch ($languages) {
    case "vn":
        $lang = "vn";
        break;
    default:
        $lang = "en";
        break;
}
?>

<script>
    const lang = "<?= $lang ?>";
</script>

<style>
    #tb_content {
        border-radius: 0 !important;
    }

    /* Gỡ bỏ bo góc ở thẻ th đầu tiên và cuối cùng của thead (thường là nguyên nhân chính) */
    #tb_content thead th:first-child,
    #tb_content thead th:last-child,
    #tb_content thead th {
        border-radius: 0 !important;
    }

    @keyframes ccFadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #cc-page .cc-card {

        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(21, 33, 92, 0.08);
        overflow: hidden;
        animation: ccFadeInUp 0.35s ease both;
        transition: box-shadow 0.2s ease;
    }

    #cc-page .cc-card:hover {
        box-shadow: 0 10px 28px rgba(21, 33, 92, 0.12);
    }

    #cc-page .cc-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 22px 24px 18px;
        border-bottom: 1px solid #eef1fa;
        flex-wrap: wrap;
    }

    #cc-page .cc-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    #cc-page .cc-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        color: #fff;
        font-size: 22px;
        flex-shrink: 0;
    }

    #cc-page .cc-header h5 {
        margin: 0;
        font-weight: 700;
        color: #012970;
    }

    #cc-page .cc-header small {
        color: #8a94b3;
    }

    #cc-page .cc-stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 12px;
        background: #f8f9ff;
        border: 1px solid #eef1fa;
        min-width: 130px;
    }

    #cc-page .cc-stat-item i {
        font-size: 18px;
        color: #4154f1;
    }

    #cc-page .cc-stat-item b {
        display: block;
        font-size: 17px;
        color: #012970;
        line-height: 1;
    }

    #cc-page .cc-stat-item span {
        display: block;
        font-size: 11.5px;
        color: #8a94b3;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    #cc-page .cc-filter-bar {
        padding: 20px 24px;
        background: #f8f9ff;
        border-bottom: 1px solid #eef1fa;
    }

    #cc-page .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #4b5580;
        margin-bottom: 6px;
    }

    #cc-page .cc-filter-bar .input-group-text {
        background: #fff;
        color: #6a71a8;
        border-color: #e3e6f5;
    }

    #cc-page .cc-filter-bar .form-control {
        border-color: #e3e6f5;
    }

    #cc-page .cc-filter-bar .form-control:focus {
        box-shadow: 0 0 0 3px rgba(65, 84, 241, 0.12);
    }

    #cc-page .cc-toolbar {
        padding: 16px 24px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    #cc-page .btn-search,
    #cc-page .cc-toolbar .btn,
    #modalContent .modal-footer .btn {

        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.2px;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    #cc-page .btn-search {
        padding: 10px 26px;
    }

    #cc-page .cc-toolbar .btn {
        padding: 8px 20px;
        font-size: 14px;
    }

    #cc-page .btn-search:hover,
    #cc-page .cc-toolbar .btn:hover,
    #modalContent .modal-footer .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }

    #cc-page .btn-search:active,
    #cc-page .cc-toolbar .btn:active,
    #modalContent .modal-footer .btn:active {
        transform: translateY(0);
    }

    #cc-page .btn-search,
    #cc-page .cc-toolbar .btn-primary,
    #modalContent .modal-footer .btn-primary {
        background: linear-gradient(135deg, #4154f1, #7b8cff);
        box-shadow: 0 6px 16px rgba(65, 84, 241, 0.35);
    }

    #cc-page .btn-search:hover,
    #cc-page .cc-toolbar .btn-primary:hover,
    #modalContent .modal-footer .btn-primary:hover {
        box-shadow: 0 10px 20px rgba(65, 84, 241, 0.42);
    }

    #cc-page .cc-toolbar .btn-warning {
        background: linear-gradient(135deg, #f7b733, #fc4a1a);
        color: #fff;
        box-shadow: 0 6px 16px rgba(252, 74, 26, 0.3);
    }

    #cc-page .cc-toolbar .btn-warning:hover {
        box-shadow: 0 10px 20px rgba(252, 74, 26, 0.4);
    }

    #cc-page .cc-toolbar .btn-danger {
        background: linear-gradient(135deg, #eb3349, #f45c43);
        box-shadow: 0 6px 16px rgba(235, 51, 73, 0.3);
    }

    #cc-page .cc-toolbar .btn-danger:hover {
        box-shadow: 0 10px 20px rgba(235, 51, 73, 0.4);
    }

    #cc-page .cc-toolbar .btn-success {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        box-shadow: 0 6px 16px rgba(17, 153, 142, 0.3);
    }

    #cc-page .cc-toolbar .btn-success:hover {
        box-shadow: 0 10px 20px rgba(17, 153, 142, 0.4);
    }

    #modalContent .modal-footer .btn-secondary {
        background: linear-gradient(135deg, #7b8794, #99a3b0);
        box-shadow: 0 6px 16px rgba(90, 100, 120, 0.25);
    }

    #modalContent .modal-footer .btn-secondary:hover {
        box-shadow: 0 10px 20px rgba(90, 100, 120, 0.32);
    }

    #cc-page .table-responsive {
        padding: 0 24px 24px;
    }

    #tb_content thead th {
        background: linear-gradient(135deg, #2c3ea1, #4154f1) !important;
        color: #fff !important;
        border: none !important;
        text-transform: uppercase;
        font-size: 12.5px;
        letter-spacing: 0.4px;
        padding: 14px 10px !important;
    }

    /* DataTables scrollX clones the whole table (same id) into .dataTables_scrollBody
       as a hidden sizing header. Force it collapsed so our padding/background above
       doesn't turn it into a visible bar under the real header. */
    .dataTables_scrollBody #tb_content thead tr,
    .dataTables_scrollBody #tb_content thead th {
        height: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        line-height: 0 !important;
        background: transparent !important;
    }

    #cc-page .dataTables_length select {
        border-radius: 8px;
    }

    #cc-page .dataTables_wrapper .row:first-child {
        padding: 16px 24px 0;
    }

    #tb_content tbody td {
        padding: 12px 10px !important;
        vertical-align: middle;
        border-color: #eef1fa !important;
    }

    #tb_content tbody tr {
        cursor: pointer;
        transition: background 0.12s ease;
    }

    #tb_content .cc-img-thumb {
        width: 140px;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(21, 33, 92, 0.15);
        transition: transform 0.15s ease;
    }

    #tb_content .cc-img-thumb:hover {
        transform: scale(1.05);
    }

    #modalContent .modal-content,
    #viewContent .modal-content {}

    #modalContent .modal-header,
    #viewContent .modal-header {
        background: linear-gradient(135deg, #4154f1, #6a7bfb);
        color: #fff;

        padding: 14px 24px;
    }

    #modalContent .modal-header .btn-close,
    #viewContent .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    #modalContent .modal-body {
        padding: 22px 24px;
    }

    #modalContent .form-label-modal {
        font-weight: 600;
        color: #4b5580;
    }

    #modalContent label[for="image-content"] {
        border: 2px dashed #d7dcf5 !important;
        border-radius: 14px;
        background: #f8f9ff;
        transition: border-color 0.15s ease, background 0.15s ease;
    }

    #modalContent label[for="image-content"]:hover {
        border-color: #4154f1 !important;
        background: #f0f2ff;
    }

    #modalContent #image-icon-content {
        color: #8a94b3;
    }

    #modalContent #preview-img-content {
        border-radius: 14px !important;
    }

    #modalContent #close-image-content {
        background: #fff;
        border-radius: 50%;
        line-height: 0;
        top: -8px !important;
        right: -8px !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    #modalContent .modal-footer {

        padding: 12px 24px 18px;
    }
</style>

<main id="main" class="main">
    <section class="section" id="cc-page">
        <div id="spinnerContainer"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card cc-card">
                    <div class="cc-header">
                        <div class="cc-header-left">
                            <div class="cc-icon"><i class="bi bi-newspaper"></i></div>
                            <div>
                                <h5 class="card-title"><?= $news ?></h5>
                                <small><?= $news ?></small>
                            </div>
                        </div>
                        <div class="cc-stat-item">
                            <i class="bi bi-collection"></i>
                            <div>
                                <b id="cc-stat-total">0</b>
                                <span><?= $news ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="cc-filter-bar">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-auto">
                                <label class="form-label"><?= $user_date ?></label>
                                <div class="input-group">
                                    <span class="input-group-text"><?= $from ?></span>
                                    <input type="date" class="form-control" name="User_Date_From" id="User_Date_From">
                                </div>
                            </div>

                            <div class="col-12 col-md-auto">
                                <label class="form-label d-none d-md-block">&nbsp;</label>
                                <div class="input-group">
                                    <span class="input-group-text"><?= $to ?></span>
                                    <input type="date" class="form-control" name="User_Date_To" id="User_Date_To">
                                </div>
                            </div>

                            <div class="col-12 col-md-auto">
                                <button type="submit" class="btn btn-sm btn-primary btn-search px-4" onclick="onQueryContent()">
                                    <i class="bi bi-search"></i> <?= $search ?>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="cc-toolbar">
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="addContent(1)"><i class="bi bi-plus-square"></i> <?= $add ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning"
                            onclick="editContent()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="removeContent()"><i class="bi bi-trash"></i> <?= $delete ?>
                        </button>
                        <button type="button" class="btn btn-sm btn-success"
                            onclick="viewContent()"><i class="bi bi-eye-fill"></i> <?= $view ?>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="tb_content" class="table table-striped table-hover table-bordered zero-configuration" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th><?= $image_content ?></th>
                                    <th><?= $title_content ?></th>
                                    <th><?= $description_content ?></th>
                                    <!-- <th><?= $news_content ?></th> -->

                                    <!-- <th><?= $title_content_en ?></th>
                                    <th><?= $description_content_en ?></th>
                                    <th><?= $news_contentEN ?></th> -->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal fade show" id="modalContent" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <form id="create-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="IDNews" id="IDNews">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex flex-column">
                                <label class='form-label-modal form-label'><?= $image_content ?></label>
                                <div class='col-12 col-sm-6 col-md-4 col-lg-4 position-relative'
                                    style='width: 100%;'>
                                    <label for='image-content'
                                        class='border d-flex justify-content-center align-items-center'
                                        style='width: 100%; height: 300px; border-style: dotted;'>
                                        <i id='image-icon-content' class='bi bi-images fs-2 opacity-50'></i>
                                        <img src='' id='preview-img-content' class='border'
                                            style='width: 100%; height: 300px; display:none; object-fit: contain;' alt=''>
                                    </label>
                                    <span id='close-image-content' class='close-image position-absolute top-0'
                                        style='right: 5px; display:none; outline: none; cursor: pointer;'>
                                        <i class='bi bi-x-square-fill text-danger' style='font-size: 30px'></i>

                                    </span>
                                    <input type='file' id='image-content' accept='image/*' hidden>
                                    <input type='text' id='image-content-hidden' name='Image_Content' hidden>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column">
                                <label class='form-label-modal form-label'><?= $show_new; ?></label>
                                <div class='col-12 col-sm-6 col-md-4 col-lg-4 position-relative'
                                    style='width: 50%;'>
                                    <input type="checkbox" style="width: 30px; height:30px;"
                                        name="Check_News" id="check_news" value="1">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label"><?= $title_content ?></label>
                            <input type="text" class="form-control" id="title_name" name="Title_Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= $title_content_en ?></label>
                            <input type="text" class="form-control" id="title_name_en" name="Title_Name_EN">
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label"><?= $description_content ?></label>
                            <textarea name="Description_Content" id="description_content" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= $description_content_en ?></label>
                            <textarea name="Description_Content_EN" id="description_content_en" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">

                        <div class="col-md-6">
                            <label class="form-label"><?= $news_content ?></label>

                            <textarea class="form-control" id="PostEditor" name="PostEditor"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= $news_contentEN ?></label>

                            <textarea class="form-control" id="PostEditorEN" name="PostEditorEN"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" onclick="closeModal()"><?= $close ?></button>
                    <button type="submit" class="btn btn-sm btn-primary" id="saveContent" check="1"><i class="bi bi-check2"></i> <?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade show" id="viewContent" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form id="view-content" style="height:100vh">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title_view"></h5>
                    <button type="button" class="btn-close fs-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body view-content">

                </div>
                <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                </div> -->
            </form>
        </div>
    </div>
</div>
<style>
    #view-content svg {
        display: none;
    }
</style>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Paragraph,
        Heading,
        Bold,
        Italic,
        Underline,
        Strikethrough,
        Subscript,
        Superscript,
        Code,
        Font,
        Alignment,
        List,
        TodoList,
        Indent,
        IndentBlock,
        BlockQuote,
        Link,
        AutoLink,
        Image,
        ImageToolbar,
        ImageCaption,
        ImageStyle,
        ImageResize,
        ImageUpload,
        LinkImage,
        SimpleUploadAdapter,
        MediaEmbed,
        Highlight,
        HorizontalLine,
        SpecialCharacters,
        PageBreak,
        Table,
        TableToolbar,
        TableCellProperties,
        TableProperties,
        Autoformat,

    } from 'ckeditor5';

    window.editors = {};

    const editorConfig = {
        licenseKey: 'GPL',
        plugins: [
            Essentials, Paragraph, Heading, Bold, Italic, Underline, Strikethrough, Subscript, Superscript, Code, Font, Alignment, List, TodoList, Indent,
            IndentBlock, BlockQuote, Link, AutoLink, Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, ImageUpload, LinkImage, SimpleUploadAdapter,
            MediaEmbed, Highlight, HorizontalLine, SpecialCharacters, PageBreak, Table, TableToolbar, TableCellProperties, TableProperties, Autoformat
        ],
        toolbar: {
            items: [
                'undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', 'code', '|',
                'fontFamily', 'fontColor', 'fontBackgroundColor', '|', 'alignment', '|',
                'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent', '|',
                'link', 'blockQuote', 'insertTable', 'insertImage', 'mediaEmbed', '|',
                'highlight', 'horizontalLine', 'specialCharacters', 'pageBreak'
            ],
            shouldNotGroupWhenFull: true
        },
        // Ảnh chèn vào bài được upload lên server (Admin/data/upload_image.php -> file-api), nội dung chỉ lưu URL ảnh.
        // Trước đây dùng Base64UploadAdapter nhúng ảnh base64 vào nội dung, bài nhiều ảnh làm PHP hết memory_limit khi lưu.
        simpleUpload: {
            uploadUrl: '../data/upload_image.php'
        },
        image: {
            // file-api chỉ nhận JPG/PNG
            upload: {
                types: ['jpeg', 'png']
            },
            toolbar: [
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side',
                '|',
                'toggleImageCaption',
                'linkImage'
            ],
            styles: [
                'inline',
                'block',
                'side'
            ]
        },
        table: {
            contentToolbar: [
                'tableColumn',
                'tableRow',
                'mergeTableCells',
                'tableProperties',
                'tableCellProperties'
            ]
        },
        htmlSupport: {
            allow: [{
                name: /.*/, // cho phép mọi tag
                attributes: true, // giữ mọi attribute
                classes: true, // giữ mọi class
                styles: true // giữ mọi style
            }]
        }
    };

    // const editorID = ["#PostEditor", "#PostEditorEN"];
    // editorID.forEach(id => {
    //     const el = document.querySelector(id);
    //     if (el) {
    //         ClassicEditor
    //             .create(el, editorConfig)
    //             .then(editor => {
    //                 window.editors[id.replace('#', '')] = editor;
    //             })
    //             .catch(error => console.error(error));
    //     }
    // });
    const editorID = ["#PostEditor", "#PostEditorEN"];
    editorID.forEach(id => {
        const el = document.querySelector(id);
        if (el) {
            ClassicEditor
                .create(el, editorConfig)
                .then(editor => {
                    editor.getData = function() {
                        return editor.editing.view.getDomRoot().innerHTML;
                    };

                    window.editors[id.replace('#', '')] = editor;
                })
                .catch(error => console.error(error));
        }
    });
</script>
<script>
    function closeModal() {
        $("#create-content")[0].reset();
        $("#create-content").validate().resetForm();
        $('#preview-img-content').hide();
        $('#close-image-content').hide();
        $('#image-icon-content').show();
    }
</script>
<script src="../js/content_company.js"></script>