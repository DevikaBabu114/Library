<?php
session_start();


// Ensure the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the current user ID from the session
    $user_id = $_SESSION['user_id']; // Ensure this session variable is set during login


    // Get the updated values from the form
    $name = $_POST["name"] ?: $_POST["original_name"]; // Use original value if not edited
    $phone_no = $_POST["phone"] ?: $_POST["original_phone"]; // Use original value if not edited
    $email = $_POST["email"] ?: $_POST["original_email"]; // Use original value if not edited


    try {
        // Include the database connection file
        require_once "dbh.inc.php";


        // Prepare the query to update the user's profile information
        $query = "UPDATE user_details SET name = ?, phone_no = ?, email = ? WHERE user_id = ?";
        $stmt = $pdo->prepare($query);


        // Execute the query with the provided values
        $stmt->execute([$name, $phone_no, $email, $user_id]);


        // Redirect to a success page with a message
        header("Location: ../viewuserprofile.php?message=Profile updated successfully!");
        exit();
    } catch (PDOException $e) {
        // Handle query failure
        die("Update failed: " . $e->getMessage());
    }
} else {
    // Redirect back to the profile page if not a POST request
    header("Location: user_dashboard.php");
    exit();
}



