<?php
session_start();
// Error reporting off for users to avoid messy screen
error_reporting(0);
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
        
        <h4 class="text" style="margin-top: 15px;">Are you an Admin? <a href="admin/admin_login.php" style="color: #ff8795; font-weight: bold;">Login Here</a></h4>
        
      </div>
    </div>

<?php
if(isset($_POST['login']))
{
    // FIX: Using include.php for correct DB connection
    include 'include.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check User in user_detail table
    $q1 = "SELECT * FROM `user_detail` WHERE email='$email' AND password='$password'";
    $result = mysqli_query($con, $q1);

    if(mysqli_num_rows($result) > 0) {
        // Login Success
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email']; 
        $_SESSION['user_id'] = $row['id']; // Storing ID is safer
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
                    window.location.href = 'index.php'; // Redirect to User Home
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
                    text: 'Invalid Email or Password! (Please check if you Signed Up correctly)',
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