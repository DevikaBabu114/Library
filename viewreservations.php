<!--
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




// Fetch the reservations for the logged-in user
$reservation_query = "
    SELECT r.reservation_id, b.name AS book_name, r.date_reserved, r.status
    FROM reservation r
    JOIN book b ON b.book_id = r.book_id
    WHERE r.user_id = ? AND r.status IN ('active', 'pending')
";
$reservation_stmt = $pdo->prepare($reservation_query);
$reservation_stmt->execute([$user_id]);
$reservations = $reservation_stmt->fetchAll(PDO::FETCH_ASSOC);




?>


-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>


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
    height: 100vh;
}








.container {
    display: flex;
    width: 90%;
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
    padding-right: 20px;
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
    margin-top: 40px;
    background: linear-gradient(to bottom, #4D9078, #ddd);
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ccc;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    min-height: 300px;
}








h2 {
    margin-bottom: 20px;
    color: #34495e;
    text-align: center;
}








/* Grid for reserved books */
.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 columns */
    gap: 20px;
    margin-top: 20px;
}








.grid-item {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: left;  /* Align text to the left */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}








.grid-item h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #2c3e50;
}








.grid-item p {
    font-size: 14px;
    color: #555;
}








.grid-item .status {
    font-weight: bold;
    color: #e74c3c;
    margin-top: 15px;
    font-size: 14px;
    text-align: right;  /* Align status to the right */
}



.sidebar ul li a:hover,
        .sidebar ul li a.selected {
            background-color: #4d5c4e;
        }




.grid-item .date {
    font-size: 13px;
    color: #7f8c8d;
    margin-bottom: 10px;
}


    </style>
   
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <div class="sidebar">
            <h2>User</h2>
            <ul>
                <li><a href="user_dashboard.php">Search Book</a></li>
                <li><a href="viewuserprofile.php">View/Update Profile</a></li>
                <li><a href="rentedbooks.php">View Rented Books</a></li>
                <li><a href="requestbook.php">Request Book</a></li>
                <li><a href="viewfine.php">View Fine Details</a></li>
                <li><a href="viewreservations.php">View Reservation Details</a></li>
                <li><a href="changepassword.php">Change Password</a></li>
            </ul>
        </div>




        <!-- Main Content Section -->
        <div class="content">
            <header>
                <div class="profile">
                    <a href="notification.php">Notifications</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>
            <div class="main-content">
                <h2>Your Book Reservations</h2>
                <div class="grid-container">
                <?php if (count($reservations) > 0): ?>
    <?php foreach ($reservations as $reservation): ?>
        <div class="reservation-item">
            <h3>Book Name: <?= htmlspecialchars($reservation['book_name']) ?></h3>
            <p>Reserved Date: <?= htmlspecialchars($reservation['date_reserved']) ?></p>
            <!-- Show cancel button only for active reservations -->
            <?php if (isset($reservation['status']) && $reservation['status'] === 'active'): ?>
                <form action="includes/u-cancelreservation.inc.php" method="POST">
                    <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                    <button type="submit" class="cancel-btn">Cancel Reservation</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No reservations found.</p>
<?php endif; ?>




                </div>
            </div>
        </div>
    </div>
</body>
</html>









