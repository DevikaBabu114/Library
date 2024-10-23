<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $copy_id = $_POST["copyid"];

    try {
        require_once "dbh.inc.php"; // Include the database connection file

        // Check if the copy ID exists in the book_issue table
        $query = "SELECT issue_no, copy_id FROM book_issue WHERE copy_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$copy_id]);
        $issue = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($issue) {
            $issue_no = $issue['issue_no'];

            // Check if there is a pending fine for this issue_no in the fines table
            $query = "SELECT * FROM fine WHERE issue_no = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$issue_no]);
            $fine = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($fine) {
                // Fine found, notify the user to pay the fine
                header("Location: ../returnbook.php?error=Please pay the fine before returning the book.");
                exit();
            } else {
                // Before deleting, find the book_id associated with the copy_id
                $query = "SELECT book_id FROM book_copy WHERE copy_id = ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$copy_id]);
                $book = $stmt->fetch(PDO::FETCH_ASSOC);
                $book_id = $book['book_id'];

                // Check if there are pending reservations for this book_id
                $query = "SELECT user_id FROM reservation WHERE book_id = ? AND status = 'pending' ORDER BY date_reserved ASC LIMIT 1;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$book_id]);
                $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($reservation) {
                    // If there is a pending reservation, update the reservation and notify the user
                    $user_id = $reservation['user_id'];

                    // Update the reservation status to 'active' and set the notification date
                    $query = "UPDATE reservation SET status = 'active', date_notified = CURRENT_TIMESTAMP, copy_id = ? WHERE user_id = ? AND status = 'pending';";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$copy_id, $user_id]);

                    // Update the book_copy status to 'reserved'
                    $query = "UPDATE book_copy SET status = 'reserved' WHERE copy_id = ?;";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$copy_id]);

                } else {
                    // If no reservations, set the copy_id status to 'available'
                    $query = "UPDATE book_copy SET status = 'available' WHERE copy_id = ?;";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$copy_id]);

                    // Increment the available copies in the book table
                    $query = "UPDATE book SET no_of_available_copies = no_of_available_copies + 1 WHERE book_id = ?;";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$book_id]);
                }

                // Proceed to delete the book issue record
                $query = "DELETE FROM book_issue WHERE copy_id = ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$copy_id]);

                // Redirect to the return book page with success message
                header("Location: ../returnbook.php?message=Book returned successfully!");
                exit();
            }
        } else {
            // No issue record found for the copy ID
            header("Location: ../returnbook.php?error=No such book issue found for the provided Copy ID.");
            exit();
        }
    } catch (PDOException $e) {
        // Handle the database error
        header("Location: ../returnbook.php?error=Database error: " . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirect back if the request method is not POST
    header("Location: ../returnbook.php");
    exit();
}
