<?php
session_start();
include 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['name'];
            $_SESSION['folder_id'] = $row['folder_id'];
                (execQuery("SET GLOBAL max_allowed_packet = 100*1024*1024;","study_mate"));
                
            
            echo "success";
        } else {
            // Send error response for incorrect password
            echo "*Incorrect username or password.";
        }
    } else {
        // Send error response for user not found
        echo "*User not found";
    }
}
?>