<?php
// include('./src/conn.php');

$id = isset($_GET['news']) ? $_GET['news'] : "";
    if (!preg_match('/^[A-Za-z0-9]{1,19}$/', $id)) {
        echo "<script>
            alert('$delete');
            window.location.href ='../index.php'
        </script>";
    exit();
    }
//$sql = "SELECT * FROM CO_ContentCompany
//        WHERE Id_News = '$id' ORDER BY CreateDate DESC";
$sql = "EXEC LYV_CO_ContentCompany '$id'";
$rs_sql = fetch_to_array($sql);
?>

<head>
  <!-- <link href="./assets/vendor/ckeditor5/ckeditor5.css" rel="stylesheet"> -->
</head>


<style>
  .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
    border: none;
  }

  .screen-editor {
    padding: 0 40px;
  }

  .editor {
    color: black;
  }

  .editor svg {
    display: none;
  }

  .editor img {
    max-width: 100%;
    height: auto;
    object-fit: contain;
  }


  @media (min-width: 1680px) {
    .screen-editor {
      padding: 0 80px;
    }
  }

  @media (max-width: 1024px) {
    .screen-editor figure img {
      width: 400px;
    }
  }
   @media (max-width: 430px) {
    .screen-editor {
      padding: 0;
    }
  }
</style>

<div class="screen-editor ck-content">
  <?php foreach ($rs_sql as $row) {
    $news = ($lang == 'vn') ? $row['Post_Content'] : $row['Post_ContentEN']  ?>
    <div class="editor" style="font-family: 'Segoe UI', Arial, sans-serif;">
      <?= $news; ?>
    </div>
  <?php } ?>
</div>


<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<!-- <script type="module" src="../assets/vendor/ckeditor5/ckeditor5.js"></script> -->

<!-- <script>
  document.querySelectorAll('.editor').forEach((el) => {
    ClassicEditor
      .create(el, {
        toolbar: [], // Ẩn thanh công cụ
        // removePlugins: ['Essentials', 'MediaEmbed', 'Link', 'CKFinder'],
      })
      .then(editor => {
        editor.enableReadOnlyMode('editor'); // Chỉ đọc
      })
      .catch(error => {
        console.error(error);
      });
  });
</script> -->

<script>
  ClassicEditor
    .create(el, editorConfig)
    .then(editor => {
        // Bật chế độ chỉ xem
        editor.enableReadOnlyMode('view-mode');

        window.editors[id.replace('#', '')] = editor;
    })
    .catch(error => console.error(error));

</script>