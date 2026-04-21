<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Login first'); window.location.href='login.html';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

$hotel_name = $_POST['hotel_name'];
$location = $_POST['location'];
$price = intval(preg_replace('/[^0-9]/', '', $_POST['price']));
$room_type = "Deluxe Room";
$checkin = $_POST['checkin_date'];
$checkout = $_POST['checkout_date'];
$guests = 1;

// 🔥 CHECK ROOM AVAILABILITY
$sqlCheck = "SELECT COUNT(*) as total 
FROM bookings 
WHERE hotel_name='$hotel_name'
AND NOT (
    checkout_date <= '$checkin'
    OR checkin_date >= '$checkout'
)";
$res = $conn->query($sqlCheck);
$row = $res ? $res->fetch_assoc() : ['total' => 0];

$totalRooms = 5;
$booked = $row['total'] ?? 0;

if ($booked >= $totalRooms) {
    echo "<script>alert('Rooms fully booked!'); window.history.back();</script>";
    exit();
}

// INSERT BOOKING
$sql = "INSERT INTO bookings (user_id, hotel_name, location, room_type, price, checkin_date, checkout_date, guests)
VALUES ('$user_id', '$hotel_name', '$location', '$room_type', '$price', '$checkin', '$checkout', '$guests')";

if ($conn->query($sql)) {
    header("Location: payment.php");
} else {
    echo "Error: " . $conn->error;
}
?>