<!--<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        require_once "includes/dbh.inc.php";


        // SQL query to fetch user details for users with role 'user'
        $query = "
            SELECT ud.*, ut.role
            FROM user_details ud
            JOIN user_table ut ON ud.user_id = ut.user_id
            WHERE ut.role = 'user';
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();


        // Fetch all users with role 'user'
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $pdo = null;
        $stmt = null;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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

        
         /* Content Section Styling */
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


        .edit-button {
            background-color: #007bff;
            color: white;
            padding: 7px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }


        .edit-button:hover {
            background-color: #0056b3;
        }
        .delete-button {
    background-color: #ff0000; /* Red color for Delete button */
    color: white;
    padding: 7px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}


.delete-button:hover {
    background-color: #cc0000; /* Darker red on hover */
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
                <li><a href="manageuser.php"class="selected">Manage Users</a></li>
                <li><a href="managefine.php">Manage Fine</a></li>
                <li><a href="admin_dashboard.php">Issue Book</a></li>
                <li><a href="returnbook.php">Return Book</a></li>
                <li><a href="bookrequest.php">View Book Request</a></li>
                <li><a href="managereservation.php">View/Manage Reservation</a></li>
            </ul>
        </div>
       
        <div class="content">
            <header>
                <h2>Manage Users</h2>
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
                <table id="user-table">
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Phone No</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone_no']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <a href="updatepassword.php?user_id=<?php echo htmlspecialchars($user['user_id']); ?>" class="edit-button">Edit Password</a>
                                    <a href="includes/deleteuser.inc.php?user_id=<?php echo htmlspecialchars($user['user_id']); ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
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