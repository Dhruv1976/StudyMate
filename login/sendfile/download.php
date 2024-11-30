<?php
$dbname = "file_upload_download";
$servername = "localhost";
$username = "root";
$password = "";
$file_id = isset($_GET['file_id']) ? (int) $_GET['file_id'] : null;

if ($file_id) {
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT filename, filetype, file_data FROM files WHERE id = ?");
        $stmt->execute([$file_id]);

        $file = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($file) {

            header('Content-Type: ' . $file['filetype']);
            header('Content-Disposition: attachment; filename="' . $file['filename'] . '"');


            echo $file['file_data'];
        } else {
            echo "File not found.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    } finally {
        if (isset($pdo)) {
            $pdo = null;
        }
    }
} else {
    echo "Invalid file ID.";
}
?>