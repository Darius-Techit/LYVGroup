<?php
$Action = $_REQUEST['Action'];


if ($Action == 'List_Applicant') {
    $File_PDF = $_REQUEST['PDF'];

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    $file =  file_get_contents("\\\\192.168.0.17\\IT_Software2\\ERP_Folder\\WEB_HR\\" . $File_PDF);

    header('Cache-Control: public');
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . $File_PDF . '"');
    header('Content-Length: ' . strlen($file));

    echo $file;
}
