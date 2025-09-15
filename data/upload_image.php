<?php
header('Content-Type: application/json');

if (!isset($_FILES['file'])) {
    echo json_encode(["status" => "Error", "message" => "No file uploaded"]);
    exit;
}

$file = $_FILES['file'];
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$newName = time() . '_' . uniqid() . '.' . $ext;
$target = $uploadDir . $newName;

if (move_uploaded_file($file['tmp_name'], $target)) {
    $url = "/modules/LYVGroup/Admin_LYVCompany/uploads/" . $newName;
    echo json_encode(["status" => "Success", "url" => $url]);
} else {
    echo json_encode(["status" => "Error", "message" => "Upload failed"]);
}
