<?php
// Upload ảnh chèn vào nội dung tin tức (CKEditor SimpleUploadAdapter ở Admin/modules/content_company.php).
// Ảnh được gửi sang service file-api (Nest.js, C:\Server\HR_CV) lưu vào ổ mạng, giống CV ở src/data/data_home.php.
// Thành công trả về { url } để CKEditor gắn vào <img src>, lỗi trả về { error: { message } } (định dạng CKEditor yêu cầu).
session_start();
header('Content-Type: application/json; charset=utf-8');

function upload_error($code, $message)
{
    http_response_code($code);
    echo json_encode(['error' => ['message' => $message]], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isset($_SESSION['userid'])) {
    upload_error(401, 'Chưa đăng nhập');
}
session_write_close();

// CKEditor gửi file trong field "upload"
$file = isset($_FILES['upload']) ? $_FILES['upload'] : null;
if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
    upload_error(400, 'Không nhận được file ảnh');
}

// Xác định loại ảnh theo nội dung file, không dựa vào phần mở rộng tên file gửi lên.
// file-api chỉ nhận .jpg/.jpeg/.png
$info = @getimagesize($file['tmp_name']);
$types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png'];
if ($info === false || !isset($types[$info[2]])) {
    upload_error(415, 'Chỉ hỗ trợ ảnh JPG hoặc PNG');
}

// Tên bắt đầu bằng NEWS_ để src/data/news_image.php phân biệt với CV ứng viên nằm cùng thư mục
$name = 'NEWS_' . date('Ymd') . '_' . uniqid() . '.' . $types[$info[2]];

$ch = curl_init('http://127.0.0.1:9999/files');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'file' => new CURLFile($file['tmp_name'], $info['mime'], $name),
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

$result = $response !== false ? json_decode($response, true) : null;
if ($status != 201 || empty($result['name'])) {
    error_log("Upload anh tin tuc qua file-api that bai: HTTP $status " . ($response === false ? curl_error($ch) : $response));
    upload_error(502, 'Lưu ảnh thất bại, kiểm tra service file-api');
}

echo json_encode(['url' => '/LYVGroup/src/data/news_image.php?name=' . rawurlencode($result['name'])], JSON_UNESCAPED_SLASHES);
