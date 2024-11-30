<?php
include ("dbconnect.php");
$dataArray = fetchQuery(
    "SELECT g.group_id AS `group_id`, 
            g.groupname AS `Group Name`, 
            g.admin_name AS Admin, 
            g.group_description AS Description 
    FROM groups g 
    LEFT JOIN group_status_list gsl ON g.group_id = gsl.group_id AND gsl.user_id = " . $_GET['user_id'] . " 
    WHERE (gsl.status = 'rejected' ) OR gsl.group_id IS NULL ;",
    "study_mate"
);

if (count($dataArray) > 0) {
    // print_r($dataArray);
    // echo "<div>";
    $i = 1;
    foreach ($dataArray as $row) {

        if (!$row) {
            echo "addRow($i, 'No more groups available.', '', '',' ');";

        } else {
            $groupid = $row['group_id'];
            $groupName = $row['Group Name'];
            $admin = $row["Admin"];
            $description = $row['Description'];
            echo "<tr><td>$i.</td><td>$groupName</td><td>$admin</td><td>$description</td><td><button class='button' id='".$groupid."' name='".$groupName."'>Request</button></td></tr>";
            // echo "<div><div>$i.</div><div>$groupName</div><div>$admin</div><div>$description</div><div><button class='button' id='".$groupid."' name='".$groupName."'>Request</button></div></div>";
            $i++;

        }
    }
    
} else {
    echo "<tr><td colspan='5'>No more groups available.</tr>";
    
}
// echo "</div>";
?>