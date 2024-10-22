<!--<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        require_once "includes/dbh.inc.php";


        // Fetch all book requests from the database
        $query = "SELECT * FROM book_request;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();


        $bookRequests = $stmt->fetchAll(PDO::FETCH_ASSOC); // Store results in an array
        $pdo = null;
        $stmt = null;


    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
?>
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book Requests</title>
    <style>
        /* Styling the layout */
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

        .sidebar ul li a:hover, .sidebar ul li a.selected {
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


        /* Search bar styling */
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
        h2 {
            margin-bottom: 20px;
            color: #34495e;
            text-align: center;
}


        /* Table styling */
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


        tr:hover {
            background-color: #f1f1f1;
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
    <body>
        <div class="container">
            <!-- Sidebar Section -->
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
                <li><a href="bookrequest.php"class="selected">View Book Request</a></li>
                <li><a href="managereservation.php">View/Manage Reservation</a></li>
                </ul>
            </div>
    
            <!-- Profile and Logout Section -->
            <div class="profile">
                <a href="viewadminprofile.php">Profile</a>
                    <a href="index.php">Logout</a>
            </div>
    
            <!-- Main Content Section -->
            <div class="content">
                <header>
                    <h2 >Book Requests</h2>
                </header>
                <!-- The rest of your main content here -->
             <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="search-bar" placeholder="Search by User ID, Book Name, or Author">
            </div>


            <!-- Book Request Table -->
            <table id="book-request-table">
                <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>User ID</th>
                        <th>Name of Book</th>
                        <th>Author</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookRequests as $index => $request): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td class="user-id"><?php echo htmlspecialchars($request['user_id']); ?></td>
                            <td class="book-name"><?php echo htmlspecialchars($request['name']); ?></td>
                            <td class="author"><?php echo htmlspecialchars($request['author']); ?></td>
                            <td><?php echo htmlspecialchars($request['category']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <script>
        const searchBar = document.getElementById('search-bar');
        const tableRows = document.querySelectorAll('#book-request-table tbody tr');


        searchBar.addEventListener('input', () => {
            const query = searchBar.value.toLowerCase();


            tableRows.forEach(row => {
                const userId = row.querySelector('.user-id').textContent.toLowerCase();
                const bookName = row.querySelector('.book-name').textContent.toLowerCase();
                const author = row.querySelector('.author').textContent.toLowerCase();


                if (userId.includes(query) || bookName.includes(query) || author.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</div>
</div>
</body>
</html>