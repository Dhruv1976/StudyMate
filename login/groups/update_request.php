<?php
include ("dbconnect.php");
if ($_GET) {
    $name = $_GET['requestName'];
    $group = $_GET['groupname'];
    $action;

    if ($_GET['Action'] == "add")
        $action = "member";
    else
        $action = "rejected";

    $query = "UPDATE group_status_list SET status = '$action' WHERE username = '$name' and groupname = '$group'";
    $result = execQuery($query, "study_mate");

    if ($result) {
        echo "true";
    } else {
        $connection->close();
        echo "false";
    }
} else {
    echo "nothing found to exec";
}



?>