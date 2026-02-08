<?php
// Connect to Database
$con = mysqli_connect("localhost", "root", "", "fashion_fusion");

if(!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}

echo "<h3>--- Fixing Admin Password ---</h3>";

// 1. Force Update the password to '12345' (No spaces, very simple)
$sql = "UPDATE `admin_detail` SET `password` = '12345' WHERE `admin_email` = 'admin@gmail.com'";

if(mysqli_query($con, $sql)) {
    echo "<h2 style='color:green'>SUCCESS! Password Changed.</h2>";
    echo "Now your Admin Password is: <b>12345</b><br><br>";
    echo "User: <b>admin@gmail.com</b><br>";
    echo "Pass: <b>12345</b><br><br>";
    echo "<a href='login.php'>Click here to Login</a>";
} else {
    echo "<h2 style='color:red'>Error updating password: " . mysqli_error($con) . "</h2>";
}
?>