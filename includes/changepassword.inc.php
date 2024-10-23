<?php
session_start(); // Ensure the session is started
require_once 'dbh.inc.php'; // Adjust path if necessary

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $current_password = $_POST['current-password'];
        $new_password = $_POST['new-password'];
        $confirm_password = $_POST['confirm-password'];

        // Check if new password and confirm password match
        if ($new_password !== $confirm_password) {
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
                    // Check if the new password is different from the current one
                    if ($new_password === $current_password) {
                        $_SESSION['error'] = "New password cannot be the same as the current password!";
                    } else {
                        // Update the password in the database
                        $update_query = "UPDATE user_table SET pwd = ? WHERE user_id = ?";
                        $update_stmt = $pdo->prepare($update_query);
                        $update_stmt->execute([$new_password, $user_id]);

                        $_SESSION['success'] = "Password set successfully.";
                    }
                } else {
                    $_SESSION['error'] = "Current password is incorrect.";
                }
            } else {
                $_SESSION['error'] = "User not found.";
            }

            // Close the connections
            $pdo = null;
            $stmt = null;
            $update_stmt = null;

            // Redirect back to the changepassword.php page
            header("Location: ../changepassword.php");
            exit();

        } catch (PDOException $e) {
            $_SESSION['error'] = "An error occurred: " . $e->getMessage();
            header("Location: ../changepassword.php");
            exit();
        }
    }
} else {
    $_SESSION['error'] = "Please log in first.";
    header("Location: ../index.php");
    exit();
}
