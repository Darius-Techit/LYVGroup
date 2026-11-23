<?php
session_start();
require('../conn.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/conn.php');

$lang = isset($_GET['lang']) ? $_GET['lang'] : 'vn';
if ($lang === 'vn') {
    $lang = 'vn';
} else {
    $lang = 'en';
}

include('../../languages/' . $lang . '.php');

$Action = $_REQUEST['Action'];

$fac = isset($_SESSION['factory']) ? $_SESSION['factory'] : '';

if ($Action == 'queryWorkList') {
    $sql = "SELECT *, d.Dep_Name FROM CO_WorkList AS w
            LEFT JOIN CO_DepartmentCompany AS d
            ON d.Dep_ID = w.Dep_ID";

    $rs_sql = fetch_to_array($sql);

    echo json_encode($rs_sql);
}

function removeVietnameseSigns($str)
{
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
    );

    foreach ($unicode as $nonAccent => $accent) {
        $str = preg_replace("/($accent)/i", $nonAccent, $str);
    }

    // loại ký tự đặc biệt, thay bằng _
    $str = preg_replace('/[^A-Za-z0-9]/', '_', $str);

    // gộp nhiều dấu _ thành 1
    $str = preg_replace('/_+/', '_', $str);

    // xóa _ ở đầu/cuối
    $str = trim($str, '_');

    return $str;
}




if ($Action == 'addApply') {

    $dep_id = isset($_POST['Job_Id']) ? $_POST['Job_Id'] : "";
    $name = isset($_POST['Name']) ? $_POST['Name'] : "";
    $birthday = isset($_POST['Birthday']) ? $_POST['Birthday'] : "";
    $phone = isset($_POST['Phone']) ? $_POST['Phone'] : "";
    $email = isset($_POST['Email']) ? $_POST['Email'] : "";


    $file = "";
    $upload_date = "NULL";
    if (isset($_FILES["CV"]["name"]) && $_FILES["CV"]["error"] == 0) {
        $original_name = basename($_FILES["CV"]["name"]);

        $extension = pathinfo($original_name, PATHINFO_EXTENSION);

        $clean_name = removeVietnameseSigns($name);

        // $base_name = "CV-$clean_name-$phone";
        $base_name = "CV_" . $clean_name . "_" . $phone;

        $base_name = str_replace([" ", "/"], "_", $base_name);

        // Gửi file sang service file-api (Nest.js) lưu vào thư mục CV trên ổ mạng,
        // API tự thêm (1), (2)... nếu trùng tên và trả về tên file đã lưu
        $ch = curl_init("http://127.0.0.1:9999/files");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'file' => new CURLFile($_FILES['CV']['tmp_name'], $_FILES['CV']['type'], $base_name . "." . $extension),
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        if ($response !== false && $status == 201) {
            $result = json_decode($response, true);
            $file = $result['name'];
            $upload_date = "GETDATE()";
        } else {
            error_log("Upload CV qua file-api that bai: HTTP $status " . ($response === false ? curl_error($ch) : $response));
        }
    }

    $sql_exists = "SELECT 1 FROM CO_ListApplicant WHERE Dep_ID='$dep_id' AND PhoneNumber='$phone'";
    $rs_exists = fetch_to_array($sql_exists);
    $tmp_count = count($rs_exists);
    if ($tmp_count != 0) {
        echo json_encode(array("status" => false, "Info" => $applied));
        exit;
    } else {
        try {
            $sql = "INSERT INTO CO_ListApplicant(Dep_ID, FullName, Birthday, PhoneNumber, Email, File_name, Upload_Date, File_nameS,CreateDate)
        VALUES('$dep_id', N'$name', '$birthday', '$phone', N'$email' , '$file' , $upload_date , '',GETDATE())";
            execute_query($sql);
            echo json_encode(['status' => true, 'Info' => $applied_success]);
            exit;
        } catch (Throwable $th) {
            echo json_encode(['status' => false, 'Info' => 'Gủi CC thất bại']);
        }
    }
}

if ($Action == 'CheckCategory') {

    $jobId = $_POST['Job_Id'];
    $check_category = "SELECT Position_Level FROM CO_WorkList WHERE Dep_ID = '$jobId' ";
    $rs_check = fetch_to_array($check_category);


    if (!empty($rs_check)) {
        echo json_encode($rs_check[0]); // chỉ trả về 1 dòng đầu tiên
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
