<?php
// Check if file is uploaded
session_start();
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    
    $userId=$_SESSION['folder_id'];
    if (!$userId) {
        echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
        exit;
    }

    $folderPath = isset($_POST['folderPath']) ? $_POST['folderPath'] : '';
    if (empty($folderPath)) {
        echo json_encode(['success' => false, 'message' => 'Folder path not provided.']);
        exit;
    }

    $userFolder = "uploads/" . $folderPath;
  
    $fileName = $_FILES['file']['name'];
    $filePath = $userFolder . '/' . $fileName;
    move_uploaded_file($_FILES['file']['tmp_name'], $filePath);

    echo json_encode(['success' => true, 'fileName' => $fileName]);
} else {
    echo json_encode(['success' => false, 'message' => 'File upload failed.']);
}
?>
