<?php
require('conn.php');
$Action = $_REQUEST['Action'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

if ($Action == "sendMail") {
    $jobId = isset($_POST['jobId']) ? trim($_POST['jobId']) : '';
    $name  = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    $check_position = "SELECT Dep_Name FROM CO_DepartmentCompany WHERE Dep_ID = '$jobId' ";
    $rs_check = fetch_to_array($check_position);

    $position = $rs_check[0]['Dep_Name'];

    $mail = new PHPMailer(true);

    try {
        $mail_server = 'mail.lacty.com.vn';
        $mail_account = 'Auto-report';
        $mail_password = 'tZZ6knpPHz';
        $sender_address = 'tuyendung@lacty.com.vn';

        $sender_name = "Bộ phận Nhân sự - Lạc Tỷ (LYV Group)";


        $mail->SMTPDebug = 1;
        $mail->isSMTP();
        $mail->Host = $mail_server;
        $mail->SMTPAuth = true;
        $mail->SMTPAutoTLS = false;
        $mail->SMTPSecure = false;
        $mail->Username = $mail_account;
        $mail->Password = $mail_password;
        $mail->CharSet = 'utf-8';
        $mail->Port = 25;
        $mail->IsHTML(true);
        // ==========================================
        // 3. THIẾT LẬP NGƯỜI NHẬN & NỘI DUNG
        // ==========================================
        $mail->setFrom($sender_address, $sender_name);
        $mail->addAddress($email, $name);

        $mail->Subject = "Lạc Tỷ (LYV Group) – Cảm ơn bạn đã ứng tuyển";
        $mail->AddEmbeddedImage('../assets/images/logo/LAI_logo.png', 'ly_logo_cid');
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <style type="text/css">
                body {
                    font-family: Arial, sans-serif;
                    font-size: 14px;
                    line-height: 1.6;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <p>Chào <strong>' . htmlspecialchars($name) . '</strong>,</p>

            <p>Công ty TNHH Lạc Tỷ đã nhận được CV của bạn và hiện đang tiến hành xem xét cùng với các ứng viên khác cho vị trí <strong>' . htmlspecialchars($position) . '</strong>.</p>

            <p>Đối với những hồ sơ phù hợp, Lạc Tỷ sẽ chủ động liên hệ để trao đổi và sắp xếp lịch phỏng vấn trong thời gian sớm nhất.</p>

            <p>Cảm ơn bạn đã quan tâm và ứng tuyển vào Công ty.</p>

            <p><em>(Lưu ý: Do hạn chế về mặt thời gian, Nhân sự chỉ liên hệ với các ứng viên được lựa chọn vào vòng tiếp theo. Rất mong bạn thông cảm.)</em></p>

            <p>Trân trọng.</p>
  
            <p style="font-style: italic; font-weight: bold; margin-bottom: 5px;">Thanks and best regards,</p>
            <p style="margin-top: 0; margin-bottom: 15px;">--</p>
            
            <table cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; font-size: 13px; color: #7f7f7f;">
                <tr>
                    <td style="padding-right: 15px; vertical-align: top; padding-top: 5px;">
                        <img src="cid:ly_logo_cid" alt="LAI Logo" width="80" style="display: block; border: none;">
                    </td>
                    
                    <td style="border-left: 2px solid #1f497d; padding-left: 15px; vertical-align: top;">
                        <div style="color: #1f497d; font-weight: bold; margin-bottom: 3px; font-size: 14px;">HUMAN RESOURCES TEAM</div>
                        <div style="margin-bottom: 2px;">Lac Ty (LYV) Co., Ltd.</div>
                        <div style="margin-bottom: 2px;">Add: 3-5 Ten Lua Str., An Lac Ward (Binh Tan), HCMC, VNX.</div>
                        <div style="margin-bottom: 2px;">Phone: 028 3876 2443.</div>
                        <div style="margin-bottom: 2px;">W: <a href="https://www.lacty.com.vn/LYVGroup/" style="color: #7f7f7f; text-decoration: none;">www.lacty.com.vn/LYVGroup/</a></div>
                        <div>E: <a href="mailto:tuyendung@lacty.com.vn" style="color: #1f497d; text-decoration: underline;">tuyendung@lacty.com.vn</a></div>
                    </td>
                </tr>
            </table>
        </body>
        </html>';


        $mail->send();

        // (Tùy chọn) Lưu log vào DB giống như file mẫu
        // $sql_insert_log = "INSERT INTO IT_MAIL_LOG (SYSTEM_ID, FormID, Mail_SendTo, Created_At) VALUES ('HR', 'Applicant Reply', '$email', GETDATE())";
        // odbc_exec($conn_eip, $sql_insert_log);
    } catch (Exception $e) {

        echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
    }
}
