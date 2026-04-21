<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login first.');
            window.location.href='login.html';
          </script>";
    exit();
}

include 'includes/db.php';

// Fetch latest booking for this user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM bookings WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$booking = $result->fetch_assoc();

if (!$booking) {
    die("No booking found");
}

$hotel_name     = $booking ? htmlspecialchars($booking['hotel_name']) : 'Selected Hotel';
$location       = $booking ? htmlspecialchars($booking['location']) : 'Location';
$room_type      = $booking ? htmlspecialchars($booking['room_type']) : 'Deluxe Room';
$checkin_date   = $booking ? htmlspecialchars($booking['checkin_date']) : '';
$checkout_date  = $booking ? htmlspecialchars($booking['checkout_date']) : '';
$guests         = $booking ? htmlspecialchars($booking['guests']) : '1';
$price_str      = $booking ? $booking['price'] : '₹0';
$booking_id     = $booking ? $booking['id'] : 0;

// Parse numeric price
preg_match('/[\d,]+/', $price_str, $matches);
$price_per_night = isset($matches[0]) ? (int) str_replace(',', '', $matches[0]) : 0;

// Calculate nights
$nights = 1;
if ($checkin_date && $checkout_date) {
    $d1 = new DateTime($checkin_date);
    $d2 = new DateTime($checkout_date);
    $diff = $d1->diff($d2)->days;
    if ($diff > 0) $nights = $diff;
}

$subtotal = $price_per_night * $nights;
$taxes    = round($subtotal * 0.12);
$total    = $subtotal + $taxes;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - StayEase</title>
    <link rel="stylesheet" href="bg.css">
    <link rel="stylesheet" href="payment.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo"><a href="homepage.php">StayEase</a></div>
        <ul class="nav-links">
            <li><a href="homepage.php">Home</a></li>
            <li><a href="hotel.php">Hotels</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="contact.html">Support</a></li>
        </ul>
        <div class="nav-buttons">
            <button class="login-btn" onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </nav>
</header>

<main class="payment-main">
    <div class="payment-wrapper">

        <!-- LEFT: Order Summary -->
        <div class="summary-panel">
            <div class="summary-header">
                <span class="summary-tag">Booking Summary</span>
                <h2><?php echo $hotel_name; ?></h2>
                <p class="summary-location">📍 <?php echo $location; ?></p>
            </div>

            <div class="summary-details">
                <div class="detail-row">
                    <span>Room Type</span>
                    <span><?php echo $room_type; ?></span>
                </div>
                <div class="detail-row">
                    <span>Check-in</span>
                    <span><?php echo $checkin_date ? date('d M Y', strtotime($checkin_date)) : '—'; ?></span>
                </div>
                <div class="detail-row">
                    <span>Check-out</span>
                    <span><?php echo $checkout_date ? date('d M Y', strtotime($checkout_date)) : '—'; ?></span>
                </div>
                <div class="detail-row">
                    <span>Guests</span>
                    <span><?php echo $guests; ?> Guest<?php echo $guests > 1 ? 's' : ''; ?></span>
                </div>
                <div class="detail-row">
                    <span>Duration</span>
                    <span><?php echo $nights; ?> Night<?php echo $nights > 1 ? 's' : ''; ?></span>
                </div>
            </div>

            <div class="price-breakdown">
                <div class="price-row">
                    <span>₹<?php echo number_format($price_per_night); ?> × <?php echo $nights; ?> night<?php echo $nights > 1 ? 's' : ''; ?></span>
                    <span>₹<?php echo number_format($subtotal); ?></span>
                </div>
                <div class="price-row">
                    <span>Taxes & Fees (12%)</span>
                    <span>₹<?php echo number_format($taxes); ?></span>
                </div>
                <div class="price-row total-row">
                    <span>Total</span>
                    <span>₹<?php echo number_format($total); ?></span>
                </div>
            </div>

            <div class="security-badges">
                <span>🔒 SSL Secured</span>
                <span>✅ Instant Confirmation</span>
                <span>🔄 Free Cancellation</span>
            </div>
        </div>

        <!-- RIGHT: Payment Form -->
        <div class="payment-panel">
            <h2 class="payment-title">Complete Payment</h2>
            <p class="payment-subtitle">Choose your preferred payment method</p>

            <!-- Payment Method Tabs -->
            <div class="method-tabs">
                <button class="method-tab active" data-method="upi" onclick="switchMethod('upi', this)">
                    <span class="tab-icon">📱</span> UPI
                </button>
                <button class="method-tab" data-method="card" onclick="switchMethod('card', this)">
                    <span class="tab-icon">💳</span> Card
                </button>
                <button class="method-tab" data-method="netbanking" onclick="switchMethod('netbanking', this)">
                    <span class="tab-icon">🏦</span> Net Banking
                </button>
                <button class="method-tab" data-method="wallet" onclick="switchMethod('wallet', this)">
                    <span class="tab-icon">👛</span> Wallet
                </button>
            </div>

            <form action="payment_process.php" method="POST" id="paymentForm">
                <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                <input type="hidden" name="payment_method" id="payment_method" value="upi">

                <!-- UPI Section -->
                <div class="method-section active" id="section-upi">
                    <div class="upi-apps">
                        <label class="upi-app-btn">
                            <input type="radio" name="upi_app" value="gpay"> 
                            <span>G Pay</span>
                        </label>
                        <label class="upi-app-btn">
                            <input type="radio" name="upi_app" value="phonepe">
                            <span>PhonePe</span>
                        </label>
                        <label class="upi-app-btn">
                            <input type="radio" name="upi_app" value="paytm">
                            <span>Paytm</span>
                        </label>
                        <label class="upi-app-btn">
                            <input type="radio" name="upi_app" value="other">
                            <span>Other UPI</span>
                        </label>
                    </div>
                    <div class="input-group">
                        <label>UPI ID</label>
                        <input type="text" name="upi_id" placeholder="yourname@upi" class="pay-input">
                    </div>
                </div>

                <!-- Card Section -->
                <div class="method-section" id="section-card">
                    <div class="card-preview" id="cardPreview">
                        <div class="card-chip"></div>
                        <div class="card-number-preview" id="cardNumPreview">•••• •••• •••• ••••</div>
                        <div class="card-bottom-preview">
                            <div>
                                <div class="card-label">Card Holder</div>
                                <div id="cardNamePreview">YOUR NAME</div>
                            </div>
                            <div>
                                <div class="card-label">Expires</div>
                                <div id="cardExpiryPreview">MM/YY</div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Card Number</label>
                        <input type="text" name="card_number" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" class="pay-input" oninput="formatCard(this)">
                    </div>
                    <div class="input-group">
                        <label>Cardholder Name</label>
                        <input type="text" name="card_name" id="cardName" placeholder="Name as on card" class="pay-input" oninput="updateCardName(this.value)">
                    </div>
                    <div class="card-row">
                        <div class="input-group">
                            <label>Expiry Date</label>
                            <input type="text" name="card_expiry" id="cardExpiry" placeholder="MM/YY" maxlength="5" class="pay-input" oninput="formatExpiry(this)">
                        </div>
                        <div class="input-group">
                            <label>CVV</label>
                            <input type="password" name="card_cvv" placeholder="•••" maxlength="3" class="pay-input">
                        </div>
                    </div>
                </div>

                <!-- Net Banking Section -->
                <div class="method-section" id="section-netbanking">
                    <div class="input-group">
                        <label>Select Bank</label>
                        <select name="bank" class="pay-input pay-select">
                            <option value="">-- Choose your bank --</option>
                            <option value="sbi">State Bank of India</option>
                            <option value="hdfc">HDFC Bank</option>
                            <option value="icici">ICICI Bank</option>
                            <option value="axis">Axis Bank</option>
                            <option value="kotak">Kotak Mahindra Bank</option>
                            <option value="pnb">Punjab National Bank</option>
                            <option value="bob">Bank of Baroda</option>
                            <option value="other">Other Bank</option>
                        </select>
                    </div>
                    <div class="netbanking-info">
                        <p>🔗 You will be redirected to your bank's secure net banking portal to complete the payment.</p>
                    </div>
                </div>

                <!-- Wallet Section -->
                <div class="method-section" id="section-wallet">
                    <div class="wallet-options">
                        <label class="wallet-option">
                            <input type="radio" name="wallet" value="paytm">
                            <div class="wallet-card">
                                <span class="wallet-icon">💰</span>
                                <span>Paytm Wallet</span>
                            </div>
                        </label>
                        <label class="wallet-option">
                            <input type="radio" name="wallet" value="amazonpay">
                            <div class="wallet-card">
                                <span class="wallet-icon">🛒</span>
                                <span>Amazon Pay</span>
                            </div>
                        </label>
                        <label class="wallet-option">
                            <input type="radio" name="wallet" value="mobikwik">
                            <div class="wallet-card">
                                <span class="wallet-icon">📲</span>
                                <span>MobiKwik</span>
                            </div>
                        </label>
                        <label class="wallet-option">
                            <input type="radio" name="wallet" value="freecharge">
                            <div class="wallet-card">
                                <span class="wallet-icon">⚡</span>
                                <span>FreeCharge</span>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="pay-btn" id="payBtn">
                    <span id="payBtnText">Pay ₹<?php echo number_format($total); ?></span>
                    <span class="pay-arrow">→</span>
                </button>

                <p class="pay-note">🔒 Your payment is encrypted and 100% secure</p>
            </form>
        </div>

    </div>
</main>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-box">
        <div class="spinner"></div>
        <p>Processing Payment...</p>
        <small>Please do not refresh the page</small>
    </div>
</div>

<script>
function switchMethod(method, btn) {
    document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.method-section').forEach(s => s.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('section-' + method).classList.add('active');
    document.getElementById('payment_method').value = method;
}

function formatCard(input) {
    let val = input.value.replace(/\D/g, '').substring(0, 16);
    let formatted = val.match(/.{1,4}/g)?.join(' ') || val;
    input.value = formatted;
    let display = val.padEnd(16, '•').match(/.{1,4}/g).join(' ');
    document.getElementById('cardNumPreview').textContent = display;
}

function updateCardName(val) {
    document.getElementById('cardNamePreview').textContent = val.toUpperCase() || 'YOUR NAME';
}

function formatExpiry(input) {
    let val = input.value.replace(/\D/g, '');
    if (val.length >= 2) val = val.substring(0,2) + '/' + val.substring(2,4);
    input.value = val;
    document.getElementById('cardExpiryPreview').textContent = val || 'MM/YY';
}

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    document.getElementById('loadingOverlay').style.display = 'flex';
});
</script>

</body>
</html>
