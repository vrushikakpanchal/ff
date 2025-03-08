<?php
function send_otp($email, $otp) {
    $subject = "Your OTP Code";
    $message = "Your OTP code is: " . $otp;
    $headers = "From: no-reply@yougoo.com";

    // Use mail function to send the OTP
    if (mail($email, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}
?>
