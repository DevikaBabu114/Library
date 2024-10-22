<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->


    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family:serif;
}








body {
    display: flex;
    height: 100vh;
    background-image: url("https://as1.ftcdn.net/v2/jpg/07/96/87/98/1000_F_796879852_mjHIV6gAsK4yXL2EiEcfkeAlhjIoWN9Z.jpg");


}








.container {
    display: flex;
    width: 100%;
}








/* Sidebar styling */




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


















/* Main content styling */
.content {
    width: calc(100% - 250px);
    padding: 20px;
    margin-left: 250px;
}








header {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 10px;
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
    margin-top: 40px;
}








h2 {
    margin-bottom: 20px;
    color: #34495e;
}








.search-section {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}








#search-bar, #category-bar {
    padding: 10px;
    width: 300px;
    border-radius: 5px;
    border: 1px solid #ccc;
}








#search-btn {
    padding: 10px 20px;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}








#search-btn:hover {
    background-color: #3498db;
}








/* Grid for book results */
.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 columns in a row */
    gap: 20px;
}








.grid-item {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}








.grid-item h3, .grid-item p {
    margin-bottom: 10px;
}








.reserve-btn, .request-btn {
    padding: 10px;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}








.reserve-btn:hover, .request-btn:hover {
    background-color: #3498db;
}








.button-container {
    display: flex;
    justify-content: center;
    gap: 10px; /* Space between the buttons */
    margin-top: 10px;
}


















.sidebar ul li a:hover,
        .sidebar ul li a.selected {
            background-color: #4d5c4e;
        }





    </style>


</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>User </h2>
            <ul>
                <li><a href="user_dashboard.php" class="selected">Search Book</a></li>
                <li><a href="viewuserprofile.php">View/Update Profile</a></li>
                <li><a href="rentedbooks.php">View Rented Books</a></li>
                <li><a href="requestbook.php">Request Book</a></li>
                <li><a href="viewfine.php">View Fine Details</a></li>
                <li><a href="viewreservations.php">View Reservation Details</a></li>
                <li><a href="changepassword.php">Change Password</a></li>
            </ul>
        </div>




        <!-- Main content -->
        <div class="content">
            <header>
                <div class="profile">
                    <a href="notification.php">Notifications</a>
                    <a href="index.php">Logout</a>
                </div>
            </header>




            <div class="main-content">
                <h2>Search Books</h2>




                <!-- Search Section with Dropdown for Categories -->
                <div class="search-section">
                    <input type="text" id="search-bar" placeholder="Search by Book Name or Author">
                    <select id="category-bar">
                        <option value="">Select Category</option>
                        <option value="Technology">Technology</option>
                        <option value="Fiction">Fiction</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Science">Science</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="History">History</option>
                    </select>
                    <button id="search-btn">Search</button>
                </div>




                <!-- Grid Container for Displaying Books -->
                <div class="grid-container" id="book-results">
                    <!-- Dynamic results will be injected here -->
                    <?php include 'includes/search.inc.php'; ?> <!-- Default book list -->
                </div>
            </div>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            $('#search-btn').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission
               
                // Get search input and selected category
                var search = $('#search-bar').val();
                var category = $('#category-bar').val();




                // AJAX request
                $.ajax({
                    url: 'includes/search.inc.php',
                    method: 'GET',
                    data: {
                        search: search,
                        category: category
                    },
                    success: function(data) {
                        $('#book-results').html(data); // Update the grid with the new results
                    },
                    error: function() {
                        alert('Error fetching books. Please try again.');
                    }
                });
            });
        });
    </script>


    <!--
    <?php




// Check if there's a success message set in the session
if (isset($_SESSION['reserve_success'])) {
    // Display the message in green color
    echo "<p style='color: green; font-weight: bold;'>" . $_SESSION['reserve_success'] . "</p>";
   
    // Unset the message so it doesn't show again on page reload
    unset($_SESSION['reserve_success']);
}
?>
-->


</body>
</html>









