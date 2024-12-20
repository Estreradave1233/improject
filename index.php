<?php
// Start session
session_start();

// Database connection details
$servername = "localhost";  // Replace with your database host
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "improject";      // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch and sanitize form data
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$pwd = isset($_POST['password']) ? $_POST['password'] : '';

// Check if form fields are filled
if ($email && $pwd) {
    // Check in the admin table first
    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch admin data
        $admin = $result->fetch_assoc();
        
        // Verify password for admin
        if ($pwd === $admin['password']) {
            // Password is correct, set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['email'] = $admin['email'];
            
            // Redirect to admin view
            header("Location: adminview.php");
            exit();
        } else {
            echo "Invalid password for admin.";
        }
    } else {
        // If not found in admin, check in users table
        $sql = "SELECT * FROM student WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Fetch user data
            $user = $result->fetch_assoc();
            
            // Verify password for user
            if ($pwd === $user['password']) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect to user view
                header("Location: userview.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No account found with that email.";
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="login.css">
        <script src="https://kit.fontawesome.com/f5c2ead0ac.js" crossorigin="anonymous"></script>
    </head>
    <body> 
        <form class="form" action="index.php" method="post">
            <span class="input-span">
                <label for="email" class="label">Email</label>
                <input type="email" name="email" id="email"
            /></span>
            <span class="input-span">
                <label for="password" class="label">Password</label>
                <input type="password" name="password" id="password"
            /></span>
            <input class="submit" type="submit" value="Log in" />
            <span class="span">Don't have an account? <a href="registration.php">Sign up</a></span>
        </form>
    </body>
</html>
