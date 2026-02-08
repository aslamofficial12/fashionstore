<?php
// Start Session
session_start();

// Database Connection (Path Corrected)
include '../include.php';

if(isset($_POST['submit'])){

   // Getting input values (Used trim to remove spaces)
   $email = mysqli_real_escape_string($con, trim($_POST['email']));
   $password = mysqli_real_escape_string($con, trim($_POST['password']));

   // Query
   $select = "SELECT * FROM admin_detail WHERE admin_email = '$email' AND password = '$password'";

   $result = mysqli_query($con, $select);

   if(mysqli_num_rows($result) > 0){
      // Login Success
      $row = mysqli_fetch_array($result);
      
      // Setting Session variables
      $_SESSION['admin_name'] = $row['name'];
      $_SESSION['admin_email'] = $row['admin_email'];
      $_SESSION['admin_id'] = $row['id'];
      
      // Redirect to Dashboard
      header('location:index.php');
   }else{
      // Login Failed
      $error[] = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login</title>
   
   <style>
      body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f0f0f0; }
      .form-container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 10px rgba(0,0,0,0.1); width: 350px; text-align: center; }
      .form-container h3 { font-size: 30px; margin-bottom: 20px; color: #333; }
      .form-container input { width: 100%; padding: 10px; margin: 10px 0; background: #eee; border: none; border-radius: 5px; box-sizing: border-box; }
      .form-btn { background: #333; color: #fff; cursor: pointer; font-size: 20px; }
      .form-btn:hover { background: #555; }
      .error-msg { background: #ffe6e6; color: #d9534f; padding: 10px; margin-bottom: 10px; border-radius: 5px; display: block; }
   </style>
</head>
<body>

<div class="form-container">
   <form action="" method="post">
      <h3>Admin Login</h3>
      
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         }
      }
      ?>
      
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login" class="form-btn">
   </form>
</div>

</body>
</html>