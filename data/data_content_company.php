<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
include_once("../languages/languages.php");
@$userid = $_SESSION['userid'];
$Action = $_REQUEST['Action'];

if ($Action == 'GetDataContent') {
    $dateFrom = isset($_GET['User_Date_From']) ? $_GET['User_Date_From'] : "";
    $dateTo = isset($_GET['User_Date_To']) ? $_GET['User_Date_To'] : "";
    $where = "1=1";
    if ($dateTo != '' && $dateFrom == '') {
        $where .= " AND CONVERT(VARCHAR(20),UserDate,23) = '$dateTo' ";
    }
    if ($dateFrom != '' && $dateTo == '') {
        $where .= " AND CONVERT(VARCHAR(20),UserDate,23) = '$dateFrom' ";
    }
    if ($dateTo != '' && $dateFrom != '') {
        $where .= " AND CONVERT(VARCHAR(20),UserDate,23) BETWEEN '$dateFrom' AND '$dateTo' ";
    }
    $sqlDataContent = " SELECT *
                        FROM CO_ContentCompany
                        WHERE $where";
    $dataContent =  fetch_to_array($sqlDataContent);
    echo json_encode($dataContent);
}
if ($Action == "InsertContent") {
    $Post_Content = str_replace("'", "''", isset($_REQUEST['Post_Content']) ? $_REQUEST['Post_Content'] : "");
    $Post_ContentEN = str_replace("'", "''", isset($_REQUEST['Post_ContentEN']) ? $_REQUEST['Post_ContentEN'] : "");

    $title = str_replace("'", "''", isset($_REQUEST['Title_Name']) ? $_REQUEST['Title_Name'] : "");
    $title_EN = str_replace("'", "''", isset($_REQUEST['Title_Name_EN']) ? $_REQUEST['Title_Name_EN'] : "");

    $description = str_replace("'", "''", isset($_REQUEST['Description_Content']) ? $_REQUEST['Description_Content'] : "");
    $description_EN = str_replace("'", "''", isset($_REQUEST['Description_Content_EN']) ? $_REQUEST['Description_Content_EN'] : "");

    $image = isset($_REQUEST['Image_Content']) ? $_REQUEST['Image_Content'] : "";

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
                    CreateDate,
                    Title_Name,
                    Title_NameEN,
                    Description_Content,
                    Description_ContentEN,
                    Image_Content
                )
                VALUES
                (
                    '$ID_News', 
                    N'$Post_Content',
                    N'$Post_ContentEN',
                    '$userid',
                    GETDATE(),
                    GETDATE(),
                    N'$title',
                    N'$title_EN',
                    N'$description',
                    N'$description_EN',
                    '$image'
                )";
    $rs_Insert =  execute_query($sql_Insert);
    if ($rs_Insert > 0) {
        echo json_encode(array("status" => "Success", "message" => $insert_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $insert_error));
    }
}
if ($Action == "UpdateContent") {
    $IDNews = isset($_POST['IDNews']) ? $_POST['IDNews'] : "";
    $Post_Content = str_replace("'", "''", isset($_POST['Post_Content']) ? $_POST['Post_Content'] : "");
    $Post_ContentEN = str_replace("'", "''", isset($_POST['Post_ContentEN']) ? $_POST['Post_ContentEN'] : "");

    $title = str_replace("'", "''", isset($_POST['Title_Name']) ? $_POST['Title_Name'] : "");
    $title_en = str_replace("'", "''", isset($_POST['Title_Name_EN']) ? $_POST['Title_Name_EN'] : "");

    $description = str_replace("'", "''", isset($_POST['Description_Content']) ? $_POST['Description_Content'] : "");
    $description_en = str_replace("'", "''", isset($_POST['Description_Content_EN']) ? $_POST['Description_Content_EN'] : "");

    $images = isset($_POST['Image_Content']) ? $_POST['Image_Content'] : "";

    $sql_old = "SELECT Post_Content, Post_ContentEN, Title_Name, Title_NameEN, Description_Content, Description_ContentEN, Image_Content
                FROM CO_ContentCompany 
                WHERE ID_News = '$IDNews'";
    $rs_old = fetch_to_array($sql_old);
    $old_content = $rs_old ? $rs_old[0]['Post_Content'] : "";
    $old_contentEN = $rs_old ? $rs_old[0]['Post_ContentEN'] : "";
    $old_title = $rs_old ? $rs_old[0]['Title_Name'] : "";
    $old_titleEN = $rs_old ? $rs_old[0]['Title_NameEN'] : "";
    $old_description = $rs_old ? $rs_old[0]['Description_Content'] : "";
    $old_descriptionEN = $rs_old ? $rs_old[0]['Description_ContentEN'] : "";
    $old_imageContent = $rs_old ? $rs_old[0]['Image_Content'] : "";


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
                        Title_Name = N'$title',
                        Title_NameEN = N'$title_en',
                        Description_Content = N'$description',
                        Description_ContentEN = N'$description_en',
                        Image_Content = '$images',
                        UserID = '$userid',
                        UserDate = GETDATE()
                    WHERE ID_News='$IDNews' ";
    $rs_Update = execute_query($sql_Update);

    // echo $sql_Update;
    if ($rs_Update > 0) {
        echo json_encode(array("status" => "Success", "message" => $update_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $update_error));
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
        echo json_encode(array("status" => "Success", "message" => $deleted_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $deleted_error));
    }
}
