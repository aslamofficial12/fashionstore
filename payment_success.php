<?php
error_reporting(0);
session_start();
@include 'include.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Processing Payment...</title>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <style>
       body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; }
   </style>
</head>
<body>

<?php
// Checks if the user actually clicked Pay Now
if(isset($_POST['order_btn']))
{ 
      $user=$_SESSION['email'];
      $items=$_POST['items'];
      $custname=$_POST['name'];
      $contactno=$_POST['contact'];
      $email=$_POST['email'];
      $gender=$_POST['gender'];
      $address=$_POST['address'];
      $city=$_POST['city'];
      $state=$_POST['state'];
      $country=$_POST['country'];
      $pincode=$_POST['pin_code'];
      $payment=$_POST['payment'];

      // DATABASE FIX: mysqli_select_db lines removed completely. Your include.php handles it!
      $q1 = "SELECT * FROM orders WHERE email = '$user' AND status='pending'";
      $result = mysqli_query($con, $q1);
      
      if(empty($items)){
         ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                    icon: 'info',
                    title:'Sorry !',
                    text: 'Your Cart Is Empty , Shopping Now.',
                    }).then(() => {
                    window.location.href = 'Products.php'; 
                    });
                });
            </script>
         <?php
      }
      elseif(mysqli_num_rows($result)>0)
      {   
            ?>
            <script>
               document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                  icon: 'info',
                  title:'Sorry !',
                  text: 'Your Previous Request is Pending , Please Wait For Approval.',
                  }).then(() => {
                  window.location.href = 'cart.php';
                  });
               });
            </script>
            <?php
       }
      else {
         // Insert order details
         $q1="INSERT INTO `orders`(items,custname,contactno,email,gender,address,city,state,country,pincode,payment) VALUES('$items','$custname','$contactno','$email','$gender','$address','$city','$state','$country','$pincode','$payment')";
         
         $insert_result = mysqli_query($con, $q1);

         if($insert_result)
         {
            // Clear cart
            $q2="DELETE FROM `cart` where email='$user'";
            mysqli_query($con, $q2);

            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                    icon: 'success',
                    title:'Payment Successful!',
                    text: 'Your Order has been Placed Successfully.',
                    }).then(() => {
                    window.location.href = 'cart.php'; 
                    });
                });
            </script>
            <?php
         } else {
             // Will show you the exact error if DB insert fails
             echo "<h2 style='text-align:center;color:red;margin-top:50px;'>Database Insert Error: " . mysqli_error($con) . "</h2>";
         }
      }
} else {
    // Prevents the blank screen if someone opens this file directly
    echo "<h2 style='text-align:center;margin-top:50px;'>Direct access not allowed. Please checkout from the cart.</h2>";
}
?>
</body>
</html>