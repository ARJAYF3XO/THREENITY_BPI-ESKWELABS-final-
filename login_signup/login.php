<?php
session_start(); // Start a session for login tracking

// Database connection
require_once __DIR__ . "/../db_conn.php";

if ($conn->connect_error) {
    // Keep original behavior for DB connection errors
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data safely
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Check if email and password are provided
if (empty($email) || empty($password)) {
    $_SESSION['notification'] = "Email and password are required.";
    header("Location: login_signup.php?tab=login");
    exit();
}

// Prepare and execute statement
$stmt = $conn->prepare("SELECT id, password FROM login_info WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        // ✅ Correct password. Set session variables.
        $_SESSION['user_id'] = $user_id;
        $_SESSION['email'] = $email;

        // Set a notification message in the session to be displayed on index.php
        $_SESSION['notification'] = "Login successful with email: " . htmlspecialchars($email) . "!";

        // Redirect to homepage
        header("Location: ../index.php");
        exit();
    } else {
        // ❌ Incorrect password
        $_SESSION['notification'] = "❌ Incorrect password.";
        header("Location: login_signup.php?tab=login");
        exit();
    }
} else {
    // ❌ Email not found
    $_SESSION['notification'] = "❌ Email not found.";
    header("Location: login_signup.php?tab=login");
    exit();
}

$stmt->close();
$conn->close();
?>
