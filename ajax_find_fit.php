<?php
// ajax_find_fit.php
header('Content-Type: application/json');

// Database connection
$conn = mysqli_connect("localhost", "root", "", "fashion_fusion");

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection error."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $height = isset($_POST['user_height_cm']) ? (int)$_POST['user_height_cm'] : 0;
    $weight = isset($_POST['user_weight_kg']) ? (int)$_POST['user_weight_kg'] : 0;

    // Default product_id for testing (Shirt ID 107)
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

                // --- CALCULATION LOGIC ---
                $weight_score = 100;
                $height_score = 100;

                if ($weight < $min_w) {
                    $weight_score -= ($min_w - $weight) * 2; 
                } elseif ($weight > $max_w) {
                    $weight_score -= ($weight - $max_w) * 2;
                }

                if ($height < $min_h) {
                    $height_score -= ($min_h - $height) * 1.5; 
                } elseif ($height > $max_h) {
                    $height_score -= ($height - $max_h) * 1.5;
                }

                $weight_score = max(0, $weight_score);
                $height_score = max(0, $height_score);

                $percentage = round(($weight_score * 0.6) + ($height_score * 0.4));
                $percentage = min(100, max(5, $percentage));

                if ($percentage <= 15) {
                    $percentage = rand(5, 12);
                }

                // --- PROFESSIONAL FEEDBACK MESSAGES ---
                if ($percentage >= 85) {
                    $message = "Perfect Match! This size aligns ideally with your measurements.";
                    $color = "#2ed573"; // Green
                } elseif ($weight > $max_w && $percentage >= 45) {
                    $message = "Slim Fit. This garment may feel tight or body-hugging.";
                    $color = "#ffa502"; // Orange
                } elseif ($weight < $min_w && $percentage >= 45) {
                    $message = "Relaxed Fit. This size might be slightly loose for your build.";
                    $color = "#1e90ff"; // Blue
                } else {
                    $message = "Not Recommended. This size is significantly different from your fit profile.";
                    $color = "#ff4757"; // Red
                }

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
                echo json_encode(["success" => false, "message" => "Size guide data not found for this product."]);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Please provide valid height and weight values."]);
    }
}
?>