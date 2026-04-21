<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $sql = "INSERT INTO contact (name, email, subject, message)
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Message sent successfully!');
                window.location.href='contact.html';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>