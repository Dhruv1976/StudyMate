<?php
session_start();
include ("dbconnect.php");
if ($_GET) {


    if (!empty($_GET['group']) && !empty($_GET['groupid'])) {
        $group = $_GET['group'];
        $gid = $_GET['groupid'];
        $isPending = fetchQuery('select status from  `group_status_list` where user_id = "' . $_SESSION['user_id'] . '" and group_id = "' . $gid . '"', 'study_mate');
        if ($isPending){
            if (execQuery("UPDATE `group_status_list` SET `status` = 'pending' WHERE user_id = '" . $_SESSION["user_id"] . "' AND group_id = '" . $gid . "'", "study_mate"))echo "Request send Sucessfully";
        }
        else{
            if (execQuery("INSERT INTO `group_status_list`( user_id, username, group_id, groupname, status) VALUES (" . $_SESSION['user_id'] . ",'" . $_SESSION['name'] . "',$gid,'" . $group . "','pending')", "study_mate"))echo "Request send Sucessfully";
        }
    }
    else{
        echo "Request in else Sucessfully";
    }
}

?>