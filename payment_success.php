<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$booking_id     = $_SESSION['last_booking_id']    ?? '—';
$transaction_id = $_SESSION['last_transaction_id'] ?? '—';
$amount         = $_SESSION['last_amount']         ?? 0;
$method         = $_SESSION['last_method']         ?? 'Online';

// Clear session variables after use
unset($_SESSION['last_booking_id'], $_SESSION['last_transaction_id'], $_SESSION['last_amount'], $_SESSION['last_method']);

$method_labels = [
    'upi'        => '📱 UPI',
    'card'       => '💳 Credit/Debit Card',
    'netbanking' => '🏦 Net Banking',
    'wallet'     => '👛 Digital Wallet',
];
$method_display = $method_labels[$method] ?? ucfirst($method);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - StayEase</title>
    <link rel="stylesheet" href="bg.css">
    <link rel="stylesheet" href="payment_success.css">
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
        </ul>
        <div class="nav-buttons">
            <button class="login-btn" onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </nav>
</header>

<main class="success-main">
    <div class="success-card">

        <!-- Animated checkmark -->
        <div class="check-circle">
            <svg class="check-svg" viewBox="0 0 52 52">
                <circle class="check-circle-bg" cx="26" cy="26" r="25" fill="none"/>
                <path class="check-mark" fill="none" d="M14 27 l8 8 l16-16"/>
            </svg>
        </div>

        <h1>Payment Successful!</h1>
        <p class="success-msg">Your booking has been confirmed. Get ready for an amazing stay! 🎉</p>

        <div class="txn-details">
            <div class="txn-row">
                <span>Booking ID</span>
                <span class="mono">#<?php echo $booking_id; ?></span>
            </div>
            <div class="txn-row">
                <span>Transaction ID</span>
                <span class="mono"><?php echo $transaction_id; ?></span>
            </div>
            <div class="txn-row">
                <span>Payment Method</span>
                <span><?php echo $method_display; ?></span>
            </div>
            <div class="txn-row total-paid">
                <span>Amount Paid</span>
                <span>₹<?php echo number_format($amount); ?></span>
            </div>
        </div>

        <p class="email-notice">📧 A confirmation has been sent to <strong><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'your email'); ?></strong></p>

        <div class="success-actions">
            <a href="dashboard.php" class="btn-primary">Go to Dashboard</a>
            <a href="hotel.php" class="btn-secondary">Browse More Hotels</a>
        </div>

    </div>
</main>

</body>
</html>
