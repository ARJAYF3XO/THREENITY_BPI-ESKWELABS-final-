<?php
session_start(); // Start a session for signup tracking

// Database connection
require_once __DIR__ . "/../db_conn.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data safely
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

// Check if all fields are provided
if (empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['notification'] = "All fields are required.";
    header("Location: login_signup.php?tab=signup");
    exit();
}

// Check if password and confirm password match
if ($password !== $confirm_password) {
    $_SESSION['notification'] = "Passwords do not match.";
    header("Location: login_signup.php?tab=signup");
    exit();
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM login_info WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['notification'] = "Email already registered.";
    $stmt->close();
    $conn->close();
    header("Location: login_signup.php?tab=signup");
    exit();
}
$stmt->close();

// Hash the password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO login_info (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $hashed);

if ($stmt->execute()) {
    // ✅ Successful signup. Set session variables.
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['email'] = $email;

    // Set success notification
    $_SESSION['notification'] = "Signup successful with email: " . htmlspecialchars($email) . "! You are now logged in.";

    // Redirect to homepage
    header("Location: ../index.php");
    exit();
} else {
    $_SESSION['notification'] = "Signup failed: " . $stmt->error;
    header("Location: login_signup.php?tab=signup");
    exit();
}

$stmt->close();
$conn->close();
?>
