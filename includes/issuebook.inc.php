<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $copy_id = $_POST["copyid"];
    $user_id = $_POST["userid"];


    try {
        require_once "dbh.inc.php"; // Include the database connection file


        // Check if the copy ID is available
        $query = "SELECT * FROM book_copy WHERE copy_id = ? AND status = 'available';";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$copy_id]);
        $copy = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($copy) {
            // Check if the user exists
            $query = "SELECT * FROM user_table WHERE user_id = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($user) {
                // Calculate due date (15 days from today)
                $issue_date = date('Y-m-d');
                $due_date = date('Y-m-d', strtotime('+15 days'));


                // Insert the book issue record
                $query = "INSERT INTO book_issue (copy_id, user_id, issue_date, due_date) VALUES (?, ?, ?, ?);";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$copy_id, $user_id, $issue_date, $due_date]);


                // Update the status of the copy to 'issued'
                $query = "UPDATE book_copy SET status = 'issued' WHERE copy_id = ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$copy_id]);


                // Decrement the number of available copies in the book table
                $query = "UPDATE book SET no_of_available_copies = no_of_available_copies - 1 WHERE book_id = (SELECT book_id FROM book_copy WHERE copy_id = ?);";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$copy_id]);


                // Redirect to a success page with a message
                header("Location: ../admin_dashboard.php?message=Book issued successfully!");
                exit();
            } else {
                // User does not exist
                header("Location: ../admin_dashboard.php?error=nouser");
                exit();
            }
        } else {
            // Copy ID not available
            header("Location: ../admin_dashboard.php?error=copyunavailable");
            exit();
        }
    } catch (PDOException $e) {
        // Handle any errors from the database
        die("Query failed: " . $e->getMessage());
    }
} else {
    // If not a POST request, redirect back to the issuebook page
    header("Location: ../admin_dashboard.php");
    exit();
}



