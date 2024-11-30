<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && isset($_SESSION['name'])) {
    header("Location: /studyMate/src/login/quicknotes/quicknotes.php");
    exit();
}
?>