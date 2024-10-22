<?php
session_start();
require_once "dbh.inc.php"; // Include your database connection file


// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}


// Check if reservation_id is provided
if (isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];


    // Start a transaction
    $pdo->beginTransaction();


    try {
        // Fetch the book_id, copy_id, and status of the reservation only if the status is 'active'
        $query = "
            SELECT book_id, copy_id
            FROM reservation
            WHERE reservation_id = ? AND status = 'active'
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$reservation_id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$reservation) {
            throw new Exception('Reservation not found or is not active.');
        }


        $book_id = $reservation['book_id'];
        $copy_id = $reservation['copy_id'];


        // Delete the reservation
        $delete_query = "
            DELETE FROM reservation
            WHERE reservation_id = ?
        ";
        $delete_stmt = $pdo->prepare($delete_query);
        $delete_stmt->execute([$reservation_id]);


        // Check for any pending reservations for the same book_id
        $pending_query = "
            SELECT user_id
            FROM reservation
            WHERE book_id = ? AND status = 'pending'
            ORDER BY date_reserved ASC
            LIMIT 1
        ";
        $pending_stmt = $pdo->prepare($pending_query);
        $pending_stmt->execute([$book_id]);
        $pending_reservation = $pending_stmt->fetch(PDO::FETCH_ASSOC);


        if ($pending_reservation) {
            // Update the first pending reservation to active and assign the current copy_id
            $update_pending_query = "
                UPDATE reservation
                SET status = 'active', date_notified = CURRENT_TIMESTAMP, copy_id = ?
                WHERE book_id = ? AND user_id = ? AND status = 'pending'
            ";
            $update_pending_stmt = $pdo->prepare($update_pending_query);
            $update_pending_stmt->execute([$copy_id, $book_id, $pending_reservation['user_id']]);
        } else {
            // No pending reservations: update the copy_id status to 'available'
            $update_copy_query = "
                UPDATE book_copy
                SET status = 'available'
                WHERE copy_id = ?
            ";
            $update_copy_stmt = $pdo->prepare($update_copy_query);
            $update_copy_stmt->execute([$copy_id]);


            // Increment the number of available copies in the book table
            $update_book_query = "
                UPDATE book
                SET no_of_available_copies = no_of_available_copies + 1
                WHERE book_id = ?
            ";
            $update_book_stmt = $pdo->prepare($update_book_query);
            $update_book_stmt->execute([$book_id]);
        }


        // Commit the transaction
        $pdo->commit();


        // Redirect back to the reservation page with a success message
        header("Location: ../viewreservation.php?cancel=success");
        exit();


    } catch (Exception $e) {
        // Roll back the transaction if something went wrong
        $pdo->rollBack();
        // Redirect with an error message
        header("Location: ../viewreservation.php?cancel=error&message=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirect with an error message if no reservation_id is provided
    header("Location: ../viewreservation.php?cancel=error");
    exit();
}
?>



