<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book - Library Management System</title>

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
    margin-bottom: 5px; /* Reduce margin to move Profile and Logout slightly up */
    padding-right: 20px; /* Add some right padding to position the links better */
    width: 100%; 
}

.profile {
    margin-left: auto; /* Pushes the profile section to the far right */
}


.profile a {
   
    color: #0b0b0b;
    text-decoration: none;
    font-weight: bold;
    font-size: 20px; /* Adjust font size if needed */
}


.main-content {

    background: linear-gradient(to bottom,#4D9078,#ddd);
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ccc;
}


h2 {
    margin-bottom: 20px;
    color: #34495e;
    text-align: center;
}


.form-group {
    margin-bottom: 15px;
}


.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}


.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #090707;
    border-radius: 4px;
    font-size: 16px;
}


button {
    padding: 10px 20px;
    background-color: #27ae60;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
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

button:hover {
    background-color: #2ecc71;
}


/* Ensure form occupies full width of container */
form {
    max-width: 400px; /* Limit the form width */
    margin: 0 auto; /* Center the form on the page */
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
}
.sidebar ul li a:hover,
        .sidebar ul li a.selected {
            background-color: #4d5c4e;
        }


    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <nav class="sidebar">
            <h2>Librarian</h2>
            <ul>
                <li><a href="addbook.php" class="selected">Add Book</a></li>
                <li><a href="managebook.php">Manage Books</a></li>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="manageuser.php">Manage Users</a></li>
                <li><a href="managefine.php">Manage Fine</a></li>
                <li><a href="admin_dashboard.php" >Issue Book</a></li>
                <li><a href="returnbook.php">Return Book</a></li>
                <li><a href="bookrequest.php">View Book Request</a></li>
                <li><a href="managereservation.php">View/Manage Reservation</a></li>
            </ul>
        </nav>


        <!-- Main Content Section -->
        <div class="content">
            <header>
                <div class="profile">
                    <a href="viewadminprofile.php">Profile</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>
           
            <!-- Main Content Area -->
            <div class="main-content">
                <h2>Add New Book</h2>
                <form action="includes/addbook.inc.php" method="POST">
                    <!-- Book ID Field -->
                    <div class="form-group">
                        <label for="bookid">Book ID</label>
                        <input type="text" id="bookid" name="bookid" placeholder="Enter Book ID" required>
                    </div>


                    <!-- Book Title Field -->
                    <div class="form-group">
                        <label for="title">Book Title</label>
                        <input type="text" id="title" name="title" placeholder="Enter Book Title" required>
                    </div>


                    <!-- Author Field -->
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author" placeholder="Enter Author Name" required>
                    </div>


                    <!-- Publisher Field -->
                    <div class="form-group">
                        <label for="publisher">Publisher</label>
                        <input type="text" id="publisher" name="publisher" placeholder="Enter Publisher Name" required>
                    </div>


                    <!-- Price Field -->
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" placeholder="Enter Book Price" step="0.01" required>
                    </div>


                    <!-- Number of Copies Field -->
                    <div class="form-group">
                        <label for="copies">Number of Copies</label>
                        <input type="number" id="copies" name="copies" placeholder="Enter Number of Copies" required>
                    </div>


                    <!-- Rack Number Field -->
                    <div class="form-group">
                        <label for="rack">Rack Number</label>
                        <input type="text" id="rack" name="rack" placeholder="Enter Rack Number" required>
                    </div>


                    <!-- Category Field -->
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category" placeholder="Enter Book Category" required>
                    </div>


                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit">Add Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
