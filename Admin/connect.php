<?php
/** thong tin ket noi nam ngoai thu muc web: C:\wamp64\connect-database\lyv_group_db_config.php */
$GLOBALS['db_config'] = require dirname(__DIR__, 4) . '/connect-database/lyv_group_db_config.php';

/** build connection string, missing parameters are taken from config 'main' */
function db_conn_str($server = null, $dbname = null, $id = null, $pass = null)
{
    $cfg = $GLOBALS['db_config']['main'];
    $server = $server === null ? $cfg['server'] : $server;
    $dbname = $dbname === null ? $cfg['database'] : $dbname;
    $id = $id === null ? $cfg['user'] : $id;
    $pass = $pass === null ? $cfg['password'] : $pass;
    return "Driver={SQL Server};Server={" . $server . "};Database=" . $dbname . ";UID=" . $id . ";PWD=" . $pass . ";";
}

function fetch_to_array($sql, $server = null, $dbname = null, $id = null, $pass = null)
{
    try {
        $conn = new COM("ADODB.Connection", NULL, CP_UTF8) or die("Cannot start ADO");
        $conn_str = db_conn_str($server, $dbname, $id, $pass);
        $conn->Open($conn_str);

        $rs = $conn->Execute($sql);
        $num_columns = $rs->Fields->Count();
        $data = [];
        while (!$rs->EOF) {
            $tmp_arr = [];
            for ($i = 0; $i < $num_columns; $i++) {
                $tmp_arr[(string)$rs->Fields[$i]->Name] = (string)$rs->Fields[$i]->Value;
            }
            array_push($data, $tmp_arr);
            $rs->MoveNext();
        }
        $rs->Close();
        $conn->Close();

        $rs = null;
        $conn = null;
        return $data;
    } catch (Exception $e) {
        if (isset($rs)) $rs->Close();
        if (isset($conn)) $conn->Close();
        $rs = null;
        $conn = null;
        return FALSE;
    }
}


function execute_query($sql, $server = null, $dbname = null, $id = null, $pass = null)
{
    try {
        $conn = new COM("ADODB.Connection", NULL, CP_UTF8) or die("Cannot start ADO");
        $conn_str = db_conn_str($server, $dbname, $id, $pass);
        $conn->Open($conn_str);
        $conn->Execute($sql);
        $conn->Close();
        $conn = null;
        return TRUE;
    } catch (Exception $e) {
        if (isset($conn)) $conn->Close();
        $conn = null;
        return FALSE;
    }
}
