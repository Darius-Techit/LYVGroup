<?php
session_start();
$language = isset($_GET['language']) ? $_GET['language'] : "en";
if ($language) {
    $_SESSION['language'] = $language;
    echo $language;
}
// $langDisplay = [
//     'en' => ['flag' => 'en', 'text' => 'English'],
//     'vn' => ['flag' => 'vn', 'text' => 'Tiếng Việt'],
// ];
