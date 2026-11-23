<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/LYVGroup/Admin/connect.php');
include_once("../languages/languages.php");
@$userid = $_SESSION['userid'];
$Action = $_REQUEST['Action'];


if ($Action == 'GetDataContent') {
    // $page  = isset($_GET['page']) ? $_GET['page'] : 1;
    // $limit = 5;
    // $offset = ($page - 1) * $limit;
    // $dateFrom = isset($_GET['User_Date_From']) ? $_GET['User_Date_From'] : "";
    // $dateTo = isset($_GET['User_Date_To']) ? $_GET['User_Date_To'] : "";
    // $where = "1=1";
    // if ($dateTo != '' && $dateFrom == '') {
    //     $where .= " AND CONVERT(VARCHAR(20),UserDate,23) = '$dateTo' ";
    // }
    // if ($dateFrom != '' && $dateTo == '') {
    //     $where .= " AND CONVERT(VARCHAR(20),UserDate,23) = '$dateFrom' ";
    // }
    // if ($dateTo != '' && $dateFrom != '') {
    //     $where .= " AND CONVERT(VARCHAR(20),UserDate,23) BETWEEN '$dateFrom' AND '$dateTo' ";
    // }
    // $sqlDataContent = " SELECT ID_News,Image_Content,Title_Name,Description_Content, Post_Content
    //                     FROM CO_ContentCompany
    //                     WHERE $where
    //                     ORDER BY UserDate DESC
    //                     OFFSET $offset ROWS
    //                     FETCH NEXT $limit ROWS ONLY";
    // // echo $sqlDataContent;
    // $dataContent =  fetch_to_array($sqlDataContent);
    // echo json_encode($dataContent);

    $draw   = isset($_GET['draw']) ? intval($_GET['draw']) : 1;
    $start  = isset($_GET['start']) ? intval($_GET['start']) : 0;
    $limit  = isset($_GET['length']) ? intval($_GET['length']) : 5;

    $dateFrom = isset($_GET['User_Date_From']) ? $_GET['User_Date_From'] : "";
    $dateTo   = isset($_GET['User_Date_To']) ? $_GET['User_Date_To'] : "";

    $where = "1=1";
    if ($dateTo != '' && $dateFrom == '') {
        $where .= " AND CONVERT(VARCHAR(20),UserDate,23) = '$dateTo' ";
    } elseif ($dateFrom != '' && $dateTo == '') {
        $where .= " AND CONVERT(VARCHAR(20),UserDate,23) = '$dateFrom' ";
    } elseif ($dateTo != '' && $dateFrom != '') {
        $where .= " AND CONVERT(VARCHAR(20),UserDate,23) BETWEEN '$dateFrom' AND '$dateTo' ";
    }

    $sqlCount = "SELECT COUNT(*) AS Total FROM CO_ContentCompany WHERE $where";
    $rsCount = fetch_to_array($sqlCount);
    $totalRecords = $rsCount[0]['Total'];


    $sqlData = "SELECT ID_News,Image_Content, Title_Name, Description_Content, Title_NameEN,
                       Description_ContentEN, Image_Content, Is_Active
                FROM CO_ContentCompany
                WHERE $where
                ORDER BY UserDate DESC
                OFFSET $start ROWS
                FETCH NEXT $limit ROWS ONLY";

    $dataContent = fetch_to_array($sqlData);

    echo json_encode(array(
        "draw"            => $draw,
        "recordsTotal"    => $totalRecords,
        "recordsFiltered" => $totalRecords,
        "data"            => $dataContent
    ));
    exit;
}
if ($Action == "GetPostContent") {
    $ID_News = isset($_GET['id']) ? $_GET['id'] : "";
    $sql = "SELECT Post_Content, Post_ContentEN FROM CO_ContentCompany
            WHERE ID_News = '$ID_News'";
    $rs_sql = fetch_to_array($sql);
    if (!empty($rs_sql)) {
        echo json_encode([
            "success" => true,
            "data" => $rs_sql[0]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Không tìm thấy nội dung"
        ]);
    }
    exit;
}
if ($Action == "InsertContent") {
    $Post_Content = str_replace("'", "''", isset($_REQUEST['PostEditor']) ? $_REQUEST['PostEditor'] : "");
    $Post_ContentEN = str_replace("'", "''", isset($_REQUEST['PostEditorEN']) ? $_REQUEST['PostEditorEN'] : "");

    $title = str_replace("'", "''", isset($_REQUEST['Title_Name']) ? $_REQUEST['Title_Name'] : "");
    $title_EN = str_replace("'", "''", isset($_REQUEST['Title_Name_EN']) ? $_REQUEST['Title_Name_EN'] : "");

    $description = str_replace("'", "''", isset($_REQUEST['Description_Content']) ? $_REQUEST['Description_Content'] : "");
    $description_EN = str_replace("'", "''", isset($_REQUEST['Description_Content_EN']) ? $_REQUEST['Description_Content_EN'] : "");

    $image = isset($_REQUEST['Image_Content']) ? $_REQUEST['Image_Content'] : "";

    $check = isset($_REQUEST['Check_News']) ? $_REQUEST['Check_News'] : 0;

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
                    Image_Content,
                    Is_Active
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
                    '$image',
                    '$check'
                )";
    // echo $sql_Insert;
    $rs_Insert =  execute_query($sql_Insert);
    if ($rs_Insert > 0) {
        echo json_encode(array("status" => "Success", "message" => $insert_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $insert_error));
    }
}
if ($Action == "UpdateContent") {
    $IDNews = isset($_POST['IDNews']) ? $_POST['IDNews'] : "";
    $Post_Content = str_replace("'", "''", isset($_POST['PostEditor']) ? $_POST['PostEditor'] : "");
    $Post_ContentEN = str_replace("'", "''", isset($_POST['PostEditorEN']) ? $_POST['PostEditorEN'] : "");

    $title = str_replace("'", "''", isset($_POST['Title_Name']) ? $_POST['Title_Name'] : "");
    $title_en = str_replace("'", "''", isset($_POST['Title_Name_EN']) ? $_POST['Title_Name_EN'] : "");

    $description = str_replace("'", "''", isset($_POST['Description_Content']) ? $_POST['Description_Content'] : "");
    $description_en = str_replace("'", "''", isset($_POST['Description_Content_EN']) ? $_POST['Description_Content_EN'] : "");

    $images = isset($_POST['Image_Content']) ? $_POST['Image_Content'] : "";

    $check = isset($_REQUEST['Check_News']) ? $_REQUEST['Check_News'] : 0;


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
                        UserDate = GETDATE(),
                        Is_Active = '$check'
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
            // PHP 8: loadHTML('') báo ValueError (không chặn được bằng @) làm hỏng cả lệnh xóa bài, nên bỏ qua nội dung trống
            if (trim((string)$html) === '') {
                return;
            }
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

if ($Action == 'viewNew') {
    $IDNews = isset($_POST['IDNews']) ? $_POST['IDNews'] : "";

    $sql = "SELECT * FROM CO_ContentCompany
            WHERE ID_News = '$IDNews'";
    $rs_sql = fetch_to_array($sql);

    echo json_encode($rs_sql);
}
