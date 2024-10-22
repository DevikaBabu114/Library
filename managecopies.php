<!--
<?php
session_start(); // Start the session


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        require_once "includes/dbh.inc.php"; // Ensure the database connection file exists


        if (isset($_GET['book_id'])) {
            $bookId = $_GET['book_id'];


            // SQL query to fetch copy IDs for the specific book
            $query = "SELECT copy_id FROM book_copy WHERE book_id = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$bookId]);


            // Fetch all copy IDs
            $copyIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $stmt = null; // Close statement


            // Check if no copy IDs found (Optional: handle this case if needed)
            if (empty($copyIds)) {
                $copyIds = [];
            }
        } else {
            header("Location: ../index.php"); // Redirect if book_id is not set
            exit();
        }


    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require_once "includes/dbh.inc.php"; // Ensure the database connection file exists


        if (isset($_POST['delete_copyid'])) {
            // Delete Copy ID
            $copyIdToDelete = $_POST['delete_copyid'];
            $bookId = $_POST['bookid'];

            // Delete the copy ID
            $deleteSql = "DELETE FROM book_copy WHERE copy_id = ?;";
            $deleteStmt = $pdo->prepare($deleteSql);
            $deleteStmt->execute([$copyIdToDelete]);

            // Update the book's copy counts
            $updateSql = "
                UPDATE book 
                SET no_of_copies = no_of_copies - 1, 
                    no_of_available_copies = GREATEST(no_of_available_copies - 1, 0)
                WHERE book_id = ?;
            ";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([$bookId]);

            // Set a success message
            $_SESSION['message'] = "Copy ID $copyIdToDelete has been deleted.";
        }

        if (isset($_POST['new_copyid'])) {
            // Add New Copy ID
            $newCopyId = $_POST['new_copyid'];
            $bookId = $_POST['bookid'];

            // Insert the new copy ID
            $insertSql = "INSERT INTO book_copy (copy_id, book_id) VALUES (?, ?);";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->execute([$newCopyId, $bookId]);

            // Update the book's copy counts
            $updateSql = "
                UPDATE book 
                SET no_of_copies = no_of_copies + 1, 
                    no_of_available_copies = no_of_available_copies + 1
                WHERE book_id = ?;
            ";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([$bookId]);

            // Set a success message
            $_SESSION['message'] = "Copy ID $newCopyId has been added.";
        }

        // Refresh the page to show updated copy IDs
        header("Location: " . $_SERVER['PHP_SELF'] . "?book_id=" . $_POST['bookid']);
        exit();


    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>

-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Copy IDs</title>
    <style>
           * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: serif;
        }


        body {
            background-image: url("https://as1.ftcdn.net/v2/jpg/07/96/87/98/1000_F_796879852_mjHIV6gAsK4yXL2EiEcfkeAlhjIoWN9Z.jpg");
            display: flex;
            height: 90%;
        }


        .container {
            display: flex;
            width: 100%;
        }


        /* Sidebar Styling */
.sidebar {
    width: 250px;
    background-color: #2c2c2c;
    padding: 20px;
    color: white;
    display: flex;
    flex-direction: column;
    height: 100vh; /* Sidebar takes full viewport height */
    overflow-y: auto; /* Enable scrolling for overflow */
    position: fixed; /* Keep the sidebar fixed on the left */
}


.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
    color: white; /* Makes the text color of Librarian white */
}


.sidebar ul {
    list-style-type: none;
    padding: 0;
}


.sidebar ul li {
    margin: 20px 0;
}


.sidebar ul li a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 10px;
    text-align: center;

}


.sidebar ul li a:hover {
    background-color: #4d5c4e;
}

/* Content Section Styling */
.content {
    width: calc(100% - 250px); /* Adjust width to leave space for the sidebar */
    padding: 50px;
    margin-left: 250px; /* Offset the content to the right */
}


header {
    display: flex;
    justify-content: flex-end;
    align-items: center; /* Vertically centers the content */
    margin-bottom: 0px; /* Reduce margin to move Profile and Logout slightly up */
    padding-right: 50px; /* Add some right padding to position the links better */
    width: 100%; 
}

.profile {
               position: absolute;
               top: 20px;
               right:20px;
               display: flex;
               gap: 15px;
        }

        .profile a {
           background-color: rgba(255, 255, 255, 0.8);
            padding: 5px 10px;
            border-radius: 4px;
            color: #0b0b0b;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
        }


.main-content {

background: linear-gradient(to bottom,#4D9078,#ddd);
padding: 20px;
border-radius: 8px;
border: 1px solid #ccc;
}


h2 {
margin-bottom: 20px;
color: #34495e;
text-align: center;
}



        .form-group {
            margin-bottom: 15px;
            background-color: white;
            padding: 10px;
            border-radius: 10px;
        }


        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }


        .form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #090707;
    border-radius: 4px;
    font-size: 16px;
}



        .delete-button {
            padding: 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
            margin-top: 10px;
        }


        .delete-button:hover {
            background-color: #c0392b;
        }


        .add-button {
            padding: 10px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }


        .add-button:hover {
            background-color: #2ecc71;
        }
        .sidebar ul li a:hover,
        .sidebar ul li a.selected {
            background-color: #4d5c4e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Librarian</h2>
            <ul>
               <li><a href="addbook.php" >Add Book</a></li>
                <li><a href="managebook.php">Manage Books</a></li>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="manageuser.php">Manage Users</a></li>
                <li><a href="managefine.php">Manage Fine</a></li>
                <li><a href="admin_dashboard.php" class="selected">Issue Book</a></li>
                <li><a href="returnbook.php">Return Book</a></li>
                <li><a href="bookrequest.php">View Book Request</a></li>
                <li><a href="managereservation.php">View/Manage Reservation</a></li>
            </ul>
        </div>


        <div class="content">
            <header>
                <div class="profile">
                    <a href="viewadminprofile.php">Profile</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>


            <div class="main-content">
                <h2>Update Copy IDs for Book ID: <?php echo htmlspecialchars($bookId); ?></h2>
               <!--
                <?php
                // Display the session message if it exists
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert">' . htmlspecialchars($_SESSION['message']) . '</div>';
                    unset($_SESSION['message']); // Clear the message after displaying it
                }
                ?>
                -->
               
                <form action="" method="POST">
                    <input type="hidden" name="bookid" value="<?php echo htmlspecialchars($bookId); ?>">
                   
                    <?php foreach ($copyIds as $index => $copyId): ?>
                        <div class="form-group">
                            <label for="copyid<?php echo $index; ?>">Copy ID <?php echo $index + 1; ?></label>
                            <input type="text" id="copyid<?php echo $index; ?>" name="copyid[]" value="<?php echo htmlspecialchars($copyId); ?>" required>
                            <button type="submit" class="delete-button" name="delete_copyid" value="<?php echo $copyId; ?>">Delete</button>
                        </div>
                    <?php endforeach; ?>
                </form>
               
                <h3>Add New Copy ID</h3>
                <form action="" method="POST">
                    <input type="hidden" name="bookid" value="<?php echo htmlspecialchars($bookId); ?>">
                    <div class="form-group">
                        <label for="new_copyid">New Copy ID</label>
                        <input type="text" id="new_copyid" name="new_copyid" placeholder="Enter New Copy ID" required>
                    </div>
                    <button type="submit" class="add-button">Add Copy ID</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>