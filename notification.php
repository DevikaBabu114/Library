<!--<?php
session_start();
require_once "includes/dbh.inc.php"; // Include your database connection file


// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}


$user_id = $_SESSION['user_id'];
// Fetch fines for the logged-in user with the associated book and copy details
$fine_query = "
    SELECT f.no_of_days_past_due_date, f.due_date, f.amount,
           bc.copy_id, b.name AS book_name
    FROM fine f
    JOIN book_issue bi ON f.issue_no = bi.issue_no
    JOIN book_copy bc ON bi.copy_id = bc.copy_id
    JOIN book b ON bc.book_id = b.book_id
    WHERE f.user_id = ?
";
$fine_stmt = $pdo->prepare($fine_query);
$fine_stmt->execute([$user_id]);
$fines = $fine_stmt->fetchAll(PDO::FETCH_ASSOC);
// Fetch active reservations for the logged-in user
$reservation_query = "
    SELECT r.reservation_id, r.book_id, r.copy_id, r.date_reserved, r.date_notifed, r.status, b.name AS book_name
    FROM reservation r
    JOIN book b ON r.book_id = b.book_id
    WHERE r.user_id = ? AND r.status = 'active'
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
    <title>User Dashboard - Fines and Reservations</title>
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
    height: 100vh;
}

/* Sidebar Styling */
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







/* Main Content */
.content {
    flex: 1;
    padding: 20px;
    margin-left: 300px;
}


header {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 20px;
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



/* Fine and Reservation List */
.main-content {
    display: flex;
    gap: 30px;
    /*min-width: 500px;
    min-height: 400px;
    background: linear-gradient(to bottom, #4D9078, #ddd);
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            text-align: center;*/
}
.box {
            min-width: 450px; /* Increased minimum width */
            padding: 30px; /* Increased padding */
           
            background: linear-gradient(to bottom, #4D9078, #ddd);
            
            border-radius: 8px;
            border: 1px solid #ccc;
            text-align: center;
            flex: 1;
        }


h2 {
    font-size: 24px;
    margin-bottom: 20px;
}


.fine-list, .reservation-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}


.fine-item, .reservation-item {
    background-color: #fafafa;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}


.fine-item p, .reservation-item p {
    margin: 10px 0;
    font-size: 16px;
}


.fine-item p:first-child, .reservation-item p:first-child {
    font-weight: bold;
    font-size: 18px;
}
.cancel-button {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .cancel-button:hover {
            background-color: darkred; /* Darker red on hover */
        }


/* Responsive Design */
@media (max-width: 768px) {
    .fine-list, .reservation-list {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }


    .sidebar {
        width: 200px;
    }


    .sidebar ul li {
        margin: 15px 0;
    }


    .sidebar ul li a {
        font-size: 16px;
    }
}


@media (max-width: 480px) {
    .fine-list, .reservation-list {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }


    .sidebar {
        width: 150px;
    }


    .sidebar ul li a {
        font-size: 14px;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar section -->
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


        <!-- Main content -->
        <div class="content">
            <header>
                <div class="profile">
                    <a href="index.php">Logout</a>
                </div>
            </header>


            <!-- Fines Section -->
            <div class="main-content">
                <!-- Fines Section -->
                <div class="box">
                    <h2>Your Fines</h2>
                    <div class="fine-list">  
                    <?php if (count($fines) > 0): ?>
                        <?php foreach ($fines as $fine): ?>
                            <div class="fine-item">
                                <h3>Book: <?= htmlspecialchars($fine['book_name']) ?></h3>
                                <p>Copy Number: <?= htmlspecialchars($fine['copy_id']) ?></p>
                                <p>Due Date: <?= htmlspecialchars($fine['due_date']) ?></p>
                                <p>Days Past Due Date: <?= htmlspecialchars($fine['no_of_days_past_due_date']) ?> days</p>
                                <p>Fine Amount: $<?= htmlspecialchars($fine['amount']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No fines found.</p>
                    <?php endif; ?>
                    
                </div>
            </div>


            <!-- Reservation Section -->
            <div class="box">
                <h2>Your Book Reservations</h2>
                <div class="reservation-list">
    <?php if (count($reservations) > 0): ?>
        <?php foreach ($reservations as $reservation): ?>
            <div class="reservation-item">
                <h3>Book Name: <?= htmlspecialchars($reservation['book_name']) ?></h3>
                <p>Reserved Date: <?= htmlspecialchars($reservation['date_reserved']) ?></p>
                <?php if ($reservation['status'] === 'active'): ?>
                    <form method="POST" action="includes/u-cancelreservation.inc.php">
                        <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                        <button type="submit" class="cancel-button">Cancel Reservation</button>
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
</div>
</body>
</html>