<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/modules/LYVGroup/Admin_LYVCompany/connect.php');
include_once("../languages/languages.php");
@$userid = $_SESSION['userid'];
$Action = $_REQUEST['Action'];

if ($Action == "GetDataWorkList") {
    $DepName = isset($_GET['DepName']) ? $_GET['DepName'] : "";
    $where = "1=1";
    if ($DepName != '') {
        $where .= " AND dc.Dep_Name LIKE N'%$DepName%'";
    }
    $sqlDataWL = "  SELECT  wl.ID, dc.Dep_ID , dc.Dep_Name, wl.Job_Description,wl.Job_DescriptionEN, wl.Request_Work,wl.Request_WorkEN,
                            wl.Degree,wl.DegreeEN, wl.Gender,wl.GenderEN, wl.Age_Range,wl.Age_RangeEN, wl.Salary,wl.SalaryEN,
                            wl.Number_Vacancies, wl.Work_Experience,wl.Work_ExperienceEN, wl.Working_Time,wl.Working_TimeEN,
                            wl.Job_Hot, wl.UserDate, wl.CreateDate,(SELECT COUNT(Dep_ID) FROM CO_ListApplicant WHERE Dep_ID=wl.Dep_ID) IDListApply
                    FROM CO_WorkList wl
                    LEFT JOIN CO_DepartmentCompany AS dc ON dc.Dep_ID=wl.Dep_ID
                    WHERE $where";
    $dataWL = fetch_to_array($sqlDataWL);
    echo json_encode($dataWL);
}
if ($Action == "InsertWL") {
    $Dep_ID = isset($_POST['DepID']) ? $_POST['DepID'] : "";
    $Number_Vacancies = isset($_POST['Number_Vacancies']) ? $_POST['Number_Vacancies'] : "";
    $Degree = isset($_POST['Degree']) ? $_POST['Degree'] : "";
    $DegreeEN = isset($_POST['DegreeEN']) ? $_POST['DegreeEN'] : "";
    $Gender = isset($_POST['Gender']) ? $_POST['Gender'] : "";
    $GenderEN = isset($_POST['GenderEN']) ? $_POST['GenderEN'] : "";
    $Age_Range = isset($_POST['Age_Range']) ? $_POST['Age_Range'] : "";
    $Age_RangeEN = isset($_POST['Age_RangeEN']) ? $_POST['Age_RangeEN'] : "";
    $Salary = isset($_POST['Salary']) ? $_POST['Salary'] : "";
    $SalaryEN = isset($_POST['SalaryEN']) ? $_POST['SalaryEN'] : "";
    $Work_Experience = isset($_POST['Work_Experience']) ? $_POST['Work_Experience'] : "";
    $Work_ExperienceEN = isset($_POST['Work_ExperienceEN']) ? $_POST['Work_ExperienceEN'] : "";
    $Working_Time = isset($_POST['Working_Time']) ? $_POST['Working_Time'] : "";
    $Working_TimeEN = isset($_POST['Working_TimeEN']) ? $_POST['Working_TimeEN'] : "";
    $Job_Description = isset($_POST['Job_Description_input']) ? $_POST['Job_Description_input'] : "";
    $Job_DescriptionEN = isset($_POST['Job_DescriptionEN_input']) ? $_POST['Job_DescriptionEN_input'] : "";
    $Request_Work = isset($_POST['Request_Work_input']) ? $_POST['Request_Work_input'] : "";
    $Request_WorkEN = isset($_POST['Request_WorkEN_input']) ? $_POST['Request_WorkEN_input'] : "";
    $Job_Hot = isset($_POST['Job_Hot']) ? 1 : 0;

    $sql_exists = "SELECT 1 FROM CO_WorkList WHERE Dep_ID='$Dep_ID'";
    $rs_exists = fetch_to_array($sql_exists);
    $tmp_count = count($rs_exists);
    if ($tmp_count != 0) {
        echo json_encode(array("status" => "Error", "message" => "Department Name already exists"));
        exit;
    } else {
        $sql_Insert = "INSERT INTO CO_WorkList
                (
                    Dep_ID,
                    Job_Description,
                    Job_DescriptionEN,
                    Request_Work,
                    Request_WorkEN,
                    Degree,
                    DegreeEN,
                    Gender,
                    GenderEN,
                    Age_Range,
                    Age_RangeEN,
                    Salary,
                    SalaryEN,
                    Number_Vacancies,
                    Work_Experience,
                    Work_ExperienceEN,
                    Working_Time,
                    Working_TimeEN,
                    Job_Hot,
                    UserID,
                    UserDate,
                    CreateDate
                )
                VALUES
                (  
                    '$Dep_ID',
                    N'$Job_Description',
                    N'$Job_DescriptionEN',
                    N'$Request_Work',
                    N'$Request_WorkEN',
                    N'$Degree',
                    N'$DegreeEN',
                    N'$Gender',
                    N'$GenderEN',
                    N'$Age_Range',
                    N'$Age_RangeEN',
                    N'$Salary',
                    N'$SalaryEN',
                    N'$Number_Vacancies',
                    N'$Work_Experience',
                    N'$Work_ExperienceEN',
                    N'$Working_Time',
                    N'$Working_TimeEN',
                    '$Job_Hot',
                    '$userid',
                    GETDATE(),
                    GETDATE()
                )";
        $rs_Insert = execute_query($sql_Insert);
        if ($rs_Insert > 0) {
            echo json_encode(array("status" => "Success", "message" => $insert_successfully));
        } else {
            echo json_encode(array("status" => "Error", "message" => $insert_error));
        }
    }
}
if ($Action == "UpdateWL") {
    $ID = isset($_POST['ID']) ? $_POST['ID'] : "";
    $Dep_ID = isset($_POST['DepID']) ? $_POST['DepID'] : "";
    $Number_Vacancies = isset($_POST['Number_Vacancies']) ? $_POST['Number_Vacancies'] : "";
    $Degree = isset($_POST['Degree']) ? $_POST['Degree'] : "";
    $DegreeEN = isset($_POST['DegreeEN']) ? $_POST['DegreeEN'] : "";
    $Gender = isset($_POST['Gender']) ? $_POST['Gender'] : "";
    $GenderEN = isset($_POST['GenderEN']) ? $_POST['GenderEN'] : "";
    $Age_Range = isset($_POST['Age_Range']) ? $_POST['Age_Range'] : "";
    $Age_RangeEN = isset($_POST['Age_RangeEN']) ? $_POST['Age_RangeEN'] : "";
    $Salary = isset($_POST['Salary']) ? $_POST['Salary'] : "";
    $SalaryEN = isset($_POST['SalaryEN']) ? $_POST['SalaryEN'] : "";
    $Work_Experience = isset($_POST['Work_Experience']) ? $_POST['Work_Experience'] : "";
    $Work_ExperienceEN = isset($_POST['Work_ExperienceEN']) ? $_POST['Work_ExperienceEN'] : "";
    $Working_Time = isset($_POST['Working_Time']) ? $_POST['Working_Time'] : "";
    $Working_TimeEN = isset($_POST['Working_TimeEN']) ? $_POST['Working_TimeEN'] : "";
    $Job_Description = isset($_POST['Job_Description_input']) ? $_POST['Job_Description_input'] : "";
    $Job_DescriptionEN = isset($_POST['Job_DescriptionEN_input']) ? $_POST['Job_DescriptionEN_input'] : "";
    $Request_Work = isset($_POST['Request_Work_input']) ? $_POST['Request_Work_input'] : "";
    $Request_WorkEN = isset($_POST['Request_WorkEN_input']) ? $_POST['Request_WorkEN_input'] : "";
    $Job_Hot = isset($_POST['Job_Hot']) ? 1 : 0;

    $sql_Update = "UPDATE CO_WorkList SET
                Job_Description = N'$Job_Description',
                Job_DescriptionEN = N'$Job_DescriptionEN',
                Request_Work = N'$Request_Work',
                Request_WorkEN = N'$Request_WorkEN',
                Degree = N'$Degree',
                DegreeEN = N'$DegreeEN',
                Gender = N'$Gender',
                GenderEN = N'$GenderEN',
                Age_Range = N'$Age_Range',
                Age_RangeEN = N'$Age_RangeEN',
                Salary = N'$Salary',
                SalaryEN = N'$SalaryEN',
                Number_Vacancies = N'$Number_Vacancies',
                Work_Experience = N'$Work_Experience',
                Work_ExperienceEN = N'$Work_ExperienceEN',
                Working_Time = N'$Working_Time',
                Working_TimeEN = N'$Working_TimeEN',
                UserID = '$userid',
                UserDate = GETDATE(),
                Job_Hot = '$Job_Hot'
                WHERE ID = '$ID' AND Dep_ID = '$Dep_ID'";
    $rs_Update = execute_query($sql_Update);
    if ($rs_Update > 0) {
        echo json_encode(array("status" => "Success", "message" => $update_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $update_error));
    }
}
if ($Action == "DeleteWL") {
    $ID = isset($_POST['ID']) ? $_POST['ID'] : "";
    $Dep_ID = isset($_POST['Dep_ID']) ? $_POST['Dep_ID'] : "";

    $sql_Delete = "DELETE FROM CO_WorkList WHERE ID = '$ID' AND Dep_ID = '$Dep_ID'";
    $rs_Delete = execute_query($sql_Delete);
    if ($rs_Delete > 0) {
        echo json_encode(array("status" => "Success", "message" => $deleted_successfully));
    } else {
        echo json_encode(array("status" => "Error", "message" => $deleted_error));
    }
}
