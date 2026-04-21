<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login first.');
            window.location.href='login.html';
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id        = $_SESSION['user_id'];
    $booking_id     = intval($_POST['booking_id']);
    $total_amount   = intval($_POST['total_amount']);
    $payment_method = trim($_POST['payment_method']);

    // Validate booking belongs to this user
    $check = $conn->query("SELECT id FROM bookings WHERE id='$booking_id' AND user_id='$user_id'");
    if ($check->num_rows === 0) {
        echo "<script>alert('Invalid booking.'); window.location.href='homepage.php';</script>";
        exit();
    }

    // Generate transaction ID
    $transaction_id = 'TXN' . strtoupper(uniqid());

    // Update booking with payment info
    $sql = "UPDATE bookings 
            SET payment_status='paid', 
                payment_method='$payment_method', 
                transaction_id='$transaction_id', 
                total_amount='$total_amount',
                paid_at=NOW()
            WHERE id='$booking_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['last_booking_id']    = $booking_id;
        $_SESSION['last_transaction_id']= $transaction_id;
        $_SESSION['last_amount']        = $total_amount;
        $_SESSION['last_method']        = $payment_method;

        header("Location: payment_pending.php");
        exit();
    } else {
        echo "Payment Error: " . $conn->error;
    }

} else {
    echo "Invalid request!";
}
?>
