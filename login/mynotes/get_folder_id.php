<?php
session_start();

if (isset($_SESSION['folder_id'])) {
  echo $_SESSION['folder_id'];
} else {
  echo 'Folder ID not found';
}
?>
