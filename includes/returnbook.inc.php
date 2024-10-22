<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $copy_id = $_POST["copyid"];


    try {
        require_once "dbh.inc.php"; // Include the database connection file


        // Check if the copy ID exists in the book_issue table
        $query = "SELECT * FROM book_issue WHERE copy_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$copy_id]);
        $issue = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($issue) {
            // Delete the corresponding row in book_issue table
            $query = "DELETE FROM book_issue WHERE copy_id = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$copy_id]);


            // Redirect to a success page
            header("Location:../returnbook.php?message=Book returned successfully!");
            exit();
        } else {
            // No issue record found for the copy ID
            header("Location:../returnbook.php?error=norecord");
            exit();
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: return_book.php");
    exit();
}





