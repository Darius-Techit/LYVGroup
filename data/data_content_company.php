<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
@$userid = $_SESSION['userid'];
$Action = $_REQUEST['Action'];

if ($Action == 'GetDataContent') {
    $sqlDataContent = " SELECT ID_News, Post_Content, Post_ContentEN, UserID, UserDate, CreateDate
                        FROM CO_ContentCompany";
    $dataContent =  fetch_to_array($sqlDataContent);
    echo json_encode($dataContent);
}
if ($Action == "InsertContent") {
    $Post_Content = isset($_REQUEST['Post_Content']) ? $_REQUEST['Post_Content'] : "";
    $Post_ContentEN = isset($_REQUEST['Post_ContentEN']) ? $_REQUEST['Post_ContentEN'] : "";

    $sql_maxid = "SELECT ISNULL(MAX(RIGHT(ID_News,8)),0)+1 ID_News FROM CO_ContentCompany";
    $rs_maxid = fetch_to_array($sql_maxid);
    $num_id = $rs_maxid[0]['ID_News'];
    $num_rs = str_pad($num_id, 8, "0", STR_PAD_LEFT);
    $ID_News = "NEWS" . $num_rs;

    $sql_Insert = "INSERT INTO CO_ContentCompany
                (
                    ID_News,
                    Post_Content,
                    Post_ContentEN,
                    UserID,
                    UserDate,
                    CreateDate
                )
                VALUES
                (
                    '$ID_News', 
                    N'$Post_Content',
                    N'$Post_ContentEN',
                    '$userid',
                    GETDATE(),
                    GETDATE()
                )";
    $rs_Insert =  execute_query($sql_Insert);
    if ($rs_Insert > 0) {
        echo json_encode(array("status" => "Success", "message" => "Insert Successfully"));
    } else {
        echo json_encode(array("status" => "Error", "message" => "Insert Error"));
    }
}
if ($Action == "UpdateContent") {
    $IDNews = isset($_POST['IDNews']) ? $_POST['IDNews'] : "";
    $Post_Content = isset($_POST['Post_Content']) ? $_POST['Post_Content'] : "";
    $Post_ContentEN = isset($_POST['Post_ContentEN']) ? $_POST['Post_ContentEN'] : "";

    $sql_old = "SELECT Post_Content, Post_ContentEN 
                FROM CO_ContentCompany 
                WHERE ID_News = '$IDNews'";
    $rs_old = fetch_to_array($sql_old);
    $old_content = $rs_old ? $rs_old[0]['Post_Content'] : "";
    $old_contentEN = $rs_old ? $rs_old[0]['Post_ContentEN'] : "";


    function deleteUnusedImages($oldHtml, $newHtml, $uploadDir)
    {
        $oldDom = new DOMDocument();
        @$oldDom->loadHTML($oldHtml);
        $oldImgs = [];
        foreach ($oldDom->getElementsByTagName('img') as $img) {
            $src = $img->getAttribute('src');
            if ($src) $oldImgs[] = basename($src);
        }

        $newDom = new DOMDocument();
        @$newDom->loadHTML($newHtml);
        $newImgs = [];
        foreach ($newDom->getElementsByTagName('img') as $img) {
            $src = $img->getAttribute('src');
            if ($src) $newImgs[] = basename($src);
        }

        $toDelete = array_diff($oldImgs, $newImgs);
        foreach ($toDelete as $file) {
            $path = $uploadDir . $file;
            if (file_exists($path)) {
                unlink($path); // xoá file cũ
            }
        }
    }

    $uploadDir = __DIR__ . '/../uploads/';

    deleteUnusedImages($old_content, $Post_Content, $uploadDir);
    deleteUnusedImages($old_contentEN, $Post_ContentEN, $uploadDir);
    $sql_Update = " UPDATE CO_ContentCompany
                    SET
                        Post_Content = N'$Post_Content',
                        Post_ContentEN = N'$Post_ContentEN',
                        UserID = '$userid',
                        UserDate = GETDATE()
                    WHERE ID_News='$IDNews' ";
    $rs_Update = execute_query($sql_Update);
    if ($rs_Update > 0) {
        echo json_encode(array("status" => "Success", "message" => "Update Successfully"));
    } else {
        echo json_encode(array("status" => "Error", "message" => "Update Error"));
    }
}
if ($Action == "DeleteContent") {
    $IDNews = isset($_REQUEST['IDNews']) ? $_REQUEST['IDNews'] : '';


    //Lấy nội dung cũ để biết ảnh nào đang dùng
    $sql_old = "SELECT Post_Content, Post_ContentEN 
                FROM CO_ContentCompany 
                WHERE ID_News = '$IDNews'";
    $rs_old = fetch_to_array($sql_old);

    if ($rs_old) {
        $old_content = $rs_old[0]['Post_Content'];
        $old_contentEN = $rs_old[0]['Post_ContentEN'];

        // Hàm xóa ảnh trong nội dung
        function deleteImagesFromContent($html, $uploadDir)
        {
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            foreach ($dom->getElementsByTagName('img') as $img) {
                $src = $img->getAttribute('src');
                if ($src) {
                    $file = basename($src);
                    $path = $uploadDir . $file;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        }

        $uploadDir = __DIR__ . '/../uploads/';

        deleteImagesFromContent($old_content, $uploadDir);
        deleteImagesFromContent($old_contentEN, $uploadDir);
    }

    $sql_Delete = "DELETE FROM CO_ContentCompany WHERE ID_News='$IDNews'";
    $rs_Delete = execute_query($sql_Delete);
    if ($rs_Delete > 0) {
        echo json_encode(array("status" => "Success", "message" => "Delete Successfully"));
    } else {
        echo json_encode(array("status" => "Error", "message" => "Delete Error"));
    }
}
