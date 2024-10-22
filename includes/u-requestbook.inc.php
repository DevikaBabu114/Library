<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the current user ID from the session
    $user_id = $_SESSION['user_id']; // Ensure this session variable is set during login
    $title = $_POST["title"];
    $author = $_POST["author"];
    $category = $_POST["category"];


    try {
        require_once "dbh.inc.php"; // Include the database connection file


        // Prepare and execute the query to insert the book request
        $query = "INSERT INTO book_request (name, author, category, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $author, $category, $user_id]);


        // Redirect to a success page
        header("Location:../requestbook.php?message=Book recommendation submitted successfully!");
        exit();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location:..requestbook.php"); // Redirect back if not a POST request
    exit();
}





