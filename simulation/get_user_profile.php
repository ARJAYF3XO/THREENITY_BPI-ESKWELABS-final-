    <?php
    session_start();
    header('Content-Type: application/json');

    // Debug: capture errors
    $debug = [];

    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            "error" => "No user logged in.",
            "debug" => $debug
        ]);
        exit;
    }

    $user_id = intval($_SESSION['user_id']);

    // DB config
    $conn = new mysqli("localhost", "root", "", "user_db");
    if ($conn->connect_error) {
        echo json_encode([
            "error" => "Database connection failed.",
            "debug" => $conn->connect_error
        ]);
        exit;
    }

    // Fetch simulation profile
    $sql = "SELECT * FROM simulation_profiles WHERE user_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            "error" => "Prepare failed",
            "debug" => $conn->error
        ]);
        exit;
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode([
            "profile" => null,
            "education" => [],
            "debug" => $debug
        ]);
        exit;
    }

    $profile = $result->fetch_assoc();
    $profile_id = $profile['profile_id'];

    // ✅ Debug: list all keys
    $debug[] = "Profile keys: " . implode(", ", array_keys($profile));

    // ✅ Alias gender → sex
    if (isset($profile['gender'])) {
        $profile['sex'] = $profile['gender'];
        $debug[] = "Aliased gender to sex = " . $profile['sex'];
    }

    // Fetch education entries
    $sql2 = "SELECT degree, college, year FROM education_entries WHERE profile_id = ?";
    $stmt2 = $conn->prepare($sql2);
    if ($stmt2) {
        $stmt2->bind_param("i", $profile_id);
        $stmt2->execute();
        $res2 = $stmt2->get_result();

        $education = [];
        while ($r = $res2->fetch_assoc()) {
            $education[] = $r;
        }
    } else {
        $education = [];
        $debug[] = "Education query failed: " . $conn->error;
    }

    echo json_encode([
        "profile" => $profile,
        "education" => $education,
        "debug" => $debug
    ]);
