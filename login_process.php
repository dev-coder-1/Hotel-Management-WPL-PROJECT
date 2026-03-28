<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>
                alert('Please fill all fields!');
                window.location.href='login.php';
              </script>";
        exit();
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_email'] = $user['email'];

            echo "<script>
                    alert('Login successful!');
                    window.location.href='dashboard.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Incorrect password!');
                    window.location.href='login.php';
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                alert('No account found with this email!');
                window.location.href='login.php';
              </script>";
        exit();
    }
} else {
    echo "Invalid request!";
}
?>