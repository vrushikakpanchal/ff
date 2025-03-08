<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo "Email and Password are required.";
        exit;
    }

    // Get user details
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Generate and send OTP
            $otp = rand(100000, 999999); // Generate a random 6-digit OTP
            send_otp($email, $otp); // Send the OTP to the user's email

            // Store OTP in session for verification
            $_SESSION['otp'] = $otp;
            $_SESSION['user_id'] = $user_id;
            echo "OTP has been sent to your email. Please check your inbox.";
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "User not found!";
    }
}
?>
