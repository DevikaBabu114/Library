<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require_once "dbh.inc.php"; // Ensure the database connection file exists

        // Retrieve data from the form
        $book_id = $_POST['book_id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $publisher = $_POST['publisher'];
        $price = $_POST['price'];
        $copies = $_POST['copies'];
        $available_copies = $_POST['available_copies'];
        $rack_no = $_POST['rack_no'];
        $category = $_POST['category'];

        // SQL query to update the book details
        $query = "UPDATE book SET name = ?, author = ?, publisher = ?, price = ?, no_of_copies = ?, no_of_available_copies = ?, rack_no = ?, category = ? WHERE book_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $author, $publisher, $price, $copies, $available_copies, $rack_no, $category, $book_id]);

        // Check if the update affected any rows
        if ($stmt->rowCount() > 0) {
            // Redirect with success message
            header("Location: ../managebookdetails.php?book_id={$book_id}&status=success");
        } else {
            // Redirect with no changes message
            header("Location: ../managebookdetails.php?book_id={$book_id}&status=no_change");
        }

        // Clean up
        $stmt = null; // Close statement
        $pdo = null; // Close connection
        exit(); 

    } catch(PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
