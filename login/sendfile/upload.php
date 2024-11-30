<?php
$dbname = "file_upload_download";
$servername = "localhost";
$username = "root";
$password = "";
$maxFileSize = 100 * 1024 * 1024;
$maxFileSizeMb = $maxFileSize / (1024 * 1024);



try {

    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $filesize = $_FILES["file"]["size"];
        if ($filesize < $maxFileSize) {
        
            $fileData = file_get_contents($file['tmp_name']);


            
            $fileName = $file['name'];
            $fileType = $file['type'];
            

            $groupid = !empty($_POST['group']) ? $_POST['group'] : "testers Group";
            $uploadedby = !empty($_POST['name']) ? $_POST['name'] : "tester";
            $stmt = $pdo->prepare("INSERT INTO files (filename, filesize, filetype,file_data,uploadedBy,group_id,status) VALUES (?, ?, ?,?,?,?,'pending')");
            $stmt->execute([$fileName, $filesize, $fileType, $fileData, $uploadedby, $groupid]);

            echo "File uploaded successfully!";
        } else {
            echo "Files with size less than " . $maxFileSizeMb . " mb is allowed";
        }
    } else {
        echo "No file uploaded.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() .", file size : ". $filesize;
} finally {

    if (isset($pdo)) {
        $pdo = null;
    }
}
?>