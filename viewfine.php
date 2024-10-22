<?php
session_start();
require_once 'includes/dbh.inc.php'; // Include your database connection file


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get the user ID from session
    try {
        $query = "SELECT
                        bi.copy_id,
                        bi.due_date,
                        f.no_of_days_past_due_date,
                        f.amount
                    FROM
                        fine f
                    JOIN
                        book_issue bi ON f.issue_no = bi.issue_no
                    WHERE
                        f.user_id = ?;";  // The query with the placeholder
       
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id]); // Bind the user_id parameter


        // Fetch all fines
        $fines = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
        $pdo = null; // Close the connection
        $stmt = null; // Close the statement
   
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit(); // Make sure to exit after the header redirect
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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


        .sidebar ul li a:hover,
        .sidebar ul li a.selected {
            background-color: #4d5c4e;
        }


        .content {
            background: linear-gradient(to bottom, #4D9078, #ddd);
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: calc(100% - 250px);
            padding: 50px;
            margin-left: 280px;
            margin-top: 60px;
        }


        header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 5px;
            width: 100%;
            padding-right: 40px;
        }


        header h2 {
            margin-bottom: 20px;
            color: #34495e;
            text-align: center;
        }


        .profile {
            position: absolute;
            top: 20px;
            right: 20px;
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


        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }


        .search-container input {
            width: 50%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }


        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }


        th {
            background-color: #444;
            color: white;
        }


        td {
            background-color: #f9f9f9;
        }


        .settle-button {
            padding: 7px 15px;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }


        .settle-button:hover {
            background-color: #218838;
        }


        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }


            .sidebar {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>User</h2>
            <ul>
                 <li><a href="user_dashboard.php">Search Book</a></li>
                <li><a href="viewuserprofile.php">View/Update Profile</a></li>
                <li><a href="rentedbooks.php">View Rented Books</a></li>
                <li><a href="requestbook.php">Request Book</a></li>
                <li><a href="viewfine.php"class="selected">View Fine Details</a></li>
                <li><a href="viewreservations.php">View Reservation Details</a></li>
                <li><a href="changepassword.php">Change Password</a></li>
            </ul>
        </div>
        <div class="content">
            <header>
                <h2>View Fines</h2>
                <div class="profile">
                    <a href="notification.php">Notifications</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>
            <div class="main-content">
                <table id="fine-table">
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>Copy ID</th>
                            <th>Due Date</th>
                            <th>Days Past Due</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fines as $index => $fine): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($fine['copy_id']); ?></td>
                                <td><?php echo htmlspecialchars($fine['due_date']); ?></td>
                                <td><?php echo htmlspecialchars($fine['no_of_days_past_due_date']); ?></td>
                                <td><?php echo htmlspecialchars($fine['amount']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>









