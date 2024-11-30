<?php
if (($_GET["user_id"])) {
    include ("dbconnect.php");
    echo json_encode(fetchQuery("select groupname,group_id from group_status_list where user_id = '".$_GET["user_id"]."' and (`status` = 'member' or `status` = 'admin')", "study_mate"));
}
else
    echo json_encode(array('result' =>false))



?>