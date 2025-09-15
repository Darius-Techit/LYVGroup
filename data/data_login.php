<?php
session_start();
require_once('../connect.php');
$Action = $_REQUEST['Action'];
if ($Action == 'Login') {

    $userid = isset($_POST['userid']) ? trim($_POST['userid']) : "";
    $password = isset($_POST['password']) ? trim($_POST['password']) : "";

    $sql_check = "  SELECT IDUser, UserName, Permission, [Password] FROM CO_UserInfor
                    WHERE IDUser = '$userid'";
    $rs_check = fetch_to_array($sql_check);
    $data = @$rs_check[0];
    if (!empty($data) && is_array($data) && count($data) > 0) {
        $password_hash = $data["Password"];
        $displayName = 'LYV - ' . $data['UserName'];
        $userid_co = $data['IDUser'];
        $permission = $data['Permission'];
        if (password_verify($password, $password_hash)) {
            $_SESSION['displayName'] = $displayName;
            $_SESSION['userid'] = $userid_co;
            $_SESSION['permission'] = $permission;

            echo json_encode(array(
                'status' => 'success',
                'message' => 'Login successful',
                'displayName' => $displayName,
                'userid' => $userid_co,
                'permission' => $permission
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Invalid password'
            ));
        }
    } else {
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Invalid account or password'
        ));
    }
}
