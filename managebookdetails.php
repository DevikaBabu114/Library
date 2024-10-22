<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        require_once "includes/dbh.inc.php"; // Ensure the database connection file exists




        if (isset($_GET['book_id'])) {
            $book_id = $_GET['book_id'];




            // SQL query to fetch the specific book
            $query = "SELECT * FROM book WHERE book_id = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$book_id]);




            // Fetch the book details
            $book = $stmt->fetch(PDO::FETCH_ASSOC);




            // Check if the book was found
            if (!$book) {
                echo "Book not found!";
                exit;
            }




            $stmt = null; // Close statement
            $pdo = null; // Close connection
        } else {
            header("Location: ../index.php"); // Redirect if book_id is not set
            exit();
        }




    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php"); // Redirect for non-GET requests
    exit();
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link rel="stylesheet" href="demostyle.css">
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
            height: 90%; /* Ensure container takes full viewport height */
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
   


        header h2 {
            font-size: 24px;
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
        min-width: 850px;
        text-align: center;
        margin-left:200px;
        }








        .details-container {
            margin-top: 20px;
            max-width: 800px;
            background-color: white;
            padding: 10px;
            border-radius: 10px;
        }




        .details-container h3 {
            margin-bottom: 10px;
            color: black;
        }




        .details-container .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            align-items: center;
        }




        .details-container .detail-row label {
            font-weight: bold;
            color: black;
            width: 150px;
        }




        .details-container .detail-row input {
            flex: 1;
            padding: 10px;
            border: 1px solid ;
            border-radius: 5px;
            margin-left: 10px;
        }




        .details-container .detail-row button {
            padding: 5px 10px;
            background-color: #27ae60;;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }




        .details-container .detail-row button:hover {
            background-color: #2ecc71;
        }




        .center {
            display: flex;
            justify-content: center; /* Center content */
        }




        .button {
            padding: 5px 10px;
            background-color: #27ae60;;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
        }




        .button:hover {
            background-color: #2ecc71;;
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
                <li><a href="managebook.php"class="selected">Manage Books</a></li>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="manageuser.php">Manage Users</a></li>
                <li><a href="managefine.php">Manage Fine</a></li>
                <li><a href="user_dashboard.php">Issue Book</a></li>
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




            <!-- Display status messages -->
           
            <?php
            // Existing code...
            if (isset($_GET['status'])) {
                $status = $_GET['status'];
                if ($status == 'success') {
                    echo '<p style="color: green;">Book details updated successfully!</p>';
                } elseif ($status == 'no_change') {
                    echo '<p style="color: orange;">No changes made to the book details.</p>';
                }
            }
            // Existing code...
            ?> 
            <!-- Main Content Area -->


            <div class="main-content">
            <h2>Book Details</h2>
            <form action="includes/updatebook.inc.php" method="POST"> <!-- Form to update book details -->
                <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>">
                <div class="details-container">
                    <div class="detail-row">
                        <label>Book ID :</label>
                        <input type="text" name="book_id_display" value="<?php echo htmlspecialchars($book['book_id']); ?>" disabled> <!-- Make Book ID non-editable -->
                    </div>
                    <div class="detail-row">
                        <label>Title :</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($book['name']); ?>" required>
                    </div>
                    <div class="detail-row">
                        <label>Author :</label>
                        <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                    </div>
                    <div class="detail-row">
                        <label>Publisher :</label>
                        <input type="text" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>" required>
                    </div>
                    <div class="detail-row">
                        <label>Price :</label>
                        <input type="number" name="price" value="<?php echo htmlspecialchars($book['price']); ?>" required>
                    </div>
                   <div class="detail-row">
                        <label>Number of Copies :</label>
                        <input type="number" name="copies" value="<?php echo htmlspecialchars($book['no_of_copies']); ?>" required>
                        <button type="button" onclick="location.href='managecopies.php?book_id=<?php echo htmlspecialchars($book['book_id']); ?>'" class="button">Edit</button>
                    </div>




                    <div class="detail-row">
                        <label>Available Copies :</label>
                        <input type="number" name="available_copies" value="<?php echo htmlspecialchars($book['no_of_available_copies']); ?>" required>
                    </div>
                    <div class="detail-row">
                        <label>Rack No :</label>
                        <input type="text" name="rack_no" value="<?php echo htmlspecialchars($book['rack_no']); ?>" required>
                    </div>
                    <div class="detail-row">
                        <label>Category :</label>
                        <input type="text" name="category" value="<?php echo htmlspecialchars($book['category']); ?>" required>
                    </div>
                    <div class="center">
                        <button type="submit" class="button">Update Book Details</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>









