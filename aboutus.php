<?php
error_reporting(0);
session_start();
@include 'include.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>FASHION FUSION</title>
    <link rel="stylesheet" href="css/style_index.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/about.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
        
        /* Your Existing CSS */
        .container{ width: 70%; height: 70%; max-width: 1170px; display: grid; grid-template-columns: repeat(2, 1fr); align-items: center; grid-gap: 60px; padding: 35px 0; margin: 0 auto; }
        .contentLeft, .contentRight{ width: 100%; }
        .contentLeft .row{ margin-top: 20%; margin-left: 20%; width: 100%; display: grid; grid-template-columns: repeat(4, 1fr); grid-gap: 10px; }
        .contentLeft .row .imgWrapper{ margin-top: 5%; margin-right: 5%; width: 120%; height: 300px; overflow: hidden; border-radius: 10px; cursor: pointer; box-shadow: 5px 10px 10px rgba(0, 0, 0, 0.15); }
        .contentLeft .row .imgWrapper img{ width: 90%; height: 90%; object-fit: cover; user-select: none; transition: 0.3s ease; }
        .contentLeft .row .imgWrapper:hover img{ transform: scale(1.5); }
        .contentLeft .row .imgWrapper:nth-child(odd){ transform: translateY(-20px); }
        .contentLeft .row .imgWrapper:nth-child(even){ transform: translateY(20px); }
        .contentRight .content{ display: flex; flex-direction: column; align-items: flex-start; gap: 15px; }
        .contentRight .content h4{ font-size: 22px; font-weight: 400; color: #d35400; }
        .contentRight .content h2{ margin-top: 10%; font-size: 40px; color: #1e272e; }
        .contentRight .content p{ font-size: 16px; color: #343434; line-height: 28px; padding-bottom: 10px; }
        .contentRight .content a{ display: inline-block; text-decoration: none; font-size: 16px; letter-spacing: 1px; padding: 13px 30px; color: #fff; background: #d35400; border-radius: 8px; user-select: none; }

        /* NEW CSS: Smart Fit-Finder Section */
        .fit-finder-container { width: 80%; max-width: 1200px; margin: 60px auto; display: flex; align-items: center; justify-content: space-between; background: #fff9f5; padding: 50px; border-radius: 15px; gap: 40px; }
        .fit-text { flex: 1; }
        .fit-text h2 { font-size: 35px; color: #1e272e; margin-bottom: 20px; }
        .fit-text p { font-size: 16px; color: #343434; line-height: 28px; margin-bottom: 20px; }
        .fit-text ul { list-style: none; padding: 0; margin-bottom: 20px;}
        .fit-text ul li { font-size: 16px; color: #444; margin-bottom: 12px; font-weight: 500; display: flex; align-items: center; gap: 10px;}
        .btn-fit { display: inline-block; padding: 12px 30px; background: #d35400; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.3s; }
        .btn-fit:hover { background: #e67e22; box-shadow: 0 5px 15px rgba(211, 84, 0, 0.4); }
        .fit-image { flex: 1; text-align: center; }
        .fit-image img { width: 100%; max-width: 450px; border-radius: 12px; box-shadow: 0 15px 30px rgba(0,0,0,0.15); }

        /* NEW CSS: Tips Section */
        .tips-container { width: 80%; max-width: 1200px; margin: 80px auto; }
        .tips-container h2 { text-align: center; font-size: 35px; color: #1e272e; margin-bottom: 10px; }
        .tips-grid { display: flex; justify-content: space-between; gap: 30px; margin-top: 50px; }
        .tip-card { background: #fff; border: 1px solid #eee; padding: 40px 30px; border-radius: 12px; flex: 1; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.4s; }
        .tip-card:hover { transform: translateY(-10px); border-color: #d35400; box-shadow: 0 15px 25px rgba(211, 84, 0, 0.15); }
        .tip-card .icon { font-size: 45px; margin-bottom: 20px; }
        .tip-card h3 { font-size: 22px; color: #d35400; margin-bottom: 15px; }
        .tip-card p { font-size: 15px; color: #555; line-height: 26px; }

        @media(max-width: 768px){
            .container, .fit-finder-container, .tips-grid { grid-template-columns: 1fr; flex-direction: column; }
            .contentLeft .row{ grid-template-columns: repeat(2, 1fr); }
            .contentLeft .row .imgWrapper{ height: 150px; }
        }
    </style>
</head> 
<body>  
  
<?php @include 'header.php';?>

<div class="container">
  <div class="contentLeft">
    <div class="row">
        <div class="imgWrapper">
        <a href="#"><img src="./image/img01.jfif"></a>
        </div>
        <div class="imgWrapper">
        <a href="#"><img src="./image/img1.png"></a>
        </div>
        <div class="imgWrapper">
        <a href="#"><img src="./image/img03.jpg"></a>
        </div>
    </div>
  </div>
  
  <div class="contentRight">
    <div class="content">
      <h4>Welcome To</h4>
      <h2 style="margin-left:50px">Fashion Fusion</h2>
      <p>
      Welcome to Fashion Fusion, where style meets innovation in the world of clothing. Our online boutique is dedicated to bringing you the latest trends with a twist, offering a unique blend of classic elegance and contemporary flair. At Fashion Fusion, we believe that fashion is more than just clothing; it's a form of self-expression, creativity, and empowerment. Thank you for choosing Fashion Fusion as your go-to destination for all things fashion. We can't wait to help you discover your next favorite look!
      </p>
      <a style="margin-left:50px" href="products.php">Shop Now</a>
    </div>
  </div>
</div>





<div class="fit-finder-container">
    <div class="fit-text">
        <h2>Experience the <span style="color: #d35400;">Smart Fit-Finder</span></h2>
        <p style="margin-left:-50px;">Tired of returning clothes because they don't fit right? Our innovative <b>Smart Fit-Finder</b> technology takes the guesswork out of online shopping. By analyzing your unique body measurements, we recommend the perfect size tailored just for you.</p>
        <ul>
            <li>📏 <span>Accurate size predictions for every brand</span></li>
            <li>🔄 <span>Say goodbye to return hassles</span></li>
            <li>✨ <span>Shop with absolute confidence</span></li>
        </ul>
        <a href="ajax_find_fit.php" class="btn-fit">Try Fit-Finder Now</a>
    </div>
    <div class="fit-image">
        <img src="./image/fit-banner.png" alt="Smart Fit Finder Technology">
    </div>
</div>

<div class="tips-container">
    <h2>Expert Sizing & Style Tips</h2>
    <p style="text-align: center; color: #777; font-size: 16px;">Look your best with these quick fashion hacks from our experts.</p>
    
    <div class="tips-grid">
        <div class="tip-card">
            <div class="icon">✂️</div>
            <h3>Know Your Measurements</h3>
            <p>Don't rely just on S, M, or L tags. Keep a measuring tape handy and know your exact chest, waist, and hip measurements in inches for the perfect buy.</p>
        </div>
        <div class="tip-card">
            <div class="icon">🧵</div>
            <h3>Understand the Fabric</h3>
            <p>Cotton shrinks slightly, while spandex stretches. Always check the material composition before choosing your size to ensure a perfect long-term fit.</p>
        </div>
        <div class="tip-card">
            <div class="icon">⚖️</div>
            <h3>Balance Proportions</h3>
            <p>If you're wearing an oversized or loose top, pair it with fitted bottoms. If you're wearing wide-leg trousers, go for a structured or fitted shirt.</p>
        </div>
    </div>
</div>

<br><br>
<h1 class="main-head-of-color-gold" style="text-align: center; color: #1e272e;">Explore Us!</h1>
<center><hr style="width: 100px; border: 2px solid #d35400; margin-top: 10px;"></center> 
<br><br>

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
         <a href="contact.php"> Contact Us<br><br></a>
         <a href="aboutus.php"> About US<br><br></a>
        </h6>
      </div>

      <div class="footer-3">
        <p><b>100% Original</b> guarantee</p>
          <h6>
            for all products at fashionfusion.com
          </h6>
        <p><b>Return within 30days</b> of</p>
          <h6>
            receiving your order
          </h6>
        <p><b>Get free delivery</b> for every</p>
          <h6>
            order above Rs.999
          </h6>
      </div>
    </div>

  <p class="copy-right" style="text-align: center; padding: 20px; background: #f1f1f1;">&copy;2026 Fashion Fusion All Rights Reserved.</p>
</body>
</html>