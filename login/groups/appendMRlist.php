<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

if ($_GET) {
    $group = $_GET['group'];
    $request = $_GET['request'];
    $q;

    if ($group) {
        include ("dbconnect.php");
        if ($request == "member")
            $q = "Select username,status from `group_status_list` where groupname = '$group' and status != 'pending'; ";//where status != 'pending' ";
        else
            $q = "Select username from `group_status_list` where groupname = '$group' and status = 'pending'; ";//where status != 'pending' ";

        $result = json_encode(fetchQuery($q, "study_mate"));
        print_r($result);
    }
}
?>