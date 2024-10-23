<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user_id and passwords from POST request
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        // Include the database connection file
        require_once "dbh.inc.php";  // Update with your dbh file

        // Validate if passwords match
        if ($password === $confirm_password) {
            // Update the user_table with the plain text password using prepared statements
            $query = "UPDATE user_table SET pwd = ? WHERE user_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$password, $user_id]);

            // Redirect to admin dashboard upon successful password update
            header("Location: ../admin_dashboard.php");
            exit();
        } else {
            // Set an error message in the session
            $_SESSION['error_message'] = "Passwords do not match! Please re-enter your password.";
            // Redirect back to the same page to display the error message
            header("Location: ../set_password.php?user_id=" . urlencode($user_id));
            exit();
        }

    } catch (PDOException $e) {
        // Handle any database errors
        die("Error updating password: " . $e->getMessage());
    }
} else {
    // If accessed without POST method, redirect to a safe page (like the set password form)
    header("Location: ../set_password.php");
    exit();
}
