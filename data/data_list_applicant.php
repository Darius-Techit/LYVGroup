<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
include_once("../languages/languages.php");

@$userid = $_SESSION['userid'];

$Action = $_REQUEST['Action'];

if ($Action == 'GetDataListApp') {
    $Dep_ID = isset($_GET['Dep_ID']) ? $_GET['Dep_ID'] : "";
    $Processing_Status = isset($_GET['SProcessing_Status']) ? $_GET['SProcessing_Status'] : "";
    $dateFrom = isset($_GET['Upload_Date_From']) ? $_GET['Upload_Date_From'] : "";
    $dateTo = isset($_GET['Upload_Date_To']) ? $_GET['Upload_Date_To'] : "";

    $where = "Dep_ID='$Dep_ID'";
    if ($dateTo != '' && $dateFrom == '') {
        $where .= " AND CONVERT(VARCHAR(20),Upload_Date,23) = '$dateTo' ";
    }
    if ($dateFrom != '' && $dateTo == '') {
        $where .= " AND CONVERT(VARCHAR(20),Upload_Date,23) = '$dateFrom' ";
    }
    if ($dateTo != '' && $dateFrom != '') {
        $where .= " AND CONVERT(VARCHAR(20),Upload_Date,23) BETWEEN '$dateFrom' AND '$dateTo' ";
    }
    if ($Processing_Status != '') {
        $where .= " AND Processing_Status LIKE N'%$Processing_Status%'";
    }
    $sqlDataLA = "SELECT ID,Dep_ID, FullName, PhoneNumber, Email, [File_name],
                           File_nameS, Birthday, Processing_Status, UserID, UserDate, CreateDate
                    FROM CO_ListApplicant
                    WHERE $where";
    $dataLA = fetch_to_array($sqlDataLA);
    echo json_encode($dataLA);
}
if ($Action == "UpdateStatus") {
    $ID = isset($_POST['ID_Status']) ? $_POST['ID_Status'] : "";
    $ID_Dep = isset($_POST['ID_Dep']) ? $_POST['ID_Dep'] : "";
    $Processing_Status = isset($_POST['Processing_Status']) ? $_POST['Processing_Status'] : "";

    $sql_Update = " UPDATE CO_ListApplicant
                    SET
                        Processing_Status = N'$Processing_Status'
                    WHERE Dep_ID='$ID_Dep' AND ID = '$ID' ";
    $rs_Update = execute_query($sql_Update);
    if ($rs_Update > 0) {
        echo json_encode(array("status" => "Success", "message" => $update_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $update_error));
    }
}
if ($Action == "DeleteStatus") {
    $ID = isset($_POST['ID_Status']) ? $_POST['ID_Status'] : "";
    $ID_Dep = isset($_POST['ID_Dep']) ? $_POST['ID_Dep'] : "";

    $sql_Delete = "DELETE FROM CO_ListApplicant WHERE ID = '$ID' AND Dep_ID = '$ID_Dep'";
    $rs_Delete = execute_query($sql_Delete);
    if ($rs_Delete > 0) {
        echo json_encode(array("status" => "Success", "message" => $deleted_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $deleted_error));
    }
}
