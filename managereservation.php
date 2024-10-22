<!--<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        require_once "includes/dbh.inc.php"; // Ensure correct path


        // Query to fetch reservation details, joining with the book and user tables for more information
        $query = "SELECT r.reservation_id, r.user_id, r.copy_id, b.name AS book_name, u.name AS user_name
                  FROM reservation r
                  JOIN book_copy bc ON r.copy_id = bc.copy_id
                  JOIN book b ON bc.book_id = b.book_id
                  JOIN user_details u ON r.user_id = u.user_id
                  WHERE r.status = 'active';";  // Assuming reservations have a 'status' column


        $stmt = $pdo->prepare($query);
        $stmt->execute();


        // Fetch all reservations
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Close connections
        $pdo = null;
        $stmt = null;


    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
?>-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations - Admin</title>
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

        .grant-button {
            background-color: #28a745;
            color: white;
            padding: 7px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }


        .grant-button:hover {
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
        .sidebar ul li a:hover,
        .sidebar ul li a.selected {
            background-color: #4d5c4e;
        }
    </style>
    <script>
        // JavaScript for real-time search by User ID or Username
        function searchUsers() {
            const input = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('#user-table tbody tr');


            rows.forEach(row => {
                const userId = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const username = row.querySelector('td:nth-child(3)').textContent.toLowerCase();


                if (userId.includes(input) || username.includes(input)) {
                    row.style.display = '';  // Show row if match found
                } else {
                    row.style.display = 'none';  // Hide row if no match
                }
            });
        }
    </script>
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
                <li><a href="admin_dashboard.php" >Issue Book</a></li>
                <li><a href="returnbook.php">Return Book</a></li>
                <li><a href="bookrequest.php">View Book Request</a></li>
                <li><a href="managereservation.php"class="selected">View/Manage Reservation</a></li>
            </ul>
        </div>


        <div class="content">
            <header>
                <h2>Manage Reservations</h2>
                <div class="profile">
                    <a href="viewadminprofile.php">Profile</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>
            <!-- Search Bar -->
            <div class="search-container">
                <input
                    type="text"
                    id="search-input"
                    class="search-input"
                    placeholder="Search by User ID or Username..."
                    onkeyup="searchUsers()"
                >
            </div>

            <div class="main-content">
                <table>
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Book Name</th>
                            <th>Copy ID</th>
                            <th>Reservation ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $index => $reservation): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($reservation['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['book_name']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['copy_id']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['reservation_id']); ?></td>
                                <td>
                                    <form action="includes/managereservation.inc.php" method="post">
                                        <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['reservation_id']); ?>">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($reservation['user_id']); ?>">
                                        <input type="hidden" name="copy_id" value="<?php echo htmlspecialchars($reservation['copy_id']); ?>">
                                        <button type="submit" class="grant-button">Grant</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>



