<?php
session_start();
include 'include.php'; // DB Connection

// Check Login
if(!isset($_SESSION['email'])){
   header('location:login.php');
}

$user_email = $_SESSION['email'];

// Fetch Data
$query = "SELECT * FROM user_detail WHERE email='$user_email'";
$result = mysqli_query($con, $query);

if(mysqli_num_rows($result) > 0){
    $user_data = mysqli_fetch_assoc($result);
} else {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Fashion Fusion</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f4f7f6;
            /* Optional: Soft background pattern */
            background-image: radial-gradient(#ff8795 0.5px, transparent 0.5px), radial-gradient(#ff8795 0.5px, #f4f7f6 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }

        /* Main Wrapper to center content and clear header */
        .main-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh; /* Takes full height */
            padding-top: 80px; /* Space for fixed header */
            padding-bottom: 50px;
        }

        .profile-card {
            background: #fff;
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        /* Pink Header Section */
        .card-header-bg {
            background: linear-gradient(135deg, #ff8795 0%, #ff5e71 100%);
            height: 150px;
            position: relative;
        }

        /* Profile Image */
        .avatar-container {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            width: 110px;
            height: 110px;
            background: #fff;
            border-radius: 50%;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            color: #ff8795;
        }

        /* User Info Section */
        .card-body {
            padding: 60px 30px 40px; /* Top padding clears the avatar */
            text-align: center;
        }

        .user-name {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .user-role {
            font-size: 14px;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 30px;
        }

        /* Details List */
        .info-list {
            list-style: none;
            text-align: left;
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            background: #f9f9f9;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .info-item:hover {
            background: #fff0f1; /* Light pink hover */
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ff8795;
            font-size: 18px;
            margin-right: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .info-content h5 {
            font-size: 12px;
            color: #888;
            font-weight: 400;
            margin-bottom: 2px;
        }

        .info-content span {
            font-size: 15px;
            color: #333;
            font-weight: 500;
        }

        /* Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-logout {
            background: #333;
            color: #fff;
        }

        .btn-logout:hover {
            background: #000;
            transform: scale(1.05);
        }

        .btn-home {
            background: #fff;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-home:hover {
            border-color: #ff8795;
            color: #ff8795;
        }

    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="main-wrapper">
        <div class="profile-card">
            
            <div class="card-header-bg">
                <div class="avatar-container">
                    <div class="avatar-img">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h1 class="user-name"><?php echo $user_data['name']; ?></h1>
                <p class="user-role">Valued Customer</p>

                <ul class="info-list">
                    <li class="info-item">
                        <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div class="info-content">
                            <h5>Email</h5>
                            <span><?php echo $user_data['email']; ?></span>
                        </div>
                    </li>
                    <li class="info-item">
                        <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div class="info-content">
                            <h5>Mobile</h5>
                            <span><?php echo $user_data['contactno']; ?></span>
                        </div>
                    </li>
                    <li class="info-item">
                        <div class="info-icon"><i class="bi bi-gender-ambiguous"></i></div>
                        <div class="info-content">
                            <h5>Gender</h5>
                            <span><?php echo $user_data['gender']; ?></span>
                        </div>
                    </li>
                </ul>

                <div class="action-buttons">
                    <a href="index.php" class="btn btn-home"><i class="bi bi-house"></i> Home</a>
                    <a href="logout.php" class="btn btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>