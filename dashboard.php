<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$userName = isset($_SESSION['fullname']) ? htmlspecialchars($_SESSION['fullname']) : "User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bg.css">
    <link rel="stylesheet" href="homepage.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayEase Dashboard</title>
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="dashboard.php">StayEase</a>
            </div>

            <ul class="nav-links">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="hotel.php">Hotels</a></li>
                <li><a href="bookings.php">Bookings</a></li>
                <li><a href="deals.php">Deals</a></li>
                <li><a href="contact.html">Support</a></li>
            </ul>

            <div class="nav-buttons">
                <button class="login-btn" onclick="showMessage('Welcome, <?php echo $userName; ?>!')">
                    <?php echo $userName; ?>
                </button>
                <button class="signup-btn" onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-overlay">
                <div class="hero-content">
                    <h1>Welcome Back, <?php echo $userName; ?> 👋</h1>
                    <p>You are now logged in. Access bookings, deals, and premium hotel services.</p>

                    <div class="search-container">
                        <form class="search-form" onsubmit="searchHotels(event)">
                            
                            <div class="search-field autocomplete-container">
                                <label for="destination">Destination</label>
                                <input type="text" id="destination" placeholder="Enter city" autocomplete="off" required>
                                <div id="suggestions" class="suggestions-box"></div>
                            </div>

                            <div class="search-field">
                                <label for="checkin">Check-In</label>
                                <input type="date" id="checkin" required>
                            </div>

                            <div class="search-field">
                                <label for="checkout">Check-Out</label>
                                <input type="date" id="checkout" required>
                            </div>

                            <div class="search-field">
                                <label for="guests">Guests</label>
                                <select id="guests" required>
                                    <option value="">Select</option>
                                    <option value="1">1 Guest</option>
                                    <option value="2">2 Guests</option>
                                    <option value="3">3 Guests</option>
                                    <option value="4">4 Guests</option>
                                    <option value="5+">5+ Guests</option>
                                </select>
                            </div>

                            <div class="search-button-wrapper">
                                <button type="submit" class="search-btn">Search Hotels</button>
                            </div>

                        </form>
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
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="hotel.html">Hotels</a></li>
                    <li><a href="bookings.php">Bookings</a></li>
                    <li><a href="deals.php">Deals</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
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
        const cities = [
            "Mumbai",
            "Pune",
            "Nashik",
            "Kolhapur",
            "Delhi",
            "Himachal",
            "Bangalore",
            "Chennai",
            "Mussoorie",
            "Rajasthan",
            "Kashmir"
        ];

        function searchHotels(event) {
            event.preventDefault();

            const destination = document.getElementById("destination").value.trim();
            const checkin = document.getElementById("checkin").value;
            const checkout = document.getElementById("checkout").value;
            const guests = document.getElementById("guests").value;

            if (!destination || !checkin || !checkout || !guests) {
                alert("Please fill all search details.");
                return;
            }

            if (checkout <= checkin) {
                alert("Check-out date must be after check-in date.");
                return;
            }

            if (!cities.includes(destination)) {
                alert("Please select a valid city from the suggestions.");
                return;
            }

            // Optional: keep if you need later
            localStorage.setItem("selectedCity", destination);
            localStorage.setItem("checkin", checkin);
            localStorage.setItem("checkout", checkout);
            localStorage.setItem("guests", guests);

            // ✅ Redirect to hotel page with filters
            window.location.href = "hotel.php?city=" + encodeURIComponent(destination) +
                "&checkin=" + checkin +
                "&checkout=" + checkout +
                "&guests=" + guests;
        }

        function showMessage(message) {
            alert(message);
        }

        const today = new Date().toISOString().split("T")[0];
        document.getElementById("checkin").setAttribute("min", today);
        document.getElementById("checkout").setAttribute("min", today);

        document.getElementById("checkin").addEventListener("change", function () {
            document.getElementById("checkout").setAttribute("min", this.value);
        });

        const destinationInput = document.getElementById("destination");
        const suggestionsBox = document.getElementById("suggestions");

        destinationInput.addEventListener("input", function () {
            const inputValue = this.value.toLowerCase();
            suggestionsBox.innerHTML = "";

            if (inputValue === "") {
                suggestionsBox.style.display = "none";
                return;
            }

            const filteredCities = cities.filter(city =>
                city.toLowerCase().startsWith(inputValue)
            );

            if (filteredCities.length === 0) {
                suggestionsBox.style.display = "none";
                return;
            }

            filteredCities.forEach(city => {
                const suggestionItem = document.createElement("div");
                suggestionItem.classList.add("suggestion-item");
                suggestionItem.textContent = city;

                suggestionItem.addEventListener("click", function () {
                    destinationInput.value = city;
                    suggestionsBox.innerHTML = "";
                    suggestionsBox.style.display = "none";
                });

                suggestionsBox.appendChild(suggestionItem);
            });

            suggestionsBox.style.display = "block";
        });

        document.addEventListener("click", function (e) {
            if (!e.target.closest(".autocomplete-container")) {
                suggestionsBox.style.display = "none";
            }
        });
    </script>

</body>
</html>