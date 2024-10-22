<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['book_id'])) {
        $book_id = $_POST['book_id'];

        try {
            require_once "dbh.inc.php"; // Ensure the path to your DB connection is correct

            // SQL query to delete the book
            $query = "DELETE FROM book WHERE book_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$book_id]);

           // Redirect back to manage fine page with a success message
            header("Location: ../managebook.php?status=success");
            exit();

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    } else {
        // If user_id or fine_id is not set, redirect to manage fine page
        header("Location: ../managebook.php?status=error");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}