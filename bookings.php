<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login first to book a hotel.');
            window.location.href='login.php';
          </script>";
    exit();
}

$hotel = isset($_GET['hotel']) ? $_GET['hotel'] : 'Selected Hotel';
$location = isset($_GET['location']) ? $_GET['location'] : 'Selected Location';
$rating = isset($_GET['rating']) ? $_GET['rating'] : '⭐ Selected Rating';
$price = isset($_GET['price']) ? $_GET['price'] : '₹ Selected Price';
$image = isset($_GET['image']) ? $_GET['image'] : 'https://images.unsplash.com/photo-1566073771259-6a8506099945';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book Your Room - StayEase</title>
  <link rel="stylesheet" href="booking.css" />
</head>
<body>

  <div class="booking-container">
    <div class="booking-left">
      <img id="hotelImage" src="<?php echo htmlspecialchars($image); ?>" alt="Hotel Room">

      <h2 id="hotelName"><?php echo htmlspecialchars($hotel); ?></h2>
      <p class="location" id="hotelLocation"><?php echo htmlspecialchars($location); ?></p>

      <div class="room-info">
        <h3 id="roomType"><?php echo htmlspecialchars($hotel); ?></h3>
        <p id="hotelRating"><?php echo htmlspecialchars($rating); ?></p>
        <p>✔ King Size Bed</p>
        <p>✔ Free WiFi</p>
        <p>✔ AC Room</p>
        <p>✔ Breakfast Included</p>
        <p>✔ 2 Guests</p>
      </div>

      <div class="price-box">
        <p>Price per night</p>
        <h1 id="hotelPrice"><?php echo htmlspecialchars($price); ?></h1>
      </div>
    </div>

    <div class="booking-right">
      <h1>Book Your Stay</h1>
      <p>Fill in your details to confirm your booking.</p>

      <form id="bookingForm" action="booking_process.php" method="POST">
        
        <!-- Hidden hotel details -->
        <input type="hidden" name="hotel_name" value="<?php echo htmlspecialchars($hotel); ?>">
        <input type="hidden" name="location" value="<?php echo htmlspecialchars($location); ?>">
        <input type="hidden" name="rating" value="<?php echo htmlspecialchars($rating); ?>">
        <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
        <input type="hidden" name="image" value="<?php echo htmlspecialchars($image); ?>">

        <div class="input-group">
          <label>Full Name</label>
          <input type="text" name="fullname" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
        </div>

        <div class="input-group">
          <label>Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" required>
        </div>

        <div class="input-group">
          <label>Phone Number</label>
          <input type="tel" name="phone" placeholder="Enter your phone number" required>
        </div>

        <div class="row">
          <div class="input-group">
            <label>Check-in Date</label>
            <input type="date" name="checkin_date" required>
          </div>

          <div class="input-group">
            <label>Check-out Date</label>
            <input type="date" name="checkout_date" required>
          </div>
        </div>

        <div class="row">
          <div class="input-group">
            <label>Guests</label>
            <input type="number" name="guests" min="1" max="5" value="1" required>
          </div>

          <div class="input-group">
            <label>Room Type</label>
            <select name="room_type" required>
              <option value="">Select Room</option>
              <option value="Standard Room">Standard Room</option>
              <option value="Deluxe Room" selected>Deluxe Room</option>
              <option value="Suite Room">Suite Room</option>
            </select>
          </div>
        </div>

        <div class="input-group">
          <label>Special Request</label>
          <textarea name="special_request" rows="4" placeholder="Any special request..."></textarea>
        </div>

        <button type="submit" class="book-btn">Confirm Booking</button>
      </form>
    </div>
  </div>

</body>
</html>