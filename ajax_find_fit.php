<?php
// ajax_find_fit.php
header('Content-Type: application/json');

// Database connection
$conn = mysqli_connect("localhost", "root", "", "fashion_fusion");

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $height = isset($_POST['user_height_cm']) ? (int)$_POST['user_height_cm'] : 0;
    $weight = isset($_POST['user_weight_kg']) ? (int)$_POST['user_weight_kg'] : 0;

    // Testing-kaga product_id varalana default aaga 107 (unga shirt id) vechukalam
    if ($product_id == 0) {
        $product_id = 107; 
    }

    if ($product_id > 0 && $height > 0 && $weight > 0) {
        $sql = "SELECT size_label, min_height_cm, max_height_cm, min_weight_kg, max_weight_kg 
                FROM product_size_logic WHERE product_id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $size_results = [];
            
            while ($row = mysqli_fetch_assoc($result)) {
                $size = $row['size_label'];
                $min_w = $row['min_weight_kg'];
                $max_w = $row['max_weight_kg'];
                $min_h = $row['min_height_cm'];
                $max_h = $row['max_height_cm'];

                // --- NEW REAL MATHEMATICAL LOGIC STARTS HERE ---
                
                $weight_score = 100;
                $height_score = 100;

                // 1. Weight Penalty (Drop 2 points for every kg off the limit)
                if ($weight < $min_w) {
                    $weight_score -= ($min_w - $weight) * 2; 
                } elseif ($weight > $max_w) {
                    $weight_score -= ($weight - $max_w) * 2;
                }

                // 2. Height Penalty (Drop 1.5 points for every cm off the limit)
                if ($height < $min_h) {
                    $height_score -= ($min_h - $height) * 1.5; 
                } elseif ($height > $max_h) {
                    $height_score -= ($height - $max_h) * 1.5;
                }

                // Ensure scores don't drop below 0 before final calculation
                $weight_score = max(0, $weight_score);
                $height_score = max(0, $height_score);

                // 3. Total Percentage Calculation 
                // Weight is generally more critical for fit, so 60% weightage for weight, 40% for height
                $percentage = round(($weight_score * 0.6) + ($height_score * 0.4));

                // 4. Safety Bounds: Keep percentage between 5% and 100%
                $percentage = min(100, max(5, $percentage));

                // If it's a very low score, add a tiny random variation so all "bad" sizes don't look identical
                if ($percentage <= 15) {
                    $percentage = rand(5, 12);
                }

                // 5. Categorize and format feedback based on actual metrics
                if ($percentage >= 85) {
                    $message = "Perfect match! Height and Weight correct ah irukku.";
                    $color = "#2ed573"; // Green
                } elseif ($weight > $max_w && $percentage >= 45) {
                    $message = "Cloth tight irukkum. Dress romba fit ah irukkum.";
                    $color = "#ffa502"; // Orange
                } elseif ($weight < $min_w && $percentage >= 45) {
                    $message = "Dress ungalukku loose ah irukkum.";
                    $color = "#1e90ff"; // Blue
                } else {
                    $message = "Not fit for you. Romba small/large.";
                    $color = "#ff4757"; // Red
                }
                // --- NEW REAL MATHEMATICAL LOGIC ENDS HERE ---

                $size_results[] = [
                    "size" => $size,
                    "percentage" => $percentage,
                    "message" => $message,
                    "color" => $color
                ];
            }
            
            // Sort by percentage (Highest first)
            usort($size_results, function($a, $b) {
                return $b['percentage'] - $a['percentage'];
            });

            if (count($size_results) > 0) {
                echo json_encode(["success" => true, "data" => $size_results]);
            } else {
                echo json_encode(["success" => false, "message" => "Size data database-la illai."]);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Height/Weight sariya enter pannunga."]);
    }
}
?>