<?php
// Start Session
session_start();

// Database Connection
include '../include.php';

if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($con, trim($_POST['email']));
   $password = mysqli_real_escape_string($con, trim($_POST['password']));

   $select = "SELECT * FROM admin_detail WHERE admin_email = '$email' AND password = '$password'";
   $result = mysqli_query($con, $select);

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_array($result);
      $_SESSION['admin_name'] = $row['name'];
      $_SESSION['admin_email'] = $row['admin_email'];
      $_SESSION['admin_id'] = $row['id'];
      header('location:index.php');
   }else{
      $error[] = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login | Fashion Fusion</title>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
   
   <style>
      body {
         font-family: 'Poppins', sans-serif;
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 100vh;
         /* Beautiful Gradient Background */
         background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
      }

      .form-container {
         background: rgba(255, 255, 255, 0.95);
         padding: 40px;
         border-radius: 20px;
         box-shadow: 0 15px 25px rgba(0,0,0,0.2);
         width: 100%;
         max-width: 400px;
         text-align: center;
      }

      .form-container h3 {
         font-size: 28px;
         color: #333;
         margin-bottom: 5px;
         font-weight: 600;
         text-transform: uppercase;
         letter-spacing: 2px;
      }
      
      .brand-sub {
         color: #666;
         font-size: 14px;
         margin-bottom: 30px;
      }

      /* Input Field with Black Border */
      .input-field {
         width: 100%;
         padding: 15px;
         margin: 12px 0;
         background: #fff;
         border: 2px solid #333; /* Black Border */
         border-radius: 30px;
         outline: none;
         font-size: 16px;
         text-align: center;
         transition: 0.3s;
         box-sizing: border-box;
         color: #333;
         font-weight: 500;
      }

      .input-field:focus {
         background: #fff;
         border-color: #000;
         box-shadow: 0 0 10px rgba(0,0,0,0.2);
         transform: scale(1.02);
      }

      .form-btn {
         width: 100%;
         padding: 15px;
         border: none;
         border-radius: 30px;
         background: linear-gradient(to right, #667eea, #764ba2);
         color: #fff;
         font-size: 18px;
         font-weight: bold;
         cursor: pointer;
         transition: 0.3s;
         margin-top: 20px;
         text-transform: uppercase;
         box-shadow: 0 5px 15px rgba(118, 75, 162, 0.3);
      }

      .form-btn:hover {
         transform: translateY(-2px);
         box-shadow: 0 8px 20px rgba(118, 75, 162, 0.5);
      }

      .error-msg {
         display: block;
         background: #ffe6e6;
         color: #d9534f;
         padding: 12px;
         border-radius: 10px;
         margin-bottom: 20px;
         font-size: 14px;
         border: 1px solid #ffcccc;
         font-weight: 500;
      }

      /* Style for the Home Link */
      .home-link {
         display: block;
         margin-top: 20px;
         font-size: 14px;
         color: #333;
         text-decoration: none;
         font-weight: 600;
         transition: 0.3s;
      }

      .home-link:hover {
         color: #764ba2; /* Changes to purple on hover */
         text-decoration: underline;
      }

   </style>
</head>
<body>

<div class="form-container">
   <form action="" method="post">
      <h3>Admin Login</h3>
      <p class="brand-sub">Welcome back to Fashion Fusion</p>
      
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         }
      }
      ?>
      
      <input type="email" name="email" required placeholder="Enter Email Address" class="input-field">
      <input type="password" name="password" required placeholder="Enter Password" class="input-field">
      <input type="submit" name="submit" value="Login" class="form-btn">
      
      <a href="../login.php" class="home-link">← Go to Customer Login / Home</a>

   </form>
</div>

</body>
</html>