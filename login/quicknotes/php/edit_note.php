<?php

include 'db.php';

session_start();
$user_id = $_SESSION['user_id'];
// $user_id = 9;

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$title = $data['title'];
$text = $data['text'];
// $color = $data['color'];
 // New color attribute

$sql = "UPDATE notes SET title='$title', text='$text' WHERE id=$id AND user_id = $user_id";
if (mysqli_query($conn, $sql)) {
    echo "Note updated successfully";
} else {
    echo "Error updating note: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
