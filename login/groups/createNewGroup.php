<?php
session_start();
function addNewGroup($adminid, $adminname, $Gname, $Gdesc)
{   
    $Gname = validateInput($Gname);
    
    if (!doesNameExists($Gname, 'groups', 'groupName', "study_mate")) {
        
        $connection = mysqli_connect("localhost", "root", "", "study_mate");

        $query1 = "INSERT INTO groups (`admin_id`,`admin_name`, `groupname`, `group_description`) VALUES (?,?, ?, ?)";
        $stmt1 = mysqli_prepare($connection, $query1);
        mysqli_stmt_bind_param($stmt1, "isss", $adminid, $adminname, $Gname, $Gdesc);


        if (mysqli_stmt_execute($stmt1)) {
            $Gid = mysqli_insert_id($connection);
            $query2 = "INSERT INTO group_status_list (user_id, username, group_id, groupname, status) VALUES (?, ?, ?, ?, 'admin')";
            $stmt2 = mysqli_prepare($connection, $query2);
            mysqli_stmt_bind_param($stmt2, "isss", $adminid, $adminname, $Gid, $Gname);


            if (mysqli_stmt_execute($stmt2)) {
                // if(0)filefunctionS()
                echo "  Group `$Gname` created sucessfully.  ";

            } else {
                echo " Error creating group status! ";
            }
        } else {
            echo " Error creating group! ";
        }
    } else {
        echo "  Group with this name already exists! ";
    }
}
function doesNameExists($name, $table, $col, $Db)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $connection = mysqli_connect($servername, $username, $password, $Db);
    $query = "SELECT COUNT(*) AS count FROM $table WHERE $col = '$name'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_close($connection);
        return $row['count'] > 0;
    } else {
        mysqli_close($connection);
        die('Error: ' . mysqli_error($connection));
    }
}
function validateInput($input)
{

    $pattern = '/^[a-zA-Z0-9\s]*$/';


    if (preg_match($pattern, $input)) {

        $input = str_replace(' ', '_', $input);
    } else {

        $inputWithoutSpecialChars = preg_replace('/[^a-zA-Z0-9\s]/', '', $input);
        $inputWithoutSpecialChars = str_replace(' ', '_', $inputWithoutSpecialChars);


        if ($input != $inputWithoutSpecialChars) {

            echo "No Special characters allowed. checking Name : '".$inputWithoutSpecialChars."' \n";
        }
        $input = $inputWithoutSpecialChars;
    }
    return $input;
}

if (isset($_GET['groupName'])) {
    
    
    $Gname = $_GET['groupName'];
    $adminid = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : "temp";
    $adminname = !empty($_SESSION["name"]) ? $_SESSION["name"] : "tester";

    $Gdesc = !empty($_GET['groupDescription']) ? $_GET['groupDescription'] : "-";
    $connection = mysqli_connect('localhost', 'root', '', 'study_mate');
    if ($connection) {
        addNewGroup($adminid, $adminname, $Gname, $Gdesc);
        mysqli_close($connection);
    } else {
        echo " Failed to connect to database  ";
    }
    
}
?>