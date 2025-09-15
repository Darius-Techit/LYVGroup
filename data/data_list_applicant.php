<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');

@$userid = $_SESSION['userid'];

$Action = $_REQUEST['Action'];

if ($Action == 'GetDataListApp') {
    $Dep_ID = isset($_GET['Dep_ID']) ? $_GET['Dep_ID'] : "";
    // echo $Dep_ID;
    $sqlDataLA = "SELECT ID, FullName, PhoneNumber, Email, [File_name],
                           File_nameS, UserID, UserDate, CreateDate
                    FROM CO_ListApplicant
                    WHERE Dep_ID='$Dep_ID'";
    $dataLA = fetch_to_array($sqlDataLA);
    echo json_encode($dataLA);
}
