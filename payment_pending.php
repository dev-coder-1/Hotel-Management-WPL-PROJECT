<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Processing Payment</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* DARK OVERLAY */
.overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(8px);
}

/* CARD */
.card {
    position: relative;
    background: rgba(30, 41, 59, 0.6);
    padding: 40px 50px;
    border-radius: 20px;
    text-align: center;
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

/* LOADER */
.loader {
    width: 60px;
    height: 60px;
    border: 5px solid rgba(255,255,255,0.2);
    border-top: 5px solid #3b82f6;
    border-radius: 50%;
    margin: 0 auto 20px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% { transform: rotate(360deg); }
}

/* TEXT */
h2 {
    color: white;
    margin-bottom: 10px;
}

p {
    color: #94a3b8;
    font-size: 14px;
}
</style>
</head>

<body>

<div class="overlay"></div>

<div class="card">
    <div class="loader"></div>
    <h2>Processing Payment...</h2>
    <p>Please do not refresh the page</p>
</div>

<script>
// redirect after 3 seconds
setTimeout(() => {
    window.location.href = "payment_success.php";
}, 3000);
</script>

</body>
</html>