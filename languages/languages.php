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
        // $company_admin = "Quản trị viên công ty";
        $system = "Hệ Thống";
        $information = "Thông Tin";
        $department = "Bộ Phận";
        $worklist = "Danh Sách Việc Làm";
        $news = "Tin Tức & Cập Nhật";
        $administrator = "Quản Trị Viên";
        $usermanagement = "Quản Lý Người Dùng ";

        //action
        $add = "Thêm";
        $edit = "Chỉnh sửa";
        $delete = "Xóa";
        $search = "Tìm Kiếm";
        $close = "Đóng";
        $save = "Lưu thay đổi";
        $insert_successfully = "Thêm thành công";
        $insert_error = "Thêm thất bại";
        $update_successfully = "Chỉnh sửa thành công";
        $update_error = "Chỉnh sửa thất bại";
        $deleted_successfully = "Xóa thành công";
        $deleted_error = "Xóa thất bại";

        //information
        $panel = "Khung";
        $information_picture = "Thông Tin Hình Ảnh";

        //department
        $department_name = "Tên Bộ Phận";
        $department_nameEN = "Tên bộ phận (Tiếng Anh)";

        //work list
        $degree = "Bằng cấp";
        $degreeEN = "Bằng cấp (Tiếng Anh)";
        $gender = "Giới tính";
        $genderEN = "Giới tính (Tiếng Anh)";
        $age = "Độ tuổi";
        $ageEN = "Độ tuổi (Tiếng Anh)";
        $salary = "Mức lương";
        $salaryEN = "Mức lương (Tiếng Anh)";
        $number_of_vacancies = "Số lượng tuyển dụng";
        $work_experience = "Kinh nghiệm làm việc";
        $work_experienceEN = "Kinh nghiệm làm việc (T.Anh)";
        $working_time = "Thời gian làm việc";
        $working_timeEN = "Thời gian làm việc (Tiếng Anh)";
        break;
    default:
        //languages
        $language = "Languages";
        $language_en = "English";
        $language_vn = "Vietnamese";

        //sidebar
        // $company_admin = "Company Administrator";
        $system = "System";
        $information = "Information";
        $department = "Department";
        $worklist = "Work List";
        $news = "News & Updates";
        $administrator = "Administrator";
        $usermanagement = "User Management";

        //action
        $add = "Add";
        $edit = "Edit";
        $delete = "Delete";
        $search = "Search";
        $close = "Close";
        $save = "Save changes";
        $insert_successfully = "Insert Successfully";
        $insert_error = "Insert Error";
        $update_successfully = "Update Successfully";
        $update_error = "Update Error";
        $deleted_successfully = "Deleted Successfully";
        $deleted_error = "Delete Error";

        //information
        $panel = "Panel";
        $information_picture = "Information Picture";

        //department
        $department_name = "Department Name";
        $department_nameEN = "Department Name (English)";

        //work list
        $degree = "Degree";
        $degreeEN = "Degree (English)";
        $gender = "Gender";
        $genderEN = "Gender (English)";
        $age = "Age Requirement";
        $ageEN = "Age Requirement (English)";
        $salary = "Salary";
        $salaryEN = "Salary (English)";
        $number_of_vacancies = "Number of Vacancies";
        $work_experience = "Work Experience";
        $work_experienceEN = "Work Experience (English)";
        $working_time = "Working Time";
        $working_timeEN = "Working Time (English)";


        break;
}
