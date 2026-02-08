<?php
// Error reporting off
error_reporting(0);
session_start();
// FIX: Database Connection
include 'include.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Fashion Fusion</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4f4; /* Light Grey Background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .main-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 900px;
            max-width: 100%;
            display: flex;
            flex-wrap: wrap; /* For mobile responsiveness */
        }

        /* Left Side Image */
        .image-section {
            flex: 1;
            background: #ffe6ea; /* Light Pink Background */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            min-width: 300px;
        }

        .image-section img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        /* Right Side Form */
        .form-section {
            flex: 1;
            padding: 40px;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-section h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group input[type="text"],
        .input-group input[type="email"],
        .input-group input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
            background: #f9f9f9;
        }

        .input-group input:focus {
            border-color: #ff8795;
            background: #fff;
            box-shadow: 0 0 5px rgba(255, 135, 149, 0.2);
        }

        /* Gender Radio Buttons Alignment */
        .gender-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
            color: #555;
            font-size: 14px;
        }
        
        .gender-group label {
            font-weight: 600;
            color: #333;
        }

        .gender-option {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #ff8795;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background: #ff5e71;
            transform: translateY(-2px);
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .footer-text a {
            color: #ff8795;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column-reverse; /* Form on top in mobile */
            }
            .image-section {
                display: none; /* Hide image on small screens to save space */
            }
        }
    </style>
</head>
<body>

    <div class="main-container">
        
        <div class="image-section">
            <img src="images/login-images/signup.png" alt="Sign Up Illustration">
        </div>

        <div class="form-section">
            <h2>Create Account</h2>
            
            <form method="POST">
                <div class="input-group">
                    <input type="text" placeholder="Full Name" name="name" required>
                </div>

                <div class="input-group">
                    <input type="email" placeholder="Email Address" name="email" required>
                </div>

                <div class="input-group">
                    <input type="text" placeholder="Contact Number" name="contact" required>
                </div>

                <div class="gender-group">
                    <label>Gender:</label>
                    <div class="gender-option">
                        <input type="radio" value="Male" name="gender" id="male" required> 
                        <label for="male" style="font-weight:400; cursor:pointer;">Male</label>
                    </div>
                    <div class="gender-option">
                        <input type="radio" value="Female" name="gender" id="female"> 
                        <label for="female" style="font-weight:400; cursor:pointer;">Female</label>
                    </div>
                </div>

                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" required>
                </div>

                <input type="submit" value="Sign Up" name="signup" class="submit-btn">
            </form>

            <div class="footer-text">
                Already have an account? <a href="login.php">Sign In</a>
            </div>
        </div>

    </div>

</body>
</html>

<?php
if(isset($_POST['signup']))
{ 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // FIX: Using $con from include.php
    $q1 = "SELECT * FROM user_detail WHERE email = '$email'";
    $result = mysqli_query($con, $q1);

    if(empty($name) OR empty($email) OR empty($contact) OR empty($password))
    {
        echo "<script>Swal.fire('Error', 'All Fields Are Required', 'error');</script>";
    }
    else if(preg_match('/[0-9]+/', $name))
    {
        echo "<script>Swal.fire('Error', 'Numbers Not Allowed In Name', 'warning');</script>";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "<script>Swal.fire('Error', 'Enter Proper Email Address', 'warning');</script>";
    }
    else if(strlen($contact) > 10 || strlen($contact) < 10)
    {
        echo "<script>Swal.fire('Error', 'Contact Number Must Be 10 Digits', 'warning');</script>";
    }
    else if(strlen($password) < 8)
    {
        echo "<script>Swal.fire('Error', 'Password Must Be At Least 8 Characters', 'warning');</script>";
    }
    elseif(mysqli_num_rows($result) > 0)
    {
        echo "<script>Swal.fire({ icon: 'info', title:'Sorry!', text: 'Email is Already Taken!' });</script>";
    }
    else
    {
        // FIX: Insert Query using correct connection
        $q1 = "INSERT INTO `user_detail`(name,email,contactno,gender,password) VALUES('$name','$email','$contact','$gender','$password')";
        $result = mysqli_query($con, $q1);
        
        if($result){
            ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Account Created Successfully.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = 'login.php';
                });
            </script>
            <?php
        } else {
            echo "<script>Swal.fire('Error', 'Something Went Wrong!', 'error');</script>";
        }
    }
}
?>