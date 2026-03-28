<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
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
            <li><a href="<?php echo $isLoggedIn ? 'deals.php' : 'login.php'; ?>">Deals</a></li>
            <li><a href="<?php echo $isLoggedIn ? 'bookings.php' : 'login.php'; ?>">Bookings</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        <div class="nav-buttons">
            <?php if ($isLoggedIn): ?>
                <a href="dashboard.php"><button class="login-btn">Dashboard</button></a>
                <a href="logout.php"><button class="signup-btn">Logout</button></a>
            <?php else: ?>
                <a href="login.php"><button class="login-btn">Login</button></a>
                <a href="signup.php"><button class="signup-btn">Sign Up</button></a>
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
                <div class="hotel-card" data-city="Mumbai" data-price="7500" data-rating="4.8">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945" alt="Mumbai Hotel">
                    <div class="hotel-info">
                        <h3>The Taj Palace Mumbai</h3>
                        <p class="location">Mumbai</p>
                        <p class="rating">⭐ 4.8</p>
                        <p class="price">₹7,500 / night</p>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- HOTEL 2 -->
                <div class="hotel-card" data-city="Mumbai" data-price="5200" data-rating="4.5">
                    <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa" alt="Mumbai Hotel">
                    <div class="hotel-info">
                        <h3>Marine Drive Residency</h3>
                        <p class="location">Mumbai</p>
                        <p class="rating">⭐ 4.5</p>
                        <p class="price">₹5,200 / night</p>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- HOTEL 3 -->
                <div class="hotel-card" data-city="Pune" data-price="4800" data-rating="4.6">
                    <img src="https://images.unsplash.com/photo-1445019980597-93fa8acb246c" alt="Pune Hotel">
                    <div class="hotel-info">
                        <h3>Pune Grand Stay</h3>
                        <p class="location">Pune</p>
                        <p class="rating">⭐ 4.6</p>
                        <p class="price">₹4,800 / night</p>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- HOTEL 4 -->
                <div class="hotel-card" data-city="Pune" data-price="4200" data-rating="4.4">
                    <img src="https://images.unsplash.com/photo-1455587734955-081b22074882" alt="Pune Hotel">
                    <div class="hotel-info">
                        <h3>Royal Orchid Pune</h3>
                        <p class="location">Pune</p>
                        <p class="rating">⭐ 4.4</p>
                        <p class="price">₹4,200 / night</p>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- HOTEL 5 -->
                <div class="hotel-card" data-city="Nashik" data-price="4900" data-rating="4.7">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267" alt="Nashik Hotel">
                    <div class="hotel-info">
                        <h3>Vine Valley Resort</h3>
                        <p class="location">Nashik</p>
                        <p class="rating">⭐ 4.7</p>
                        <p class="price">₹4,900 / night</p>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- HOTEL 6 -->
                <div class="hotel-card" data-city="Delhi" data-price="6800" data-rating="4.8">
                    <img src="https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd" alt="Delhi Hotel">
                    <div class="hotel-info">
                        <h3>Capital Crown Delhi</h3>
                        <p class="location">Delhi</p>
                        <p class="rating">⭐ 4.8</p>
                        <p class="price">₹6,800 / night</p>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- HOTEL 7 -->
                <div class="hotel-card" data-city="Himachal" data-price="6200" data-rating="4.9">
                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85" alt="Himachal Hotel">
                    <div class="hotel-info">
                        <h3>Snow Peak Retreat</h3>
                        <p class="location">Himachal</p>
                        <p class="rating">⭐ 4.9</p>
                        <p class="price">₹6,200 / night</p>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- HOTEL 8 -->
                <div class="hotel-card" data-city="Bangalore" data-price="5500" data-rating="4.6">
                    <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a" alt="Bangalore Hotel">
                    <div class="hotel-info">
                        <h3>Silicon Suites Bangalore</h3>
                        <p class="location">Bangalore</p>
                        <p class="rating">⭐ 4.6</p>
                        <p class="price">₹5,500 / night</p>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- HOTEL 9 -->
                <div class="hotel-card" data-city="Chennai" data-price="5100" data-rating="4.5">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb" alt="Chennai Hotel">
                    <div class="hotel-info">
                        <h3>Marina Bay Residency</h3>
                        <p class="location">Chennai</p>
                        <p class="rating">⭐ 4.5</p>
                        <p class="price">₹5,100 / night</p>
                        <button class="book-btn">Book Now</button>
                    </div>
                </div>

                <!-- HOTEL 10 -->
                <div class="hotel-card" data-city="Kashmir" data-price="7800" data-rating="4.9">
                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85" alt="Kashmir Hotel">
                    <div class="hotel-info">
                        <h3>Dal Lake View Resort</h3>
                        <p class="location">Kashmir</p>
                        <p class="rating">⭐ 4.9</p>
                        <p class="price">₹7,800 / night</p>
                        <button class="book-btn">Book Now</button>
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
                <li><a href="<?php echo $isLoggedIn ? 'deals.php' : 'login.php'; ?>">Deals</a></li>
                <li><a href="<?php echo $isLoggedIn ? 'bookings.php' : 'login.php'; ?>">Bookings</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Support</h4>
            <ul>
                <li><a href="#">Help Center</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="#">Cancellation Policy</a></li>
                <li><a href="#">FAQs</a></li>
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
const bookButtons = document.querySelectorAll(".book-btn");

bookButtons.forEach(button => {
    button.addEventListener("click", function() {
        const card = this.closest(".hotel-card");

        const hotelName = card.querySelector("h3").innerText;
        const location = card.querySelector(".location").innerText;
        const rating = card.querySelector(".rating").innerText;
        const price = card.querySelector(".price").innerText;
        const hotelImage = card.querySelector("img").src;

        <?php if ($isLoggedIn): ?>
            window.location.href = "bookings.php?hotel=" + encodeURIComponent(hotelName)
                + "&location=" + encodeURIComponent(location)
                + "&rating=" + encodeURIComponent(rating)
                + "&price=" + encodeURIComponent(price)
                + "&image=" + encodeURIComponent(hotelImage);
        <?php else: ?>
            alert("Please login first to book a hotel.");
            window.location.href = "login.php";
        <?php endif; ?>
    });
});
</script>

</body>
</html>