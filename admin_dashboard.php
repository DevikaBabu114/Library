<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book - Library Management System</title>
   


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
    color: white; /* Makes the text color of Librarian white */
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
    width: calc(100% - 250px);
    padding: 50px;
    margin-left: 250px;
}


header {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 5px;
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
    background: linear-gradient(to bottom, #4D9078, #ddd);
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ccc;
    min-height: 400px;
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
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}


form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}




button {
    padding: 10px 20px;
    background-color: #27ae60;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}


button:hover {
    background-color: #2ecc71;
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
        <div class="sidebar">
            <h2>Librarian</h2>
            <ul>
               <li><a href="addbook.php" >Add Book</a></li>
                <li><a href="managebook.php">Manage Books</a></li>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="manageuser.php">Manage Users</a></li>
                <li><a href="managefine.php">Manage Fine</a></li>
                <li><a href="admin_dashboard.php" class="selected">Issue Book</a></li>
                <li><a href="returnbook.php">Return Book</a></li>
                <li><a href="bookrequest.php">View Book Request</a></li>
                <li><a href="managereservation.php">View/Manage Reservation</a></li>
            </ul>
        </div>




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
                <h2>Issue Book</h2>




                <!-- Display success message if it exists -->
                <?php if (isset($_GET['message'])): ?>
                    <div class="success-message">
                        <?php echo htmlspecialchars($_GET['message']); ?>
                    </div>
                <?php endif; ?>




                <!-- Display error message if it exists -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message">
                        <?php
                        if ($_GET['error'] == 'copyunavailable') {
                            echo "The copy ID is not available.";
                        } elseif ($_GET['error'] == 'nouser') {
                            echo "No user found with that User ID. Please try again.";
                        }
                        ?>
                    </div>
                <?php endif; ?>




                <form action="includes/issuebook.inc.php" method="POST">
                    <!-- Copy ID Field -->
                    <div class="form-group">
                        <label for="copyid">Copy ID</label>
                        <input type="text" id="copyid" name="copyid" placeholder="Enter Copy ID" required>
                    </div>




                    <!-- User ID Field -->
                    <div class="form-group">
                        <label for="userid">User ID</label>
                        <input type="text" id="userid" name="userid" placeholder="Enter User ID" required>
                    </div>




                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit">Issue Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <style>
        /* Optional CSS styling for success and error messages */
        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }




        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</body>
</html>









