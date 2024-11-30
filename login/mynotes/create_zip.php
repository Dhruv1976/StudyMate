<?php

$folderPath = __DIR__ . '/uploads/' . $_GET['folderPath'];
$zipFilename = 'demo.zip';


$zip = new ZipArchive();
if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    // Add all files and subdirectories in the specified folder to the ZIP archive
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath), RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($files as $name => $file) {

        if (!$file->isDir()) {

            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($folderPath) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }


    $zip->close();


    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
    header('Content-Length: ' . filesize($zipFilename));


    readfile($zipFilename);

    unlink($zipFilename);

    exit;
} else {

    http_response_code(500);
    echo 'Failed to create ZIP file.';
    exit;
}
?>