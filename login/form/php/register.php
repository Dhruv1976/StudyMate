<?php
session_start(); // Start the session

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $check_sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Email already exists, handle it accordingly
        echo "*Email is already registered.";

    } else {
        function generateRandomString($length = 10)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

        // Function to generate a unique folder ID for a user
        // Function to generate a unique folder ID for a user
        function generateUniqueFolderID($conn)
        {
            $unique = false;
            $folderID = '';
            while (!$unique) {
                // Generate a random string
                $randomString = generateRandomString(8);
                // Concatenate with user ID to ensure uniqueness
                $folderID = 'user_' . $randomString;
                // Check if the folder ID already exists in the database
                $sql = "SELECT * FROM users WHERE folder_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $folderID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 0) {
                    // Folder ID is unique
                    $unique = true;
                }
            }
            return $folderID;
        }
        // Email doesn't exist, proceed with registration
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $folderID = generateUniqueFolderID($conn);
        $sql = "INSERT INTO users (name,email,password,folder_id) VALUES ('$name', '$email', '$hashed_password','$folderID')";

        if (mysqli_query($conn, $sql)) {
            // Set session variables
            $user_id = mysqli_insert_id($conn);
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            $_SESSION['folder_id'] = $folderID;
            (execQuery("SET GLOBAL max_allowed_packet = 100*1024*1024;","study_mate"));
            
            echo "success";

            // Redirect to dashboard
            // header("Location: /studyMate/src/login/quicknotes/quicknotes.html");
            // exit(); // Ensure script stops executing after redirect
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>