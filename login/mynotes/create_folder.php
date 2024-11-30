<?php
// Get user ID 
session_start();
$useId=$_SESSION['folder_id'];

if (!$useId) {
    echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
    exit;
}

$folderName = isset($_POST['folderName']) ? $_POST['folderName'] : null;
$currentFolderPath = isset($_POST['currentFolderPath']) ? $_POST['currentFolderPath'] : null;

if (!$folderName) {
    echo json_encode(['success' => false, 'message' => 'Folder name not provided.']);
    exit;
}

if ($currentFolderPath == "" . $useId) {
    $folderPath = "uploads/" . $useId . '/' . $folderName;
} else {
    $folderPath = "uploads/" . $currentFolderPath . '/' . $folderName;
}

// Create the subfolder if it doesn't exist
if (!file_exists($folderPath)) {
    if (!mkdir($folderPath, 0777, true)) {
        echo json_encode(['success' => false, 'message' => 'Failed to create folder.']);
        exit;
    }
    echo json_encode(['success' => true, 'folderName' => $folderName]);
} else {
    echo json_encode(['success' => false, 'message' => 'Folder already exists.']);
}
?>