<!--
<?php
session_start();
require_once "includes/dbh.inc.php"; // Include your database connection file




// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}




// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user_details WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);




if (!$user) {
    die("User not found."); // Handle the case where the user is not found
}
?>
-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View/Update Profile</title>
   
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


       


/* Main Content Area Styling */
.main-content {
            background: linear-gradient(to bottom, #4D9078, #ddd);
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }


        h2 {
            margin-bottom: 20px;
            color: #34495e;
            text-align: center;
        }






/* Form Group Styling */
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




/* Button Styling */
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




/* Edit Button Styling */
.edit-btn {
    background-color: #27ae60;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    cursor: pointer;
   
}




.edit-btn:hover {
    background-color: #218838;
}




/* Form Styling */
form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            <h2>User</h2>
            <ul>
                <li><a href="user_dashboard.php">Search Book</a></li>
                <li><a href="viewuserprofile.php"class="selected">View/Update Profile</a></li>
                <li><a href="rentedbooks.php">View Rented Books</a></li>
                <li><a href="requestbook..php">Request Book</a></li>
                <li><a href="viewfine.php">View Fine Details</a></li>
                <li><a href="viewreservations.php">View Reservation Details</a></li>
                <li><a href="changepassword.php">Change Password</a></li>
            </ul>
           
        </div>




        <!-- Main Content Section -->
        <div class="content">
            <header>
                <div class="profile">    
                    <a href="notification.php">Notifications</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>




            <div class="main-content">
                <h2 style="color: black;">View/Update Profile</h2>
                <form id="profile-form" action="includes/u-editprofile.inc.php" method="POST">
                    <!-- User ID Field -->
                    <div class="form-group">
                        <label for="user-id">User ID</label>
                        <input type="text" id="user-id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" readonly>
                    </div>




                    <!-- Name Field with Edit Button -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" disabled>
                            <button type="button" class="edit-btn" onclick="enableEdit('name')">Edit</button>
                        </div>
                        <input type="hidden" name="original_name" value="<?php echo $user['name']; ?>"> <!-- Hidden field -->
                    </div>




                    <!-- Phone Number Field with Edit Button -->
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="phone" name="phone" value="<?php echo $user['phone_no']; ?>" disabled>
                            <button type="button" class="edit-btn" onclick="enableEdit('phone')">Edit</button>
                        </div>
                        <input type="hidden" name="original_phone" value="<?php echo $user['phone_no']; ?>"> <!-- Hidden field -->
                    </div>




                    <!-- Email Field with Edit Button -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" disabled>
                            <button type="button" class="edit-btn" onclick="enableEdit('email')">Edit</button>
                        </div>
                        <input type="hidden" name="original_email" value="<?php echo $user['email']; ?>"> <!-- Hidden field -->
                    </div>




                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- Script to Enable Editing of Fields -->
    <script>
        function enableEdit(fieldId) {
            document.getElementById(fieldId).disabled = false; // Fixed typo here
        }
    </script>
</body>
</html>









