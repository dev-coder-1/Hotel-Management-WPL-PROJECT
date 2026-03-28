<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login first.');
            window.location.href='login.php';
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $hotel_name = trim($_POST['hotel_name']);
    $location = trim($_POST['location']);
    $rating = trim($_POST['rating']);
    $price = trim($_POST['price']);
    $image = trim($_POST['image']);
    $checkin_date = trim($_POST['checkin_date']);
    $checkout_date = trim($_POST['checkout_date']);
    $guests = trim($_POST['guests']);
    $room_type = trim($_POST['room_type']);
    $special_request = trim($_POST['special_request']);

    if (
        empty($fullname) || empty($email) || empty($phone) ||
        empty($hotel_name) || empty($location) ||
        empty($checkin_date) || empty($checkout_date) ||
        empty($guests) || empty($room_type)
    ) {
        echo "<script>
                alert('Please fill all required fields.');
                window.history.back();
              </script>";
        exit();
    }

    $sql = "INSERT INTO bookings 
            (user_id, fullname, email, phone, hotel_name, location, rating, price, image, checkin_date, checkout_date, guests, room_type, special_request)
            VALUES
            ('$user_id', '$fullname', '$email', '$phone', '$hotel_name', '$location', '$rating', '$price', '$image', '$checkin_date', '$checkout_date', '$guests', '$room_type', '$special_request')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Booking Confirmed Successfully!');
                window.location.href='bookings.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

} else {
    echo "Invalid request!";
}
?>