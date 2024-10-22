<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the book ID
    $bookid = $_POST['bookid'];
    
    // Initialize an array to hold the copy IDs
    $copyIds = [];
    
    // Dynamically retrieve all copy IDs from the form
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'copyid') === 0) {
            $copyIds[] = $value;
        }
    }

    try {
        // Include the database connection
        require_once "dbh.inc.php";

        // Begin a transaction
        $pdo->beginTransaction();

        // Insert each copy ID into the `book_copy` table
        foreach ($copyIds as $copyid) {
            $query = "INSERT INTO book_copy (copy_id, book_id, status) VALUES (?, ?, 'available')";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$copyid, $bookid]);
        }

        // Commit the transaction
        $pdo->commit();

        // Close the database connection
        $pdo = null;
        $stmt = null;

        // Redirect to the index page or a success page
        header("Location: ../managebook.php?status=success");
        exit();

    } catch (PDOException $e) {
        // Roll back the transaction if an error occurs
        $pdo->rollBack();
        die("Database error: " . $e->getMessage());
    }
} else {
    // If the request method is not POST, redirect to the index page
    header("Location: ../index.php");
    exit();
}
?>
