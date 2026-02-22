<?php
error_reporting(0);
session_start();
@include 'include.php';
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <title>Home - Fashion Fusion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700|Montserrat:300,400,500,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Chivo:300,700|Playfair+Display:400,500,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/style_index.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/slideshow.css">

    <style>
        :root {
            --primary-dark: #111;
            --primary-gold: #c5a059;
            --text-grey: #666;
            --bg-light: #f9f9f9;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Montserrat', sans-serif;
            --image-border: 1px solid #eee;
        }

        body {
            font-family: var(--font-body);
            overflow-x: hidden;
        }

        /* --- Z-INDEX FIX --- */
        .page-content-wrapper {
            position: relative;
            z-index: 10;
            background: #fff;
        }

        /* --- TYPOGRAPHY & SPACING --- */
        section {
            padding: 80px 0;
            position: relative;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            color: var(--primary-dark);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .section-header p {
            color: var(--text-grey);
            font-style: italic;
            font-size: 1.1rem;
        }

        /* --- 1. FEATURES STRIP (NEW DESIGN) --- */
        .features-strip {
            background-color: #f2f2f2; /* Soft Grey Background */
            padding: 70px 0;
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            border-bottom: 1px solid #e0e0e0;
        }

        .feature-box {
            background: #ffffff; /* White Card */
            text-align: center;
            padding: 35px 25px;
            width: 280px; /* Fixed width for consistency */
            border-radius: 12px; /* Smooth rounded corners */
            box-shadow: 0 10px 20px rgba(0,0,0,0.03); /* Very subtle shadow */
            transition: all 0.4s ease; /* Smooth animation time */
            border: 1px solid transparent;
            cursor: default;
        }

        .feature-box i {
            font-size: 2.2rem;
            color: var(--primary-dark);
            margin-bottom: 15px;
            display: inline-block;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .feature-box h4 {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 10px 0;
            font-weight: 700;
            color: var(--primary-dark);
        }
        
        .feature-box p {
            color: #777;
            font-size: 0.85rem;
            margin: 0;
            line-height: 1.5;
        }

        /* --- HOVER EFFECTS (POP) --- */
        .feature-box:hover {
            transform: translateY(-15px); /* Moves the card Up */
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); /* Shadow gets deeper */
            border-color: #e5e5e5;
        }

        .feature-box:hover i {
            transform: scale(1.1); /* Icon grows slightly */
            color: var(--primary-gold); /* Icon turns gold */
        }


        /* --- 2. PRODUCT GRID (TRENDING) --- */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .product-card {
            background: #fff;
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
        }
        .p-img-container {
            position: relative;
            height: 400px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .p-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            border: var(--image-border);
        }
        .product-card:hover .p-img-container img {
            transform: scale(1.05);
        }
        .p-info {
            text-align: center;
        }
        .p-cat {
            font-size: 0.75rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .p-name {
            font-family: var(--font-heading);
            font-size: 1.2rem;
            color: var(--primary-dark);
            margin: 5px 0;
        }
        .p-price {
            font-weight: 500;
            color: var(--primary-dark);
            margin-top: 5px;
        }

        /* --- 3. SHOP BY CATEGORY --- */
        .category-section {
            background-color: #f9f5f0; 
        }
        .category-wrapper {
            display: flex;
            justify-content: center;
            gap: 50px; 
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }
        .cat-circle-item {
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .cat-circle-img {
            width: 220px; 
            height: 220px; 
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 25px;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .cat-circle-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: var(--image-border); 
        }
        .cat-circle-item:hover .cat-circle-img {
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        .cat-title {
            font-family: var(--font-heading);
            font-size: 1.2rem; 
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--primary-dark);
        }

        /* --- 4. PROMO BANNER --- */
        .promo-banner {
            background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop'); 
            background-attachment: fixed;
            background-size: cover;
            background-position: center top;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin: 80px 0;
        }
        .promo-content h3 {
            font-family: var(--font-heading);
            font-size: 3.5rem;
            margin-bottom: 15px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }
        .promo-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .btn-premium {
            background: white;
            color: black;
            padding: 15px 40px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-premium:hover {
            background: var(--primary-dark);
            color: white;
        }

        /* --- 5. BRAND SHOWCASE --- */
        .brands-section {
            background: #724242;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 60px 0;
            overflow: hidden;
        }
        .brands-grid {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 1000px;
            margin: 0 auto;
            flex-wrap: wrap;
            gap: 40px;
        }
        .brand-item {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            color: #bbb; 
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        /* --- 6. NEWSLETTER --- */
        .newsletter-section {
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            padding: 80px 20px;
        }
        .newsletter-form {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 0;
        }
        .newsletter-input {
            padding: 15px 20px;
            border: 1px solid #ddd;
            width: 70%;
            outline: none;
            font-family: var(--font-body);
        }
        .newsletter-btn {
            background: var(--primary-dark);
            color: white;
            border: none;
            padding: 15px 30px;
            text-transform: uppercase;
            cursor: pointer;
            font-weight: 600;
            letter-spacing: 1px;
            transition: background 0.3s;
        }
        .newsletter-btn:hover {
            background: #333;
        }

        .slider-spacing-helper {
            margin-top: 60px;
            margin-bottom: 60px;
            position: relative;
            z-index: 1;
        }
    </style>
</head> 
<body>  

  <?php @include 'header.php';?>

  <div class="video">
    <video autoplay muted loop plays-inline class="back__video" height="100%" width="100%">
      <source src="images/video.mp4" type="video/mp4">
    </video>
  </div>

  <div class="page-content-wrapper">

      <div class="features-strip">
          <div class="feature-box">
              <i class="bi bi-truck"></i>
              <h4>Free Shipping</h4>
              <p>On all orders over Rs. 999.<br>Delivered safely to your door.</p>
          </div>
          <div class="feature-box">
              <i class="bi bi-arrow-counterclockwise"></i>
              <h4>Easy Returns</h4>
              <p>Not satisfied? Return it within<br>30 days for a full refund.</p>
          </div>
          <div class="feature-box">
              <i class="bi bi-shield-lock"></i>
              <h4>Secure Payment</h4>
              <p>100% secure checkout with<br>encrypted transactions.</p>
          </div>
      </div>

      <div class="slider-spacing-helper">
          <div class="container">
              <div class="sidebar">
                <div style="background: linear-gradient(229.99deg, #353535 -26%, darkgrey 145%);">
                  <h1>Men's Fashion</h1>
                  <p>New Fashion, New Passion.</p>
                </div>
                <div style="background: linear-gradient(215.32deg, #AAAAA8 -1%, #4f6996 124%);">
                  <h1>Kid's Fashion</h1>
                  <p>New Fashion, New Passion.</p>
                </div>
                <div style="background: linear-gradient(221.87deg, #6f5f4d 1%, #7a7057 128%);">
                  <h1>Women's Fashion</h1>
                  <p>New Fashion, New Passion.</p>
                </div>
              </div>
              <div class="main-slide">
                <div style="background-image: url('images/slide1.jpg');"></div>
                <div style="background-image: url('images/slide2.jpg');"></div>
                <div style="background-image: url('images/slide3.jpg');"></div>
              </div>
              <div class="controls">
                <button class="down-button"><i class="bi bi-caret-down-fill"></i></button>
                <button class="up-button"><i class="bi bi-caret-up-fill"></i></button>
              </div>
          </div>
      </div>

      <section class="category-section">
          <div class="section-header">
              <h2>Browse Collections</h2>
              <p>Curated styles for every occasion</p>
          </div>
          <div class="category-wrapper">
              <div class="cat-circle-item">
                  <div class="cat-circle-img">
                      <img src="https://images.unsplash.com/photo-1566737236500-c8ac43014a67?auto=format&fit=crop&w=600&q=80" alt="Party Wear">
                  </div>
                  <div class="cat-title">Party Wear</div>
              </div>
              <div class="cat-circle-item">
                  <div class="cat-circle-img">
                      <img src="https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=600&q=80" alt="Elegant Dresses">
                  </div>
                  <div class="cat-title">Elegant Dresses</div>
              </div>
              <div class="cat-circle-item">
                  <div class="cat-circle-img">
                      <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=600&q=80" alt="Summer Styles">
                  </div>
                  <div class="cat-title">Summer Styles</div>
              </div>
              <div class="cat-circle-item">
                  <div class="cat-circle-img">
                      <img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?auto=format&fit=crop&w=600&q=80" alt="Accessories">
                  </div>
                  <div class="cat-title">Accessories</div>
              </div>
          </div>
      </section>

      <section> 
          <div class="section-header">
              <h2>Trending Now</h2>
              <p>Selected items from our premium catalog</p>
          </div>

          <div class="product-grid">
              <div class="product-card">
                  <div class="p-img-container">
                      <img src="https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=800&q=80" alt="Velvet Gown">
                  </div>
                  <div class="p-info">
                      <div class="p-cat">Women</div>
                      <h3 class="p-name">Velvet Evening Gown</h3>
                      <div class="p-price">Rs. 2,499</div>
                  </div>
              </div>

              <div class="product-card">
                  <div class="p-img-container">
                      <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=800&q=80" alt="Trench Coat">
                  </div>
                  <div class="p-info">
                      <div class="p-cat">Men</div>
                      <h3 class="p-name">Classic Trench Coat</h3>
                      <div class="p-price">Rs. 3,999</div>
                  </div>
              </div>

              <div class="product-card">
                  <div class="p-img-container">
                      <img src="https://images.unsplash.com/photo-1605763240000-7e93b172d754?auto=format&fit=crop&w=800&q=80" alt="Maxi Dress">
                  </div>
                  <div class="p-info">
                      <div class="p-cat">Women</div>
                      <h3 class="p-name">Floral Maxi Dress</h3>
                      <div class="p-price">Rs. 1,899</div>
                  </div>
              </div>
              
               <div class="product-card">
                  <div class="p-img-container">
                      <img src="https://images.unsplash.com/photo-1519238809107-748f54fad8dc?auto=format&fit=crop&w=800&q=80" alt="Kids Fashion">
                  </div>
                  <div class="p-info">
                      <div class="p-cat">Kids</div>
                      <h3 class="p-name">Summer Denim Set</h3>
                      <div class="p-price">Rs. 899</div>
                  </div>
              </div>
          </div>
      </section>

      <div class="promo-banner">
          <div class="promo-content">
              <h3>The Winter Edit</h3>
              <p>Cozy Layers & Premium Knits</p>
              <a href="#" class="btn-premium">Shop The Collection</a>
          </div>
      </div>

      <div class="brands-section">
          <div class="brands-grid">
              <div class="brand-item">VOGUE</div>
              <div class="brand-item">ELLE</div>
              <div class="brand-item">HARPER'S</div>
              <div class="brand-item">GQ STYLE</div>
              <div class="brand-item">VANITY FAIR</div>
          </div>
      </div>

      <section class="newsletter-section">
          <div class="section-header" style="margin-bottom: 20px;">
              <h2>Join Our List</h2>
              <p>Unlock 10% off your first order plus exclusive access to new drops.</p>
          </div>
          <form class="newsletter-form">
              <input type="email" class="newsletter-input" placeholder="Your email address">
              <button type="submit" class="newsletter-btn">Subscribe</button>
          </form>
      </section>

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
        <h6>
          for all products at fashionfashion.com
        </h6>
      <p><b>Return within 30days</b> of</p>
        <h6>
          receiving you order
        </h6>
      <p><b>Get free delivery</b> for every</p>
        <h6>
          order above Rs.999
        </h6>
    </div>
  </div>
  <p class="copy-right">&copy;2024 Fashion Fusion All Rights Reserved.</p>
  
  <script src="js/slideshow.js"></script>
  
</body>
</html>