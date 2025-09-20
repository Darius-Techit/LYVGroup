<?php
$Action = $_REQUEST['Action'];


if ($Action == 'PDF_ListApp') {
    $File_PDF = $_REQUEST['PDF'];

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    $file =  file_get_contents("\\\\192.168.0.96\\d$\\wamp2.5\\www\\modules\\LYVGroup\\user\\assets\\uploads\\" . $File_PDF);

    header('Cache-Control: public');
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $File_PDF . '"');
    header('Content-Length: ' . strlen($file));

    echo $file;
}
