<?php
// Trả ảnh banner trang chủ (CO_InformationCompany.Info_Image) dưới dạng file ảnh thật.
// Admin lưu ảnh dạng base64 (~1MB/ảnh) ngay trong DB; nếu nhúng thẳng vào HTML thì trang chủ
// nặng thêm vài MB và không cache được. Qua file này trình duyệt chỉ tải ảnh khi cần và cache lại.
// Link có tham số v (thời điểm sửa ảnh) => sửa ảnh ở Admin thì link đổi, trình duyệt tự tải ảnh mới.

ob_start(); // chặn mọi ký tự lạ lọt ra trước dữ liệu ảnh

$id = isset($_GET['id']) ? $_GET['id'] : '';
$v  = isset($_GET['v']) ? $_GET['v'] : '';
if (!preg_match('/^IMG\d{8}$/', $id)) {
    http_response_code(400);
    exit('Mã ảnh không hợp lệ');
}

// Trình duyệt đã có đúng phiên bản này => trả 304, khỏi truy vấn DB
$etag = '"' . md5($id . '|' . $v) . '"';
if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) === $etag) {
    ob_end_clean();
    http_response_code(304);
    header('ETag: ' . $etag);
    exit;
}

include dirname(__DIR__) . '/conn.php';

$rs = fetch_to_array("SELECT Info_Image FROM CO_InformationCompany
                      WHERE ID_Info_Image = '$id' AND Image_Status = '1'");

// Info_Image có thể chứa nhiều ảnh nối bằng "[]" (giống trang Admin) -> lấy ảnh đầu tiên
$data = empty($rs) ? '' : trim(explode('[]', $rs[0]['Info_Image'])[0]);
if (!preg_match('#^data:(image/(?:jpeg|png|gif|webp));base64,#', $data, $m)) {
    ob_end_clean();
    http_response_code(404);
    exit('Không tìm thấy ảnh');
}

$content = base64_decode(substr($data, strlen($m[0])));
unset($data, $rs);

ob_end_clean();
header('Content-Type: ' . $m[1]);
header('Content-Length: ' . strlen($content));
header('Cache-Control: public, max-age=31536000, immutable');
header('ETag: ' . $etag);
header('X-Content-Type-Options: nosniff');
echo $content;
