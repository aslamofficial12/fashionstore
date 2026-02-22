<?php
error_reporting(0);
session_start();
@include 'include.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Products | Fashion Fusion</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700|Montserrat:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Chivo:300,700|Playfair+Display:700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="stylesheet" href="css/style_index.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/nav.css">
    <script src="js/product.js" defer></script>

    <style>
        :root {
            --primary-color: #333;
            --accent-color: #d4af37;
            --bg-light: #f9f9f9;
        }

        body { font-family: 'Montserrat', sans-serif; margin: 0; background-color: #fff; }

        /* GAP FIX */
        .main-content-wrapper {
            margin-top: 20px; 
        }

        .category-header { text-align: center; padding: 10px 20px 30px; }
        .category-header h1 { font-family: 'Playfair Display', serif; font-size: 2.2rem; margin: 0 0 10px 0; }
        .products-hr { width: 100px; border: 2px solid var(--accent-color); margin-bottom: 30px; }
        
        .products-container { display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; margin-bottom: 60px; }
        .product { transition: transform 0.3s ease; border-radius: 10px; overflow: hidden; background: #fff; width: 300px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        .product:hover { transform: translateY(-10px); }
        
        .product img { width: 100%; height: 350px; object-fit: cover; border-radius: 10px 10px 0 0; }
        .product h3 { padding: 15px; text-align: center; color: var(--primary-color); text-transform: uppercase; font-size: 1.1rem; margin: 0; }

        .trust-badges { background-color: var(--bg-light); padding: 40px 20px; display: flex; justify-content: space-around; flex-wrap: wrap; text-align: center; }
        .badge-item { flex: 1; min-width: 200px; padding: 10px; }
        .badge-item i { font-size: 2rem; color: var(--accent-color); margin-bottom: 10px; }

        /* BANNER SECTION - HEIGHT INCREASED */
        .value-banner {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            /* Padding increased from 80px to 120px for more height */
            padding: 180px 20px; 
            margin: 50px 0;
        }

        .trending-section { padding: 60px 10%; }
        .trending-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }
        .card { border: 1px solid #eee; border-radius: 8px; overflow: hidden; text-align: center; background: #fff; }
        .card img { width: 100%; height: 300px; object-fit: cover; }
        .card-body { padding: 15px; }

        /* REVIEW SECTION */
        .reviews-section { background-color: #f4f4f4; padding: 60px 10%; text-align: center; }
        .reviews-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .review-card { background: white; padding: 30px; border-radius: 8px; flex: 1; min-width: 280px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .stars { color: #f39c12; margin-bottom: 10px; }
    </style>
  </head>
  
  <body>
    <?php @include 'header.php';?>
    
    <div class="main-content-wrapper">
        <div class="category-header">
            <h1>Choose <span style="color: var(--accent-color);">Categories</span></h1>
            <center><hr class="products-hr"></center>
        </div>

        <div class="container">
            <div class="products-container">
                <a href="man.php" style="text-decoration: none;">
                    <div class="product">
                        <img src="https://images.unsplash.com/photo-1617137984095-74e4e5e3613f?q=80&w=600&auto=format&fit=crop" 
                             alt="Men"
                             onerror="this.src='https://via.placeholder.com/300x350?text=Men+Fashion'">
                        <h3>Men's Collection</h3>
                    </div>
                </a>
                <a href="woman.php" style="text-decoration: none;">
                    <div class="product">
                        <img src="https://images.unsplash.com/photo-1581044777550-4cfa60707c03?q=80&w=600&auto=format&fit=crop" 
                             alt="Women"
                             onerror="this.src='https://via.placeholder.com/300x350?text=Women+Fashion'">
                        <h3>Women's Collection</h3>
                    </div>
                </a>
                <a href="kids.php" style="text-decoration: none;">
                    <div class="product">
                        <img src="https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?q=80&w=600&auto=format&fit=crop" 
                             alt="Kids"
                             onerror="this.src='https://via.placeholder.com/300x350?text=Kids+Fashion'">
                        <h3>Kid's Collection</h3>
                    </div>
                </a>
            </div>
        </div>

        <div class="trust-badges">
            <div style="border:solid 1px black;padding:75px;margin-left:50px;background-color:black;" class="badge-item"><i class="fas fa-truck"></i><h4 style="color:black;">Free Shipping</h4><p>On orders above Rs.999</p></div>
            <div style="border:solid 1px black; padding:75px;margin-left:50px;background-color:black;"class="badge-item"><i class="fas fa-shield-alt"></i><h4 style="color:black;">Secure Payment</h4><p>100% Safe Transaction</p></div>
            <div style="border:solid 1px black; padding:75px;margin-left:50px;background-color:black;"class="badge-item"><i class="fas fa-undo"></i><h4 style="color:black;">7-Day Returns</h4><p>Easy Return Policy</p></div>
        </div>

        <div class="value-banner">
            <h2>Redefining Style & Comfort</h2>
            <p>Experience premium fabrics crafted just for you.</p>
        </div>

        <div class="trending-section">
          <h2 style="text-align: center; font-family: 'Playfair Display', serif; margin-bottom: 40px;">Trending Now</h2>
          <div class="trending-grid">
              <div class="card">
                  <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=500&auto=format&fit=crop" alt="T-Shirt">
                  <div class="card-body"><p style="color:black;"><b>Classic White Tee</b><br>Rs. 499</p></div>
              </div>
              <div class="card">
                  <img src="https://images.unsplash.com/photo-1601924994987-69e26d50dc26?q=80&w=500&auto=format&fit=crop" 
                       alt="Urban Denim Jacket"
                       onerror="this.src='https://via.placeholder.com/300x300?text=Denim+Jacket'">
                  <div class="card-body"><p style="color:black;"><b>Urban Denim Jacket</b><br>Rs. 1299</p></div>
              </div>
              <div class="card">
                  <img src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=500&auto=format&fit=crop" alt="Dress">
                  <div class="card-body"><p style="color:black;"><b>Summer Floral Dress</b><br>Rs. 899</p></div>
              </div>
              <div class="card">
                  <img src="https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?q=80&w=500&auto=format&fit=crop" alt="Chinos">
                  <div class="card-body"><p style="color:black;"><b>Slim Fit Chinos</b><br>Rs. 799</p></div>
              </div>
          </div>
        </div>

        <div class="reviews-section">
            <h2 style="text-align: center; font-family: 'Playfair Display', serif; margin-bottom: 40px;color:black;">What Our Customers Say</h2>
            <div class="reviews-container">
                <div class="review-card">
                    <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p style="color:black;">"The quality is amazing! Best online shopping experience."</p>
                    <p style="color:black;"><strong>- Priya S.</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-container">
      <div class="footer-1">
        <a href="index.php"><h2>FASHION FUSION🦋</h2></a>
        <br>
        <p><b>ONLINE SHOPPING</b></p>
          <h6>
            Man<br><br>
            Woman <br><br>
            Kids <br><br>
            FashionFusion Exclusive<br><br>
          </h6>
      </div>
      <div class="footer-2">
        <p><b>USEFUL LINKS</b></p>
        <h6>
         <a href=""> Contact Us<br><br></a>
         <a href=""> About US<br><br></a>
        </h6>
      </div>
      <div class="footer-3">
        <p><b>100% Original</b> guarantee</p>
          <h6>for all products at merlinfashion.com</h6>
        <p><b>Return within 30days</b> of</p>
          <h6>receiving you order</h6>
        <p><b>Get free delivery</b> for every</p>
          <h6>order above Rs.999</h6>
      </div>
    </div>
    <p class="copy-right">&copy;2026 Fashion Fusion All Rights Reserved.</p>
  </body>
</html>