<?php

if (isset($_GET['fileName']) && isset($_GET['folderPath'])) {

    $fileName = basename($_GET['fileName']);
    $folderPath = $_GET['folderPath'];

    $filePath = __DIR__ . '/uploads' . '/' . $folderPath . '/' . $fileName;

    header('Content-Disposition: attachment; filename="' . $fileName);


    readfile($filePath);
    exit;
}
?>