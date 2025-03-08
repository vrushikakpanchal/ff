<?php
session_start();
include 'db_connect.php';
include 'send_otp.php'; // Ensure the path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $policeID = $_POST['policeID'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Validate inputs
    if (empty($fullName) || empty($policeID) || empty($role) || empty($email) || empty($phone) || empty($state) || empty($city)) {
        echo "All fields are required.";
        exit;
    }

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO admin (full_name, police_id, role, email, phone, state, city, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $fullName, $policeID, $role, $email, $phone, $state, $city, $password);

    if ($stmt->execute()) {
        // Generate and send OTP
        $otp = rand(100000, 999999); // Generate a random 6-digit OTP
        if (send_otp($email, $otp)) { // Send the OTP to the user's email
            echo "OTP has been sent to your email. Please check your inbox.";
        } else {
            echo "Failed to send OTP.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
