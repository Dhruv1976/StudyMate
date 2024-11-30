<?php

include 'db.php';

session_start();
$user_id = $_SESSION['user_id'];
// $user_id = 9;

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

$sql = "DELETE FROM notes WHERE id=$id AND user_id = $user_id";
if (mysqli_query($conn, $sql)) {
    echo "Note deleted successfully";
} else {
    echo "Error deleting note: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
