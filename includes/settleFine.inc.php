<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user_id and fine_id are set
    if (isset($_POST['user_id']) && isset($_POST['fine_id'])) {
        $user_id = $_POST['user_id'];
        $fine_id = $_POST['fine_id'];

        try {
            // Ensure the path is correct
            require_once "dbh.inc.php"; 

            // SQL query to delete the fine entry from the fine table
            $query = "DELETE FROM fine WHERE fine_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$fine_id]);

            // Redirect back to manage fine page with a success message
            header("Location: ../managefine.php?status=success");
            exit();

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    } else {
        // If user_id or fine_id is not set, redirect to manage fine page
        header("Location: ../managefine.php?status=error");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
