<?php
// Include the database connection
include('db.php'); // Ensure this file correctly sets up $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $studID = trim($_POST['studID']);
    $firstName = trim($_POST['firstName']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);

    // Validate form data
    if (empty($studID) || empty($firstName) || empty($lname) || empty($email)) {
        echo "Error: All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email format.";
        exit;
    }

    // Update query
    $sql = "UPDATE student SET 
                firstName = ?, 
                mname = ?, 
                lname = ?, 
                email = ?
            WHERE studID = ?";

    // Prepare and bind parameters
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssssi', $firstName, $mname, $lname, $email, $studID);

      // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
            alert('Student information updated successfully.');
            window.location.href = 'adminview.php#updateStudents';
        </script>";
    } else {
        echo "<script>
            alert('Error updating student: " . $conn->error . "');
            window.location.href = 'adminview.php#updateStudents';
        </script>";
    }
    $conn->close();
    }
}
?>
