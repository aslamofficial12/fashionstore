<?php
error_reporting(E_ALL); // Changed to report errors
session_start();
// Check if session variables are set, adjust 'admin_email' if needed
if(!isset($_SESSION['admin_email'])){
   header('location:admin_login.php');
   exit();
}
$user = $_SESSION['admin_email'];

@include 'include.php';

$randomNumber = rand(10, 99);
$prefix = "P";
$productId = $prefix . $randomNumber;
?>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/p_form.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin Panel - Add Woman Product</title>
</head>
<body>

    <div class="side-menu">
        <?php @include 'header.php';?>
    </div>

    <center>
    <div class="container">
    <form class="form" method="post" enctype="multipart/form-data">
             <p class="msg">ADD A NEW WOMEN'S PRODUCT</p>
            <div class="flex">
                <label>
                    <input readonly required="" value="<?php echo $productId;?>" name="id" type="text" class="input">
                </label>
                <label>
                    <input required="" placeholder="Enter Product Name" name="name" type="text" class="input">
                </label>
            </div>  
                    
            <label>
                <input required="" placeholder="Enter Product Price" name="price" min="0" type="number" class="input">
            </label> 

            <label>
            <p align="left">&nbsp;Select Product Image:</p>
                <input required="" placeholder="" name="upload" type="file" id="upload" accept="image/png, image/jpg, image/jpeg, image/webp" class="input">
            </label>

            <label>
            <p align="left">&nbsp;Enter Product Description:</p>
                <textarea id="feedback" name="description" rows="5" cols="30" class="input"></textarea>
            </label>
            <input type="submit" value="Add The Product" name="submit" class="submit">
    </form>
    </div>
    </center>
</body>
</html>

<?php
      if(isset($_POST['submit']))
      { 
        // Use the $con from include.php instead of reconnecting manually if possible
        // But keeping your style for consistency:
        $con=mysqli_connect("localhost","root","","fashionfusion");
        if(!$con) { die("Failed to connect"); }

            $id=$_POST['id'];
            $name=$_POST['name'];
            $price=$_POST['price'];
            $image = $_FILES['upload']['name'];
            $file_local = $_FILES['upload']['tmp_name'];
            $description=$_POST['description'];

            // --- 🛠️ FIX PATH HERE 🛠️ ---
            // Old Path: $folder="uploaded_img/"; (WRONG)
            // New Path: Direct to the women's folder
            $folder = "images/products-img/woman/"; 
            
            // Ensure folder exists, if not, create it (optional safety)
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            if(move_uploaded_file($file_local, $folder . $image)) {
                // Image upload success, now insert to DB
                
                mysqli_select_db($con, "fashionfusion");
                $q1 = "SELECT * FROM `products_woman` WHERE p_id = '$id'";
                $result = mysqli_query($con, $q1);
                
                if(mysqli_num_rows($result) > 0)
                {
                    echo "<script>
                        Swal.fire({ icon: 'info', title: 'Product ID already exists!', timer: 4000, showConfirmButton: false });
                    </script>";
                }
                else{
                    $q2="INSERT INTO `products_woman`(p_id,p_name,p_price,p_image,p_description) VALUES('$id', '$name', '$price','$image','$description')";
                    $result_insert = mysqli_query($con, $q2);
                    
                    if(!$result_insert){
                        echo "<script>
                            Swal.fire({ icon: 'error', title: 'Oops!', text: 'Database Error!', timer: 4000, showConfirmButton: false });
                        </script>";
                    }
                    else{
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Product Added Successfully to Woman Category.',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(() => {
                                window.location.href = 'Products.php';
                                });
                            });
                        </script>";
                    }
                }
            } else {
                 echo "<script>
                    Swal.fire({ icon: 'error', title: 'Upload Failed', text: 'Could not move image to folder $folder', timer: 4000 });
                </script>";
            }
        
        mysqli_close($con);
      }
?>