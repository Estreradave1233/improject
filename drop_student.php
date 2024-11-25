<?php
require_once('db.php');

// Check if studID is passed
if (isset($_GET['studID'])) {
    $studID = $_GET['studID'];

    // Insert into drop_student table
    $query = "INSERT INTO drop_student (studID) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $studID);

    if (mysqli_stmt_execute($stmt)) {
        echo "Student dropped successfully.";
    } else {
        echo "Error dropping the student: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid student ID.";
}
?>
