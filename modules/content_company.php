<?php
require('../sidebar.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $news ?></h5>
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"><?= $user_date ?></label>
                                <div class="d-flex align-items-center">
                                    <div class="input-group w-40">
                                        <span class="input-group-text"><?= $from ?></span>
                                        <input type="date" class="form-control" name="User_Date_From" id="User_Date_From">
                                    </div>
                                    <span class="mx-2">~</span>
                                    <div class="input-group w-40">
                                        <span class="input-group-text"><?= $to ?></span>
                                        <input type="date" class="form-control" name="User_Date_To" id="User_Date_To">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" style="align-self: flex-end;">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control" onclick="onQueryContent()">
                                    <i class="bi bi-search"></i> <?= $search ?></button>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 30px">
                            <div class="col-md-12 col-sm-12 mb-3"
                                style="display: flex; gap: 10px; align-items: center;">

                                <button type="button" class="btn btn-outline-primary"
                                    onclick="addContent(1)"><i class="bi bi-plus-square"></i> <?= $add ?>
                                </button>
                                <button type="button" class="btn btn-outline-warning"
                                    onclick="editContent()"><i class="bi bi-pencil-square"></i> <?= $edit ?>
                                </button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="removeContent()"><i class="bi bi-trash"></i> <?= $delete ?>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tb_content" class="table table-striped table-bordered zero-configuration" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th><?= $image_content ?></th>
                                        <th><?= $title_content ?></th>
                                        <th><?= $description_content ?></th>
                                        <th><?= $news_content ?></th>

                                        <th><?= $title_content_en ?></th>
                                        <th><?= $description_content_en ?></th>
                                        <th><?= $news_contentEN ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
                        <div class="col-md-12">
                            <div class="d-flex align-items-center flex-column">
                                <label class='form-label-modal form-label'><?= $image_content ?></label>
                                <div class='col-12 col-sm-6 col-md-4 col-lg-4 position-relative'
                                    style='width: 50%;'>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()"><?= $close ?></button>
                    <button type="submit" class="btn btn-primary" id="saveContent" check="1"><?= $save ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        Base64UploadAdapter,
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
            IndentBlock, BlockQuote, Link, AutoLink, Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, ImageUpload, LinkImage, Base64UploadAdapter,
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
        image: {
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