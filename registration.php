<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="registration.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<form action="register.php" method="POST" class="form">
    <div class="container mt-5">
        <div class="card shadow-sm rounded-lg p-4">
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
                <a href="index.php"><button type="button" class="btn btn-light px-4 py-2 btn-custom m-1">Already have an account?</button></a>
            </div>
            
            <div class="mt-4 d-flex justify-content-end ">
                    <button type="submit" class="btn btn-light px-4 py-2 btn-custom">Submit</button>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
