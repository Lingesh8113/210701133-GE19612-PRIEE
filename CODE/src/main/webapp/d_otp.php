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

// Check if OTP form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate OTP
    $otp_entered = $_POST['otp'];

    if ($otp_entered == $_SESSION['email_otp']) {
        // OTP verification successful, insert doctor data into database
        $name = $_SESSION['name'];
        $dob = $_SESSION['dob'];
        $gender = $_SESSION['gender'];
        $mobile = $_SESSION['mobile'];
        $email = $_SESSION['email'];
        $reg_no = $_SESSION['reg_no'];
        $year_of_reg = $_SESSION['year_of_reg'];
        $state_medical_council = $_SESSION['state_medical_council'];
        $address = $_SESSION['address'];
        $password = $_SESSION['password'];

        // Insert doctor data into database
        $sql = "INSERT INTO doctors (name, dob, gender, mobile_no, email, reg_no, year_of_reg, state_medical_council, address, password) 
                VALUES ('$name', '$dob', '$gender', '$mobile', '$email', '$reg_no', '$year_of_reg', '$state_medical_council', '$address', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Registration successful
            echo "Registration successful!";
            // Redirect user to login page or dashboard
             header("Location: d_signin.php");
             exit();
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
