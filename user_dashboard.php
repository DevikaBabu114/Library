<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/search.css">
</head>
<body>
<div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>User</h2>
            <ul>
        <li><a href="user_dashboard.php">Search Book</a></li>
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
                </div> <!-- Search section ends -->

                <!-- Grid Container for Displaying Books -->
                <div class="grid-container" id="book-results">
                    <!-- Dynamic results will be injected here -->
                    <?php include 'includes/search.inc.php'; ?>
                </div>
            </div> <!-- main content ends -->
        </div> <!-- content ends -->
     <!-- Success message modal -->
     <div id="reservation-success-modal" style="display:none;">
        <div id="reservation-success-content">
            <h3>Reservation Successful!</h3>
            <p>Your book has been successfully reserved.</p>
            <button class="close-modal">OK</button>
        </div>
    </div>
    </div> <!-- container ends -->

   

    <script>
        $(document).ready(function() {
            // Check for session variable on page load
            <?php if (isset($_SESSION['reservation_success']) && $_SESSION['reservation_success']) : ?>
                $('#reservation-success-modal').show();
                <?php unset($_SESSION['reservation_success']); ?>
            <?php endif; ?>

            // Handle Search Button Click
            $('#search-btn').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission
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

            // Handle Reservation Button Click inside AJAX loaded content
            $('#book-results').on('click', '.reserve-btn', function(e) {
                e.preventDefault();
                var bookId = $(this).closest('form').find('input[name="book_id"]').val();

                // AJAX request to handle the reservation
                $.ajax({
                    url: 'includes/search.inc.php',
                    method: 'POST',
                    data: {
                        book_id: bookId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            // Show success message modal
                            $('#reservation-success-modal').show();
                        } else if (data.error) {
                            alert(data.error);
                        }
                    },
                    error: function() {
                        alert('Error reserving the book. Please try again.');
                    }
                });
            });

            // Handle modal close
            $('.close-modal').on('click', function() {
                $('#reservation-success-modal').hide();
                window.location.href = 'user_dashboard.php'; // Redirect to user dashboard
            });
        });
    </script>
</body>
</html>
