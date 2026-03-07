<?php
error_reporting(0);
session_start();
$total_amount = isset($_POST['payment']) ? $_POST['payment'] : '0.00';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout | Payment Portal</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* (Munnadi kudutha same CSS dhaan, no changes here) */
        :root { --primary: #6366f1; --text-main: #1f2937; --text-muted: #6b7280; --bg-gray: #f9fafb; }
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .checkout-container { background: white; width: 900px; max-width: 95%; display: flex; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
        .order-summary { background: var(--bg-gray); flex: 1; padding: 40px; border-right: 1px solid #e5e7eb; }
        .order-summary h3 { color: var(--text-main); margin-bottom: 20px; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 12px; color: var(--text-muted); font-size: 14px; }
        .total-row { border-top: 1px solid #e5e7eb; margin-top: 20px; padding-top: 20px; font-weight: 600; font-size: 18px; color: var(--text-main); }
        .payment-form { flex: 1.2; padding: 40px; }
        .payment-form h2 { margin-top: 0; font-size: 22px; margin-bottom: 8px; }
        .subtitle { color: var(--text-muted); font-size: 14px; margin-bottom: 24px; }
        .input-group { margin-bottom: 20px; position: relative; }
        .input-group label { display: block; font-size: 13px; font-weight: 500; color: var(--text-main); margin-bottom: 6px; }
        .input-wrapper input { width: 100%; padding: 12px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 15px; box-sizing: border-box; }
        .card-icons { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); display: flex; gap: 5px; }
        .card-icons img { height: 20px; opacity: 0.5; }
        .row { display: flex; gap: 16px; }
        .row .input-group { flex: 1; }
        .pay-btn { width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; margin-top: 10px; }
        .spinner { display: none; border: 3px solid rgba(255,255,255,0.3); border-radius: 50%; border-top: 3px solid white; width: 18px; height: 18px; animation: spin 0.8s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

<div class="checkout-container">
    <div class="order-summary">
        <h3>Order Summary</h3>
        <div class="summary-item"><span>Product Purchase</span><span><?php echo $total_amount; ?></span></div>
        <div class="summary-item"><span>Shipping</span><span style="color: #10b981;">Free</span></div>
        <div class="total-row"><span>Total to pay</span><span><?php echo $total_amount; ?></span></div>
        <div style="margin-top: 40px;">
            <p style="font-size: 12px; color: #9ca3af; text-transform: uppercase; font-weight: 600;">Secure SSL Connection</p>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/1200px-Stripe_Logo%2C_revised_2016.svg.png" width="80" style="filter: grayscale(1); opacity: 0.5;">
        </div>
    </div>

    <div class="payment-form">
        <h2>Payment Details</h2>
        <p class="subtitle">Complete your purchase by providing your payment details.</p>
        
        <form id="paymentForm" action="payment_success.php" method="POST">
            <?php foreach ($_POST as $key => $value): ?>
                <input type="hidden" name="<?php echo htmlspecialchars($key); ?>" value="<?php echo htmlspecialchars($value); ?>">
            <?php endforeach; ?>
            <input type="hidden" name="order_btn" value="1">

            <div class="input-group">
                <label>Cardholder Name</label>
                <div class="input-wrapper">
                    <input type="text" id="cardName" placeholder="John Doe">
                </div>
            </div>

            <div class="input-group">
                <label>Card Number</label>
                <div class="input-wrapper">
                    <input type="text" id="cardNumber" placeholder="4111 1111 1111 1111" maxlength="19">
                    <div class="card-icons">
                        <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa">
                        <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="Mastercard">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="input-group">
                    <label>Expiry Date</label>
                    <div class="input-wrapper">
                        <input type="text" id="expiryDate" placeholder="MM/YY" maxlength="5">
                    </div>
                </div>
                <div class="input-group">
                    <label>CVC</label>
                    <div class="input-wrapper">
                        <input type="password" id="cvc" placeholder="123" maxlength="3">
                    </div>
                </div>
            </div>

            <button type="submit" class="pay-btn" id="payButton">
                <span id="btnText">Pay <?php echo $total_amount; ?></span>
                <div class="spinner" id="spinner"></div>
            </button>
        </form>
    </div>
</div>

<script>
    // 1. Live Formatting for Card Number (Auto-spacing)
    document.getElementById('cardNumber').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g);
        if (formattedValue) { e.target.value = formattedValue.join(' '); }
    });

    // 2. Live Formatting for Expiry Date (Adds '/' automatically)
    document.getElementById('expiryDate').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 2) {
            e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
        } else {
            e.target.value = value;
        }
    });

    // 3. Main Form Validation
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Stop form from submitting immediately

        const name = document.getElementById('cardName').value.trim();
        const cardNo = document.getElementById('cardNumber').value.replace(/\s/g, '');
        const expiry = document.getElementById('expiryDate').value;
        const cvc = document.getElementById('cvc').value;

        // Validation Logic
        if (name === "") {
            showError("Cardholder Name is required!");
            return;
        }
        
        // Check if card number is exactly 16 digits and numeric
        if (cardNo.length !== 16 || isNaN(cardNo)) {
            showError("Invalid Card Number! Must be 16 digits.");
            return;
        }

        // Check Expiry Date format (MM/YY) and Month
        const expiryParts = expiry.split('/');
        if (expiryParts.length !== 2 || expiryParts[0] > 12 || expiryParts[0] < 1 || expiryParts[1].length !== 2) {
            showError("Invalid Expiry Date! Use MM/YY format (Month 01-12).");
            return;
        }

        // Check CVC
        if (cvc.length !== 3 || isNaN(cvc)) {
            showError("Invalid CVC! Must be 3 digits.");
            return;
        }

        // If everything is OK, show spinner and submit
        const btn = document.getElementById('payButton');
        document.getElementById('btnText').style.display = 'none';
        document.getElementById('spinner').style.display = 'block';
        btn.disabled = true;
        
        setTimeout(() => {
            this.submit(); 
        }, 2000);
    });

    function showError(msg) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: msg,
            confirmButtonColor: '#6366f1'
        });
    }
</script>

</body>
</html>