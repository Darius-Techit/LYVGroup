<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
include_once("../languages/languages.php");
@$userid = $_SESSION['userid'];
$Action = $_REQUEST['Action'];

if ($Action == "GetDataUser") {
    $sql_user = "SELECT IDUser,[Password], UserName, Permission, UserID, CONVERT(VARCHAR(20),UserDate,23) UserDate
                FROM CO_UserInfor ";
    $dataUser = fetch_to_array($sql_user);
    echo json_encode($dataUser);
}
if ($Action == "InsertUser") {
    $IDUser = isset($_POST['IDUser']) ? $_POST['IDUser'] : "";
    $Password = isset($_POST['Password']) ? $_POST['Password'] : "";
    $UserName = isset($_POST['UserName']) ? $_POST['UserName'] : "";
    $Permission = isset($_POST['Permission']) ? $_POST['Permission'] : "";

    $hashed_password = password_hash($Password, PASSWORD_DEFAULT);
    $sql_check = "SELECT 1 FROM CO_UserInfor WHERE IDUser='$IDUser'";
    $rs_check = fetch_to_array($sql_check);
    $tmp_count = count($rs_check);
    if ($tmp_count != 0) {
        echo json_encode(array("status" => "Error", "message" => "ID User already exists"));
        exit;
    } else {
        $sql_Insert = "INSERT INTO CO_UserInfor
                    (
                        IDUser,
                        [Password],
                        UserName,
                        Permission,
                        UserID,
                        UserDate
                    )
                    VALUES
                    (
                        '$IDUser',
                        '$hashed_password',
                        N'$UserName',
                        N'$Permission',
                        '$userid',
                        GETDATE()
                    )";
        // echo $sql_Insert;
        $rs_Insert = execute_query($sql_Insert);
        if ($rs_Insert > 0) {
            echo json_encode(array("status" => "Success", "message" => $insert_successfully));
        } else {
            echo json_encode(array("status" => "Error", "message" => $insert_error));
        }
    }
}
if ($Action == "UpdateUser") {
    $IDUser = isset($_POST['IDHidden']) ? $_POST['IDHidden'] : "";
    $Password = isset($_POST['Password']) ? $_POST['Password'] : "";
    $UserName = isset($_POST['UserName']) ? $_POST['UserName'] : "";
    $Permission = isset($_POST['Permission']) ? $_POST['Permission'] : "";
    $hashed_password = password_hash($Password, PASSWORD_DEFAULT);
    $sql_Update = "UPDATE CO_UserInfor SET 
                        [Password] = '$hashed_password',
                        UserName = N'$UserName',
                        Permission = N'$Permission'
                    WHERE IDUser = '$IDUser'";
    $rs_Update = execute_query($sql_Update);
    if ($rs_Update > 0) {
        echo json_encode(array("status" => "Success", "message" => $update_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $update_error));
    }
}
if ($Action == "DeleteUser") {
    $IDUser = isset($_POST['IDUser']) ? $_POST['IDUser'] : "";
    $sql_Delete = "DELETE FROM CO_UserInfor WHERE IDUser='$IDUser'";

    $rs_Delete = execute_query($sql_Delete);
    if ($rs_Delete > 0) {
        echo json_encode(array("status" => "Success", "message" => $deleted_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" =>  $deleted_error));
    }
}
