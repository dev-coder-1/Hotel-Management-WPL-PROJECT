<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotels - StayEase</title>

    <link rel="stylesheet" href="bg.css">
    <link rel="stylesheet" href="hotel.css">
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <a href="homepage.php">StayEase</a>
        </div>

        <ul class="nav-links">
            <li><a href="homepage.php">Home</a></li>
            <li><a href="hotel.php" class="active-link">Hotels</a></li>
            <li><a href="<?php echo $isLoggedIn ? 'bookings.php' : 'login.html'; ?>">Bookings</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>

        <div class="nav-buttons">
            <?php if ($isLoggedIn): ?>
                <a href="dashboard.php"><button class="login-btn" >Dashboard</button></a>
                <a href="logout.php"><button class="signup-btn">Logout</button></a>
            <?php else: ?>
                <a href="login.html"><button class="login-btn">Login</button></a>
                <a href="signup.html"><button class="signup-btn">Sign Up</button></a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<main>
    <section class="hotels-section">
        <div class="hotels-wrapper">

            <div class="page-heading">
                <h1>Explore Hotels</h1>
                <p>Discover top-rated stays, compare prices, and book your perfect hotel.</p>
            </div>

            <div class="search-filter-box">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search by city or hotel name..." onkeyup="filterHotels()">
                </div>

                <div class="filter-box">
                    <select id="priceFilter" onchange="filterHotels()">
                        <option value="all">All Prices</option>
                        <option value="low">Below ₹5000</option>
                        <option value="mid">₹5000 - ₹10000</option>
                        <option value="high">Above ₹10000</option>
                    </select>

                    <select id="ratingFilter" onchange="filterHotels()">
                        <option value="all">All Ratings</option>
                        <option value="4">4★ & Above</option>
                        <option value="4.5">4.5★ & Above</option>
                    </select>
                </div>
            </div>

            <div class="hotels-grid" id="hotelsGrid">

                <!-- HOTEL 1 -->
                <div class="hotel-card" data-hotel="The Taj Palace Mumbai" data-city="Mumbai" data-price="7500" data-rating="4.8">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945" alt="Mumbai Hotel">
                    <div class="hotel-info">
                        <h3>The Taj Palace Mumbai</h3>
                        <p class="location">Mumbai</p>
                        <p class="rating">⭐ 4.8</p>
                        <p class="price">₹7,500 / night</p>
                        <?php
                        $hotelName = "The Taj Palace Mumbai";
                        $today = isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">
                        Available Rooms: <?php echo $available; ?>
                        </p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- HOTEL 2 -->
                <div class="hotel-card" data-hotel="Marine Drive Residency" data-city="Mumbai" data-price="5200" data-rating="4.5">
                    <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa" alt="Mumbai Hotel">
                    <div class="hotel-info">
                        <h3>Marine Drive Residency</h3>
                        <p class="location">Mumbai</p>
                        <p class="rating">⭐ 4.5</p>
                        <p class="price">₹5,200 / night</p>
                        <?php
                        $hotelName = "Marine Drive Residency";
                        $today = isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">Available Rooms: <?php echo $available; ?></p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- HOTEL 3 -->
                <div class="hotel-card" data-hotel="Pune Grand Stay" data-city="Pune" data-price="4800" data-rating="4.6">
                    <img src="https://images.unsplash.com/photo-1445019980597-93fa8acb246c" alt="Pune Hotel">
                    <div class="hotel-info">
                        <h3>Pune Grand Stay</h3>
                        <p class="location">Pune</p>
                        <p class="rating">⭐ 4.6</p>
                        <p class="price">₹4,800 / night</p>
                        <?php
                                                $hotelName = "Pune Grand Stay";
                        $today = isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">Available Rooms: <?php echo $available; ?></p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- HOTEL 4 -->
                <div class="hotel-card" data-hotel="Royal Orchid Pune" data-city="Pune" data-price="4200" data-rating="4.4">
                    <img src="https://images.unsplash.com/photo-1455587734955-081b22074882" alt="Pune Hotel">
                    <div class="hotel-info">
                        <h3>Royal Orchid Pune</h3>
                        <p class="location">Pune</p>
                        <p class="rating">⭐ 4.4</p>
                        <p class="price">₹4,200 / night</p>
                        <?php
                                                $hotelName = "Royal Orchid Pune";
                        $today = isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">Available Rooms: <?php echo $available; ?></p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- HOTEL 5 -->
                <div class="hotel-card" data-hotel="Vine Valley Resort" data-city="Nashik" data-price="4900" data-rating="4.7">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267" alt="Nashik Hotel">
                    <div class="hotel-info">
                        <h3>Vine Valley Resort</h3>
                        <p class="location">Nashik</p>
                        <p class="rating">⭐ 4.7</p>
                        <p class="price">₹4,900 / night</p>
                        <?php
                                                $hotelName = "Vine Valley Resort";
                        $today = isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">Available Rooms: <?php echo $available; ?></p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- HOTEL 6 -->
                <div class="hotel-card" data-hotel="Capital Crown Delhi" data-city="Delhi" data-price="6800" data-rating="4.8">
                    <img src="https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd" alt="Delhi Hotel">
                    <div class="hotel-info">
                        <h3>Capital Crown Delhi</h3>
                        <p class="location">Delhi</p>
                        <p class="rating">⭐ 4.8</p>
                        <p class="price">₹6,800 / night</p>
                        <?php
                                                $hotelName = "Capital Crown Delhi";
                        $today = isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">Available Rooms: <?php echo $available; ?></p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- HOTEL 7 -->
                <div class="hotel-card" data-hotel="Snow Peak Retreat" data-city="Himachal" data-price="6200" data-rating="4.9">
                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85" alt="Himachal Hotel">
                    <div class="hotel-info">
                        <h3>Snow Peak Retreat</h3>
                        <p class="location">Himachal</p>
                        <p class="rating">⭐ 4.9</p>
                        <p class="price">₹6,200 / night</p>
                        <?php
                                                $hotelName = "Snow Peak Retreat";
                        $today = isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">Available Rooms: <?php echo $available; ?></p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- HOTEL 8 -->
                <div class="hotel-card" data-hotel="Silicon Suites Bangalore" data-city="Bangalore" data-price="5500" data-rating="4.6">
                    <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a" alt="Bangalore Hotel">
                    <div class="hotel-info">
                        <h3>Silicon Suites Bangalore</h3>
                        <p class="location">Bangalore</p>
                        <p class="rating">⭐ 4.6</p>
                        <p class="price">₹5,500 / night</p>
                        <?php
                                                $hotelName = "Silicon Suites Bangalore";
                        $today = isset($_SESSION['selected_date']) ? $_SESSION['selected_date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">Available Rooms: <?php echo $available; ?></p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- HOTEL 9 -->
                <div class="hotel-card" data-hotel="Marina Bay Residency" data-city="Chennai" data-price="5100" data-rating="4.5">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb" alt="Chennai Hotel">
                    <div class="hotel-info">
                        <h3>Marina Bay Residency</h3>
                        <p class="location">Chennai</p>
                        <p class="rating">⭐ 4.5</p>
                        <p class="price">₹5,100 / night</p>
                        <?php
                                                $hotelName = "Marina Bay Residency";
                        $today = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">Available Rooms: <?php echo $available; ?></p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- HOTEL 10 -->
                <div class="hotel-card" data-hotel="Dal Lake View Resort" data-city="Kashmir" data-price="7800" data-rating="4.9">
                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85" alt="Kashmir Hotel">
                    <div class="hotel-info">
                        <h3>Dal Lake View Resort</h3>
                        <p class="location">Kashmir</p>
                        <p class="rating">⭐ 4.9</p>
                        <p class="price">₹7,800 / night</p>
                        <?php
                                                $hotelName = "Dal Lake View Resort";
                        $today = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

                        $sql = "SELECT COUNT(*) as total 
                                FROM bookings 
                                WHERE hotel_name='$hotelName' 
                                AND checkin_date='$today'";

                        $res = $conn->query($sql);
                        $row = $res ? $res->fetch_assoc() : ['total' => 0];

                        $totalRooms = 5;
                        $available = max(0, $totalRooms - $row['total']);
                        ?>

                        <p style="color:lightgreen;">Available Rooms: <?php echo $available; ?></p>

                        <?php if($available <= 2 && $available > 0){ ?>
                        <p style="color:orange;">Only <?php echo $available; ?> left!</p>
                        <?php } ?>

                        <?php if($available <= 0){ ?>
                        <p style="color:red;">❌ Fully Booked</p>
                        <?php } ?>

                        <?php if($available > 0){ ?>
                        <button class="book-btn">Book Now</button>
                        <?php } else { ?>
                        <button disabled>Not Available</button>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="footer-container">

        <div class="footer-section">
            <h3>StayEase</h3>
            <p>Your trusted hotel booking partner for comfortable and affordable stays.</p>
        </div>

        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="hotel.php">Hotels</a></li>
                <li><a href="<?php echo $isLoggedIn ? 'bookings.php' : 'login.html'; ?>">Bookings</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Support</h4>
            <ul>
                <li><a href="contact.html">Help Center</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                
            </ul>
        </div>

        <div class="footer-section">
            <h4>Contact</h4>
            <p>Email: support@stayease.com</p>
            <p>Phone: +91 8856789715</p>
            <p>Mumbai, India</p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 All Rights With Coding Mavlas</p>
    </div>
</footer>

<script>


document.querySelectorAll(".book-btn").forEach(btn => {
    btn.addEventListener("click", function() {

        if (this.disabled) return; // 🔥 IMPORTANT

        const card = this.closest(".hotel-card");

        const hotel = card.getAttribute("data-hotel");
        const location = card.querySelector(".location").innerText;
        const price = card.querySelector(".price").innerText;
        const rating = card.querySelector(".rating").innerText;
        const image = card.querySelector("img").src;

        window.location.href =
        `bookings.php?hotel=${hotel}&location=${location}&price=${price}&rating=${rating}&image=${image}`;
    });
});
</script>

</body>
</html>