<!--<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        require_once "includes/dbh.inc.php";


        // SQL query to fetch all books
        $query = "SELECT * FROM book;";
       
        $stmt = $pdo->prepare($query);
        $stmt->execute();


        // Fetch all books
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
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
    <title>Manage Books</title>
    
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


        .edit-button, .delete-button {
            padding: 7px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }


        .edit-button {
            background-color: #007bff;
        }


        .edit-button:hover {
            background-color: #0056b3;
        }


        .delete-button {
            background-color: #dc3545;
        }


        .delete-button:hover {
            background-color: #c82333;
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


        .sidebar ul li a:hover {
            background-color: #4d5c4e;
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


        .search-input {
            width: 50%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
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
        function confirmDelete(event) {
            if (!confirm('Are you sure you want to delete this book?')) {
                event.preventDefault();
            }
        }


        // JavaScript for real-time search
        function searchBooks() {
            let input = document.getElementById('search-input').value.toLowerCase();
            let rows = document.querySelectorAll('#book-table tbody tr');


            rows.forEach(row => {
                let bookName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                if (bookName.includes(input)) {
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
                <li><a href="managebook.php"class="selected">Manage Books</a></li>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="manageuser.php">Manage Users</a></li>
                <li><a href="managefine.php">Manage Fine</a></li>
                <li><a href="admin_dashboard.php" >Issue Book</a></li>
                <li><a href="returnbook.php">Return Book</a></li>
                <li><a href="bookrequest.php">View Book Request</a></li>
                <li><a href="managereservation.php">View/Manage Reservation</a></li>
            </ul>
        </div>
       
                <div class="profile">
                    <a href="viewadminprofile.php">Profile</a>
                    <a href="index.php">Logout</a>
                </div>
            
                <div class="content">
                    <header>
                        <h2>Manage Books</h2>
                    </header>
            
                <div class="search-container">
                    <input
                        type="text"
                        id="search-input"
                        class="search-input"
                        placeholder="Search by Book Name..."
                        onkeyup="searchBooks()"
                    >
                </div>


                <table id="book-table">
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>Book ID</th>
                            <th>Book Name</th>
                            <th>No of Available Copies</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $index => $book): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($book['book_id']); ?></td>
                                <td><?php echo htmlspecialchars($book['name']); ?></td>
                                <td><?php echo htmlspecialchars($book['no_of_available_copies']); ?></td>
                                <td>
                                    <form action="managebookdetails.php" method="get" style="display:inline-block;">
                                        <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>">
                                        <button type="submit" class="edit-button">Edit</button>
                                    </form>
                                    <form action="includes/deletebook.inc.php" method="post" style="display:inline-block;" onsubmit="confirmDelete(event)">
                                        <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>">
                                        <button type="submit" class="delete-button">Delete</button>
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