<?php
error_reporting(0);
session_start();
@include 'include.php'; 

// Database connection check (Safety)
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order Confirmation | Payment Successful</title>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
   <style>
        :root {
            --success: #10b981;
            --primary: #6366f1;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --bg: #f3f4f6;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .success-card { background: white; width: 450px; padding: 40px; border-radius: 20px; text-align: center; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
        .icon-circle { width: 80px; height: 80px; background: #ecfdf5; color: var(--success); border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 20px; }
        .icon-circle svg { width: 40px; height: 40px; stroke-width: 3; stroke: currentColor; fill: none; }
        h1 { color: var(--text-main); font-size: 24px; margin-bottom: 8px; }
        .sub-text { color: var(--text-muted); font-size: 14px; margin-bottom: 30px; }
        .receipt-box { background: #f9fafb; border-radius: 12px; padding: 20px; text-align: left; margin-bottom: 30px; border: 1px solid #f3f4f6; }
        .receipt-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
        .receipt-row:last-child { margin-bottom: 0; padding-top: 12px; border-top: 1px dashed #d1d5db; }
        .label { color: var(--text-muted); }
        .value { color: var(--text-main); font-weight: 600; }
        .btn-group { display: flex; flex-direction: column; gap: 12px; }
        .btn-primary { background: var(--primary); color: white; padding: 14px; border-radius: 8px; text-decoration: none; font-weight: 600; }
        .btn-secondary { background: white; color: var(--text-main); border: 1px solid #d1d5db; padding: 12px; border-radius: 8px; text-decoration: none; font-size: 14px; }
        @media print { .btn-group, .icon-circle { display: none; } }
   </style>
</head>
<body>

<?php
if(isset($_POST['order_btn']))
{ 
      $user = $_SESSION['email'];
      $items = mysqli_real_escape_string($con, $_POST['items']);
      $custname = mysqli_real_escape_string($con, $_POST['name']);
      $contactno = $_POST['contact'];
      $email = $_POST['email'];
      $gender = $_POST['gender'];
      $address = mysqli_real_escape_string($con, $_POST['address']);
      $city = $_POST['city'];
      $state = $_POST['state'];
      $country = $_POST['country'];
      $pincode = $_POST['pin_code'];
      $payment = $_POST['payment'];

      // Checking conditions
      $check_q = "SELECT * FROM orders WHERE email = '$user' AND status='pending'";
      $result = mysqli_query($con, $check_q);
      
      if(empty($items)){
         echo "<script>Swal.fire({icon:'info', title:'Empty Cart', text:'Please add items first.'}).then(()=>{window.location.href='Products.php';});</script>";
      }
      elseif(mysqli_num_rows($result) > 0)
      {   
         echo "<script>Swal.fire({icon:'info', title:'Pending Order', text:'Previous request is pending.'}).then(()=>{window.location.href='cart.php';});</script>";
      }
      else {
         // Insert order details
         $q_insert = "INSERT INTO `orders`(items,custname,contactno,email,gender,address,city,state,country,pincode,payment,status) 
                      VALUES('$items','$custname','$contactno','$email','$gender','$address','$city','$state','$country','$pincode','$payment','pending')";
         
         if(mysqli_query($con, $q_insert))
         {
            // Clear cart
            mysqli_query($con, "DELETE FROM `cart` WHERE email='$user'");
            $txn_id = "TXN" . rand(100000, 999999);
            ?>

            <div class="success-card">
                <div class="icon-circle">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h1>Order Placed!</h1>
                <p class="sub-text">Thank you <b><?php echo htmlspecialchars($custname); ?></b>. Your order is recorded.</p>

                <div class="receipt-box">
                    <div class="receipt-row"><span class="label">Transaction ID</span><span class="value"><?php echo $txn_id; ?></span></div>
                    <div class="receipt-row"><span class="label">Payment Status</span><span class="value" style="color: #10b981;">Success</span></div>
                    <div class="receipt-row"><span class="label">Total Amount</span><span class="value" style="color: var(--primary); font-size: 16px;"><?php echo htmlspecialchars($payment); ?></span></div>
                </div>

                <div class="btn-group">
                    <a href="Products.php" class="btn-primary">Continue Shopping</a>
                    <a href="#" onclick="window.print()" class="btn-secondary">Print Receipt</a>
                </div>
            </div>

            <?php
         } else {
             // Line 132-la vara error-ah fix panna proper semicolon use pannirukkom
             echo "<div style='text-align:center; padding:50px;'>";
             echo "<h2 style='color:red;'>Database Error</h2>";
             echo "<p>" . mysqli_error($con) . "</p>";
             echo "</div>";
         }
      }
} else {
    echo "<h2 style='text-align:center;margin-top:50px;'>Direct access not allowed.</h2>";
}
?>
</body>
</html>