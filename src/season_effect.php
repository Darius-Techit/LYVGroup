<?php

/**
 * Cấu hình hiệu ứng mùa (Xuân / Hạ / Thu / Đông).
 * Lưu trong bảng CO_Season_Effects_Config (ID, Config, CreateUser, CreateDate).
 * File src/season_effect.json chỉ còn dùng làm dự phòng khi bảng trống / lỗi DB.
 * Dùng chung cho Admin (đọc/ghi) và website (đọc).
 */

if (!defined('SEASON_EFFECT_FILE')) {
    define('SEASON_EFFECT_FILE', __DIR__ . '/season_effect.json');
}

function season_effect_keys()
{
    return array('spring', 'summer', 'autumn', 'winter');
}

function season_effect_defaults()
{
    return array(
        'enabled'      => false,
        'mode'         => 'auto',      // auto: theo tháng | manual: chọn tay
        'manualSeason' => 'winter',
        'pages'        => 'home',      // home | all
        'layer'        => 'under',     // under: dưới nội dung | over: trên nội dung
        'mobile'       => 'reduce',    // full | reduce | off
        'seasons'      => array(
            'spring' => array(
                'from' => 1,
                'to' => 3,
                'shapes' => array('flower', 'petal'),
                'colors' => array('#ffd24d', '#f5b335', '#ffb3c7', '#ff8fab'),
                'motion' => 'sway',
                'size' => 18,
                'qty' => 60,
                'speed' => 7,
            ),
            'summer' => array(
                'from' => 4,
                'to' => 6,
                'shapes' => array('petal', 'sparkle'),
                'colors' => array('#e8141c', '#ff5a36', '#ff8a3d', '#ffd24d'),
                'motion' => 'sway',
                'size' => 16,
                'qty' => 50,
                'speed' => 8,
            ),
            'autumn' => array(
                'from' => 7,
                'to' => 9,
                'shapes' => array('leaf', 'maple'),
                'colors' => array('#e07a1f', '#c4561d', '#f5b335', '#a0522d'),
                'motion' => 'flutter',
                'size' => 22,
                'qty' => 45,
                'speed' => 7,
            ),
            'winter' => array(
                'from' => 10,
                'to' => 12,
                'shapes' => array('flake', 'dot', 'pine'),
                'colors' => array('#8fd3a8', '#6cc28d', '#a9dfbc', '#ffd24d', '#f5b335'),
                'motion' => 'sway',
                'size' => 16,
                'qty' => 110,
                'speed' => 10,
            ),
        ),
    );
}

function season_effect_clamp($v, $min, $max, $def)
{
    if (!is_numeric($v)) return $def;
    $v = (int) round($v);
    return max($min, min($max, $v));
}

function season_effect_pick($v, $allowed, $def)
{
    return in_array($v, $allowed, true) ? $v : $def;
}

/** Lọc toàn bộ dữ liệu theo danh sách cho phép — không tin dữ liệu gửi lên. */
function season_effect_sanitize($in)
{
    $def = season_effect_defaults();
    if (!is_array($in)) return $def;

    $shapes  = array('flake', 'dot', 'pine', 'flower', 'petal', 'leaf', 'maple', 'sparkle');
    $motions = array('sway', 'straight', 'wind', 'windy', 'flutter', 'depth', 'twinkle', 'fade');

    $out = array(
        'enabled'      => !empty($in['enabled']) && $in['enabled'] !== 'false',
        'mode'         => season_effect_pick(isset($in['mode']) ? $in['mode'] : '', array('auto', 'manual'), $def['mode']),
        'manualSeason' => season_effect_pick(isset($in['manualSeason']) ? $in['manualSeason'] : '', season_effect_keys(), $def['manualSeason']),
        'pages'        => season_effect_pick(isset($in['pages']) ? $in['pages'] : '', array('home', 'all'), $def['pages']),
        'layer'        => season_effect_pick(isset($in['layer']) ? $in['layer'] : '', array('under', 'over'), $def['layer']),
        'mobile'       => season_effect_pick(isset($in['mobile']) ? $in['mobile'] : '', array('full', 'reduce', 'off'), $def['mobile']),
        'seasons'      => array(),
    );

    foreach (season_effect_keys() as $k) {
        $d = $def['seasons'][$k];
        $s = (isset($in['seasons'][$k]) && is_array($in['seasons'][$k])) ? $in['seasons'][$k] : array();

        $sh = array();
        if (isset($s['shapes']) && is_array($s['shapes'])) {
            foreach ($s['shapes'] as $x) {
                if (in_array($x, $shapes, true) && !in_array($x, $sh, true)) $sh[] = $x;
            }
        }
        $co = array();
        if (isset($s['colors']) && is_array($s['colors'])) {
            foreach ($s['colors'] as $x) {
                if (is_string($x) && preg_match('/^#[0-9a-fA-F]{6}$/', $x)) $co[] = strtolower($x);
                if (count($co) >= 6) break;
            }
        }

        $out['seasons'][$k] = array(
            'from'   => season_effect_clamp(isset($s['from']) ? $s['from'] : null, 1, 12, $d['from']),
            'to'     => season_effect_clamp(isset($s['to']) ? $s['to'] : null, 1, 12, $d['to']),
            'shapes' => $sh ? $sh : $d['shapes'],
            'colors' => $co ? $co : $d['colors'],
            'motion' => season_effect_pick(isset($s['motion']) ? $s['motion'] : '', $motions, $d['motion']),
            'size'   => season_effect_clamp(isset($s['size']) ? $s['size'] : null, 6, 40, $d['size']),
            'qty'    => season_effect_clamp(isset($s['qty']) ? $s['qty'] : null, 0, 300, $d['qty']),
            'speed'  => season_effect_clamp(isset($s['speed']) ? $s['speed'] : null, 1, 25, $d['speed']),
        );
    }
    return $out;
}

/**
 * Kết nối DB riêng cho hiệu ứng mùa.
 * KHÔNG include conn.php ở đây: các trang (home.php, job.php...) tự include('conn.php')
 * sau header → nếu đã nạp trước sẽ lỗi "Cannot redeclare function" làm trắng trang.
 */
function season_effect_db_open()
{
    $all = isset($GLOBALS['db_config']['main'])
        ? $GLOBALS['db_config']
        : require dirname(__DIR__, 4) . '/connect-database/lyv_group_db_config.php';
    $c = $all['main'];
    $conn = new COM("ADODB.Connection", NULL, CP_UTF8);
    $conn->Open("Driver={SQL Server};Server={" . $c['server'] . "};Database=" . $c['database']
        . ";UID=" . $c['user'] . ";PWD=" . $c['password'] . ";");
    return $conn;
}

/** Lấy giá trị cột đầu tiên của dòng đầu tiên (null nếu không có dòng). */
function season_effect_db_scalar($sql)
{
    $conn = season_effect_db_open();
    try {
        $rs = $conn->Execute($sql);
        $val = $rs->EOF ? null : (string) $rs->Fields[0]->Value;
        $rs->Close();
    } finally {
        $conn->Close();
    }
    return $val;
}

function season_effect_db_exec($sql)
{
    $conn = season_effect_db_open();
    try {
        $conn->Execute($sql);
    } finally {
        $conn->Close();
    }
}

/**
 * Đọc cấu hình mới nhất từ bảng CO_Season_Effects_Config (cột Config = JSON).
 * Nếu bảng chưa có dữ liệu / lỗi DB thì dùng file JSON cũ, cuối cùng là mặc định.
 */
function season_effect_load()
{
    static $cache = null;
    if ($cache !== null) return $cache;

    try {
        $raw = season_effect_db_scalar("SELECT TOP 1 Config FROM CO_Season_Effects_Config ORDER BY CreateDate DESC");
        if ($raw !== null) {
            $data = json_decode($raw, true);
            if (is_array($data)) return $cache = season_effect_sanitize($data);
        }
    } catch (Exception $e) {
        // lỗi DB → dùng phương án dự phòng bên dưới, không làm hỏng trang
    }

    if (is_file(SEASON_EFFECT_FILE)) {
        $data = json_decode(@file_get_contents(SEASON_EFFECT_FILE), true);
        if (is_array($data)) return $cache = season_effect_sanitize($data);
    }
    return $cache = season_effect_defaults();
}

/** Lưu cấu hình: thêm 1 dòng mới vào CO_Season_Effects_Config (giữ lịch sử). */
function season_effect_save($cfg, $user = '')
{
    $cfg = season_effect_sanitize($cfg);
    $json = json_encode($cfg, JSON_UNESCAPED_UNICODE);
    $esc = function ($s) {
        return str_replace("'", "''", (string) $s);
    };

    // ID = chuỗi ngẫu nhiên 20 ký tự hex in hoa, vd: 9F3A1C7B2E004D8A6B51
    $id = strtoupper(bin2hex(random_bytes(10)));
    $sql = "INSERT INTO CO_Season_Effects_Config (ID, Config, CreateUser, CreateDate)
            VALUES ('" . $id . "', N'" . $esc($json) . "', N'" . $esc($user) . "', GETDATE())";

    $GLOBALS['season_effect_error'] = '';
    try {
        season_effect_db_exec($sql);
    } catch (Exception $e) {
        $GLOBALS['season_effect_error'] = $e->getMessage();
        return false;
    }
    return $cfg;
}

/** Mùa đang áp dụng (null nếu tháng hiện tại không thuộc mùa nào). */
function season_effect_current($cfg, $month = null)
{
    if ($cfg['mode'] === 'manual') return $cfg['manualSeason'];
    $m = $month ? (int) $month : (int) date('n');
    foreach (season_effect_keys() as $k) {
        $f = $cfg['seasons'][$k]['from'];
        $t = $cfg['seasons'][$k]['to'];
        $in = ($f <= $t) ? ($m >= $f && $m <= $t) : ($m >= $f || $m <= $t); // hỗ trợ vắt năm, vd 11 → 2
        if ($in) return $k;
    }
    return null;
}
