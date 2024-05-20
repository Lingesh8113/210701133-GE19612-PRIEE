<?php
session_start();

// Database configuration
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "doc_actor";

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to send OTP via email
function sendEmailOTP($email, $otp) {
    $to = $email;
    $subject = "Your OTP Code";
    $message = "Your OTP code for registration is: $otp";
    $headers = "From: 210701160@rajalakshmi.edu.in"; // Replace with your email

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $reg_no = $_POST['reg_no'];
    $year_of_reg = $_POST['year_of_reg'];
    $state_medical_council = $_POST['state_medical_council'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate OTP for email
    $email_otp = rand(100000, 999999);
    $otp_expiry = date("Y-m-d H:i:s", strtotime("+10 minutes")); // OTP expires in 10 minutes

    // Store OTP and other data in session
    $_SESSION['email_otp'] = $email_otp;
    $_SESSION['otp_expiry'] = $otp_expiry;
    $_SESSION['name'] = $name;
    $_SESSION['dob'] = $dob;
    $_SESSION['gender'] = $gender;
    $_SESSION['mobile'] = $mobile;
    $_SESSION['email'] = $email;
    $_SESSION['reg_no'] = $reg_no;
    $_SESSION['year_of_reg'] = $year_of_reg;
    $_SESSION['state_medical_council'] = $state_medical_council;
    $_SESSION['address'] = $address;
    $_SESSION['password'] = $hashed_password;

    // Send OTP via email
    $emailSent = sendEmailOTP($email, $email_otp);

    if ($emailSent) {
        // Redirect to OTP verification page
        header("Location: d_otp.php");
        exit();
    } else {
        echo "Failed to send OTP. Please try again.";
    }
}
?>
