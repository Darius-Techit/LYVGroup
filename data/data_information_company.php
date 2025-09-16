<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
include_once("../languages/languages.php");
@$userid = $_SESSION['userid'];

$Action = $_REQUEST['Action'];

if ($Action == "GetDataInfo") {

    $sqlDataInfo = "SELECT ID_Info_Image, Info_Image, Image_Status, UserID, UserDate, CreateDate
                    FROM CO_InformationCompany";
    $dataInfo = fetch_to_array($sqlDataInfo);
    echo json_encode($dataInfo);
}
// if ($Action == "GetDataInfoPic") {
//     $ID_Info_Image = isset($_REQUEST['ID_Info_Image']) ? $_REQUEST['ID_Info_Image'] : "NEWS00001";
//     $sqlDataInfoPic = " SELECT ID_Image, Images FROM CO_InformationPicture
//                         WHERE ID_Info_Image = '$ID_Info_Image'";
//     $dataInfoPic = fetch_to_array($sqlDataInfoPic);
//     echo json_encode($dataInfoPic);
// }

if ($Action == "InsertInfo") {
    $images = isset($_POST['Imageinfo1']) ? $_POST['Imageinfo1'] : "";

    $sql_maxid = "SELECT ISNULL(MAX(RIGHT(ID_Info_Image,8)),0)+1 ID_Info_Image FROM CO_InformationCompany WHERE LEFT(ID_Info_Image,3)='IMG'";
    $rs_maxid = fetch_to_array($sql_maxid);
    $num_id = $rs_maxid[0]['ID_Info_Image'];
    $num_rs = str_pad($num_id, 8, "0", STR_PAD_LEFT);
    $InfoImageID = "IMG" . $num_rs;

    $sql_Insert = "INSERT INTO CO_InformationCompany
                            (
                                ID_Info_Image,
                                Info_Image,
                                Image_Status,
                                UserID,
                                UserDate,
                                CreateDate
                            )
                            VALUES
                            (
                                '$InfoImageID',
                                '$images',
                                '1',
                                '$userid',
                                GETDATE(),
                                GETDATE()
                            )";

    $rs_Insert = execute_query($sql_Insert);
    if ($rs_Insert > 0) {
        echo json_encode(array("status" => "Success", "message" => "Insert Successfully"));
    } else {
        echo json_encode(array('status' => "Error", "message" => 'Insert Error!'));
    }
}
if ($Action == "UpdateInfo") {
    $ID_Info_Image = isset($_POST['ID_Info_Image']) ? $_POST['ID_Info_Image'] : "";
    $images = isset($_POST['Imageinfo1']) ? $_POST['Imageinfo1'] : "";

    if ($ID_Info_Image != "") {
        $sql_Update = " UPDATE CO_InformationCompany
                        SET Info_Image = '$images',
                            UserID = '$userid',
                            UserDate = GETDATE() 
                        WHERE ID_Info_Image = '$ID_Info_Image'";
        $rs_Update = execute_query($sql_Update);
        if ($rs_Update > 0) {
            echo json_encode(array("status" => "Success", "message" => "Update Successfully"));
        } else {
            echo json_encode(array('status' => "Error", "message" => 'Update Error!'));
        }
    } else {
        echo json_encode(array('status' => "Error", "message" => 'Missing ID_Info_Image!'));
    }
}
if ($Action == "DeleteInfo") {
    $ID_Info_Image = isset($_POST['ID_Info_Image']) ? $_POST['ID_Info_Image'] : "";
    if ($ID_Info_Image != "") {
        $sql_Delete = "DELETE FROM CO_InformationCompany WHERE ID_Info_Image = '$ID_Info_Image'";
        $rs_Delete = execute_query($sql_Delete);
        if ($rs_Delete > 0) {
            echo json_encode(array("status" => "Success", "message" => "Delete Successfully"));
        } else {
            echo json_encode(array('status' => "Error", "message" => 'Delete Error!'));
        }
    } else {
        echo json_encode(array('status' => "Error", "message" => 'Missing ID_Info_Image!'));
    }
}
