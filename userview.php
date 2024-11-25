<?php
// Start the session
session_start();

// Assuming the email was saved in the session when the user logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email']; // Get the email from session
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "improject";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get student information by email
$sql = "SELECT * FROM student WHERE email = '$email'";
$result = $conn->query($sql);

// Check if the student exists
if ($result->num_rows > 0) {
    // Fetch student data
    $student = $result->fetch_assoc();
} else {
    $student = null;
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .img {
        width: 30%;
      }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Student Portal</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="student_status.php?email=<?php echo urlencode($email); ?>">Approval Status</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="subjects.php?email=<?php echo urlencode($email); ?>">Subjects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="mt-4 row">
    <div class="col">
      <table class="table table-bordered">
        <tr>
          <td colspan="3" class="text-center">
            <img src="image.png" alt="" class="rounded-circle img-thumbnail img">
          </td>
        </tr>
        <tr>
          <td>Name</td>
          <td>:</td>
          <td><?php echo strtoupper($student['firstName']) .' ' . strtoupper($student['mname']) .' '.strtoupper($student['lname']) ; ?></td>
        </tr>
        <tr>
          <td>Student ID</td>
          <td>:</td>
          <td><?php echo $student['studID']; ?></td>
        </tr>
        <tr>
          <td>Course</td>
          <td>:</td>
          <td><?php echo strtoupper($student['course']); ?></td>
        </tr>
        <tr>
          <td>Year</td>
          <td>:</td>
          <td><?php echo strtoupper($student['year']); ?></td>
        </tr>
      </table>
    </div>
      <div class="col">
        <?php if ($student): ?>
          <h3>Your Profile Information</h3>
          <table class="table table-bordered">
          
            <tr>
              <td>Email</td>
              <td>:</td>
              <td><?php echo $student['email']; ?></td>
            </tr>
            <tr>
              <td>Gender</td>
              <td>:</td>
              <td><?php echo strtoupper($student['gender']); ?></td>
            </tr>
            <tr>
              <td>Birthdate</td>
              <td>:</td>
              <td><?php echo strtoupper($student['birthdate']); ?></td>
            </tr>
            <tr>
              <td>Address </td>
              <td>:</td>
              <td><?php echo  strtoupper($student['city']) . ', ' .strtoupper($student['municipality']) .', ' . strtoupper($student['barangay']) ; ?></td>
            </tr>
          </table>
          <?php else: ?>
          <p>Student not found.</p>
          <?php endif; ?>
      </div>
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
