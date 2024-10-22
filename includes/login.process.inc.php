<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $password = $_POST["password"];

    try {
        require_once "dbh.inc.php";  // Include the database connection file

        // Prepare and execute the query to check user ID
        $query = "SELECT * FROM user_table WHERE user_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user exists
        if ($user) {
            // Verify the password (as plain text)
            if ($password == $user['pwd']) {  // Compare the input password with the stored password
                // Set session variables
                $_SESSION['user_id'] = $user['user_id']; // Store user ID in session
                $_SESSION['username'] = $user['name'];   // Assuming name is stored in user_table
                
                // Check the user's role
                if ($user['role'] == 'admin') {
                    header("Location: ../admin_dashboard.php");
                    exit();
                } else {
                    header("Location: ../user_dashboard.php");
                    exit();
                }
            } else {
                // Incorrect password
                header("Location: ../login.php?error=wrongpassword");
                exit();
            }
        } else {
            // No user found
            header("Location: ../login.php?error=nouser");
            exit();
        }

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../login.php");
    exit();
}
