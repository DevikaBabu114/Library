  <?php
// Get the book ID and number of copies from the URL parameters
$bookid = $_GET['bookid'];
$copies = $_GET['copies'];
?>  


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Copy</title>
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
    background-color: #333;
    padding: 20px;
    color: white;
    display: flex;
    flex-direction: column;
    height: 100vh; /* Sidebar takes full viewport height */
    overflow-y: auto; /* Enable scrolling for overflow */
    position:fixed;
   
}


.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
    color: white; /* Librarian text color */
}


.sidebar ul {
    list-style-type: none;
    padding: 0;
}


.sidebar ul li {
    margin: 20px 0;
}


.sidebar ul li a {
    color: white;
    text-decoration: none;
    display: block;
    padding: 10px;
    text-align: center;
}


/* Add this class for selected menu item */
.sidebar ul li a.selected {
    background-color:  /* Different background to highlight selected item */
    font-weight: bold;
}


.sidebar ul li a:hover {
    background-color: #4d5c4e;
}


/* Content Section Styling */
.content {
    width: calc(100% - 250px);
     padding: 50px;
     margin-left: 250px; /* Offset the content to the right */  
}


header {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 0px;


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


form {
    max-width: 400px; /* Limit the form width */
    margin: 0 auto; /* Center the form on the page */
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
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
                <!-- "Add Book" is selected -->
                <li><a href="addbook.php"class="selected" >Add Book</a></li>
                <li><a href="managebook.php">Manage Books</a></li>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="manageuser.php">Manage Users</a></li>
                <li><a href="managefine.php">Manage Fine</a></li>
                <li><a href="admin_dashboard.php" >Issue Book</a></li>
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


            <div class="main-content">
                <h2>Add Copies for Book ID: <?php echo $bookid; ?></h2>
                <form action="includes/addcopies.inc.php" method="POST">
                    <input type="hidden" name="bookid" value="<?php echo $bookid; ?>">
                 
                    <?php
                    // Dynamically generate input fields for the number of copies
                    for ($i = 1; $i <= $copies; $i++) {
                        echo '<div class="form-group">';
                        echo '<label for="copyid' . $i . '">Copy ID ' . $i . '</label>';
                        echo '<input type="text" id="copyid' . $i . '" name="copyid' . $i . '" placeholder="Enter Copy ID ' . $i . '" required>';
                        echo '</div>';
                    }
                    ?>
                   
                   
                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit">Add Copies</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

