<?php
session_start();
require_once 'dbh.inc.php'; // Adjust path if necessary

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $current_password = $_POST['current-password'];
        $new_password = $_POST['new-password'];

        // Check if new password and confirm password match
        if ($_POST['new-password'] !== $_POST['confirm-password']) {
            $_SESSION['error'] = "New Password and Confirm Password do not match!";
            header("Location: ../changepassword.php");
            exit();
        }

        try {
            // Fetch the current password from the database
            $query = "SELECT pwd FROM user_table WHERE user_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Check if the current password is correct
                if ($current_password === $result['pwd']) {
                    // Update the password
                    $update_query = "UPDATE user_table SET pwd = ? WHERE user_id = ?";
                    $update_stmt = $pdo->prepare($update_query);
                    $update_stmt->execute([$new_password, $user_id]);

                    $_SESSION['success'] = "Password set successfully.";
                } else {
                    $_SESSION['error'] = "Current password is incorrect.";
                }
            } else {
                $_SESSION['error'] = "User not found.";
            }

            $pdo = null;
            $stmt = null;
            $update_stmt = null;

            header("Location: ../changepassword.php");
            exit();

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
