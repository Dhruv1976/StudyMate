<?php
session_start(); // Start the session

// Temporary connection to the "user_accounts" database
$servername = "localhost"; // Change if necessary
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "user_accounts"; // Change if necessary

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID and email from session
    $userId = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    $newPassword = $_POST['newPassword'];

    // Check if the user ID and email exist in the session
    if ($userId && $email) {
        // Proceed with updating the password
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password = '$hashed_password' WHERE id = '$userId' AND email = '$email'";

        if ($conn->query($update_sql) === TRUE) {
            // Password updated successfully
            echo "Password updated successfully.";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        // User ID or email not found in the session
        echo "User ID or email not found in session.";
    }
}

// Close connection
$conn->close();
?>
