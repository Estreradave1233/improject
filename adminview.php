<?php
require_once('db.php');

// Fetch all students
$query = "SELECT * FROM student WHERE studID NOT IN (SELECT studID FROM student_approval) and studID not in (select studID from deny_student)";
$result = mysqli_query($conn, $query);

$querys = "SELECT s.studID, s.firstName, s.mname, s.lname, s.email, s.course, s.year, sa.approval_date, sa.approved_by 
          FROM student s
          INNER JOIN student_approval sa ON s.studID = sa.studID
          WHERE sa.approved_by IS NOT NULL";
$results = mysqli_query($conn, $querys);

$studentData = null; // Default value to prevent undefined variable errors

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['studentId'])) {
    $studentId = intval($_POST['studentId']); // Sanitize input

    // Fetch student data from database
    $query = "SELECT * FROM student WHERE studID = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $studentId); // Bind the input
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a student is found
        if ($result->num_rows > 0) {
            $studentData = $result->fetch_assoc(); // Fetch student data as associative array
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-section {
            display: none; /* Hide all content sections by default */
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="d-flex">
        <div class="bg-dark text-white vh-100 p-3" style="width: 250px;">
            <h2 class="text-center">Admin Dashboard</h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="showSection('home')">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="showSection('addStudent')">Add a student</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="showSection('manageStudents')">Manage Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="showSection('manageSection')">Drop a student</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="showSection('updateStudents')">Update information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php" onclick="showSection('logout')">Logout</a>
                </li>
            </ul>
        </div>
        
        <!-- Main content area -->
        <div class="flex-grow-1">
            <div id="home" class="content-section">
                <h1>Home</h1>
                <p>Welcome to the admin dashboard.</p>
            </div>
            <div id="addStudent" class="content-section ">
                <h1>Add a Student</h1>
                <form action="registrationAdmin.php" method="POST" class="form">
                    <div class="container mt-5">
                        <div class="card shadow-sm rounded-lg p-4 bg-light">
                            <h2 class="font-weight-bold">Registration Form</h2>
                            <div class="mt-4 row">
                                <div class="col">
                                    <label for="name">First name</label>
                                    <input type="text" class="form-control bg-dark text-white border-0" id="fname" placeholder="First name" name="firstName">
                                </div>
                                <div class="col">
                                    <label for="name">Middle name</label>
                                    <input type="text" class="form-control bg-dark text-white border-0" id="mname" placeholder="Middle name" name="middleName">
                                </div>
                                <div class="col">
                                    <label for="name">Last name</label>
                                    <input type="text" class="form-control bg-dark text-white border-0" id="lname" placeholder="Last name" name="lastName">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="email">Email</label>
                                <input type="text" class="form-control bg-dark text-white border-0" id="email" placeholder="Your email address" name="email">
                            </div>
                            <div class="mt-4">
                                <label for="password">Password</label>
                                <input type="password" class="form-control bg-dark text-white border-0" id="password" placeholder="Your password" name="password">
                            </div>

                            <div class="mt-4 row">
                                <div class="col">
                                    <label for="city">Birth date</label>
                                    <input type="date" class="form-control bg-dark text-white border-0" id="bday" placeholder="Your birth date" name="birthdate">
                                </div>
                                <div class="col">
                                    <label for="state">Gender</label>
                                    <div class="form-control bg-dark text-white border-0" >
                                        <label class="radio-inline"><input type="radio" name="gender" value="male"> Male</label>
                                        <label class="radio-inline"><input type="radio" name="gender" value="female"> Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 row">
                                <div class="col">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control bg-dark text-white border-0" id="city" placeholder="Your city" name="city">
                                </div>
                                <div class="col">
                                    <label for="state">Municipality</label>
                                    <input type="text" class="form-control bg-dark text-white border-0" id="state" placeholder="Your municipality" name="municipality">
                                </div>
                                <div class="col">
                                    <label for="state">Barangay</label>
                                    <input type="text" class="form-control bg-dark text-white border-0" id="state" placeholder="Your barangay" name="barangay">
                                </div>
                            </div>

                            <div class="mt-4 row">
                                <div class="col">
                                    <label for="country">Course</label>
                                    <div class="form-control bg-dark text-white border-0" required>
                                        <label class="radio-inline"><input type="radio" name="course" value="bsit"> BSIT</label>
                                        <label class="radio-inline"><input type="radio" name="course" value="bshm"> BSHM</label>
                                        <label class="radio-inline"><input type="radio" name="course" value="bsed"> BSED</label>
                                        <label class="radio-inline"><input type="radio" name="course" value="beed"> BEED</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="country">Year</label>
                                    <div class="form-control bg-dark text-white border-0">
                                        <label class="radio-inline"><input type="radio" name="year" value="1st"> 1st Year</label>
                                        <label class="radio-inline"><input type="radio" name="year" value="2nd"> 2nd Year</label>
                                        <label class="radio-inline"><input type="radio" name="year" value="3rd"> 3rd Year</label>
                                        <label class="radio-inline"><input type="radio" name="year" value="4th"> 4th Year</label>
                                    </div> 
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-end ">
                                    <button type="submit" class="btn btn-light px-4 py-2 btn-custom">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="manageStudents" class="content-section">
                <h1>Manage Students</h1>
                <p>Here you can manage student records and information.</p>
                <div class="container">
                    <div class="row mt-5">
                        <div class="col">
                            <div class="card mt-5">
                                <div class="card-header">
                                    <h2 class="display-6 text-center">Students</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr class="bg-dark text-white">
                                            <td>Student ID</td>
                                            <td>First Name</td>
                                            <td>Middle Name</td>
                                            <td>Last Name</td>
                                            <td>Email</td>
                                            <td>Course</td>
                                            <td>Year</td>
                                            <td>Approve</td>
                                            <td>Deny</td>
                                        </tr>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>  
                                            <tr id="studentRow_<?php echo $row['studID']; ?>">
                                                <td><?php echo $row['studID']; ?></td>
                                                <td><?php echo $row['firstName']; ?></td>
                                                <td><?php echo $row['mname']; ?></td>
                                                <td><?php echo $row['lname']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['course']; ?></td>
                                                <td><?php echo $row['year']; ?></td>
                                                <td>
                                                    <a href="#" class="btn btn-primary" onclick="approveStudent('<?php echo $row['studID']; ?>')">Approve</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-danger" onclick="denyStudent('<?php echo $row['studID']; ?>')">Deny</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="manageSection" class="content-section">
                <p id="approvedStudentsList"></p> <!-- Display approved student IDs here -->
                <div class="container">
                    <div class="row mt-5">
                        <div class="col">
                            <div class="card mt-5">
                                <div class="card-header">
                                    <h2 class="display-6 text-center">Dropped Students</h2>
                                </div>
                                <div class="card-body">
                                <table class="table table-bordered" id="approvedStudentsTable">
                                    <tr class="bg-dark text-white">
                                        <td>Student ID</td>
                                        <td>First Name</td>
                                        <td>Middle Name</td>
                                        <td>Last Name</td>
                                        <td>Email</td>
                                        <td>Course</td>
                                        <td>Year</td>
                                        <td>Approval Date</td>
                                        <td>Drop student</td>
                                    </tr>
                                    <?php while ($row = mysqli_fetch_assoc($results)) { ?>
                                        <tr id="studentRow_<?php echo $row['studID']; ?>">
                                            <td><?php echo $row['studID']; ?></td>
                                            <td><?php echo $row['firstName']; ?></td>
                                            <td><?php echo $row['mname']; ?></td>
                                            <td><?php echo $row['lname']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['course']; ?></td>
                                            <td><?php echo $row['year']; ?></td>
                                            <td><?php echo $row['approval_date']; ?></td>
                                            <td><button class="btn btn-danger" onclick="dropStudent('<?php echo $row['studID']; ?>')">Drop</button></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="updateStudents" class="content-section">
        <h1>Update Student Information</h1>
        <p>Enter a Student ID to view and update their information.</p>
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h2 class="display-6 text-center">Search Student</h2>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="adminview.php#updateStudents">
                                <div class="mb-3">
                                    <label for="studentIdInput" class="form-label">Enter Student ID:</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="studentIdInput" 
                                        name="studentId" 
                                        placeholder="Enter Student ID" 
                                        min="1" 
                                        required>
                                    <button type="submit" class="btn btn-primary mt-2">Search</button>
                                </div>
                            </form>

                            <!-- Display Student Information -->
                            <?php if (isset($studentData) && $studentData): ?>
                                <div id="studentInfo" class="mt-4">
                                    <h3>Student Information:</h3>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-dark text-white">
                                                <th>Student ID</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Course</th>
                                                <th>Year</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $studentData['studID']; ?></td>
                                                <td><?php echo $studentData['firstName']; ?></td>
                                                <td><?php echo $studentData['mname']; ?></td>
                                                <td><?php echo $studentData['lname']; ?></td>
                                                <td><?php echo $studentData['email']; ?></td>
                                                <td><?php echo $studentData['course']; ?></td>
                                                <td><?php echo $studentData['year']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary edit-btn" 
                                                            data-student='<?php echo json_encode($studentData); ?>'>
                                                        Edit
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div id="studentInfo" class="mt-4 text-danger">
                                    <p>No student found with the provided ID.</p>
                                </div>
                            <?php endif; ?>

                            <!-- Display Edit Form -->
                            <div id="editForm" class="mt-4" style="display: none;">
                                <h3>Edit Student Information:</h3>
                                <form method="POST" action="update_student.php">
                                    <input type="hidden" name="studID" id="editStudID">

                                    <div class="mb-3">
                                        <label for="editFirstName" class="form-label">First Name:</label>
                                        <input type="text" name="firstName" id="editFirstName" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editMiddleName" class="form-label">Middle Name:</label>
                                        <input type="text" name="mname" id="editMiddleName" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editLastName" class="form-label">Last Name:</label>
                                        <input type="text" name="lname" id="editLastName" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editEmail" class="form-label">Email:</label>
                                        <input type="email" name="email" id="editEmail" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to show sections
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.content-section');

            // Hide all sections
            sections.forEach(section => {
                section.style.display = 'none';
            });

            // Show the selected section
            const section = document.getElementById(sectionId);
            if (section) {
                section.style.display = 'block';
            }
        }

        function approveStudent(studID) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "student_approval.php?studID=" + studID, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText);

                    // Remove the row from the table
                    const row = document.getElementById("studentRow_" + studID);
                    if (row) {
                        row.remove();
                    }
                } else {
                    alert("Error approving student.");
                }
            };
            xhr.send();
        }


        function denyStudent(studID) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "student_deny.php?studID=" + studID, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText); // Success or error message from PHP

                    // Remove the row from the table
                    const row = document.getElementById("studentRow_" + studID);
                    if (row) {
                        row.remove();
                    }
                } else {
                    alert("Error denying student.");
                }
            };
            xhr.send();
        }

        function dropStudent(studID) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "drop_student.php?studID=" + studID, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText); // Success or error message from PHP

                    // Remove the row from the table
                    const row = document.getElementById("studentRow_" + studID);
                    if (row) {
                        row.remove();
                    }
                } else {
                    alert("Error dropping student.");
                }
            };
            xhr.send();
        }

        // Default section to display
        showSection('home');
        // Function to show sections
function showSection(sectionId) {
    const sections = document.querySelectorAll('.content-section');

    // Hide all sections
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Show the selected section
    const section = document.getElementById(sectionId);
    if (section) {
        section.style.display = 'block';
    }
}

// Check URL for section hash and show it
window.addEventListener('load', function () {
    const hash = window.location.hash.substring(1); // Get the part after the #
    if (hash) {
        showSection(hash);
    } else {
        showSection('home'); // Default section
    }
});
  // Wait for the DOM to load
  document.addEventListener('DOMContentLoaded', function () {
        // Add event listener to all Edit buttons
        document.querySelectorAll('.edit-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                // Parse the student data from the button's data attribute
                const studentData = JSON.parse(this.dataset.student);

                // Populate the form fields with the student data
                document.getElementById('editStudID').value = studentData.studID;
                document.getElementById('editFirstName').value = studentData.firstName;
                document.getElementById('editMiddleName').value = studentData.mname;
                document.getElementById('editLastName').value = studentData.lname;
                document.getElementById('editEmail').value = studentData.email;

                // Show the edit form
                document.getElementById('editForm').style.display = 'block';
            });
        });
    });
    </script>
</body>
</html>
