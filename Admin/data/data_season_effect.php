<?php
session_start();
include_once("../languages/languages.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/LYVGroup/src/season_effect.php');

header('Content-Type: application/json; charset=utf-8');

// Chỉ người đã đăng nhập Admin mới được đọc/ghi
if (!isset($_SESSION['displayName'])) {
    http_response_code(401);
    echo json_encode(array('status' => 'Error', 'message' => 'Unauthorized'));
    exit();
}

$Action = isset($_REQUEST['Action']) ? $_REQUEST['Action'] : '';

if ($Action == 'GetSetting') {
    $cfg = season_effect_load();
    echo json_encode(array(
        'config'   => $cfg,
        'defaults' => season_effect_defaults(),
        'current'  => season_effect_current($cfg),
        'month'    => (int) date('n'),
    ), JSON_UNESCAPED_UNICODE);
    exit();
}

if ($Action == 'SaveSetting' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = isset($_POST['config']) ? $_POST['config'] : '';
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        echo json_encode(array('status' => 'Error', 'message' => $update_error));
        exit();
    }
    $saved = season_effect_save($data, isset($_SESSION['userid']) ? $_SESSION['userid'] : '');
    if ($saved === false) {
        echo json_encode(array('status' => 'Error', 'message' => $update_error . ' (không ghi được vào bảng CO_Season_Effects_Config: '
            . (isset($GLOBALS['season_effect_error']) ? $GLOBALS['season_effect_error'] : '') . ')'), JSON_UNESCAPED_UNICODE);
        exit();
    }
    echo json_encode(array(
        'status'  => 'Success',
        'message' => $update_successfully,
        'config'  => $saved,
        'current' => season_effect_current($saved),
    ), JSON_UNESCAPED_UNICODE);
    exit();
}

echo json_encode(array('status' => 'Error', 'message' => 'Invalid action'));
