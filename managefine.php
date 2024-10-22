<!--<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        require_once "includes/dbh.inc.php";




        // Fetch all fines initially
        $query = "SELECT f.*, u.name
                  FROM fine f
                  JOIN user_details u ON f.user_id = u.user_id;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();




        $fines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        $stmt = null;




    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
?> -->




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Fines</title>
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
                <li><a href="managefine.php"class="selected">Manage Fine</a></li>
                <li><a href="admin_dashboard.php" >Issue Book</a></li>
                <li><a href="returnbook.php">Return Book</a></li>
                <li><a href="bookrequest.php">View Book Request</a></li>
                <li><a href="managereservation.php">View/Manage Reservation</a></li>
            </ul>
        </div>
       
        <div class="content">
            <header>
                <h2>Manage Fines</h2>
                <div class="profile">
                    <a href="viewadminprofile.php">Profile</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>


            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="search-bar" placeholder="Search by User ID or Name">
            </div>


            <div class="main-content">
                <table id="fine-table">
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Issue No</th>
                            <th>Due Date</th>
                            <th>Days Past Due</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($fines)): ?>
                            <tr>
                                <td colspan="8">No fines found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($fines as $index => $fine): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td class="user-id"><?php echo htmlspecialchars($fine['user_id']); ?></td>
                                    <td class="name"><?php echo htmlspecialchars($fine['name']); ?></td>
                                    <td><?php echo htmlspecialchars($fine['issue_no']); ?></td>
                                    <td><?php echo htmlspecialchars($fine['due_date']); ?></td>
                                    <td><?php echo htmlspecialchars($fine['no_of_days_past_due_date']); ?></td>
                                    <td><?php echo htmlspecialchars($fine['amount']); ?></td>
                                    <td>
                                        <form action="includes/settleFine.inc.php" method="post">
                                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($fine['user_id']); ?>">
                                            <input type="hidden" name="fine_id" value="<?php echo htmlspecialchars($fine['fine_id']); ?>">
                                            <button type="submit" class="settle-button">Settle Fine</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>
        const searchBar = document.getElementById('search-bar');
        const tableRows = document.querySelectorAll('#fine-table tbody tr');


        searchBar.addEventListener('input', () => {
            const query = searchBar.value.toLowerCase();


            tableRows.forEach(row => {
                const userId = row.querySelector('.user-id').textContent.toLowerCase();
                const name = row.querySelector('.name').textContent.toLowerCase();


                if (userId.includes(query) || name.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>



