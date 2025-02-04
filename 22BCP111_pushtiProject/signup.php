<?php
include 'db.php'; // Include the connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);

    // Server-side validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    } else if (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
        exit;
    } else if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database using the $conn connection from db.php
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

    // Check for duplicate emails and other errors
    if ($conn->query($sql) === TRUE) {
        header("Location: login.html");
        exit;
        } else {
        // Handle duplicate email error specifically
        if ($conn->errno === 1062) { // Error code for duplicate entry
            echo "This email is already registered.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
