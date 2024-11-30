<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\studyMate\src\login\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\studyMate\src\login\vendor\phpmailer\phpmailer\src\SMTP.php';
require 'C:\xampp\htdocs\studyMate\src\login\vendor\phpmailer\phpmailer\src\Exception.php';

if (isset($_POST['email'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_accounts";

    $email = $_POST['email'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        exit();
    }

    $tempass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

    $hashed_password = password_hash($tempass, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password=? WHERE email=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error in preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            try {
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Your SMTP host
                $mail->SMTPAuth = true;
                $mail->Username = 'studymate.co@gmail.com'; // SMTP username
                $mail->Password = 'bazw kwrv yavp jars'; // SMTP password
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption
                $mail->Port = 587; // TCP port to connect to

                $mail->setFrom('studymate.co@gmail.com', 'StudyMate');
                $mail->addAddress($email);
                $mail->isHTML(false);
                $mail->Subject = "StudyMate: Password Reset";
                $mail->Body = "Your temporary password is\n\n$tempass\n\nPlease change your password after login.";

                $mail->send();

                $reset_message = "Password reset email has been sent to your email address.";
            } catch (Exception $e) {
                $reset_message = "Failed to send password reset email.";
            }
        } else {
            $reset_message = "Email not found in the database.";
        }
    } else {
        $reset_message = "Error updating record: " . $stmt->error;
    }

    $stmt->close();

    $conn->close();

    echo $reset_message;
} else {
    echo "Email not provided via POST method.";
}
?>
