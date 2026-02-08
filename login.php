<?php
session_start();
// Error reporting - Idhu errors irundha screen la kaatum
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700|Montserrat:300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Chivo:300,700|Playfair+Display:700i" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>

<?php 
// Header file irundha include pannum, illana error varadhu (@ symbol)
@include 'header.php';
?>

    <div class="login">
      <img src="images/login-images/login.png" height="100%" alt="Login Image">
      <div class="line"></div>
      <div class="login-form">
        <form method="POST">
            <input type="text" placeholder="Enter Email" name="email" required>
            <br><br> 
            <input type="password" placeholder="Password" name="password" required>
            <br><br>
            <a align="right" href="forgot.php">Forgot Password?</a>
            <br><br>
            <input type="submit" value="LOGIN" name="login" class="login-button">
            <br>
        </form>
        <br>
        <hr>
        <h4 class="text">Don't Have An Account? <a href="signup.php">Sign Up</a></h4>
      </div>
    </div>

<?php
// PHP LOGIN LOGIC STARTS HERE
if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Database Connection (Updated to 'fashion_fusion')
    $con = mysqli_connect("localhost", "root", "", "fashion_fusion");

    // Connection Check
    if(!$con) {
        die("Connection Failed: " . mysqli_connect_error());
    }   

    // 2. Query to check User (Updated to 'user_detail' table)
    // Note: Use prepared statements in production for security
    $q1 = "SELECT * FROM `user_detail` WHERE email='$email' AND password='$password'";
    
    $result = mysqli_query($con, $q1);

    if(mysqli_num_rows($result) > 0) {
        // Login Success
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email']; 
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Welcome Back!',
                    text: 'Signed in successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'index.php'; // Redirect to home
                });
            });
        </script>
        <?php
    } else {
        // Login Failed
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: 'Invalid Email or Password!',
                    showConfirmButton: true
                });
            });
        </script>
        <?php
    }
}
?>

</body>
</html>