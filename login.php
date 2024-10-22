<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library Management System</title>
    <style>
        /* Body Styling */
body {
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: serif;
    background-image: url("https://as1.ftcdn.net/v2/jpg/07/96/87/98/1000_F_796879852_mjHIV6gAsK4yXL2EiEcfkeAlhjIoWN9Z.jpg");


}




/* Login container */
.login-container {
   
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 400px;
   
}




/* Login box */
.login-box {
    background: linear-gradient(to bottom,#4D9078,#ddd);


    background-color: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
    text-align: center;
    border-color: #0d0d0e;
   
}




/* Login heading */
.login-box h2 {
    margin-bottom: 20px;
    color: #0d0f10;
    font-size: 24px;
}




/* Input groups */
.input-group {
    margin-bottom: 20px;
    text-align: left;
}




/* Input labels */
.input-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: black;
}




/* Text input fields */
.input-group input {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    box-sizing: border-box;
   
}




.input-group input:focus {
    border-color: #3498db;
}




/* Login button */
.btn-login {
    background-color: #1e150b;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
}




.btn-login:hover {
    background-color: #152d12;
}




/* Error message */
.error-message {
    color: red; /* Ensure this is applied correctly */
    margin-bottom: 15px; /* Space below the error message */
    font-size: 14px; /* Font size */
    text-align: center; /* Center align the message */
    font-weight: bold; /* Make the font bold */
}


    </style>
</head>
<body>




<div class="login-container">
    <div class="login-box">
        <h2>Login</h2>




        <!-- Display error message if it exists -->
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php
                if ($_GET['error'] == 'wrongpassword') {
                    echo "Incorrect password. Please try again.";
                } elseif ($_GET['error'] == 'nouser') {
                    echo "No user found with that User ID. Please try again.";
                }
                ?>
            </div>
        <?php endif; ?>




        <form action="includes/login.process.inc.php" method="POST">
            <div class="input-group">
                <label for="user_id">User ID</label>
                <input type="text" id="user_id" name="user_id" placeholder="Enter your User ID" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</div>




</body>
</html>









