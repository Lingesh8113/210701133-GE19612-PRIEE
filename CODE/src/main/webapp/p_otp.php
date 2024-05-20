<?php
session_start();
require 'db_config.php'; // Make sure this file contains your database connection details
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

// Check if OTP form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate OTP
    $otp_entered = $_POST['otp'];

    if ($otp_entered == $_SESSION['email_otp']) {
        // OTP verification successful, insert patient data into database
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $mobile = $_SESSION['mobile'];
        $dob = $_SESSION['dob'];
        $gender = $_SESSION['gender'];
        $address = $_SESSION['address'];
        $password = $_SESSION['password'];

        // Insert patient data into database
        $sql = "INSERT INTO patients (name, email, mobile_no, dob, gender, address, password) 
                VALUES ('$name', '$email', '$mobile', '$dob', '$gender', '$address', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Registration successful
            echo "Registration successful!";
            // Redirect user to login page or dashboard
            // header("Location: login.php");
            // exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // OTP verification failed
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email OTP Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Email OTP Verification</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="otp">Enter OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
</body>
</html>
