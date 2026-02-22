<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
@include 'include.php'; // Ensure your database connection $con is here
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Fashion | Fashion Fusion</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --pink-accent: #fbc2c2; /* The exact pink from your design images */
            --pink-dark: #f06292;
            --border-color: #e8e8e8;
            --text-dark: #1a1a1a;
            --bg-light: #fdfdfd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        /* --- Page Title Section --- */
        .title-section {
            text-align: center;
            padding: 60px 0 30px;
        }

        .title-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -1px;
            text-transform: none; /* Keeping it natural like the others */
        }

        .colored-word {
            color: var(--pink-dark);
        }

        .underline {
            width: 45px;
            height: 4px;
            background-color: var(--pink-dark);
            border: none;
            margin: 12px auto;
            border-radius: 2px;
        }

        /* --- 4-Column Grid System --- */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 25px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Matching design image exactly */
            gap: 24px;
            padding-bottom: 100px;
        }

        /* --- Product Card Design --- */
        .product-link {
            text-decoration: none;
            color: inherit;
        }

        .product-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px; /* 12px Rounded corners */
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Image Zoom Container */
        .img-container {
            width: 100%;
            height: 400px; /* Fixed portrait height */
            overflow: hidden;
            background-color: #f5f5f5;
            position: relative;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.7s ease; /* Premium Zoom Effect */
        }

        /* Card Content Container */
        .card-content {
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        /* Ultra-Bold Price Styling */
        .price-text {
            font-size: 1.4rem;
            font-weight: 900; 
            margin-bottom: 18px;
            color: #000;
            letter-spacing: -0.5px;
        }

        /* View Product Button */
        .action-btn {
            width: 100%;
            padding: 14px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            text-align: center;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #444;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        /* --- HOVER INTERACTIONS --- */
        .product-link:hover .product-card {
            border-color: var(--pink-accent); /* Border turns pink */
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            transform: translateY(-4px);
        }

        .product-link:hover .img-container img {
            transform: scale(1.1); /* Smooth Image Zoom */
        }

        .product-link:hover .action-btn {
            background-color: var(--pink-accent); /* Button turns pink */
            border-color: var(--pink-accent);
            color: #222;
        }

        /* Fallback for Missing Image */
        .missing-info {
            background: #fff3cd;
            color: #856404;
            padding: 8px;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #ffeeba;
        }

        /* --- Footer Section --- */
        .site-footer {
            background: #111;
            color: #fff;
            padding: 80px 10% 40px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 50px;
        }

        .site-footer h2 { font-size: 1.1rem; margin-bottom: 20px; font-weight: 700; }
        .site-footer p { font-size: 14px; color: #888; line-height: 1.8; }
        .site-footer a { color: #888; text-decoration: none; }
        .site-footer a:hover { color: var(--pink-dark); }
        .copy-area { text-align: center; padding: 25px; color: #555; font-size: 12px; background: #111; border-top: 1px solid #222; }

        /* Responsive Settings */
        @media (max-width: 1100px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 650px) { .products-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    
    <?php @include 'header.php';?>

    <div class="title-section">
        <h1>Men<span class="colored-word">'s Fashion</span></h1>
        <div class="underline"></div>
    </div>

    <div class="container">
        <div class="products-grid">
            <?php
            // Database Selection
            mysqli_select_db($con, "fashion_fusion");

            // Fetch Men's Products
            $q1 = "SELECT * FROM `products_man` ORDER BY id DESC";
            $result = mysqli_query($con, $q1);

            if($result && mysqli_num_rows($result) > 0){
                while($item = mysqli_fetch_assoc($result)){
                    
                    // --- Men's Category Image Logic ---
                    $db_image = $item['p_image']; 
                    $filename_only = pathinfo($db_image, PATHINFO_FILENAME);
                    $clean_name = strtolower($filename_only);
                    $final_image_name = $clean_name . ".png";
                    
                    $full_path = "images/products-img/man/" . $final_image_name;

                    // Check if file exists
                    if (file_exists($full_path) && !empty($db_image)) {
                        $display_src = $full_path;
                        $error_msg = "";
                    } else {
                        $display_src = "images/logo.png"; // Fallback
                        $error_msg = "<div class='missing-info'>⚠️ File not found: $final_image_name</div>";
                    }
            ?>
                <a href="productdetail.php?edit=<?php echo $item['id']; ?>" class="product-link">
                    <div class="product-card">
                        <div class="img-container">
                            <img src="<?php echo $display_src; ?>?v=<?php echo time(); ?>" 
                                 alt="<?php echo $item['p_name']; ?>">
                        </div>
                        
                        <div class="card-content">
                            <div class="price-text">₹<?php echo number_format($item['p_price']); ?></div>
                            
                            <div class="action-btn">View Product</div>
                        </div>

                        <?php echo $error_msg; ?>
                    </div>
                </a>
            <?php
                }
            } else {
                echo "<h2 style='grid-column: 1/-1; text-align: center; padding: 100px; color: #999;'>No Men's Products Found.</h2>";
            }
            ?>
        </div>
    </div>

    <div style="text-align: center; padding: 40px;">
        <a href='cart.php' style="text-decoration:none; color:var(--text-dark);">
            <h4>Uh-Oh! We are<span class="colored-word"> done</span> 🛒</h4>
        </a>
    </div>
    
    <footer class="site-footer">
        <div>
            <h2>FASHION FUSION🦋</h2>
            <p><b>PREMIUM ONLINE SHOPPING</b><br>Curated collections for Men, Women, and Kids.</p>
        </div>
        <div>
            <h2>USEFUL LINKS</h2>
            <p>
                <a href="contact.php">Contact Us</a><br>
                <a href="about.php">About Us</a><br>
                <a href="faq.php">FAQ</a>
            </p>
        </div>
        <div>
            <h2>QUALITY PROMISE</h2>
            <p>100% Original guarantee for all items. Secure checkout and fast delivery nationwide.</p>
        </div>
    </footer>
    <p class="copy-area">&copy; 2026 Fashion Fusion. All Rights Reserved.</p>
</body>
</html>