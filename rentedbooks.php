<?php
session_start();
require_once "includes/dbh.inc.php"; // Include your database connection file


// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}


// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user_details WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$user) {
    die("User not found."); // Handle the case where the user is not found
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rented Books</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family:serif;
}








body {
    display: flex;
    height: 100vh;
    background-image: url("https://as1.ftcdn.net/v2/jpg/07/96/87/98/1000_F_796879852_mjHIV6gAsK4yXL2EiEcfkeAlhjIoWN9Z.jpg");


}








.container {
    display: flex;
    width: 100%;
}








/* Sidebar styling */




.sidebar {
            width: 250px;
            background-color: #2c2c2c;
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            position: fixed;
        }








        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }








        .sidebar ul {
            list-style: none;
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


















/* Main content styling */
.content {
    width: calc(100% - 250px);
    padding: 20px;
    margin-left: 250px;
}








header {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 10px;
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
    background: linear-gradient(to bottom, #4D9078, #ddd);

    
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin-top: 40px;
}








h2 {
    margin-bottom: 20px;
    color: #34495e;
}








.search-section {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}








#search-bar, #category-bar {
    padding: 10px;
    width: 300px;
    border-radius: 5px;
    border: 1px solid #ccc;
}








#search-btn {
    padding: 10px 20px;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}








#search-btn:hover {
    background-color: #3498db;
}








/* Grid for book results */
.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 columns in a row */
    gap: 20px;
}








.grid-item {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}








.grid-item h3, .grid-item p {
    margin-bottom: 10px;
}








.reserve-btn, .request-btn {
    padding: 10px;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}








.reserve-btn:hover, .request-btn:hover {
    background-color: #3498db;
}








.button-container {
    display: flex;
    justify-content: center;
    gap: 10px; /* Space between the buttons */
    margin-top: 10px;
}
















.sidebar ul li a:hover,
        .sidebar ul li a.selected {
            background-color: #4d5c4e;
        }







    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>User</h2>
            <ul>
        <li><a href="user_dashboard.php">Search Book</a></li>
                <li><a href="viewuserprofile.php">View/Update Profile</a></li>
                <li><a href="rentedbooks.php"class="selected">View Rented Books</a></li>
                <li><a href="requestbook.php">Request Book</a></li>
                <li><a href="viewfine.php">View Fine Details</a></li>
                <li><a href="viewreservations.php">View Reservation Details</a></li>
                <li><a href="changepassword.php">Change Password</a></li>
            </ul>
        </div>


        <!-- Main content -->
        <div class="content">
            <header>
                <div class="profile">
                    <a href="notification.php">Notifications</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>


            <div class="main-content">
                <h2>Your Rented Books</h2>
                <div class="grid-container">
                    <?php
                    // SQL query to fetch rented books for the logged-in user
                    $query = "SELECT bi.issue_no, bo.name, bi.issue_date, bi.due_date, bi.remaining_renewal
                              FROM book_issue bi
                              JOIN book_copy bc
                              join book bo
                              ON bi.copy_id = bc.copy_id and bo.book_id=bc.book_id
                              WHERE bi.user_id = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$user_id]);
                    $rentedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    // Check if any books are rented
                    if ($rentedBooks) {
                        // Output data of each rented book
                        foreach ($rentedBooks as $row) {
                            echo "<div class='grid-item'>";
                            echo "<p>Book Name: " . htmlspecialchars($row['name']) . "</p>";
                            echo "<p>Issue Date: " . htmlspecialchars($row['issue_date']) . "</p>";
                            echo "<p>Due Date: " . htmlspecialchars($row['due_date']) . "</p>";
                            echo "<p>No. of Renewals Remaining: " . htmlspecialchars($row['remaining_renewal']) . "</p>";
                           
                            // Renew button with form
                            echo "<form action='includes/u-renew.inc.php' method='POST' style='display:inline;'>";
                            echo "<input type='hidden' name='book_id' value='" . htmlspecialchars($row['issue_no']) . "' />";
                            echo "<button type='submit'class='reserve-btn'>Renew</button>";
                            echo "</form>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No rented books found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



