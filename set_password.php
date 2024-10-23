
<?php
// Start the session
session_start();




// Get user_id from URL
$user_id = $_GET['user_id'];




// Check if there's an error message to display
if (isset($_SESSION['error_message'])) {
    echo "<p style='color:red;'>" . $_SESSION['error_message'] . "</p>";
    // Clear the message after displaying it
    unset($_SESSION['error_message']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password</title>
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




        /* Container to align sidebar and main content */
        .container {
            display: flex;
            width: 90%;
        }




       /* Sidebar Styling */
.sidebar {
    width: 250px;
    background-color: black;
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


.profile {
               position: absolute;
               top: 13px;
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




        /* Form Styling */
        h2 {
            color: white; /* Keeping the font white for "Librarian" */
        }
        h1{
            text-align: center;
            margin-top:20px;
            color: green;
        }




        p {
            font-size: 18px;
        }




        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }




        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }




        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        .main-content{
            background: linear-gradient(to bottom,#4D9078,#ddd);
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ccc;


        }


        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }




        button:hover {
            background-color: #218838;
        }
     
         .error {
            color: red;
            margin-bottom: 10px;
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
                <li><a href="adduser.php"class="selected">Add User</a></li>
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
                    <a href="#">Profile</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>
            <div class="main-content">
            <h1 style="color: black;">User Created Successfully!</h1>
            <br>
            <p>User ID: <strong><?php echo htmlspecialchars($user_id); ?></strong></p>
            <br>


            <form id="passwordForm" action="includes/set_password.inc.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" />
                <div id="errorMessage" class="error" style="display:none;">Password do not match!</div>




                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
               
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
               
                <button type="submit">Set Password</button>
            </form>
 
 <!--         <?php
    // If the passwords do not match, allow re-entry of password only
    if (isset($_SESSION['password_error'])) {
        echo "<p style='color:red;'>Passwords do not match! Please re-enter your password.</p>";
        unset($_SESSION['password_error']);
    }
    ?>
        -->
        </div>
    </div>
    </div>
      <script>
        document.getElementById('passwordForm').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var errorMessage = document.getElementById('errorMessage');




            if (password !== confirmPassword) {
                event.preventDefault();  // Stop form submission
                errorMessage.style.display = 'block';  // Show error message
            } else {
                errorMessage.style.display = 'none';  // Hide error message if no error
            }
        });
    </script>
</body>
</html>





