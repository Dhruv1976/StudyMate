<?php
session_start();
$userId=$_SESSION['folder_id']; // Replace with the actual user ID
$currentFolderPath = isset($_GET['folderName']) ? $_GET['folderName'] : null;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
    exit;
}

if ($currentFolderPath === null) {
    $folderPath = "uploads/" . $userId;
} else {
    $folderPath = "uploads/" . $currentFolderPath;
}

if (!file_exists($folderPath) || !is_dir($folderPath)) {
    echo json_encode(['success' => false, 'message' => 'Folder not found.']);
    exit;
}

$contents = scandir($folderPath);
$contents = array_diff($contents, ['.', '..']);

echo json_encode(['success' => true, 'contents' => array_values($contents)]);

?>
