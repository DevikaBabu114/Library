<?php
session_start();
require_once "dbh.inc.php"; // Include your database connection file


// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}


// Get the logged-in user's ID and the book issue number from the POST request
$user_id = $_SESSION['user_id'];
$issue_no = $_POST['book_id'] ?? null;


// Check if the issue_no is valid
if (!$issue_no) {
    header("Location: ../rentedbooks.php?error=invalid_request");
    exit();
}


// Fetch the current details of the issued book to check renewal status
$query = "SELECT remaining_renewal, due_date FROM book_issue WHERE issue_no = ? AND user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$issue_no, $user_id]);
$book_issue = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$book_issue) {
    // If no valid issue record is found
    header("Location: ../rentedbooks.php?error=book_not_found");
    exit();
}


// Check if the book has remaining renewals
if ($book_issue['remaining_renewal'] <= 0) {
    header("Location: ../rentedbooks.php?error=no_renewals_left");
    exit();
}


// Check if there is a pending fine for this issue_no
$query = "SELECT * FROM fine WHERE issue_no = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$issue_no]);
$fine = $stmt->fetch(PDO::FETCH_ASSOC);


if ($fine) {
    // If a fine exists, notify the user to pay the fine before renewing
    header("Location: ../rentedbooks.php?error=pay_fine_first");
    exit();
}


// Calculate the new due date (e.g., adding 14 days to the current due date)
$new_due_date = date('Y-m-d', strtotime($book_issue['due_date'] . ' +14 days'));


// Update the book_issue table with the new due date and decrement remaining renewals
$updateQuery = "UPDATE book_issue
                SET due_date = ?, remaining_renewal = remaining_renewal - 1
                WHERE issue_no = ? AND user_id = ?";
$stmt = $pdo->prepare($updateQuery);
$stmt->execute([$new_due_date, $issue_no, $user_id]);


// Check if the update was successful
if ($stmt->rowCount() > 0) {
    header("Location: ../rentedbooks.php?success=book_renewed");
} else {
    header("Location: ../rentedbooks.php?error=renewal_failed");
}
exit();
?>



