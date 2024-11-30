
<?php
session_start();
$userId = $_SESSION['folder_id'];

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Folder ID not provided.']);
    exit;
}

$userFolder = "uploads/" . $userId;

if (!file_exists($userFolder)) {
    if (!mkdir($userFolder, 0777, true)) {
        echo json_encode(['success' => false, 'message' => 'Failed to create user folder.']);
        exit;
    } else {
        echo json_encode(['success' => true, 'message' => 'User folder created successfully.']);
    }
} else {
    echo json_encode(['success' => true, 'message' => 'User folder already exists.']);
}
?>
