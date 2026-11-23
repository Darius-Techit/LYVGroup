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
        $language_en = "Tiếng anh";
        $language_vn = "Tiếng việt";
        $logout = "Đăng xuất";

        //sidebar
        // $company_admin = "Quản trị viên công ty";
        $system = "Hệ thống";
        $information = "Thông tin";
        $department = "Bộ phận";
        $worklist = "Danh sách việc làm";
        $news = "Tin tức & Cập nhật";
        $administrator = "Quản trị viên";
        $usermanagement = "Quản lý người dùng ";

        //action
        $add = "Thêm";
        $edit = "Chỉnh sửa";
        $delete = "Xóa";
        $search = "Tìm kiếm";
        $close = "Đóng";
        $save = "Lưu thay đổi";
        $insert_successfully = "Thêm thành công";
        $insert_error = "Thêm thất bại";
        $update_successfully = "Chỉnh sửa thành công";
        $update_error = "Chỉnh sửa thất bại";
        $deleted_successfully = "Xóa thành công";
        $deleted_error = "Xóa thất bại";
        $from = "Từ";
        $to = "Đến";
        $user_date = "Ngày Tạo";

        //information
        $panel = "Khung";

        //season effect
        $season_effect = "Hiệu ứng mùa";
        $season_effect_sub = "Hiệu ứng rơi Xuân · Hạ · Thu · Đông trên website";
        $information_picture = "Thông tin hình ảnh";

        //department

        $department_name = "Tên bộ phận";
        $department_nameEN = "Tên bộ phận (Tiếng anh)";
        $cannot_delete_wl = " Không thể xóa vì có trong danh sách công việc";
        $cannot_delete_la = " Không thể xóa vì có ứng viên trong danh sách ứng tuyển công việc";

        //work list
        $degree = "Bằng cấp";
        $degreeEN = "Bằng cấp (Tiếng anh)";
        $gender = "Giới tính";
        $genderEN = "Giới tính (Tiếng anh)";
        $age = "Độ tuổi";
        $ageEN = "Độ tuổi (Tiếng anh)";
        $salary = "Mức lương";
        $salaryEN = "Mức lương (Tiếng anh)";
        $number_of_vacancies = "Số lượng tuyển dụng";
        $work_experience = "Kinh nghiệm làm việc";
        $work_experienceEN = "Kinh nghiệm làm việc (T.Anh)";
        $working_time = "Thời gian làm việc";
        $working_timeEN = "Thời gian làm việc (Tiếng anh)";
        $application_deadline = "Thời gian nộp hồ sơ";
        $position_level = "Cấp bậc";
        $job_hot = "Công việc hot";
        $job_description = "Mô tả công việc";
        $job_descriptionEN = "Mô tả công việc (Tiếng anh)";
        $request_work = "Yêu cầu công việc";
        $request_workEN = "Yêu cầu công việc (Tiếng anh)";
        $compensation_benefits = "Chế độ và phúc lợi";
        $compensation_benefitsEN = "Chế độ và phúc lợi (Tiếng anh)";
        $laborer = "Công nhân";
        $office_staff = "Văn phòng";
        $dep_already = "Tên bộ phận đã tồn tại";
        $status_hide = "Hiển thị việc làm";
        $expire = "Sắp hết hạn";
		$hidden_news = "Tin đang ẩn";
		$show_news = "Tin hiển thị";

        // List Applicant
        $progress_status = "Trạng thái xử lý";
        $date_applicant = "Ngày nộp đơn";
        $fullName = "Họ và tên";
        $phone = "Số điện thoại";
        $birthday = "Ngày sinh";
        $file_name = "Tên tập tin";
		$date_apply = "Ngày ứng tuyển";
		$select_row_hint = "Chọn một dòng để Sửa hoặc Xóa";

        //content_company
        $image_content = "Hình ảnh";
        $title_content = "Tiêu đề";
        $description_content = "Mô tả";
        $news_content = "Nội dung";
        $show_new = "Hiển thị tin tức";
        $view = "Xem trước";

        $title_content_en = "Tiêu đề (Tiếng anh)";
        $description_content_en = "Mô tả (Tiếng anh)";
        $news_contentEN = "Nội dung (Tiếng anh)";
		//
		$helper_center = "Trung tâm hỗ trợ";
		
        //user management
        $id_already = "ID người dùng đã tồn tại";
        break;
    default:
        //languages
        $language = "Languages";
        $language_en = "English";
        $language_vn = "Vietnamese";
        $logout = "Logout";

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
        $from = "From";
        $to = "To";
        $user_date = "Created Date";

        //information
        $panel = "Panel";
        $information_picture = "Information Picture";

        //department
        $department_name = "Department Name";
        $department_nameEN = "Department Name (English)";
        $cannot_delete_wl = " Cannot delete because it is in the work list";
        $cannot_delete_la = " Cannot delete because there are applicants in the job application list";

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
        $application_deadline = "Application Deadline";
        $position_level = "Position Level";
        $job_hot = "Job Hot";
        $job_description = "Job Description";
        $job_descriptionEN = "Job Description (English)";
        $request_work = "Request Work";
        $request_workEN = "Request Work (English)";
        $compensation_benefits = "Compensation and Benefits";
        $compensation_benefitsEN = "Compensation and Benefits (English)";
        $laborer = "Laborer";
        $office_staff = "Office Staff";
        $dep_already = "Department Name already exists";
        $status_hide = "Show Work List";
        $expire = "About to expire";
		$hidden_news = "Hidden News";
		$show_news = "Show News";

        // List Applicant
        $progress_status = "Progress Status";
        $date_applicant = "Date Applicant";
        $fullName = "Full Name";
        $phone = "Phone";
        $birthday = "Birthday";
        $file_name = "File Name";
		$date_apply = "Application Date";
		$select_row_hint = "Select a row to Edit or Delete";

        //content_company
        $image_content = "Image";
        $title_content = "Title";
        $description_content = "Description";
        $news_content = "Content";
        $show_new = "Show news";
        $view = "View";

        $title_content_en = "Title (English)";
        $description_content_en = "Description (English)";
        $news_contentEN = "Content (English)";
		
		//helper_center
		$helper_center = "Help Center";

        //season effect
        $season_effect = "Seasonal Effects";
        $season_effect_sub = "Spring · Summer · Autumn · Winter falling effects on the website";

        //user management
        $id_already = "ID User already exists";
        break;
}
