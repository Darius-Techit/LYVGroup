<?php
// Trung gian mở file CV: kiểm tra đăng nhập Admin rồi lấy file từ service file-api (Nest.js),
// trình duyệt chỉ thấy đường dẫn của web (https://www.lacty.com.vn/...), không thấy port của file-api
session_start();

if (!isset($_SESSION['userid'])) {
    http_response_code(401);
    exit('Chưa đăng nhập');
}
session_write_close();

$name = isset($_GET['name']) ? $_GET['name'] : '';
if ($name === '' || $name === '.' || $name === '..' || basename($name) !== $name) {
    http_response_code(400);
    exit('Tên file không hợp lệ');
}

$file_api_url = "http://127.0.0.1:9999/files/" . rawurlencode($name);

$ch = curl_init($file_api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$content = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
$type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

if ($content === false) {
    http_response_code(502);
    exit('Không kết nối được file-api');
}
if ($status != 200) {
    http_response_code($status);
    exit($status == 404 ? 'Không tìm thấy file' : 'Không mở được file');
}

header('Content-Type: ' . ($type ?: 'application/octet-stream'));
header('Content-Length: ' . strlen($content));
header("Content-Disposition: inline; filename*=UTF-8''" . rawurlencode($name));
echo $content;
