<?php

include 'db.php';

session_start();
$user_id = $_SESSION['user_id'];
// $user_id = 9;

$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'];
$text = $data['text'];

$sql = "INSERT INTO notes (title, text, user_id) VALUES ('$title', '$text', $user_id)";
if (mysqli_query($conn, $sql)) {
    $id = mysqli_insert_id($conn);
    $note = array('id' => $id, 'title' => $title, 'text' => $text);
    echo json_encode($note);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
