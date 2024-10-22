<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: serif;
        }
        body {
            display: flex;
            height: 100vh;
            background-image: url("https://as1.ftcdn.net/v2/jpg/07/96/87/98/1000_F_796879852_mjHIV6gAsK4yXL2EiEcfkeAlhjIoWN9Z.jpg");
        }




        /* Container to align sidebar and main content */
        .container {
            display: flex;
            width: 90%;
           
        }




        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: #2c2c2c;
            padding: 20px;
            color: white;
            display: flex;
            height: 100vh;
            flex-direction: column;
            overflow-y: auto;
            position: fixed;
        }




        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
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




        .sidebar ul li a:hover, .sidebar ul li a.selected {
            background-color: #4d5c4e;
        }


        /* Content Section */
        .content {
           
            width: calc(100% - 250px);
            padding: 50px;
            margin-left: 250px;
        }


        .main-content {
            background: linear-gradient(to bottom, #4D9078, #ddd);
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }






        header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
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




        h1 {
            margin-bottom: 20px;
            color: #34495e;
            text-align: center;
            margin-top:20px;
        }




        /* Registration Form Styling */
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }




        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }




        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }




        input[type="submit"] {
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }




        input[type="submit"]:hover {
            background-color: #2ecc71;
        }




     


        /* Form styles */
        h1 {
            color: #333; /* Darker text for the heading */
        }




        label {
            display: block;
            margin: 10px 0 5px;
        }




        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }




        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }




        button:hover {
            background-color: #218838;
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
                    <a href="viewadminprofile.php">Profile</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>


             <!-- Main Content Area -->
             <div class="main-content">


            <h1>Add a New User</h1>
            <form action="includes/adduser.inc.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
               
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone_no" required>
               
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
               
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>





