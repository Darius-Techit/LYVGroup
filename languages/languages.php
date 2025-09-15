<?php
//default en
if (!isset($_SESSION['language']) || empty($_SESSION['language'])) {
    $_SESSION['language'] = 'en';
}
$languages = $_SESSION['language'];

switch ($languages) {
    case "vn":
        //languages
        $language = "Ngôn ngữ";
        $language_en = "Tiếng Anh";
        $language_vn = "Tiếng Việt";

        //sidebar
        $system = "Hệ Thống";
        $department = "Bộ Phận";
        $worklist = "Danh Sách Việc Làm";
        $news = "Tin Tức & Cập Nhật";
        $administrator = "Quản Trị Viên";
        $usermanagement = "Quản Lý Người Dùng ";
        break;
    default:
        $language = "Languages";
        $language_en = "English";
        $language_vn = "Vietnamese";


        $system = "System";
        $department = "Department";
        $worklist = "Work List";
        $news = "News & Updates";
        $administrator = "Administrator";
        $usermanagement = "User Management";
        break;
}
