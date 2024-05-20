<?php
session_start();
require 'db_config.php'; // Make sure this file contains your database connection details
// Database configuration
$db_host = "localhost"; // Your database host (usually "localhost")
$db_user = "root"; // Your database username
$db_pass = ""; // Your database password
$db_name = "doc_actor"; // Your database name

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    
    // Generate OTP for email (assuming email verification only)
    $email_otp = rand(100000, 999999);
    $otp_expiry = date("Y-m-d H:i:s", strtotime("+10 minutes")); // OTP expires in 10 minutes
    
    // Store OTP and other data in session
    $_SESSION['email_otp'] = $email_otp;
    $_SESSION['otp_expiry'] = $otp_expiry;
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['mobile'] = $mobile;
    $_SESSION['dob'] = $dob;
    $_SESSION['gender'] = $gender;
    $_SESSION['address'] = $address;
    $_SESSION['password'] = $password;
    
    // Redirect to OTP verification page
    header("Location: p_otp.php");
    exit();
}
?>
