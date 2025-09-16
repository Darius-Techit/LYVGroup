<?php
// header('Content-Type: application/json');
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');

if (!isset($_FILES['file'])) {
    echo json_encode(["status" => "Error", "message" => "No file uploaded"]);
    exit;
}

$file = $_FILES['file'];
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$sql_maxid = "SELECT ISNULL(MAX(RIGHT(ID_News,8)),0)+1 ID_News FROM CO_ContentCompany";
$rs_maxid = fetch_to_array($sql_maxid);
$num_id = $rs_maxid[0]['ID_News'];
$num_rs = str_pad($num_id, 8, "0", STR_PAD_LEFT);
$ID_News = "NEWS" . $num_rs;

$newName = $ID_News . '_' . uniqid() . '.' . $ext;
$target = $uploadDir . $newName;

if (move_uploaded_file($file['tmp_name'], $target)) {
    $url = "/modules/LYVGroup/Admin_LYVCompany/uploads/" . $newName;
    echo json_encode(["status" => "Success", "url" => $url]);
} else {
    echo json_encode(["status" => "Error", "message" => "Upload failed"]);
}
