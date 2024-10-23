<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    try {
        require_once "dbh.inc.php";

        // Begin transaction
        $pdo->beginTransaction();

        // SQL query to delete user from user_details
        $deleteDetailsQuery = "DELETE FROM user_details WHERE user_id = :user_id";
        $stmt = $pdo->prepare($deleteDetailsQuery);
        $stmt->execute(['user_id' => $user_id]);

        // SQL query to delete user from user_table
        $deleteTableQuery = "DELETE FROM user_table WHERE user_id = :user_id";
        $stmt = $pdo->prepare($deleteTableQuery);
        $stmt->execute(['user_id' => $user_id]);

        // Commit transaction
        $pdo->commit();

        // Redirect back to Manage Users page with success message
        header("Location: ../manageuser.php?message=User deleted successfully");
        //header("Location: ../issuebook.php?message=Book issued successfully!");
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
?>
