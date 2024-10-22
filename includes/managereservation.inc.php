<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if reservation_id, user_id, and copy_id are set
    if (isset($_POST['reservation_id']) && isset($_POST['user_id']) && isset($_POST['copy_id'])) {
        $reservation_id = $_POST['reservation_id'];
        $user_id = $_POST['user_id'];
        $copy_id = $_POST['copy_id'];


        try {
            // Include the database connection file
            require_once 'dbh.inc.php';


            // Start a transaction
            $pdo->beginTransaction();


            // 1. Update the reservation status to 'completed'
            $updateReservationQuery = "UPDATE reservation SET status = 'completed' WHERE reservation_id = ?";
            $stmt = $pdo->prepare($updateReservationQuery);
            $stmt->execute([$reservation_id]);


            // 2. Change the book_copy status to 'issued'
            $updateBookCopyQuery = "UPDATE book_copy SET status = 'issued' WHERE copy_id = ?";
            $stmt = $pdo->prepare($updateBookCopyQuery);
            $stmt->execute([$copy_id]);


            // 3. Insert a row into the book_issue table
            $due_date = date('Y-m-d', strtotime("+15 days")); // Example due date 14 days from the issue date
            $insertIssueQuery = "INSERT INTO book_issue (copy_id, user_id, due_date) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($insertIssueQuery);
            $stmt->execute([$copy_id, $user_id, $due_date]);


            // Commit the transaction
            $pdo->commit();


            // Redirect to manage reservation page with a success message
            header("Location: ../managereservation.php?status=success");
            exit();
        } catch (PDOException $e) {
            // Rollback the transaction if there's an error
            $pdo->rollBack();
            die("Database error: " . $e->getMessage());
        }
    } else {
        // If reservation_id, user_id, or copy_id is not set, redirect to manage reservation page with an error message
        header("Location: ../managereservation.php?status=error");
        exit();
    }
} else {
    // If the request method is not POST, redirect to the home page
    header("Location: ../index.php");
    exit();
}
?>



