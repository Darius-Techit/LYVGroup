<?php
// Trung gian hiển thị ảnh trong nội dung tin tức: lấy file từ service file-api (Nest.js, C:\Server\HR_CV).
// Dùng cho CKEditor ở Admin và trang tin tức (pages/new_detail.php, pages/news_detail_content.php),
// nên KHÔNG bắt đăng nhập như Admin/data/file_cv.php.
// Ảnh nằm chung thư mục với CV ứng viên, vì vậy chỉ cho lấy file NEWS_*.jpg/png (tên do Admin/data/upload_image.php đặt),
// tránh người ngoài đoán tên để tải CV.

$name = isset($_GET['name']) ? $_GET['name'] : '';
if (!preg_match('/^NEWS_[A-Za-z0-9_]+(\(\d+\))?\.(jpg|jpeg|png)$/', $name, $m)) {
    http_response_code(400);
    exit('Tên file không hợp lệ');
}

$ch = curl_init('http://127.0.0.1:9999/files/' . rawurlencode($name));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$content = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

if ($content === false) {
    http_response_code(502);
    exit('Không kết nối được file-api');
}
if ($status != 200) {
    http_response_code($status == 404 ? 404 : 502);
    exit($status == 404 ? 'Không tìm thấy ảnh' : 'Không mở được ảnh');
}

// Tên file là duy nhất và file-api không ghi đè file đã có, nên cho trình duyệt cache lâu
header('Content-Type: ' . ($m[2] === 'png' ? 'image/png' : 'image/jpeg'));
header('Content-Length: ' . strlen($content));
header('Cache-Control: public, max-age=31536000, immutable');
header('X-Content-Type-Options: nosniff');
echo $content;
