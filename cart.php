<?php
error_reporting(0);
session_start();
$user=$_SESSION['email'];
if(!isset($user)){
   header('location:login.php');
}
@include 'include.php';

if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($con, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      header('location:cart.php');
   };
};

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($con, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($con, "DELETE FROM `cart`");
   header('location:cart.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>
   
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
   <link rel="stylesheet" href="css/nav.css">

   <style>
      /* --- MODERN CART UI CSS --- */
      :root {
         --primary: #e91e63; /* Matches your brand color */
         --dark: #333;
         --light: #f8f9fa;
         --border: #e9ecef;
         --shadow: 0 10px 30px rgba(0,0,0,0.08);
      }

      body {
         font-family: 'Poppins', sans-serif;
         background-color: #f4f6f8;
         margin: 0;
         padding-bottom: 50px;
      }

      .main-wrapper {
         max-width: 1200px;
         margin: 100px auto 0; /* Space for fixed nav */
         padding: 0 20px;
      }

      .cart-header {
         text-align: center;
         margin-bottom: 30px;
      }

      .cart-header h1 {
         font-size: 2.2rem;
         font-weight: 600;
         color: var(--dark);
         margin-bottom: 10px;
         text-transform: uppercase;
         letter-spacing: 1px;
      }

      .cart-card {
         background: white;
         border-radius: 16px;
         box-shadow: var(--shadow);
         overflow: hidden;
         padding: 20px;
      }

      /* Table Styling */
      .cart-table {
         width: 100%;
         border-collapse: collapse;
      }

      .cart-table thead {
         background-color: #fff;
         border-bottom: 2px solid var(--border);
      }

      .cart-table th {
         padding: 15px;
         text-align: left;
         font-weight: 500;
         color: #777;
         font-size: 0.9rem;
         text-transform: uppercase;
      }

      .cart-table td {
         padding: 20px 15px;
         vertical-align: middle;
         border-bottom: 1px solid var(--border);
         color: var(--dark);
      }

      /* Product Info */
      .product-img {
         border-radius: 8px;
         object-fit: cover;
         box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      }

      .product-name {
         font-weight: 600;
         font-size: 1rem;
      }

      .price {
         color: var(--primary);
         font-weight: 500;
      }

      /* Quantity Form */
      .qty-form {
         display: flex;
         align-items: center;
         gap: 10px;
      }

      .qty-input {
         width: 60px;
         padding: 8px;
         border: 1px solid #ddd;
         border-radius: 6px;
         text-align: center;
         font-family: inherit;
      }

      .btn-update {
         background: var(--dark);
         color: white;
         border: none;
         padding: 8px 15px;
         border-radius: 6px;
         cursor: pointer;
         font-size: 0.85rem;
         transition: 0.3s;
      }

      .btn-update:hover {
         background: #555;
      }

      /* Actions */
      .delete-btn {
         color: #ff4757;
         font-size: 1.2rem;
         transition: 0.3s;
      }
      .delete-btn:hover {
         color: #d63031;
         transform: scale(1.1);
      }

      .continue-shop {
         color: var(--dark);
         font-size: 1.5rem;
      }

      /* Footer / Totals */
      .cart-footer {
         margin-top: 30px;
         display: flex;
         justify-content: flex-end;
      }

      .summary-box {
         background: #fff;
         width: 100%;
         max-width: 400px;
         border-radius: 12px;
         padding: 25px;
         border: 1px solid var(--border);
      }

      .summary-row {
         display: flex;
         justify-content: space-between;
         margin-bottom: 15px;
         font-size: 1.1rem;
      }

      .summary-row.total {
         font-weight: 700;
         color: var(--dark);
         font-size: 1.4rem;
         border-top: 1px solid var(--border);
         padding-top: 15px;
         margin-top: 10px;
      }

      .checkout-btn {
         display: block;
         width: 100%;
         text-align: center;
         background: var(--primary);
         color: white;
         padding: 15px;
         border-radius: 8px;
         text-decoration: none;
         font-weight: 600;
         letter-spacing: 1px;
         margin-top: 20px;
         transition: 0.3s;
      }

      .checkout-btn:hover {
         background: #c2185b;
         box-shadow: 0 5px 15px rgba(233, 30, 99, 0.4);
      }

      .checkout-btn.disabled {
         background: #ccc;
         pointer-events: none;
      }

      .bill-actions {
         text-align: right;
         margin-top: 20px;
      }

      .bill-link {
         display: inline-block;
         margin-left: 15px;
         color: #666;
         font-size: 0.9rem;
         text-decoration: underline;
      }

      /* Responsive */
      @media (max-width: 768px) {
         .cart-table thead { display: none; }
         .cart-table, .cart-table tbody, .cart-table tr, .cart-table td {
            display: block;
            width: 100%;
         }
         .cart-table tr {
            margin-bottom: 20px;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 15px;
         }
         .cart-table td {
            text-align: right;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
         }
         .cart-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #777;
         }
         .product-img { height: 80px; width: 80px; }
      }

.main-wrapper {
   max-width: 1200px;
   /* CHANGE 100px TO 180px HERE */
   margin: 180px auto 0; 
   padding: 0 20px;
}


   </style>
</head>
<body>

<?php @include 'header.php';?>

<div class="main-wrapper">
   
   <div class="cart-header">
      <h1>Your Shopping Bag</h1>
   </div>

   <section class="cart-card">
      <table class="cart-table">
         <thead>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Remove</th>
         </thead>

         <tbody>
            <?php 
            // Note: Keeping your logic exactly as is
            $select_cart = mysqli_query($con, "SELECT * FROM `cart` where email='$user'" );
            $grand_total = 0;
            if(mysqli_num_rows($select_cart) > 0){
               while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            ?>

            <tr>
               <td data-label="Image">
                  <img src="admin/uploaded_img/<?php echo $fetch_cart['image']; ?>" class="product-img" height="100" width="100" alt="">
               </td>
               
               <td data-label="Product">
                  <div class="product-name"><?php echo $fetch_cart['name']; ?></div>
               </td>
               
               <td data-label="Price" class="price">
                  Rs.<?php echo($fetch_cart['price']); ?>/-
               </td>
               
               <td data-label="Quantity">
                  <form action="" method="post" class="qty-form">
                     <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                     <input type="number" name="update_quantity" class="qty-input" min="1" max="20" value="<?php echo $fetch_cart['quantity']; ?>">
                     <input type="submit" value="Update" name="update_update_btn" class="btn-update">
                  </form>   
               </td>
               
               <td data-label="Total" class="price">
                  Rs.<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-
               </td>
               
               <td data-label="Action">
                  <a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn">
                     <i class="bi bi-trash3-fill"></i>
                  </a>
               </td>
            </tr>

            <?php
               $grand_total += $sub_total;  
               };
            };
            ?>
         </tbody>
      </table>

      <div style="padding: 20px; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
         <a href="products.php" class="continue-shop" title="Continue Shopping"><i class="bi bi-arrow-left-circle"></i> Shop More</a>
         
         <a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn" style="font-size: 0.9rem;">
            <i class="bi bi-x-circle"></i> Clear Cart
         </a>
      </div>

   </section>

   <div class="cart-footer">
      <div class="summary-box">
         <div class="summary-row">
            <span>Subtotal</span>
            <span>Rs.<?php echo $grand_total; ?></span>
         </div>
         <div class="summary-row">
            <span>Shipping</span>
            <span style="color: green;">Free</span>
         </div>
         <div class="summary-row total">
            <span>Grand Total</span>
            <span>Rs.<?php echo $grand_total; ?>/-</span>
         </div>

         <a href="checkout.php" class="checkout-btn <?= ($grand_total > 1)?'':'disabled'; ?>">
            PROCEED TO CHECKOUT <i class="bi bi-arrow-right"></i>
         </a>

         <div class="bill-actions">
            <?php
            $user=$_SESSION['email'];
            mysqli_select_db($con, "fashionfusion");
            $q1 = "SELECT * FROM `orders` where email='$user'";
            $result = mysqli_query($con, $q1);
            if(mysqli_num_rows($result) > 0){
            ?>
               <a href='billrequestmsg.php' class="bill-link">View Bill</a>
               <a href='historyrequest.php' class="bill-link">History</a>
            <?php
            }
            ?>
         </div>
      </div>
   </div>

</div>

<script src="js/script.js"></script>
</body>
</html>