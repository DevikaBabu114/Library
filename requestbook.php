<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommend a Book - Library Management System</title>
    <style>
        /* Global styles */
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








        header {
           
            color: black;
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }








        .content {
            width: calc(100% - 250px);
            padding: 50px;
            margin-left: 250px;
           
        }








        .container {
            display: flex;
            height: 90%;
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
            min-width: 900px;
            margin-left:100px;



        }








        .form-container {
            min-width: 400px;
            border: 2px solid white; /* Outer border for the form */
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 60%; /* Adjust the width as needed */
            margin: 0 auto; /* Center the form */
        }








        .form-heading {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }








        .form-group {
            margin-bottom: 15px;
            font-weight: bold;
            color:black;
        }








        .form-group label {
            display: block;
            margin-bottom: 5px;
        }








        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }








        .form-group button {
            padding: 10px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }








        .form-group button:hover {
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
        <div class="sidebar">
            <h2>User</h2>
            <ul>
             <li><a href="user_dashboard.php">Search Book</a></li>
                <li><a href="viewuserprofile.php">View/Update Profile</a></li>
                <li><a href="rentedbooks.php">View Rented Books</a></li>
                <li><a href="requestbook.php"class="selected">Request Book</a></li>
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
        <!-- Centered form heading -->
        <h2 class="form-heading">Request a Book</h2>








        <!-- Form inside the outlined box -->
        <div class="form-container">
            <form action="includes/u-requestbook.inc.php" method="POST">
                <!-- Book Title Field -->
                <div class="form-group">
                    <label for="title">Book Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter book title" required>
                </div>








                <!-- Author Field -->
                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" placeholder="Enter author name" required>
                </div>








                <!-- Category Field -->
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="Fiction">Fiction</option>
                        <option value="Non-Fiction">Non-Fiction</option>
                        <option value="Science">Science</option>
                        <option value="History">History</option>
                        <option value="Technology">Technology</option>
                        <option value="Arts">Arts</option>
                        <option value="Biography">Biography</option>
                        <option value="Others">Others</option>
                    </select>
                </div>








                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>








</body>
</html>









