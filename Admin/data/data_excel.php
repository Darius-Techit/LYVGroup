<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/LYVGroup/Admin/connect.php');
include_once("../languages/languages.php");

$action = $_GET['Action'];

if ($action == "ExportExcel") {
    $date_from = $_GET['Date_From'];
    $date_to = $_GET['Date_To'];

    // Fetch data from database
    // $query = " SELECT  wl.ID, dc.Dep_ID , dc.Dep_Name, wl.Job_Description,wl.Job_DescriptionEN, wl.Request_Work,wl.Request_WorkEN,
    //                         wl.Degree,wl.DegreeEN, wl.Gender,wl.GenderEN, wl.Age_Range,wl.Age_RangeEN, wl.Salary,wl.SalaryEN,
    //                         wl.Number_Vacancies, wl.Work_Experience,wl.Work_ExperienceEN, wl.Working_Time,wl.Working_TimeEN,
    //                         wl.Job_Hot,CONVERT(VARCHAR(20),wl.UserDate,23) UserDate, wl.CreateDate,CONVERT(VARCHAR(20),wl.Date_Applications,23)Date_Applications, wl.Position_Level,
    //                         wl.Compensation_Benefits, wl.Compensation_BenefitsEN, wl.[STATUS]
    //                 FROM CO_WorkList wl
    //                 LEFT JOIN CO_DepartmentCompany AS dc ON dc.Dep_ID=wl.Dep_ID
    //                 WHERE $where
    //                 ORDER BY wl.UserDate DESC";
}
