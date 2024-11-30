<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

if ($_GET) {
    if (isset($_GET["fileid"]) && $_GET["filerequest"]) {
        include ("dbconnect.php");
        if ($_GET["filerequest"] == 'accepted')
            echo json_encode(array('result' => execQuery("UPDATE `files` SET `status`= '" . $_GET['filerequest'] . "' WHERE id = '" . $_GET['fileid'] . "'", "file_upload_download")));
        else
            echo json_encode(array('result' => execQuery("delete from `files`  WHERE id = '" . $_GET['fileid'] . "'", "file_upload_download")));
    }
}
?>