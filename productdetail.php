<?php
error_reporting(0);
session_start();
@include 'include.php';

// --- BACKEND: HANDLE ADD TO CART LOGIC ---
if(isset($_POST['add_to_cart'])){
    if(isset($_SESSION['email'])){
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $user_email = $_SESSION['email'];
        
        $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE image = '$product_image' AND email='$user_email' ");
        
        if(mysqli_num_rows($select_cart) > 0){
            $message_type = 'info';
            $message_text = 'Product is already In the cart.';
        }else{
            $insert_product = mysqli_query($con, "INSERT INTO `cart`(name, price, image, quantity, email) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity','$user_email')");
            $message_type = 'success';
            $message_text = 'Product Added Successfully.';
        }
    } else {
        $message_type = 'login_required';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Fashion Fusion</title>
    
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700|Montserrat:300,400,500,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Chivo:300,700|Playfair+Display:400,500,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="css/nav.css">
    <style>
        :root {
            --primary-dark: #111;
            --primary-gold: #c5a059;
            --text-grey: #666;
            --border-color: #e5e5e5;
        }
        body { font-family: 'Montserrat', sans-serif; background: #fff; margin:0; }

        /* --- LAYOUT --- */
        .product-page-container {
            max-width: 1200px;
            margin: 180px auto 60px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        /* --- IMAGE HOVER EFFECT --- */
        .main-image-frame {
            width: 100%;
            height: 600px;
            background-color: #fff;
            overflow: hidden; /* Keeps the zoom inside the box */
            border-radius: 4px;
            position: relative;
            cursor: crosshair; /* Shows user they can zoom */
        }

        .main-image-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            /* BORDER ADDED DIRECTLY TO IMAGE */
            border: 1px solid var(--border-color);
            box-sizing: border-box; 
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94), filter 0.5s ease;
            transform-origin: center center;
        }

        /* The Zoom Action */
        .main-image-frame:hover img {
            transform: scale(1.12); /* Zooms in 12% */
            filter: brightness(1.02); /* Slight brightness to show detail */
        }

        /* Details Side */
        .product-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--primary-dark);
            margin: 0 0 10px 0;
            line-height: 1.2;
        }
        .product-price {
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--primary-dark);
            display: block;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .rating-stars { color: #f4c150; font-size: 0.9rem; margin-bottom: 15px; display: block; }
        .product-description {
            color: var(--text-grey);
            line-height: 1.7;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        /* Options (Color/Size) */
        .option-group { margin-bottom: 25px; }
        .option-label { display: block; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; margin-bottom: 10px; }
        
        .color-options { display: flex; gap: 15px; align-items: center; }
        .color-radio { display: none; }
        
        .color-swatch {
            display: inline-block;
            width: 35px; 
            height: 35px; 
            border-radius: 50%; 
            border: 1px solid #ddd; 
            cursor: pointer; 
            position: relative;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        .color-radio:checked + .color-swatch {
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #000;
            transform: scale(1.1);
        }

        .size-options { display: flex; gap: 10px; }
        .size-radio { display: none; }
        .size-box {
            width: 45px; height: 45px; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s;
        }
        .size-radio:checked + .size-box { background: #000; color: #fff; border-color: #000; }
        .size-box:hover { border-color: #000; }

        /* --- ACTIONS & QUANTITY FIX --- */
        .action-row { display: flex; gap: 15px; margin-top: 40px; height: 50px; }
        
        .qty-wrapper { 
            display: flex; 
            border: 1px solid #000; /* Solid outer border */
            height: 100%;
            align-items: center;
            background: #fff;
        }
        .qty-btn { 
            width: 40px; 
            height:100%; 
            background: none; 
            border: none; /* No borders on buttons */
            font-size: 1.2rem; 
            cursor: pointer;
            padding: 0;
            margin: 0;
        }
        .qty-input { 
            width: 50px; 
            height:100%; 
            border: none; /* Reset default */
            /* --- FIX: Add vertical dividers to the input --- */
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            /* ----------------------------------------------- */
            text-align: center; 
            font-weight: 600; 
            outline: none; 
            font-size: 1rem;
            background: none;
            padding: 0;
            margin: 0;
            border-radius: 0; /* Fix for mobile */
            -webkit-appearance: none; /* Fix for mobile */
        }

        .add-cart-btn {
            flex-grow: 1; 
            height: 100%; 
            background: #000; 
            color: #fff; 
            border: none; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.3s;
        }
        .add-cart-btn:hover { background: #333; }
        
        .back-btn {
            display: inline-block; margin-top: 20px; text-decoration: none; color: #666; font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-page-container { grid-template-columns: 1fr; margin-top: 100px; }
            .main-image-frame { height: 400px; }
        }
    </style>
</head>
<body>

<?php @include 'header.php';?>

<?php 
function renderProduct($fetch_edit, $category_link) { ?>
    <div class="product-page-container">
        
        <div class="main-image-frame">
            <img src="admin/uploaded_img/<?php echo $fetch_edit['p_image']; ?>" alt="<?php echo $fetch_edit['p_name']; ?>">
        </div>

        <div class="product-details">
            <h1 class="product-title"><?php echo $fetch_edit['p_name']; ?></h1>
            
            <div class="rating-stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                <span style="color:#999; margin-left:5px;">(4.5 Reviews)</span>
            </div>

            <span class="product-price">Rs. <?php echo $fetch_edit['p_price']; ?>/-</span>

            <p class="product-description"><?php echo $fetch_edit['p_description']; ?></p>

            <form action="" method="post">
                
                <div class="option-group">
                    <span class="option-label">Select Color</span>
                    <div class="color-options">
                        <label>
                            <input type="radio" name="color" value="Black" class="color-radio" checked>
                            <span class="color-swatch" style="background-color: #000;"></span>
                        </label>
                        <label>
                            <input type="radio" name="color" value="Grey" class="color-radio">
                            <span class="color-swatch" style="background-color: #808080;"></span>
                        </label>
                        <label>
                            <input type="radio" name="color" value="Blue" class="color-radio">
                            <span class="color-swatch" style="background-color: #1a237e;"></span>
                        </label>
                    </div>
                </div>

                <div class="option-group">
                    <span class="option-label">Select Size</span>
                    <div class="size-options">
                        <label><input type="radio" name="size" value="S" class="size-radio"><div class="size-box">S</div></label>
                        <label><input type="radio" name="size" value="M" class="size-radio" checked><div class="size-box">M</div></label>
                        <label><input type="radio" name="size" value="L" class="size-radio"><div class="size-box">L</div></label>
                        <label><input type="radio" name="size" value="XL" class="size-radio"><div class="size-box">XL</div></label>
                    </div>
                </div>

                <button type="button" id="btnFindFit" style="margin-top: 10px; margin-left: 10px; cursor: pointer; padding: 8px 15px; background-color: #ff4757; color: white; border: none; border-radius: 5px; font-weight: bold;">
    Find My Fit 📏
</button>
                <div class="action-row">
                    <div class="qty-wrapper">
                        <button type="button" class="qty-btn" onclick="decrementQty()">-</button>
                        <input type="text" name="product_quantity" value="1" class="qty-input" id="qtyInput" readonly>
                        <button type="button" class="qty-btn" onclick="incrementQty()">+</button>
                    </div>

                    <input type="hidden" name="product_id" value="<?php echo $fetch_edit['id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_edit['p_name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_edit['p_price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_edit['p_image']; ?>">

                    <input type="submit" class="add-cart-btn" value="ADD TO CART" name="add_to_cart">
                </div>
                
                <a href="<?php echo $category_link; ?>" class="back-btn"><i class="bi bi-arrow-left"></i> Continue Shopping</a>

            </form>
        </div>
    </div>
<?php } ?>

<?php
if(isset($_GET['edit'])){
    $edit_id = $_GET['edit'];

    // 1. Check Woman
    $edit_query = mysqli_query($con, "SELECT * FROM `products_woman` WHERE id = $edit_id");
    if(mysqli_num_rows($edit_query) > 0){
        while($fetch_edit = mysqli_fetch_assoc($edit_query)){
            renderProduct($fetch_edit, "woman.php");
        }
    }

    // 2. Check Man
    $edit_query_man = mysqli_query($con, "SELECT * FROM `products_man` WHERE id = $edit_id");
    if(mysqli_num_rows($edit_query_man) > 0){
        while($fetch_edit = mysqli_fetch_assoc($edit_query_man)){
            renderProduct($fetch_edit, "man.php");
        }
    }

    // 3. Check Kids
    $edit_query_kids = mysqli_query($con, "SELECT * FROM `products_kids` WHERE id = $edit_id");
    if(mysqli_num_rows($edit_query_kids) > 0){
        while($fetch_edit = mysqli_fetch_assoc($edit_query_kids)){
            renderProduct($fetch_edit, "kids.php");
        }
    }
}
?>

<script>
    function incrementQty() {
        var input = document.getElementById('qtyInput');
        if(parseInt(input.value) < 20) {
            input.value = parseInt(input.value) + 1;
        }
    }
    function decrementQty() {
        var input = document.getElementById('qtyInput');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>

<?php if(isset($message_type)) { ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if($message_type == 'login_required') { ?>
            Swal.fire({
                icon: 'info',
                title:'Login First',
                text: 'You need to login to shop.',
            }).then(() => {
                window.location.href = 'login.php';
            });
        <?php } else { ?>
            Swal.fire({
                icon: '<?php echo $message_type; ?>',
                text: '<?php echo $message_text; ?>',
                showConfirmButton: false,
                timer: 1500
            });
        <?php } ?>
    });
</script>
<?php } ?>



<!-- popup -->
<div id="fitFinderModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6);">
    <div style="background-color:#fff; margin:10% auto; padding:25px; width:300px; border-radius:10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); position: relative;">
        <span id="closeFitModal" style="position: absolute; right: 15px; top: 10px; font-size:24px; cursor:pointer; color: #888;">&times;</span>
        <h3 style="margin-top: 0; color: #333;">Smart Fit-Finder</h3>
        <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Enter details to get a size recommendation.</p>
        
        <input type="hidden" id="fit_product_id" value="<?php echo isset($product_id) ? $product_id : 107; ?>"> 
        
        <div style="margin-bottom: 15px;">
            <label style="font-size: 14px; font-weight: bold;">Height (cm):</label><br>
            <input type="number" id="fit_height" placeholder="e.g. 170" required style="width:100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="font-size: 14px; font-weight: bold;">Weight (kg):</label><br>
            <input type="number" id="fit_weight" placeholder="e.g. 65" required style="width:100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <button type="button" id="btnGetRecommendation" style="width:100%; padding:12px; cursor:pointer; background-color: #2ed573; color: white; border: none; border-radius: 5px; font-weight: bold; font-size: 15px;">Get Recommendation</button>
        <div id="fitFinderMessage" style="margin-top:15px; font-size:14px; text-align: center;"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var modal = $('#fitFinderModal');

    // Button click panna Modal open aagum
    $('#btnFindFit').click(function(e) {
        e.preventDefault();
        modal.show();
        $('#fitFinderMessage').html(''); // Pazhaya message-a clear pannidum
    });

    // Close button click panna Modal close aagum
    $('#closeFitModal').click(function() {
        modal.hide();
    });

    // Modal-ku veliya click panna close aagum
    $(window).click(function(event) {
        if (event.target.id === 'fitFinderModal') {
            modal.hide();
        }
    });

    // Get Recommendation Logic
    $('#btnGetRecommendation').click(function(e) {
        e.preventDefault();
        
        var productId = $('#fit_product_id').val();
        var height = $('#fit_height').val();
        var weight = $('#fit_weight').val();

        if (!height || !weight) {
            $('#fitFinderMessage').html('<span style="color:red; font-weight:bold;">Height and Weight enter pannunga.</span>');
            return;
        }

        var btn = $(this);
        btn.text('Calculating...').prop('disabled', true);
        $('#fitFinderMessage').html('<span style="color:blue;">Checking algorithms...</span>');

        $.ajax({
            url: 'ajax_find_fit.php',
            type: 'POST',
            dataType: 'json',
            data: {
                product_id: productId,
                user_height_cm: height,
                user_weight_kg: weight
            },
            success: function(response) {
                btn.text('Get Recommendation').prop('disabled', false);
                
                if (response.success) {
                    var resultHtml = '<div style="text-align: left; margin-top: 15px; border-top: 1px solid #ddd; padding-top: 10px;">';
                    
                    $.each(response.data, function(index, item) {
                        resultHtml += '<div style="margin-bottom: 12px; padding: 10px; border-radius: 5px; background-color: #f9f9f9; border-left: 5px solid ' + item.color + ';">';
                        resultHtml += '<strong>Size ' + item.size + ' - <span style="color:' + item.color + ';">' + item.percentage + '% Match</span></strong><br>';
                        resultHtml += '<span style="font-size: 13px; color: #555;">' + item.message + '</span>';
                        resultHtml += '</div>';
                    });
                    
                    resultHtml += '</div>';
                    $('#fitFinderMessage').html(resultHtml);
                    
                } else {
                    $('#fitFinderMessage').html('<span style="color:red; font-weight:bold;">' + response.message + '</span>');
                }
            },
            error: function() {
                btn.text('Get Recommendation').prop('disabled', false);
                $('#fitFinderMessage').html('<span style="color:red; font-weight:bold;">Server error occurred.</span>');
            }
        });
    });
});
</script>










</body>
</html>