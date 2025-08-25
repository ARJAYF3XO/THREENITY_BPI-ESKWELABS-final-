<?php
// Start the session to access the user_id
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect them to the login page for security
    header("Location: ../login_signup/login_signup.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Database connection
require_once __DIR__ . "/../db_conn.php";

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $name = $_POST['name'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $country = $_POST['country'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $occupancy = $_POST['occupancy'] ?? '';
    $position = $_POST['position'] ?? '';
    $religion = $_POST['religion'] ?? '';
    $salary = floatval($_POST['salary'] ?? 0);
    $monthlyExpense = floatval($_POST['monthlyExpense'] ?? 0);
    $savings = floatval($_POST['savings'] ?? 0);
    $educationEntries = $_POST['education'] ?? [];

    // Check if a profile for this user already exists
    $stmt_check = $conn->prepare("SELECT profile_id FROM simulation_profiles WHERE user_id = ?");
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // If a profile exists, update it
        $row = $result_check->fetch_assoc();
        $profile_id = $row['profile_id'];
        $stmt_update = $conn->prepare("UPDATE simulation_profiles SET name=?, sex=?, country=?, dob=?, occupancy=?, position=?, religion=?, salary=?, monthly_expense=?, savings=? WHERE user_id=?");
        $stmt_update->bind_param("sssssssdiii", $name, $sex, $country, $dob, $occupancy, $position, $religion, $salary, $monthlyExpense, $savings, $user_id);

        if ($stmt_update->execute()) {
            echo "Profile updated successfully! Redirecting...";
        } else {
            echo "Error updating profile: " . $stmt_update->error;
        }
        $stmt_update->close();
    } else {
        // If no profile exists, insert a new one
        $stmt_insert = $conn->prepare("INSERT INTO simulation_profiles (user_id, name, sex, country, dob, occupancy, position, religion, salary, monthly_expense, savings) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("isssssssddd", $user_id, $name, $sex, $country, $dob, $occupancy, $position, $religion, $salary, $monthlyExpense, $savings);

        if ($stmt_insert->execute()) {
            $profile_id = $conn->insert_id; // Get the newly created profile_id
            echo "New profile created successfully! Redirecting...";
        } else {
            echo "Error creating profile: " . $stmt_insert->error;
        }
        $stmt_insert->close();
    }

    // Now handle the education entries.
    // First, clear old ones to avoid duplicates on update using a prepared statement.
    if (isset($profile_id)) {
        $stmt_delete_edu = $conn->prepare("DELETE FROM education_entries WHERE profile_id = ?");
        $stmt_delete_edu->bind_param("i", $profile_id);
        $stmt_delete_edu->execute();
        $stmt_delete_edu->close();

        // Prepare the statement for inserting education entries
        $stmt_edu = $conn->prepare("INSERT INTO education_entries (profile_id, degree, college, year) VALUES (?, ?, ?, ?)");

        foreach ($educationEntries as $entry) {
            $degree = $entry['degree'];
            $college = $entry['college'];
            $year = intval($entry['year']); // Explicitly cast the year to an integer

            $stmt_edu->bind_param("issi", $profile_id, $degree, $college, $year);
            $stmt_edu->execute();
        }
        $stmt_edu->close();
    }

    // Redirect to the next step of the simulation after successful submission
// Default redirect is Step 2 unless user chose another
$redirect_to = $_POST['redirect_to'] ?? 'sim2_view.php';
header("Location: " . $redirect_to);

    exit();

} else {
    // If not a POST request, redirect to the form page
    header("Location: sim1_view.php");
    exit();
}

$conn->close();
?>
