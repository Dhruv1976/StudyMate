<?php

include 'db.php';

session_start();
$user_id = $_SESSION['user_id'];
// $user_id = 9;


$sql = "SELECT * FROM notes WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

$notes = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notes[] = $row;
    }
}

echo json_encode($notes);

mysqli_close($conn);
?>
