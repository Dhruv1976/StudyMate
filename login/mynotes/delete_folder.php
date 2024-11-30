<?php
    // Get the folder path from the form data
    $folderPath = __DIR__.'/uploads/'. $_POST['folderPath'];
   
    
        if (!isset($folderPath) || empty($folderPath)) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Invalid folder path."]);
            exit;
        }
    
        // Attempt to delete the folder and its contents
        if (removeDirectory($folderPath)) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Failed to delete folder."]);
        }
    // } else {
    //     http_response_code(405);
    //     echo json_encode(["success" => false, "message" => "Method not allowed."]);
    // }
    
    function removeDirectory($path) {
        $i = new DirectoryIterator($path);
        foreach ($i as $f) {
            if ($f->isFile()) {
                unlink($f->getRealPath());
            } else if (!$f->isDot() && $f->isDir()) {
                removeDirectory($f->getRealPath());
            }
        }
        rmdir($path);
        return true;
    }
    ?>
    