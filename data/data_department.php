<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
include_once("../languages/languages.php");
@$userid = $_SESSION['userid'];
$Action = $_REQUEST['Action'];

if ($Action == "GetDataDep") {
    $DepName = isset($_GET['DepName']) ? $_GET['DepName'] : "";
    $DepNameEN = isset($_GET['DepNameEN']) ? $_GET['DepNameEN'] : "";
    $where = "1=1";
    if ($DepName != '') {
        $where .= "AND Dep_Name LIKE N'%$DepName%'";
    }
    if ($DepNameEN != '') {
        $where .= "AND Dep_NameEN LIKE N'%$DepNameEN%'";
    }
    $sql_DataDep = "SELECT Dep_ID, Dep_Name, Dep_NameEN
                   FROM CO_DepartmentCompany
                   WHERE $where
                   ORDER BY Dep_ID DESC";
    $dataDep = fetch_to_array($sql_DataDep);
    echo json_encode($dataDep);
}

if ($Action == "InsertDep") {
    $DepName = str_replace("'", "''", isset($_POST['DepName']) ? $_POST['DepName'] : "");
    $DepNameEN =  str_replace("'", "''", isset($_POST['DepNameEN']) ? $_POST['DepNameEN'] : "");
    $sql_maxid = "SELECT ISNULL(MAX(RIGHT(Dep_ID,8)),0)+1 Dep_ID FROM CO_DepartmentCompany";
    $rs_maxid = fetch_to_array($sql_maxid);
    $num_id = $rs_maxid[0]['Dep_ID'];
    $num_rs = str_pad($num_id, 8, "0", STR_PAD_LEFT);
    $DepID = "DP" . $num_rs;

    $sql_Insert = "INSERT INTO CO_DepartmentCompany
                (
                    Dep_ID,
                    Dep_Name,
                    Dep_NameEN,
                    UserID,
                    UserDate,
                    CreateDate
                )
                VALUES
                (
                    '$DepID',
                    N'$DepName',
                    N'$DepNameEN',
                    '$userid',
                    GETDATE(),
                    GETDATE()
                )";
    $rs_Insert =  execute_query($sql_Insert);
    if ($rs_Insert > 0) {
        echo json_encode(array("status" => "Success", "message" => $insert_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $insert_error));
    }
}

if ($Action == "UpdateDep") {
    $DepID = isset($_POST['DepID']) ? $_POST['DepID'] : "";
    $DepName = isset($_POST['DepName']) ? $_POST['DepName'] : "";
    $DepNameEN = isset($_POST['DepNameEN']) ? $_POST['DepNameEN'] : "";
    $sql_Update = " UPDATE CO_DepartmentCompany
                    SET
                        Dep_Name = N'$DepName',
                        UserID = '$userid',
                        UserDate = GETDATE(),
                        Dep_NameEN = N'$DepNameEN'
                    WHERE Dep_ID='$DepID'";
    $rs_Update = execute_query($sql_Update);
    if ($rs_Update > 0) {
        echo json_encode(array("status" => "Success", "message" => $update_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $update_error));
    }
}

if ($Action == "DeleteDep") {
    $Dep_ID = isset($_POST['Dep_ID']) ? $_POST['Dep_ID'] : '';
    $sql_Delete = "DELETE FROM CO_DepartmentCompany WHERE Dep_ID='$Dep_ID'";
    $rs_Delete = execute_query($sql_Delete);
    //echo $rs_DelDep;
    if ($rs_Delete > 0) {
        echo json_encode(array("status" => "Success", "message" => $deleted_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $deleted_error));
    }
}
