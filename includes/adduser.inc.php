<?php
// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user details from POST request
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];

    try {
        // Database connection (update with your credentials)
        require_once "dbh.inc.php";  // Include the database connection file

        // Function to generate a unique user_id
        function generateUniqueUserId($pdo) {
            do {
                // Generate a user_id with the format MAC**** (4 random digits)
                $user_id = 'MAC' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

                // Check if this user_id already exists
                $query = "SELECT COUNT(*) FROM user_table WHERE user_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$user_id]);
                $count = $stmt->fetchColumn();
            } while ($count > 0);  // Keep generating until a unique ID is found

            return $user_id;
        }

        // Generate a unique user_id
        $user_id = generateUniqueUserId($pdo);

        // Insert into the user_table with an empty password initially
        $query2 = "INSERT INTO user_table (user_id, pwd, role) VALUES (?, '', 'user')";
        $stmt2 = $pdo->prepare($query2);
        $stmt2->execute([$user_id]);

        // Insert user details into the user_details table using prepared statements
        $query1 = "INSERT INTO user_details (user_id, name, email, phone_no) VALUES (?, ?, ?, ?)";
        $stmt1 = $pdo->prepare($query1);
        $stmt1->execute([$user_id, $name, $email, $phone_no]);

        // Redirect to password entry page
        header("Location: ../set_password.php?user_id=$user_id");
        exit();
    } catch (PDOException $e) {
        // Handle any database errors
        die("Error: " . $e->getMessage());
    }
} else {
    // If accessed without POST method, redirect to a safe page (like the registration page)
    header("Location: ../admin_dashboard.php");
    exit();
}
