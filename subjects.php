<?php
require_once('db.php');

// Assume the student's email is passed via GET
$email = $_GET['email'] ?? '';  

$approvalStatus = ''; // Variable to store the approval status
$approvalData = [];   // Array to store approval data
$denyStatus = '';
$denyData = [];

// Query to check if the email exists in the student_approval table
$queryApproval = "
    SELECT sa.*, s.email 
    FROM student_approval sa
    JOIN student s ON sa.studID = s.studID
    WHERE s.email = ?
";
$stmtApproval = mysqli_prepare($conn, $queryApproval);
mysqli_stmt_bind_param($stmtApproval, 's', $email);
mysqli_stmt_execute($stmtApproval);
$resultApproval = mysqli_stmt_get_result($stmtApproval);

// Check if the email is found in the approval table
if (mysqli_num_rows($resultApproval) > 0) {
    $approvalStatus = 'Approved';
    $approvalData = mysqli_fetch_assoc($resultApproval);
} else {
    $approvalStatus = 'Not Approved';
}

// Query to check if the email exists in the deny table
$queryDeny = "
    SELECT sd.*, s.email 
    FROM deny_student sd
    JOIN student s ON sd.studID = s.studID
    WHERE s.email = ?
";
$stmtDeny = mysqli_prepare($conn, $queryDeny);
mysqli_stmt_bind_param($stmtDeny, 's', $email);
mysqli_stmt_execute($stmtDeny);
$resultDeny = mysqli_stmt_get_result($stmtDeny);

// Check if the email is found in the deny table
if (mysqli_num_rows($resultDeny) > 0) {
    $denyStatus = 'Denied';
    $denyData = mysqli_fetch_assoc($resultDeny);
}

// Fetching course name and subjects (similar to previous code)
$courseName = '';
$subjects = [];

// Query to fetch the course name
$queryCourse = "
    SELECT c.description 
    FROM course c
    INNER JOIN student s ON c.courseNAME = s.course
    WHERE s.email = ?
";
$stmtCourse = mysqli_prepare($conn, $queryCourse);
mysqli_stmt_bind_param($stmtCourse, 's', $email);
mysqli_stmt_execute($stmtCourse);
$resultCourse = mysqli_stmt_get_result($stmtCourse);
if ($resultCourse && mysqli_num_rows($resultCourse) > 0) {
    $courseRow = mysqli_fetch_assoc($resultCourse);
    $courseName = $courseRow['description'];
}

// Fetch subjects related to the course
if (!empty($courseName)) {
    $querySubjects = "
        SELECT s.SubjectID, s.SubjectName, s.credits, s.description 
        FROM subject s
        JOIN course c ON s.CourseID = c.CourseID
        WHERE c.description = ?
    ";
    $stmtSubjects = mysqli_prepare($conn, $querySubjects);
    mysqli_stmt_bind_param($stmtSubjects, 's', $courseName);
    mysqli_stmt_execute($stmtSubjects);
    $resultSubjects = mysqli_stmt_get_result($stmtSubjects);
    while ($row = mysqli_fetch_assoc($resultSubjects)) {
        $subjects[] = $row;
    }
}

// Fetch the schedule and room details
$schedules = [];
foreach ($subjects as $subject) {
    $querySchedule = "
        SELECT day, startTime, endTime, roomID
        FROM schedule
        WHERE SubjectID = ?
    ";
    $stmtSchedule = mysqli_prepare($conn, $querySchedule);
    mysqli_stmt_bind_param($stmtSchedule, 'i', $subject['SubjectID']);
    mysqli_stmt_execute($stmtSchedule);
    $resultSchedule = mysqli_stmt_get_result($stmtSchedule);
    
    while ($scheduleRow = mysqli_fetch_assoc($resultSchedule)) {
        // Fetch room details for each schedule
        $roomID = $scheduleRow['roomID'];
        $queryRoomDetails = "
            SELECT roomNumber, building, capacity
            FROM room
            WHERE roomID = ?
        ";
        $stmtRoomDetails = mysqli_prepare($conn, $queryRoomDetails);
        mysqli_stmt_bind_param($stmtRoomDetails, 'i', $roomID);
        mysqli_stmt_execute($stmtRoomDetails);
        $resultRoomDetails = mysqli_stmt_get_result($stmtRoomDetails);
        if ($roomRow = mysqli_fetch_assoc($resultRoomDetails)) {
            // Add room details to the schedule
            $scheduleRow['roomDetails'] = $roomRow;
        } else {
            $scheduleRow['roomDetails'] = ['roomNumber' => 'N/A', 'building' => 'N/A', 'capacity' => 'N/A'];
        }

        // Store schedule information
        $schedules[$subject['SubjectID']][] = $scheduleRow;
    }

    mysqli_stmt_close($stmtSchedule);
    mysqli_stmt_close($stmtRoomDetails);
}

mysqli_stmt_close($stmtCourse);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Approval Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
          <a class="nav-link" href="userview.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="student_status.php?email=<?php echo htmlspecialchars($email); ?>">Approval Status</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="subjects.php?email=<?php echo htmlspecialchars($email); ?>">Subjects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">

    <!-- Check if the student is approved -->
    <?php if ($approvalStatus === 'Approved'): ?>
        <h4 class="mt-4">Subjects for This Course</h4>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Credits</th>
                <th>Description</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Room Number</th>
                <th>Building</th>
                <th>Capacity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subjects as $subject): ?>
                <tr>
                    <td><?php echo htmlspecialchars($subject['SubjectName']); ?></td>
                    <td><?php echo htmlspecialchars($subject['credits']); ?></td>
                    <td><?php echo htmlspecialchars($subject['description']); ?></td>
                    <?php
                    // Check if this subject has any schedules
                    $subjectSchedules = isset($schedules[$subject['SubjectID']]) ? $schedules[$subject['SubjectID']] : [];
                    if (!empty($subjectSchedules)):
                        foreach ($subjectSchedules as $schedule): ?>
                            <td><?php echo htmlspecialchars($schedule['day']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['startTime']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['endTime']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['roomDetails']['roomNumber']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['roomDetails']['building']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['roomDetails']['capacity']); ?></td>
                        <?php endforeach; 
                    else: ?>
                        <td colspan="6">No schedule available</td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php elseif ($denyStatus === 'Denied'): ?>
        <p>There is no subjects since you are denied!</p>
    <?php else: ?>
        <h3>Approval Status: Not Approved</h3>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Not Approved</td>
                    <td>Your application has not been approved yet.</td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
