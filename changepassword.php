<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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




        /* Alert Styles */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 5px;
            text-align: center;
        }




        .alert-success {
            color: green;
            border-color: #d4edda;
            background-color: #d4edda;
        }




        .alert-danger {
            color: red;
            border-color: #f8d7da;
            background-color: #f8d7da;
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
                <li><a href="viewuserprofile.php">View/Update Profile</a></li>
                <li><a href="rentedbooks.php">View Rented Books</a></li>
                <li><a href="requestbook.php">Request Book</a></li>
                <li><a href="viewfine.php">View Fine Details</a></li>
                <li><a href="viewreservations.php">View Reservation Details</a></li>
                <li><a href="changepassword.php"class="selected">Change Password</a></li>
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
            <h2>Change Password</h2>




            <!-- Display success or error messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']); // Clear the message after displaying
                    ?>
                </div>
            <?php endif; ?>




            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); // Clear the message after displaying
                    ?>
                </div>
            <?php endif; ?>




            <form id="change-password-form" action="includes/changepassword.inc.php" method="POST">
                <!-- Current Password -->
                <div class="form-group">
                    <label for="current-password">Current Password</label>
                    <input type="password" id="current-password" name="current-password" required>
                </div>




                <!-- New Password -->
                <div class="form-group">
                    <label for="new-password">New Password</label>
                    <input type="password" id="new-password" name="new-password" required>
                </div>




                <!-- Confirm New Password -->
                <div class="form-group">
                    <label for="confirm-password">Confirm New Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>




                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>




</body>
</html>









