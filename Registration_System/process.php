<?php
// Database connection settings
$host = "localhost";
$user = "root";
$pass = "";
$db   = "student_db";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    // Sanitize input to prevent basic XSS
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $course = htmlspecialchars($_POST['course']);

    // Using prepared statements for security against SQL Injection
    $stmt = $conn->prepare("INSERT INTO students (fullname, email, course) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $course);

    if ($stmt->execute()) {
        header("Location: dashboard.php?status=success");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>