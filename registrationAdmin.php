<?php
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $password = $_POST['password'];

    //DATABASE CONNECTION
    $conn = new mysqli('localhost', 'root', '', 'improject');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        // Check if email already exists
        $check_query = $conn->prepare("SELECT email FROM student WHERE email = ?");
        $check_query->bind_param("s", $email);
        $check_query->execute();
        $check_query->store_result();

        if ($check_query->num_rows > 0) {
            echo "<script>
                    alert('Error: Email already registered. Please use a different email.');
                    window.location.href = 'adminview.php';
                </script>";
        } else {
            // Insert data if email does not exist
            $stmt = $conn->prepare("INSERT INTO student (firstName, mname, lname, email, birthdate, gender, city, municipality, barangay, course, year, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssss", $firstName, $middleName, $lastName, $email, $birthdate, $gender, $city, $municipality, $barangay, $course, $year, $password);
            $stmt->execute();

            // Alert and redirect upon successful registration
            echo "<script>
                    alert('Registered successfully.');
                    window.location.href = 'adminview.php';
                  </script>";
            $stmt->close();
        }

        $check_query->close();
        $conn->close();
    }
?>
