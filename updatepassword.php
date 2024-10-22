<!--
<?php
// Start the session
session_start();




// Get user_id from URL and validate
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    // Handle the error if user_id is missing
    $_SESSION['error_message'] = "User ID is missing.";
    header("Location: manageuser.php"); // Redirect to an error page
    exit();
}




// Check if there's an error message to display
if (isset($_SESSION['error_message'])) {
    echo "<p style='color:red;'>" . $_SESSION['error_message'] . "</p>";
    // Clear the message after displaying it
    unset($_SESSION['error_message']);
}
?>
-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admindash.css">
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


.content {
     width: calc(100% - 250px);
     padding: 50px;
     margin-left: 250px; /* Offset the content to the right */


}




 header {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin-bottom: 20px;
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






        h1 {
            text-align: center;
            margin-top: 20px;
            color: green;
        }




        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(to bottom,#4D9078,#ddd);
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
            border: 1px solid black;
            border-radius: 4px;
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
                <li><a href="addbook.php">Add Book</a></li>
                <li><a href="managebook.php">Manage Books</a></li>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="manageusers.php"class="selected">Manage Users</a></li>
                <li><a href="managefine.php">Manage Fine</a></li>
                <li><a href="issuebook.php">Issue Book</a></li>
                <li><a href="returnbook.php">Return Book</a></li>
                <li><a href="viewbookrequest.php">View Book Request</a></li>
                <li><a href="managereservation.php">Manage Reservation</a></li>
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
           
           




            <form id="passwordForm" action="includes/manageusers.inc.php" method="POST">
                <h1 style="color: black;">Set Password</h1>
                <p style="font-weight: bold; color:black;" >User ID: <strong><?php echo htmlspecialchars($user_id); ?></strong></p>
                <br>
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" />
               
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
               
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
               
                <button type="submit">Set Password</button>
            </form>


          <!--
            <?php
            // Display error message if passwords do not match
            if (isset($_SESSION['password_error'])) {
                echo "<p style='color:red;'>Passwords do not match! Please re-enter your password.</p>";
                unset($_SESSION['password_error']);
            }
            ?>
            -->
        </div>
    </div>




    <script>
        document.getElementById('passwordForm').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;




            if (password !== confirmPassword) {
                event.preventDefault();  // Stop form submission
                alert('Passwords do not match!');  // Alert the user
            }
        });
    </script>
</body>
</html>









