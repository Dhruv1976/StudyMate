<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "user_accounts";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



function execQuery($query, $dbname)
{
    $servername = "localhost";
    $username = "root";
    $password = "";

    switch ($dbname) {
        case "file_upload_download":
            $dbname = "file_upload_download";
            break;
        case "study_mate":
            $dbname = "study_mate";
            break;
        case "studymate":
            $dbname = "studymate";
            break;
            case "users":
                $dbname = "users";
                break;
    }
    $connection1 = mysqli_connect($servername, $username, $password, $dbname);


    if (!$connection1) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $result = mysqli_query($connection1, $query);
    if ($result) {
        $connection1->close();
        return true;
    } else {
        $connection1->close();
        return false;
    }
}

function fetchQuery($query, $dbname)
{
    $servername = "localhost";
    $username = "root";
    $password = "";

    switch ($dbname) {
        case "file_upload_download":
            $dbname = "file_upload_download";
            break;
        case "study_mate":
            $dbname = "study_mate";
            break;
        case "studymate":
            $dbname = "studymate";
            break;
            case "users":
                $dbname = "users";
                break;
    }
    $connection1 = mysqli_connect($servername, $username, $password, $dbname);
    $result = mysqli_query($connection1, $query);

    if (!$result) {
        die("Error executing query: " . mysqli_error($connection1));
    }

    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    mysqli_free_result($result);
    $connection1->close();
    return $rows;

}
?>
