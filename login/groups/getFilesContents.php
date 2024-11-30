<?php
include ("dbconnect.php");

if (isset($_GET["groupName"]) && isset($_GET["admin"])) {
    function displayFiles($groupName)
    {
        $fileListElement = '';
        $db = "file_upload_download";
        $fileListData = fetchQuery("SELECT id,filename, filesize, uploadedBy,status FROM files WHERE group_id = '" . $_GET["groupName"] . "' AND (`status` = 'pending' or `status` = 'accepted')", $db);
        if ($_GET["admin"] == "true") {


            if (!empty($fileListData)) {
                //echo "<input type='text' placeholder='Search files'>";
                foreach ($fileListData as $file) {

                    $div = ($file['status'] == 'pending') ? "filebuttons1" : "filebuttons";
                    $fileListElement .= '<div class="file-entry">';

                    $fileListElement .= '  <div>Filename: ' . $file['filename'] . '</div>';
                    $fileListElement .= '  <div>Filesize: ' . $file['filesize'] . ' bytes</div>';
                    $fileListElement .= '  <div>Uploaded by: ' . $file['uploadedBy'] . '</div>';
                    $fileListElement .= '<div class="' . $div . '">
                                             <form method="get" action="../sendfile/download.php"> <input type="hidden" name="file_id" value=' . $file['id'] . ' readonly><button type="submit" class="download-button" download>Download</button></form>';
                    if ($file['status'] == 'pending')
                        $fileListElement .= '<button class="fileacceptreq" name = "' . $file['filename'] . '" onclick="acceptfile(this.id,this.name)" id="' . $file['id'] . '"> Accept</button><button name = "' . $file['filename'] . '" class="fileacceptreq" onclick="rejectfile(this.id,this.name)" id="' . $file['id'] . '"> Reject</button>';
                    $fileListElement .= '</div></div>';
                }
            } else {
                $fileListElement .= '<div class="file-entry"><div>No files found.</div></div>';
            }
        } else if ($_GET["admin"] == "false") {
            // $fileListData = fetchQuery("SELECT id,filename, filesize, uploadedBy FROM files WHERE group_id = '" . $_GET["groupName"] . "' AND `status` = 'accepted'", $db);

            if (!empty($fileListData)) {

                foreach ($fileListData as $file) {

                    $fileListElement .= '<div class="file-entry">';

                    $fileListElement .= '  <div>Filename: ' . $file['filename'] . '</div>';
                    $fileListElement .= '  <div>Filesize: ' . $file['filesize'] . ' bytes</div>';
                    $fileListElement .= '  <div>Uploaded by: ' . $file['uploadedBy'] . '</div>';
                    if ($file['status'] == 'accepted')
                        $fileListElement .= '<div class="filebuttons" style="justify-content:center;"> <form action="../sendfile/download.php"> <input type="hidden" name="file_id" value=' . $file['id'] . ' readonly><button type="submit" class="download-button" download>Download</button></form></div>';
                    else
                        $fileListElement .= '<div class="filebuttons" style="justify-content:center;"><button class ="cant-download">Pending</button></div>';
                    $fileListElement .= '</div>';
                }
            } else {
                $fileListElement .= '<div class="file-entry"><div>No files found.</div></div>';
            }
        }

        echo $fileListElement;
    }

    displayFiles($_GET["groupName"]);
} else {
    // echo $_GET["groupName"] ;echo" ".$_GET["admin"];
    echo "not found any";
}
?>