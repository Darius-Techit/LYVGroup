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
                            <div class="col-md-2">
                                <label for="inputNanme4" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="inputNanme4">
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
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $news_content ?></th>
                                        <th style="background-color: #337ab7; color: #fff; text-align: center;"><?= $news_contentEN ?></th>
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
                    <div class="row g-3">
                        <input type="hidden" class="form-control" name="IDNews" id="IDNews">
                        <div class="col-md-6">
                            <label class="form-label"><?= $news_content ?></label>
                            <!-- <div id="PostEditor" name="PostEditor">


                            </div> -->
                            <textarea class="form-control" id="PostEditor" name="PostEditor"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= $news_contentEN ?></label>
                            <!-- <div id="PostEditorEN" name="PostEditorEN">

                            </div> -->
                            <textarea class="form-control" id="PostEditorEN" name="PostEditorEN"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $close ?></button>
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
        }
    };

    const editorID = ["#PostEditor", "#PostEditorEN"];
    editorID.forEach(id => {
        const el = document.querySelector(id);
        if (el) {
            ClassicEditor
                .create(el, editorConfig)
                .then(editor => {
                    window.editors[id.replace('#', '')] = editor;
                })
                .catch(error => console.error(error));
        }
    });
</script>
<script src="../js/content_company.js"></script>