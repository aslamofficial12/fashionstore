<?php
error_reporting(0);
session_start();
// Checkout page-la irundhu vara amount
$total_amount = isset($_POST['payment']) ? $_POST['payment'] : 'Rs. 0/-';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Payment Gateway</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .payment-card { background: white; width: 400px; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .payment-card h2 { text-align: center; color: #333; margin-top: 0; }
        .amount-display { text-align: center; font-size: 24px; font-weight: bold; color: #e84118; margin-bottom: 25px; }
        .input-box { margin-bottom: 15px; }
        .input-box label { display: block; font-size: 13px; color: #666; margin-bottom: 5px; }
        .input-box input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 15px; }
        .row { display: flex; justify-content: space-between; }
        .row .input-box { width: 48%; }
        .pay-btn { width: 100%; padding: 15px; background: #2f3542; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; position: relative; }
        .pay-btn:hover { background: #57606f; }
        .pay-btn:disabled { background: #a4b0be; cursor: not-allowed; }
        .spinner { display: none; border: 3px solid rgba(255,255,255,0.3); border-radius: 50%; border-top: 3px solid white; width: 20px; height: 20px; animation: spin 1s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

<div class="payment-card">
    <h2>Sandbox Payment</h2>
    <div class="amount-display"><?php echo $total_amount; ?></div>
    
    <form id="paymentForm" action="payment_success.php" method="POST">
        <input type="hidden" name="items" value="<?php echo htmlspecialchars($_POST['items']); ?>">
        <input type="hidden" name="name" value="<?php echo htmlspecialchars($_POST['name']); ?>">
        <input type="hidden" name="contact" value="<?php echo htmlspecialchars($_POST['contact']); ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_POST['email']); ?>">
        <input type="hidden" name="gender" value="<?php echo htmlspecialchars($_POST['gender']); ?>">
        <input type="hidden" name="address" value="<?php echo htmlspecialchars($_POST['address']); ?>">
        <input type="hidden" name="city" value="<?php echo htmlspecialchars($_POST['city']); ?>">
        <input type="hidden" name="state" value="<?php echo htmlspecialchars($_POST['state']); ?>">
        <input type="hidden" name="country" value="<?php echo htmlspecialchars($_POST['country']); ?>">
        <input type="hidden" name="pin_code" value="<?php echo htmlspecialchars($_POST['pin_code']); ?>">
        <input type="hidden" name="payment" value="<?php echo htmlspecialchars($_POST['payment']); ?>">
        <input type="hidden" name="order_btn" value="1"> 

        <div class="input-box">
            <label>Card Number (Dummy)</label>
            <input type="text" placeholder="4111 1111 1111 1111" maxlength="19" required>
        </div>
        <div class="row">
            <div class="input-box">
                <label>Expiry</label>
                <input type="text" placeholder="12/26" maxlength="5" required>
            </div>
            <div class="input-box">
                <label>CVV</label>
                <input type="password" placeholder="123" maxlength="3" required>
            </div>
        </div>
        <button type="submit" class="pay-btn" id="payButton">
            <span id="btnText">Pay Now</span>
            <div class="spinner" id="spinner"></div>
        </button>
    </form>
</div>

<script>
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('payButton');
        document.getElementById('btnText').style.display = 'none';
        document.getElementById('spinner').style.display = 'block';
        btn.disabled = true;
        
        // 2 sec dummy loading before processing
        setTimeout(() => {
            this.submit(); 
        }, 2000);
    });
</script>

</body>
</html>