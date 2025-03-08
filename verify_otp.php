<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    // Validate OTP
    if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
        // OTP is correct, proceed with login or sign-up completion
        echo "OTP verified successfully!";
        // Clear OTP from session
        unset($_SESSION['otp']);
        // Redirect to the appropriate dashboard or welcome page
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
</head>
<body>
    <h2>Verify OTP</h2>
    <form method="POST" action="">
        <div>
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" required>
        </div>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
