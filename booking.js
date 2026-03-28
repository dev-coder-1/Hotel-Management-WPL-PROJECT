window.onload = function () {
    const params = new URLSearchParams(window.location.search);
const image = params.get("image");
if (image) {
    document.getElementById("hotelImage").src = image;
}
    const hotel = params.get("hotel");
    const location = params.get("location");
    const rating = params.get("rating");
    const price = params.get("price");

    if (hotel) {
        document.getElementById("hotelName").innerText = hotel;
        document.getElementById("roomType").innerText = hotel;
    }

    if (location) {
        document.getElementById("hotelLocation").innerText = location;
    }

    if (rating) {
        document.getElementById("hotelRating").innerText = rating;
    }

    if (price) {
        document.getElementById("hotelPrice").innerText = price;
    }

    document.getElementById("bookingForm").addEventListener("submit", function(e) {
        e.preventDefault();
        alert("Booking Confirmed Successfully!");
        window.location.href = "confirmation.html";
    });
};