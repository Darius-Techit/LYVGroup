<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');

@$userid = $_SESSION['userid'];

$Action = $_REQUEST['Action'];

if ($Action == "GetDataInfo") {

    $sqlDataInfo = "SELECT ID, ID_Info_Image, Info_Image, Image_Status, Image_Type, UserID, UserDate, CreateDate
                    FROM CO_InformationCompany";
    $dataInfo = fetch_to_array($sqlDataInfo);
    echo json_encode($dataInfo);
}
if ($Action == "GetDataInfoPic") {
    $ID_Info_Image = isset($_REQUEST['ID_Info_Image']) ? $_REQUEST['ID_Info_Image'] : "NEWS00001";
    $sqlDataInfoPic = " SELECT ID_Image, Images FROM CO_InformationPicture
                        WHERE ID_Info_Image = '$ID_Info_Image'";
    $dataInfoPic = fetch_to_array($sqlDataInfoPic);
    echo json_encode($dataInfoPic);
}

if ($Action == "InsertInfo") {
    $images = isset($_POST['Imageinfo1']) ? $_POST['Imageinfo1'] : "";
    $img_type = isset($_POST['img_type']) ? $_POST['img_type'] : "";
    if ($img_type == 'home') {
        $sql_maxid = "SELECT ISNULL(MAX(RIGHT(ID_Info_Image,5)),0)+1 ID_Info_Image FROM CO_InformationCompany WHERE LEFT(ID_Info_Image,3)='IMG'";
        $rs_maxid = fetch_to_array($sql_maxid);
        $num_id = $rs_maxid[0]['ID_Info_Image'];
        $num_rs = str_pad($num_id, 5, "0", STR_PAD_LEFT);
        $InfoImageID = "IMG" . $num_rs;
    }
    if ($img_type == 'news') {
        $sql_maxid = "SELECT ISNULL(MAX(RIGHT(ID_Info_Image,5)),0)+1 ID_Info_Image FROM CO_InformationCompany WHERE LEFT(ID_Info_Image,4)='NEWS'";
        $rs_maxid = fetch_to_array($sql_maxid);
        $num_id = $rs_maxid[0]['ID_Info_Image'];
        $num_rs = str_pad($num_id, 5, "0", STR_PAD_LEFT);
        $InfoImageID = "NEWS" . $num_rs;
    }


    $sql_Insert = "INSERT INTO CO_InformationCompany
                            (
                                ID_Info_Image,
                                Info_Image
                            )
                            VALUES
                            (
                                '$InfoImageID',
                                '$images'
                            )";

    $rs_Insert = execute_query($sql_Insert);
    if ($rs_Insert > 0) {
        echo json_encode(array("status" => "Success", "message" => "Insert Successfully"));
    } else {
        echo json_encode(array('status' => "Error", "message" => 'Insert Error!'));
    }
}
