<?php

include 'db.php';

session_start();
$user_id = $_SESSION['user_id'];
// $user_id = 9;

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$color = $data['color']; // New color attribute

$sql = "UPDATE notes SET color='$color' WHERE id=$id AND user_id = $user_id";
if (mysqli_query($conn, $sql)) {
    echo "Note color updated successfully";
} else {
    echo "Error updating note color: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
