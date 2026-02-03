<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
@include 'include.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Men's Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style_index.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/nav.css">
    <script src="js/product.js" defer></script>
  </head>
  <body>
    
  <?php @include 'header.php';?>

    <h1>Men<span class="colored-word">'s Fashion</span></h1>
    <center><hr class="products-hr"></center>
    <br><br>

    <div class="container">
      <div class="products-container">
        <?php
        mysqli_select_db($con, "fashion_fusion");

        $q1 = "SELECT * FROM `products_man` ORDER BY id DESC";
        $result = mysqli_query($con, $q1);

        if(mysqli_num_rows($result) > 0){
          while($fetch_product = mysqli_fetch_assoc($result)){
            
            // --- 🔥 THE MAGIC FIX STARTS HERE 🔥 ---
            
            $db_image = $fetch_product['p_image']; // Example: "M20.Jpg"

            // 1. Remove Extension: "M20.Jpg" -> "M20"
            $filename_only = pathinfo($db_image, PATHINFO_FILENAME);

            // 2. FORCE SMALL LETTERS: "M20" -> "m20"
            // (Idhu dhaan romba mukkiyam!)
            $clean_name = strtolower($filename_only);

            // 3. ADD .png: "m20" -> "m20.png"
            $final_image_name = $clean_name . ".png";
            
            // --- 🔥 FIX ENDS HERE 🔥 ---
        ?>
          <a href="productdetail.php?edit=<?php echo $fetch_product['id']; ?>">
            <div class="product">
              
              <img src="images/products-img/man/<?php echo $final_image_name; ?>?v=<?php echo time(); ?>" 
                   alt="<?php echo $fetch_product['p_name']; ?>"
                   class="img-fluid"
                   onerror="this.src='images/logo.png';">
              
              <h3><?php echo $fetch_product['p_name']; ?></h3>
              <div class="price">Rs.<?php echo $fetch_product['p_price']; ?>/-</div>
            </div>
          </a>
        <?php
          }
        } else {
          echo "<h2>No Products Found!</h2>";
        }
        ?>
      </div>
    </div>

    <a href='cart.php'><h4 class="msg">Uh-Oh! We are<span class="colored-word"> done</span>🛒</h4></a>
    
    <div class="footer-container">
      <div class="footer-1">
        <a href="index.php"><h2>FASHION FUSION🦋</h2></a>
        <br>
        <p><b>ONLINE SHOPPING</b></p>
        <h6>Man<br><br>Woman <br><br>Kids <br><br>FashionFusion Exclusive<br><br></h6>
      </div>
      <div class="footer-2">
        <p><b>USEFUL LINKS</b></p>
        <h6><a href=""> Contact Us<br><br></a><a href=""> About US<br><br></a></h6>
      </div>
      <div class="footer-3">
        <p><b>100% Original</b> guarantee</p>
        <h6>for all products at merlinfashion.com</h6>
        <p><b>Return within 30days</b> of</p>
        <h6>receiving your order</h6>
        <p><b>Get free delivery</b> for every</p>
        <h6>order above Rs.999</h6>
      </div>
    </div>
    <p class="copy-right">&copy;2024 Fashion Fusion All Rights Reserved.</p>
  </body>
</html>