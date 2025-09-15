<?php
function fetch_to_array($sql, $server = "192.168.0.96\\eipsystem", $dbname = "EIP", $id = "sa", $pass = "Su@gor_pet88")
{
    try {
        $conn = new COM("ADODB.Connection", NULL, CP_UTF8) or die("Cannot start ADO");
        $conn_str = "Driver={SQL Server};Server={" . $server . "};Database=" . $dbname . ";UID=" . $id . ";PWD=" . $pass . ";";
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


function execute_query($sql, $server = "192.168.0.96\\eipsystem", $dbname = "EIP", $id = "sa", $pass = "Su@gor_pet88")
{
    try {
        $conn = new COM("ADODB.Connection", NULL, CP_UTF8) or die("Cannot start ADO");
        $conn_str = "Driver={SQL Server};Server={" . $server . "};Database=" . $dbname . ";UID=" . $id . ";PWD=" . $pass . ";";
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
