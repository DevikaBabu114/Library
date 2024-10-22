<?php
session_start();

// Include your database connection file
require_once 'dbh.inc.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Check if the request method is POST and if the book_id is passed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    // Debug: Display the received book ID
    echo "Book ID: " . htmlspecialchars($book_id) . "<br>";

    try {
        // Insert the reservation details into the reservation table
        $sql = "INSERT INTO reservation (user_id, book_id, copy_id, date_reserved, date_notifed, status)
                VALUES (:user_id, :book_id, NULL, NOW(), NULL, 'pending')";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':book_id', $book_id);
        
        // Execute the query
        if ($stmt->execute()) {
            // Reservation successful, redirect to reservation details
            header("Location: ../viewreservations.php");
            exit();
        } else {
            // Debug: If execution fails
            echo "Error: Could not execute the query.<br>";
            echo "SQLSTATE: " . $stmt->errorCode() . "<br>";
            print_r($stmt->errorInfo());
        }
    } catch (PDOException $e) {
        // Display the error message
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to user dashboard for invalid request
    header("Location: ../user_dashboard.php");
    exit();
}
?>
