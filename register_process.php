<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkSql = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "<script>
                alert('Email already registered! Please login.');
                window.location.href='login.php';
              </script>";
        exit();
    }

    $sql = "INSERT INTO users (fullname, email, phone, password) 
            VALUES ('$fullname', '$email', '$phone', '$password')";

    if ($conn->query($sql) === TRUE) {
        $newUserId = $conn->insert_id;

        $_SESSION['user_id'] = $newUserId;
        $_SESSION['user_name'] = $fullname;
        $_SESSION['user_email'] = $email;

        echo "<script>
                alert('Registration successful!');
                window.location.href='dashboard.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}
?>